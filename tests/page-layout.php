<?php
/** Behavioral checks for the built-in page renderer without a WordPress install. */
define( 'ABSPATH', __DIR__ . '/' );
function add_action( $hook, $callback ) {}
function add_filter( $hook, $callback ) {}
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
function get_queried_object_id() { return 3; }
function get_post_meta( $id, $key, $single = false ) { return $GLOBALS['post_meta'][ $key ] ?? ''; }
function get_sidebar() { echo '<aside id="test-sidebar"></aside>'; }
function have_posts() { return $GLOBALS['loop_index']++ < 1; }
function the_post() {}
function get_the_ID() { return 3; }
function get_the_title( $id = 3 ) { return array( 1 => 'Studio', 2 => 'Services', 3 => 'A page' )[ $id ]; }
function get_post_ancestors( $id ) { return array( 2, 1 ); }
function get_post_status( $id ) { return 'publish'; }
function get_permalink( $id ) { return 'https://example.test/' . $id . '/'; }
function home_url( $path ) { return 'https://example.test' . $path; }
function undo_home_url() { return home_url( '/' ); }
function post_class( $class = '' ) { echo 'class="' . esc_attr( $class ) . '"'; }
function has_post_thumbnail() { return true; }
function the_post_thumbnail( $size ) { echo '<img src="featured.jpg" alt="">'; }
function the_content() { echo '<p>Page content</p>'; }
function wp_link_pages( $args ) { echo $args['before'] . '<a href="#page-2">2</a>' . $args['after']; }
function expect( $condition, $message ) { if ( ! $condition ) { throw new RuntimeException( $message ); } }

require dirname( __DIR__ ) . '/undo-theme/inc/settings.php';
require dirname( __DIR__ ) . '/undo-theme/inc/page-layout.php';
function render_page( $settings, $layout = '', $elementor_page = false, $elementor_location = false ) {
    $GLOBALS['options']['undo_theme_settings'] = $settings;
    $GLOBALS['loop_index'] = 0;
    $GLOBALS['elementor_page'] = $elementor_page;
    $GLOBALS['elementor_location'] = $elementor_location;
    $args = array( 'layout' => $layout );
    ob_start();
    include dirname( __DIR__ ) . '/undo-theme/template-parts/page-layout.php';
    return ob_get_clean();
}

$default = render_page( array() );
expect( false !== strpos( $default, 'page-layout--reading' ) && false !== strpos( $default, '<h1>A page</h1>' ), 'Standard pages should retain the default reading layout and title' );
expect( false === strpos( $default, 'page-breadcrumbs' ) && false === strpos( $default, 'page-featured' ), 'Breadcrumbs and featured media should remain opt-in' );
expect( false !== strpos( $default, 'aria-label="Page navigation"' ), 'Paged content needs a labeled navigation landmark' );

$full = render_page( array( 'page_show_breadcrumbs' => '1', 'page_show_featured' => '1', 'page_title_style' => 'compact', 'page_show_sidebar' => '1' ), 'full' );
expect( false !== strpos( $full, 'page-layout--full' ) && false !== strpos( $full, 'page-header--compact' ) && false !== strpos( $full, 'page-featured' ), 'Full-width pages should apply the selected page presentation' );
expect( false === strpos( $full, 'test-sidebar' ), 'Full-width pages must not render the sidebar' );
expect( strpos( $full, 'Studio' ) < strpos( $full, 'Services' ) && strpos( $full, 'Services' ) < strpos( $full, 'A page' ), 'Breadcrumbs must show ancestors from the root to the current page' );

