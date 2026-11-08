<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'UNDO_THEME_UPDATE_URI', 'https://github.com/ashkankhalili/undo-theme' );
define( 'UNDO_THEME_RELEASE_API', 'https://api.github.com/repos/ashkankhalili/undo-theme/releases/latest' );
define( 'UNDO_THEME_RELEASE_CACHE', 'undo_theme_github_release' );

function undo_theme_github_release( $refresh = false ) {
    $cached = get_site_transient( UNDO_THEME_RELEASE_CACHE );
    if ( ! is_array( $cached ) || ! isset( $cached['version'], $cached['package'], $cached['sha256'], $cached['url'] )
        || ! is_string( $cached['version'] ) || ! preg_match( '/^\d+\.\d+\.\d+$/', $cached['version'] )
        || ! is_string( $cached['package'] ) || ! is_string( $cached['url'] )
        || ! is_string( $cached['sha256'] ) || ! preg_match( '/^[a-f0-9]{64}$/', $cached['sha256'] ) ) {
        $cached = false;
    }
    if ( ! $refresh && is_array( $cached ) ) { return $cached; }

    $response = wp_safe_remote_get( UNDO_THEME_RELEASE_API, array(
        'timeout' => 10,
        'headers' => array(
            'Accept' => 'application/vnd.github+json',
            'User-Agent' => 'UNDO-Theme-Updater/' . UNDO_THEME_VERSION,
        ),
    ) );
    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return is_array( $cached ) ? $cached : false;
    }

    $body = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( ! is_array( $body ) || ! empty( $body['draft'] ) || ! empty( $body['prerelease'] ) || empty( $body['tag_name'] ) || ! is_string( $body['tag_name'] ) || empty( $body['assets'] ) || ! is_array( $body['assets'] ) ) {
        return is_array( $cached ) ? $cached : false;
    }
    if ( ! preg_match( '/^v?(\d+\.\d+\.\d+)$/', $body['tag_name'], $match ) ) {
        return is_array( $cached ) ? $cached : false;
    }

    $version = $match[1];
    $name = 'undo-theme-' . $version . '.zip';
    $base = UNDO_THEME_UPDATE_URI . '/releases/download/' . $body['tag_name'] . '/';
    $package = false;
    $checksum_url = false;
    $sha256 = false;

    foreach ( $body['assets'] as $asset ) {
        if ( ! is_array( $asset ) || empty( $asset['name'] ) || empty( $asset['browser_download_url'] ) || 'uploaded' !== ( $asset['state'] ?? '' ) ) { continue; }
        if ( $name === $asset['name'] && $base . $name === $asset['browser_download_url'] && isset( $asset['size'] ) && is_int( $asset['size'] ) && $asset['size'] > 0 && $asset['size'] <= 50 * 1024 * 1024 ) {
            $package = $asset['browser_download_url'];
            if ( isset( $asset['digest'] ) && is_string( $asset['digest'] ) && preg_match( '/^sha256:([a-f0-9]{64})$/i', $asset['digest'], $digest ) ) {
                $sha256 = strtolower( $digest[1] );
            }
        }
        if ( $name . '.sha256' === $asset['name'] && $base . $name . '.sha256' === $asset['browser_download_url'] ) {
            $checksum_url = $asset['browser_download_url'];
        }
    }

    if ( ! $package ) { return is_array( $cached ) ? $cached : false; }
    if ( ! $sha256 && $checksum_url ) {
        $checksum_response = wp_safe_remote_get( $checksum_url, array( 'timeout' => 10 ) );
        if ( ! is_wp_error( $checksum_response ) && 200 === wp_remote_retrieve_response_code( $checksum_response ) ) {
            $checksum_body = trim( wp_remote_retrieve_body( $checksum_response ) );
            if ( preg_match( '/^([a-f0-9]{64})  ' . preg_quote( $name, '/' ) . '$/i', $checksum_body, $checksum ) ) {
                $sha256 = strtolower( $checksum[1] );
            }
        }
    }
    if ( ! $sha256 ) { return is_array( $cached ) ? $cached : false; }

    $release = array(
        'version' => $version,
        'package' => $package,
        'sha256' => $sha256,
        'url' => UNDO_THEME_UPDATE_URI . '/releases/tag/' . $body['tag_name'],
    );
    set_site_transient( UNDO_THEME_RELEASE_CACHE, $release, 6 * HOUR_IN_SECONDS );
    return $release;
}

function undo_theme_github_update( $update, $theme_data, $theme_stylesheet, $locales ) {
    if ( 'undo-theme' !== $theme_stylesheet || UNDO_THEME_UPDATE_URI !== ( $theme_data['UpdateURI'] ?? '' ) ) { return $update; }
    $release = undo_theme_github_release( true );
    if ( ! $release || ! isset( $theme_data['Version'] ) || ! version_compare( $release['version'], $theme_data['Version'], '>' ) ) { return $update; }
    return array(
        'theme' => 'undo-theme',
        'version' => $release['version'],
        'url' => $release['url'],
        'package' => $release['package'],
        'requires_php' => '7.4',
        'autoupdate' => false,
    );
}
add_filter( 'update_themes_github.com', 'undo_theme_github_update', 10, 4 );

function undo_theme_verify_github_package( $reply, $package, $upgrader, $hook_extra ) {
    if ( false !== $reply || ! is_array( $hook_extra ) || 'undo-theme' !== ( $hook_extra['theme'] ?? '' ) ) { return $reply; }

    $release = undo_theme_github_release();
    if ( ! $release || $package !== $release['package'] ) {
        return new WP_Error( 'undo_theme_package_unverified', __( 'Unable to verify the UNDO theme update package.', 'undo-theme' ) );
    }
    if ( ! function_exists( 'download_url' ) ) { require_once ABSPATH . 'wp-admin/includes/file.php'; }
    $file = download_url( $package, 300 );
    if ( is_wp_error( $file ) ) { return $file; }
    $hash = hash_file( 'sha256', $file );
    if ( false === $hash || ! hash_equals( $release['sha256'], strtolower( $hash ) ) ) {
        wp_delete_file( $file );
        return new WP_Error( 'undo_theme_checksum_mismatch', __( 'The UNDO theme update failed its checksum check.', 'undo-theme' ) );
    }
    return $file;
}
add_filter( 'upgrader_pre_download', 'undo_theme_verify_github_package', 10, 4 );
