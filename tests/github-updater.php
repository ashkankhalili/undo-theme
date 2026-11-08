<?php
define( 'ABSPATH', __DIR__ . '/' );
define( 'HOUR_IN_SECONDS', 3600 );
$stylesheet = file_get_contents( dirname( __DIR__ ) . '/undo-theme/style.css' );
if ( ! preg_match( '/^Version:\s*(\d+)\.(\d+)\.(\d+)/m', $stylesheet, $installed ) ) { throw new RuntimeException( 'Missing theme version' ); }
define( 'UNDO_THEME_VERSION', $installed[1] . '.' . $installed[2] . '.' . $installed[3] );

class WP_Error {
    public $code;
    public function __construct( $code, $message = '' ) { $this->code = $code; }
}
function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function admin_url( $path = '' ) { return 'https://staging.example.test/wp-admin/' . $path; }
function esc_html( $text ) { return htmlspecialchars( $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ); }
function __( $message, $domain = 'default' ) { return $message; }
function is_wp_error( $value ) { return $value instanceof WP_Error; }
function get_site_transient( $key ) { return $GLOBALS['release_cache']; }
function set_site_transient( $key, $value, $expiration = 0 ) { $GLOBALS['release_cache'] = $value; }
function wp_safe_remote_get( $url, $args = array() ) { return $GLOBALS['responses'][ $url ] ?? new WP_Error( 'not_found' ); }
function wp_remote_retrieve_response_code( $response ) { return $response['code']; }
function wp_remote_retrieve_body( $response ) { return $response['body']; }
function download_url( $url, $timeout = 300 ) {
    $file = tempnam( sys_get_temp_dir(), 'undo-theme-' );
    file_put_contents( $file, $GLOBALS['download_bytes'] );
    $GLOBALS['download_file'] = $file;
    return $file;
}
function wp_delete_file( $file ) { unlink( $file ); }
function expect( $condition, $message ) { if ( ! $condition ) { throw new RuntimeException( $message ); } }

require dirname( __DIR__ ) . '/undo-theme/inc/github-updater.php';

expect( false !== strpos( $stylesheet, 'Update URI: ' . UNDO_THEME_UPDATE_URI ), 'Update URI header must match updater' );
$version = $installed[1] . '.' . $installed[2] . '.' . ( (int) $installed[3] + 1 );
$tag = 'v' . $version;
$name = 'undo-theme-' . $version . '.zip';
$package = UNDO_THEME_UPDATE_URI . '/releases/download/' . $tag . '/' . $name;
$checksum_url = $package . '.sha256';
$bytes = 'example installable theme bytes';
$sha256 = hash( 'sha256', $bytes );
$asset = array(
    'name' => $name,
    'browser_download_url' => $package,
    'state' => 'uploaded',
    'size' => strlen( $bytes ),
    'digest' => 'sha256:' . $sha256,
);
$release = array( 'tag_name' => $tag, 'draft' => false, 'prerelease' => false, 'body' => "### Fixed\n- Popup details <script>alert(1)</script>", 'assets' => array( $asset ) );
$GLOBALS['release_cache'] = false;
$GLOBALS['responses'] = array( UNDO_THEME_RELEASE_API => array( 'code' => 200, 'body' => json_encode( $release ) ) );

$unchanged = undo_theme_github_update( false, array( 'UpdateURI' => UNDO_THEME_UPDATE_URI, 'Version' => UNDO_THEME_VERSION ), 'another-theme', array() );
expect( false === $unchanged, 'Another theme must not receive this update' );
$update = undo_theme_github_update( false, array( 'UpdateURI' => UNDO_THEME_UPDATE_URI, 'Version' => UNDO_THEME_VERSION ), 'undo-theme', array() );
expect( is_array( $update ) && $version === $update['version'] && $package === $update['package'], 'New release must appear in WordPress update data' );
expect( 'https://staging.example.test/wp-admin/admin-ajax.php?action=undo_theme_release_notes&version=' . $version === $update['url'], 'Update details must open on the same WordPress site' );
expect( $release['body'] === $GLOBALS['release_cache']['notes'], 'Release notes must be cached with the verified release' );
$rendered = undo_theme_release_notes_html( $release['body'] );
expect( false !== strpos( $rendered, '<h2 dir="auto">Fixed</h2>' ) && false !== strpos( $rendered, '<ul><li dir="auto">' ), 'Release note headings and bullets must render with mixed-language direction' );
expect( false === strpos( $rendered, '<script>' ) && false !== strpos( $rendered, '&lt;script&gt;' ), 'GitHub release notes must be escaped' );
expect( $sha256 === $GLOBALS['release_cache']['sha256'], 'Release digest must be cached' );
expect( false === undo_theme_github_update( false, array( 'UpdateURI' => UNDO_THEME_UPDATE_URI, 'Version' => $version ), 'undo-theme', array() ), 'Current version must not update itself' );

$GLOBALS['download_bytes'] = $bytes;
$file = undo_theme_verify_github_package( false, $package, null, array( 'theme' => 'undo-theme' ) );
expect( is_string( $file ) && file_exists( $file ), 'Verified package must be passed to WordPress' );
unlink( $file );
$GLOBALS['download_bytes'] = 'tampered bytes';
$failure = undo_theme_verify_github_package( false, $package, null, array( 'theme' => 'undo-theme' ) );
expect( is_wp_error( $failure ) && 'undo_theme_checksum_mismatch' === $failure->code, 'Tampered package must be blocked' );
expect( ! file_exists( $GLOBALS['download_file'] ), 'Tampered temp file must be removed' );
expect( false === undo_theme_verify_github_package( false, $package, null, array( 'theme' => 'other-theme' ) ), 'Other theme downloads must be untouched' );
expect( is_wp_error( undo_theme_verify_github_package( false, 'https://example.com/other.zip', null, array( 'theme' => 'undo-theme' ) ) ), 'Unknown package for this theme must be blocked' );

$release['assets'][0]['digest'] = null;
$release['assets'][] = array( 'name' => $name . '.sha256', 'browser_download_url' => $checksum_url, 'state' => 'uploaded' );
$GLOBALS['responses'][ UNDO_THEME_RELEASE_API ]['body'] = json_encode( $release );
$GLOBALS['responses'][ $checksum_url ] = array( 'code' => 200, 'body' => $sha256 . '  ' . $name . "\n" );
expect( $sha256 === undo_theme_github_release( true )['sha256'], 'Checksum asset must work when GitHub omits digest' );

$release['assets'][0]['browser_download_url'] = 'https://example.com/' . $name;
unset( $release['assets'][1] );
$GLOBALS['responses'][ UNDO_THEME_RELEASE_API ]['body'] = json_encode( $release );
$GLOBALS['release_cache'] = false;
expect( false === undo_theme_github_release( true ), 'A package outside this repository must be rejected' );

echo "GitHub updater checks passed.\n";
