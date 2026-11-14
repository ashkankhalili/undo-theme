<?php
define( 'ABSPATH', __DIR__ . '/' );
define( 'HOUR_IN_SECONDS', 3600 );

class WP_Error {
    public $code;
    public function __construct( $code, $message = '' ) { $this->code = $code; }
}
function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) { $GLOBALS['actions'][ $hook ][] = $callback; }
function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_shortcode( $name, $callback ) { $GLOBALS['shortcodes'][ $name ] = $callback; }
function plugin_dir_path( $file ) { return dirname( $file ) . '/'; }
function plugin_dir_url( $file ) { return 'https://example.test/wp-content/plugins/undo-elements/'; }
function plugin_basename( $file ) { return 'undo-elements/undo-elements.php'; }
function wp_parse_args( $args, $defaults ) { return array_merge( $defaults, $args ); }
function shortcode_atts( $defaults, $attributes, $name ) { return array_merge( $defaults, $attributes ); }
function sanitize_html_class( $value ) { return preg_replace( '/[^A-Za-z0-9_-]/', '', $value ); }
function esc_attr( $value ) { return htmlspecialchars( $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ); }
function esc_html( $value ) { return esc_attr( $value ); }
function esc_url( $value ) { return esc_attr( $value ); }
function __( $value, $domain = '' ) { return $value; }
function esc_html__( $value, $domain = '' ) { return esc_html( $value ); }
function esc_html_e( $value, $domain = '' ) { echo esc_html( $value ); }
function esc_attr_e( $value, $domain = '' ) { echo esc_attr( $value ); }
function wp_enqueue_style( $name ) { $GLOBALS['styles'][] = $name; }
function wp_enqueue_script( $name ) { $GLOBALS['scripts'][] = $name; }
function did_action( $name ) { return 0; }
function is_wp_error( $value ) { return $value instanceof WP_Error; }
function get_site_transient( $key ) { return $GLOBALS['release_cache'] ?? false; }
function set_site_transient( $key, $value, $time = 0 ) { $GLOBALS['release_cache'] = $value; }
function wp_safe_remote_get( $url, $args = array() ) { return $GLOBALS['responses'][ $url ] ?? new WP_Error( 'missing' ); }
function wp_remote_retrieve_response_code( $response ) { return $response['code']; }
function wp_remote_retrieve_body( $response ) { return $response['body']; }
function wpautop( $text ) { return '<p>' . $text . '</p>'; }
function download_url( $url, $timeout = 300 ) { $file = tempnam( sys_get_temp_dir(), 'undo-elements-' ); file_put_contents( $file, $GLOBALS['download_bytes'] ); $GLOBALS['download_file'] = $file; return $file; }
function wp_delete_file( $file ) { unlink( $file ); }
function expect( $test, $message ) { if ( ! $test ) { throw new RuntimeException( $message ); } }

require dirname( __DIR__ ) . '/undo-elements/undo-elements.php';
expect( isset( $GLOBALS['shortcodes']['undo_project_planner'] ), 'Shortcode must be registered without Elementor' );
undo_elements_connect_elementor();
expect( ! isset( $GLOBALS['actions']['elementor/widgets/register'] ), 'Elementor widgets must not load when Elementor is absent' );

$first = undo_elements_render_planner( array( 'id' => 'custom <id>', 'title' => '<script>alert(1)</script>' ) );
$second = undo_elements_planner_shortcode( array() );
expect( false !== strpos( $first, 'id="customid"' ), 'Planner anchor must be sanitized' );
expect( false !== strpos( $first, '&lt;script&gt;' ) && false === strpos( $first, '<script>' ), 'Planner copy must be escaped' );
expect( false !== strpos( $second, 'id="project-planner-2"' ), 'Multiple planner instances need distinct anchors' );
expect( false !== strpos( $first, 'data-undo-elements-planner' ) && false === strpos( $first, 'id="brief-form"' ), 'Addon form must use its independent handler' );
expect( false === strpos( $first, ' action=' ) && false === strpos( $first, ' method=' ), 'Planner must remain browser-only' );

$version = '0.1.1';
$name = 'undo-elements-' . $version . '.zip';
$url = UNDO_ELEMENTS_UPDATE_URI . '/releases/download/v0.11.1/' . $name;
$bytes = 'valid addon zip bytes';
$digest = hash( 'sha256', $bytes );
$GLOBALS['responses'] = array( UNDO_ELEMENTS_RELEASE_API => array( 'code' => 200, 'body' => json_encode( array(
    'tag_name' => 'v0.11.1', 'draft' => false, 'prerelease' => false, 'body' => "### UNDO Elements\n- Fixed <script>bad</script>",
    'assets' => array( array( 'name' => $name, 'browser_download_url' => $url, 'state' => 'uploaded', 'size' => strlen( $bytes ), 'digest' => 'sha256:' . $digest ) ),
) ) ) );
$update = undo_elements_github_update( false, array( 'UpdateURI' => UNDO_ELEMENTS_UPDATE_URI, 'Version' => UNDO_ELEMENTS_VERSION ), 'undo-elements/undo-elements.php', array() );
expect( is_array( $update ) && $update['version'] === $version && $update['package'] === $url, 'Addon update must use its independent asset version' );
expect( false === undo_elements_github_update( false, array( 'UpdateURI' => UNDO_ELEMENTS_UPDATE_URI, 'Version' => '0.1.0' ), 'other/plugin.php', array() ), 'Other plugins must be untouched' );
$details = undo_elements_plugin_information( false, 'plugin_information', (object) array( 'slug' => 'undo-elements' ) );
expect( false !== strpos( $details->sections['changelog'], '&lt;script&gt;' ), 'Release details must escape HTML' );
$GLOBALS['download_bytes'] = $bytes;
$file = undo_elements_verify_package( false, $url, null, array( 'plugin' => 'undo-elements/undo-elements.php' ) );
expect( is_string( $file ) && file_exists( $file ), 'Verified addon ZIP must reach the upgrader' );
unlink( $file );
$GLOBALS['download_bytes'] = 'tampered';
$result = undo_elements_verify_package( false, $url, null, array( 'plugin' => 'undo-elements/undo-elements.php' ) );
expect( $result instanceof WP_Error && 'undo_elements_checksum_mismatch' === $result->code, 'Tampered addon ZIP must be rejected' );
expect( ! file_exists( $GLOBALS['download_file'] ), 'Tampered download must be deleted' );
expect( false === undo_elements_verify_package( false, $url, null, array( 'plugin' => 'other/plugin.php' ) ), 'Other plugin downloads must be untouched' );
echo "UNDO Elements integration checks passed.\n";
