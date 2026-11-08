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
        'notes' => isset( $body['body'] ) && is_string( $body['body'] ) ? $body['body'] : '',
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
        'url' => admin_url( 'admin-ajax.php?action=undo_theme_release_notes&version=' . rawurlencode( $release['version'] ) ),
        'package' => $release['package'],
        'requires_php' => '7.4',
        'autoupdate' => false,
    );
}
add_filter( 'update_themes_github.com', 'undo_theme_github_update', 10, 4 );

/** Render the update details inside WordPress's same-origin ThickBox iframe. */
function undo_theme_release_notes_html( $notes ) {
    $lines = preg_split( '/\r\n|\r|\n/', $notes );
    $html = '';
    $in_list = false;
    foreach ( $lines as $line ) {
        $line = trim( $line );
        if ( '' === $line ) { continue; }
        if ( preg_match( '/^#{2,4}\s+(.+)$/', $line, $match ) ) {
            if ( $in_list ) { $html .= '</ul>'; $in_list = false; }
            $html .= '<h2 dir="auto">' . esc_html( $match[1] ) . '</h2>';
        } elseif ( preg_match( '/^[-*]\s+(.+)$/', $line, $match ) ) {
            if ( ! $in_list ) { $html .= '<ul>'; $in_list = true; }
            $html .= '<li dir="auto">' . esc_html( $match[1] ) . '</li>';
        } else {
            if ( $in_list ) { $html .= '</ul>'; $in_list = false; }
            $html .= '<p dir="auto">' . esc_html( $line ) . '</p>';
        }
    }
    if ( $in_list ) { $html .= '</ul>'; }
    return $html;
}

function undo_theme_show_release_notes() {
    if ( ! current_user_can( 'update_themes' ) ) { wp_die( esc_html__( 'You are not allowed to view theme update details.', 'undo-theme' ), '', array( 'response' => 403 ) ); }
    $requested = isset( $_GET['version'] ) && is_string( $_GET['version'] ) ? sanitize_text_field( wp_unslash( $_GET['version'] ) ) : '';
    $release = undo_theme_github_release( true );
    if ( ! preg_match( '/^\d+\.\d+\.\d+$/', $requested ) || ! $release || $release['version'] !== $requested ) {
        wp_die( esc_html__( 'Release details are unavailable. Refresh the WordPress Updates screen and try again.', 'undo-theme' ), '', array( 'response' => 404 ) );
    }

    header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset', 'UTF-8' ) );
    $notes = isset( $release['notes'] ) && is_string( $release['notes'] ) ? $release['notes'] : '';
    echo '<!doctype html><html lang="' . esc_attr( str_replace( '_', '-', get_user_locale() ) ) . '" dir="' . ( is_rtl() ? 'rtl' : 'ltr' ) . '"><head><meta charset="' . esc_attr( get_option( 'blog_charset', 'UTF-8' ) ) . '"><meta name="viewport" content="width=device-width,initial-scale=1"><title>' . esc_html__( 'UNDO theme update details', 'undo-theme' ) . '</title>';
    echo '<style>body{margin:0;background:#f6f6f4;color:#20221f;font:16px/1.7 system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}main{max-width:760px;margin:auto;padding:42px 34px 55px}h1{font-size:2rem;line-height:1.25;margin:0 0 12px}h2{font-size:1.15rem;line-height:1.4;margin:28px 0 9px}p{margin:8px 0 14px}ul{padding-inline-start:1.3em;margin:8px 0 20px}li{margin:7px 0}.eyebrow{font-size:.8rem;letter-spacing:.08em;text-transform:uppercase;color:#995047;font-weight:700}.summary{font-size:1.05rem;max-width:64ch}.panel{border:1px solid #d9d8d2;border-radius:14px;background:#fff;padding:8px 25px 20px;margin:28px 0}.links{display:flex;gap:18px;flex-wrap:wrap;padding-top:12px}.links a{color:#a4372e;text-decoration:underline;text-underline-offset:3px}@media(max-width:600px){main{padding:25px 20px 38px}.panel{padding:8px 18px 18px}}</style></head><body><main>';
    echo '<div class="eyebrow">' . esc_html__( 'UNDO Web Developments', 'undo-theme' ) . '</div><h1>' . esc_html__( 'Theme update', 'undo-theme' ) . ' ' . esc_html( $release['version'] ) . '</h1>';
    echo '<p class="summary">' . esc_html__( 'See what changed before you update. Your theme settings and WordPress content are stored outside the theme files.', 'undo-theme' ) . '</p>';
    echo '<div class="panel"><h2>' . esc_html__( 'What changed', 'undo-theme' ) . '</h2>';
    echo '' !== trim( $notes ) ? undo_theme_release_notes_html( $notes ) : '<p>' . esc_html__( 'No release notes were provided for this version.', 'undo-theme' ) . '</p>';
    echo '</div><div class="links"><a href="' . esc_url( $release['url'] ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'View the GitHub release', 'undo-theme' ) . '</a><a href="' . esc_url( admin_url( 'update-core.php' ) ) . '" target="_parent">' . esc_html__( 'Back to WordPress Updates', 'undo-theme' ) . '</a></div></main></body></html>';
    exit;
}
add_action( 'wp_ajax_undo_theme_release_notes', 'undo_theme_show_release_notes' );

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
