<?php
/** Behavioral checks for the built-in page renderer without a WordPress install. */
define( 'ABSPATH', __DIR__ . '/' );
function add_action( $hook, $callback ) {}
function __( $message, $domain = 'default' ) { return $message; }
function get_option( $key, $default = false ) { return $GLOBALS['options'][ $key ] ?? $default; }
function esc_attr( $value ) { return htmlspecialchars( $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ); }
function esc_html( $value ) { return htmlspecialchars( $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ); }
function esc_url( $value ) { return esc_attr( $value ); }
function esc_attr__( $value, $domain = 'default' ) { return $value; }
function esc_attr_e( $value, $domain = 'default' ) { echo esc_attr( $value ); }
function esc_html_e( $value, $domain = 'default' ) { echo esc_html( $value ); }
function elementor_theme_do_location( $location ) { return ! empty( $GLOBALS['elementor_location'] ); }
function undo_is_elementor_page() { return ! empty( $GLOBALS['elementor_page'] ); }
function is_active_sidebar( $id ) { return true; }
function undo_has_sidebar( $key ) { return undo_setting_enabled( $key ) && is_active_sidebar( 'primary-sidebar' ); }
function get_sidebar() { echo '<aside id="test-sidebar"></aside>'; }
function have_posts() { return $GLOBALS['loop_index']++ < 1; }
function the_post() {}
function get_the_ID() { return 3; }
function get_the_title( $id = 3 ) { return array( 1 => 'Studio', 2 => 'Services', 3 => 'A page' )[ $id ]; }
function get_post_ancestors( $id ) { return array( 2, 1 ); }
function get_post_status( $id ) { return 'publish'; }
function get_permalink( $id ) { return 'https://example.test/' . $id . '/'; }
function home_url( $path ) { return 'https://example.test' . $path; }
function post_class( $class = '' ) { echo 'class="' . esc_attr( $class ) . '"'; }
function has_post_thumbnail() { return true; }
function the_post_thumbnail( $size ) { echo '<img src="featured.jpg" alt="">'; }
function the_content() { echo '<p>Page content</p>'; }
function wp_link_pages( $args ) { echo $args['before'] . '<a href="#page-2">2</a>' . $args['after']; }
function expect( $condition, $message ) { if ( ! $condition ) { throw new RuntimeException( $message ); } }

require dirname( __DIR__ ) . '/undo-theme/inc/settings.php';
function render_page( $settings, $full_width = false, $elementor_page = false, $elementor_location = false ) {
    $GLOBALS['options']['undo_theme_settings'] = $settings;
    $GLOBALS['loop_index'] = 0;
    $GLOBALS['elementor_page'] = $elementor_page;
    $GLOBALS['elementor_location'] = $elementor_location;
    $args = array( 'full_width' => $full_width );
    ob_start();
    include dirname( __DIR__ ) . '/undo-theme/template-parts/page-layout.php';
    return ob_get_clean();
}

$default = render_page( array() );
expect( false !== strpos( $default, 'page-layout--reading' ) && false !== strpos( $default, '<h1>A page</h1>' ), 'Standard pages should retain the default reading layout and title' );
expect( false === strpos( $default, 'page-breadcrumbs' ) && false === strpos( $default, 'page-featured' ), 'Breadcrumbs and featured media should remain opt-in' );
expect( false !== strpos( $default, 'aria-label="Page navigation"' ), 'Paged content needs a labeled navigation landmark' );

$full = render_page( array( 'page_show_breadcrumbs' => '1', 'page_show_featured' => '1', 'page_title_style' => 'compact', 'page_show_sidebar' => '1' ), true );
expect( false !== strpos( $full, 'page-layout--full' ) && false !== strpos( $full, 'page-header--compact' ) && false !== strpos( $full, 'page-featured' ), 'Full-width pages should apply the selected page presentation' );
expect( false === strpos( $full, 'test-sidebar' ), 'Full-width pages must not render the sidebar' );
expect( strpos( $full, 'Studio' ) < strpos( $full, 'Services' ) && strpos( $full, 'Services' ) < strpos( $full, 'A page' ), 'Breadcrumbs must show ancestors from the root to the current page' );

$standard_sidebar = render_page( array( 'page_show_sidebar' => '1', 'page_content_width' => 'wide' ) );
expect( false !== strpos( $standard_sidebar, 'page-layout--wide' ) && false !== strpos( $standard_sidebar, 'test-sidebar' ), 'Standard wide pages should support the widget sidebar' );
$elementor = render_page( array( 'page_show_title' => '1', 'page_show_breadcrumbs' => '1' ), false, true );
expect( false !== strpos( $elementor, 'undo-elementor-page' ) && false === strpos( $elementor, 'page-header' ), 'Elementor-built pages should keep their own canvas' );
expect( '' === render_page( array(), false, false, true ), 'An assigned Elementor Pro single location should replace the built-in page' );
echo "Page layout and Elementor fallback checks passed.\n";
