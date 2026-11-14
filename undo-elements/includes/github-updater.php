<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'UNDO_ELEMENTS_UPDATE_URI', 'https://github.com/ashkankhalili/undo-theme' );
define( 'UNDO_ELEMENTS_RELEASE_API', 'https://api.github.com/repos/ashkankhalili/undo-theme/releases/latest' );

function undo_elements_github_release( $refresh = false ) {
    $cached = get_site_transient( 'undo_elements_github_release' );
    if ( ! is_array( $cached ) || empty( $cached['version'] ) || empty( $cached['package'] ) || empty( $cached['sha256'] ) || ! preg_match( '/^[a-f0-9]{64}$/', $cached['sha256'] ) ) { $cached = false; }
    if ( ! $refresh && $cached ) { return $cached; }
    $response = wp_safe_remote_get( UNDO_ELEMENTS_RELEASE_API, array(
        'timeout' => 10,
        'headers' => array( 'Accept' => 'application/vnd.github+json', 'User-Agent' => 'UNDO-Elements-Updater/' . UNDO_ELEMENTS_VERSION ),
    ) );
    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) { return $cached; }
    $body = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( ! is_array( $body ) || ! empty( $body['draft'] ) || ! empty( $body['prerelease'] ) || empty( $body['tag_name'] ) || ! preg_match( '/^v\d+\.\d+\.\d+$/', $body['tag_name'] ) || empty( $body['assets'] ) || ! is_array( $body['assets'] ) ) { return $cached; }
    $base = UNDO_ELEMENTS_UPDATE_URI . '/releases/download/' . $body['tag_name'] . '/';
    $found = false;
    foreach ( $body['assets'] as $asset ) {
        if ( ! is_array( $asset ) || ! isset( $asset['name'], $asset['browser_download_url'], $asset['size'] ) || 'uploaded' !== ( $asset['state'] ?? '' ) || ! is_int( $asset['size'] ) || $asset['size'] < 1 || $asset['size'] > 50 * 1024 * 1024 ) { continue; }
        if ( ! preg_match( '/^undo-elements-(\d+\.\d+\.\d+)\.zip$/', $asset['name'], $matches ) || $base . $asset['name'] !== $asset['browser_download_url'] ) { continue; }
        $digest = isset( $asset['digest'] ) && is_string( $asset['digest'] ) && preg_match( '/^sha256:([a-f0-9]{64})$/i', $asset['digest'], $hash ) ? strtolower( $hash[1] ) : '';
        if ( ! $found || version_compare( $matches[1], $found['version'], '>' ) ) {
            $found = array( 'version' => $matches[1], 'package' => $asset['browser_download_url'], 'sha256' => $digest, 'name' => $asset['name'] );
        }
    }
    if ( ! $found ) { return $cached; }
    if ( ! $found['sha256'] ) {
        $checksum_url = $base . $found['name'] . '.sha256';
        foreach ( $body['assets'] as $asset ) {
            if ( ! is_array( $asset ) || ( $asset['browser_download_url'] ?? '' ) !== $checksum_url || ( $asset['name'] ?? '' ) !== $found['name'] . '.sha256' ) { continue; }
            $sum = wp_safe_remote_get( $checksum_url, array( 'timeout' => 10 ) );
            if ( ! is_wp_error( $sum ) && 200 === wp_remote_retrieve_response_code( $sum ) && preg_match( '/^([a-f0-9]{64})  ' . preg_quote( $found['name'], '/' ) . '$/i', trim( wp_remote_retrieve_body( $sum ) ), $hash ) ) { $found['sha256'] = strtolower( $hash[1] ); }
            break;
        }
    }
    if ( ! $found['sha256'] ) { return $cached; }
    $release = array(
        'version' => $found['version'], 'package' => $found['package'], 'sha256' => $found['sha256'],
        'url' => UNDO_ELEMENTS_UPDATE_URI . '/releases/tag/' . $body['tag_name'],
        'notes' => isset( $body['body'] ) && is_string( $body['body'] ) ? $body['body'] : '',
    );
    set_site_transient( 'undo_elements_github_release', $release, 6 * HOUR_IN_SECONDS );
    return $release;
}

function undo_elements_github_update( $update, $plugin_data, $plugin_file, $locales ) {
    if ( 'undo-elements/undo-elements.php' !== $plugin_file || UNDO_ELEMENTS_UPDATE_URI !== ( $plugin_data['UpdateURI'] ?? '' ) ) { return $update; }
    $release = undo_elements_github_release( true );
    if ( ! $release || ! isset( $plugin_data['Version'] ) || ! version_compare( $release['version'], $plugin_data['Version'], '>' ) ) { return $update; }
    return array(
        'id' => UNDO_ELEMENTS_UPDATE_URI, 'slug' => 'undo-elements', 'version' => $release['version'],
        'url' => $release['url'], 'package' => $release['package'], 'requires' => '6.2', 'requires_php' => '7.4', 'autoupdate' => false,
    );
}
add_filter( 'update_plugins_github.com', 'undo_elements_github_update', 10, 4 );

function undo_elements_plugin_information( $result, $action, $args ) {
    if ( 'plugin_information' !== $action || ! isset( $args->slug ) || 'undo-elements' !== $args->slug ) { return $result; }
    $release = undo_elements_github_release();
    if ( ! $release ) { return $result; }
    return (object) array(
        'name' => 'UNDO Elements', 'slug' => 'undo-elements', 'version' => $release['version'],
        'author' => '<a href="https://github.com/ashkankhalili">UNDO Web Developments</a>',
        'homepage' => UNDO_ELEMENTS_UPDATE_URI, 'download_link' => $release['package'],
        'requires' => '6.2', 'requires_php' => '7.4',
        'sections' => array(
            'description' => '<p>' . esc_html__( 'Elementor widgets and a browser-only project brief for UNDO websites.', 'undo-elements' ) . '</p>',
            'changelog' => wpautop( esc_html( $release['notes'] ) ),
        ),
    );
}
add_filter( 'plugins_api', 'undo_elements_plugin_information', 10, 3 );

function undo_elements_verify_package( $reply, $package, $upgrader, $hook_extra ) {
    if ( false !== $reply || ! is_array( $hook_extra ) || 'undo-elements/undo-elements.php' !== ( $hook_extra['plugin'] ?? '' ) ) { return $reply; }
    $release = undo_elements_github_release();
    if ( ! $release || $release['package'] !== $package ) { return new WP_Error( 'undo_elements_unverified', __( 'Unable to verify the UNDO Elements update package.', 'undo-elements' ) ); }
    if ( ! function_exists( 'download_url' ) ) { require_once ABSPATH . 'wp-admin/includes/file.php'; }
    $file = download_url( $package, 300 );
    if ( is_wp_error( $file ) ) { return $file; }
    $hash = hash_file( 'sha256', $file );
    if ( false === $hash || ! hash_equals( $release['sha256'], strtolower( $hash ) ) ) {
        wp_delete_file( $file );
        return new WP_Error( 'undo_elements_checksum_mismatch', __( 'The UNDO Elements update failed its checksum check.', 'undo-elements' ) );
    }
    return $file;
}
add_filter( 'upgrader_pre_download', 'undo_elements_verify_package', 10, 4 );