$standard_sidebar = render_page( array( 'page_show_sidebar' => '1', 'page_content_width' => 'wide' ) );
expect( false !== strpos( $standard_sidebar, 'page-layout--wide' ) && false !== strpos( $standard_sidebar, 'test-sidebar' ), 'Standard wide pages should support the widget sidebar' );
$boxed = render_page( array( 'page_content_width' => 'boxed' ) );
expect( false !== strpos( $boxed, 'page-layout--boxed' ), 'The global boxed layout must reach the frontend' );
$global_full = render_page( array( 'page_content_width' => 'full' ) );
expect( false !== strpos( $global_full, 'page-layout--full' ), 'The global full layout must reach the frontend' );
$configured = render_page( array( 'page_content_width' => 'wide', 'page_wide_width' => '80%', 'page_wide_margin_inline' => '32', 'page_wide_padding_top' => '64' ) );
expect( false !== strpos( $configured, '--undo-page-width:80%' ) && false !== strpos( $configured, '--undo-page-margin-inline:32px' ) && false !== strpos( $configured, '--undo-page-padding-top:64px' ), 'Template-specific width and spacing must reach the frontend' );
$custom = render_page( array(), 'custom' );
expect( false !== strpos( $custom, 'page-layout--custom' ) && false !== strpos( $custom, '--undo-page-width:1200px' ), 'Custom pages without an override must retain a safe fallback width' );
$GLOBALS['post_meta']['_undo_page_custom_width'] = '960px';
$override = render_page( array(), 'custom' );
expect( false !== strpos( $override, '--undo-page-width:960px' ), 'Per-page Custom Width must reach the frontend without a global custom value' );
unset( $GLOBALS['post_meta']['_undo_page_custom_width'] );
$legacy_custom = render_page( array( 'page_content_width' => 'custom' ) );
expect( false !== strpos( $legacy_custom, 'page-layout--reading' ), 'A removed global Custom Width selection must fall back safely to Reading' );
$elementor = render_page( array( 'page_content_width' => 'reading', 'page_show_title' => '1', 'page_show_breadcrumbs' => '1' ), 'full', true );
expect( false !== strpos( $elementor, 'page-layout--full page-layout--elementor' ) && false !== strpos( $elementor, 'undo-elementor-page' ) && false === strpos( $elementor, 'page-header' ), 'Elementor-built pages should use the chosen theme width without duplicate title chrome' );
expect( '' === render_page( array(), '', false, true ), 'An assigned Elementor Pro single location should replace the built-in page' );
expect( 'full' === undo_page_template_layout( 'template-full-width.php' ) && 'custom' === undo_page_template_layout( 'template-custom-width.php' ), 'Explicit page templates must resolve to their advertised layouts' );

function get_header() { echo 'HEADER'; }
function get_footer() { echo 'FOOTER'; }
function is_page() { return true; }
function get_page_template_slug( $id ) { return $GLOBALS['front_template']; }
function get_template_part( $slug, $name = null, $args = array() ) { echo $slug . ':' . ( $args['layout'] ?? '' ); }
$GLOBALS['front_template'] = 'template-full-width.php';
$GLOBALS['elementor_page'] = false;
$GLOBALS['elementor_location'] = false;
ob_start();
include dirname( __DIR__ ) . '/undo-theme/front-page.php';
$front = ob_get_clean();
expect( false !== strpos( $front, 'template-parts/page-layout:full' ), 'An explicit front-page template must not be replaced by the landing design' );
$GLOBALS['front_template'] = '';
$GLOBALS['elementor_page'] = true;
ob_start();
include dirname( __DIR__ ) . '/undo-theme/front-page.php';
$front = ob_get_clean();
expect( false !== strpos( $front, 'template-parts/page-layout:' ) && false === strpos( $front, 'template-parts/landing:' ), 'Elementor Free front pages must render their editable content through the page layout' );
$GLOBALS['elementor_page'] = false;
ob_start();
include dirname( __DIR__ ) . '/undo-theme/front-page.php';
$front = ob_get_clean();
expect( false !== strpos( $front, 'template-parts/landing:' ) && false === strpos( $front, 'template-parts/page-layout:' ), 'Without Elementor the native landing must return when no explicit page template is selected' );
$GLOBALS['elementor_location'] = true;
ob_start();
include dirname( __DIR__ ) . '/undo-theme/front-page.php';
$front = ob_get_clean();
expect( 'HEADERFOOTER' === $front, 'An assigned Elementor Pro single location replaces the front-page body once' );
echo "Page layout and Elementor fallback checks passed.\n";
