<?php
define( 'ABSPATH', __DIR__ . '/' );
function get_template_directory() { return dirname( __DIR__ ) . '/undo-theme'; }
function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_shortcode( $tag, $callback ) {}
function __( $text, $domain = 'default' ) { return $text; }
function esc_html__( $text, $domain = 'default' ) { return $text; }
function esc_attr__( $text, $domain = 'default' ) { return $text; }
function esc_html_e( $text, $domain = 'default' ) { echo htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }
function esc_attr_e( $text, $domain = 'default' ) { echo htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }
function esc_html( $text ) { return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }
function esc_attr( $text ) { return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }
function esc_attr__( $text, $domain = 'default' ) { return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }
function esc_url( $text ) { return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }
function esc_url_raw( $text, $protocols = array( 'http', 'https' ) ) { return in_array( parse_url( $text, PHP_URL_SCHEME ), $protocols, true ) ? $text : ''; }
function wp_parse_url( $url, $component = -1 ) { return parse_url( $url, $component ); }
function wp_unslash( $text ) { return stripslashes( $text ); }
function sanitize_text_field( $text ) { return strip_tags( $text ); }
function sanitize_email( $text ) { return filter_var( $text, FILTER_VALIDATE_EMAIL ) ?: ''; }
function get_option( $key, $default = false ) { return isset( $GLOBALS['options'][ $key ] ) ? $GLOBALS['options'][ $key ] : $default; }
function get_locale() { return $GLOBALS['locale']; }
function wp_date( $format ) { return gmdate( $format ); }
function is_front_page() { return $GLOBALS['front_page']; }
function home_url( $path = '' ) { return 'https://example.test' . $path; }
function has_nav_menu( $location ) { return ! empty( $GLOBALS['menus'][ $location ] ); }
function register_sidebar( $args ) { $GLOBALS['registered_sidebars'][ $args['id'] ] = $args; }
function is_active_sidebar( $id ) { return ! empty( $GLOBALS['active_sidebars'][ $id ] ); }
function dynamic_sidebar( $id ) { echo '<p data-widget-area="' . htmlspecialchars( $id, ENT_QUOTES, 'UTF-8' ) . '">Widget content</p>'; }
function wp_nav_menu( $args ) { echo '<ul class="nav-list"><li><a href="/work">Work</a></li></ul>'; }
function get_privacy_policy_url() { return $GLOBALS['privacy_url']; }
function wp_footer() {}
function elementor_theme_do_location( $location ) { return ! empty( $GLOBALS['elementor_footer'] ); }
function expect( $condition, $message ) { if ( ! $condition ) { throw new RuntimeException( $message ); } }

$GLOBALS['options'] = array();
$GLOBALS['locale'] = 'fa_IR';
$GLOBALS['front_page'] = false;
$GLOBALS['menus'] = array( 'footer_secondary' => true );
$GLOBALS['privacy_url'] = 'https://example.test/privacy/';
$GLOBALS['elementor_footer'] = false;
$GLOBALS['active_sidebars'] = array( 'footer-widget-1' => true, 'footer-widget-3' => true );
require dirname( __DIR__ ) . '/undo-theme/functions.php';

undo_register_sidebars();
expect( 4 === count( $GLOBALS['registered_sidebars'] ), 'Primary sidebar and three footer areas are registered' );
expect( array( 'footer-widget-1', 'footer-widget-3' ) === undo_active_footer_widget_areas(), 'Only populated footer areas render, without empty columns' );

$defaults = undo_setting_defaults();
expect( '1' === $defaults['footer_show_brand'] && '1' === $defaults['footer_show_navigation'] && '1' === $defaults['footer_show_copyright'], 'Existing footer controls keep their shipped defaults' );
expect( '0' === $defaults['footer_show_social'] && '0' === $defaults['footer_show_secondary_navigation'], 'New optional footer sections stay off by default' );
expect( '0912 345 6789' === undo_sanitize_phone( '۰۹۱۲ ۳۴۵ ۶۷۸۹' ), 'Persian phone digits normalize for a usable telephone link' );

$saved = undo_sanitize_settings( array(
    'footer_show_social' => '1',
    'footer_social_github' => 'https://github.com/undo',
    'footer_social_x' => 'javascript:alert(1)',
    'footer_show_secondary_navigation' => '1',
    'footer_contact_phone' => '۰۹۱۲ ۳۴۵ ۶۷۸۹',
    'footer_copyright_fa' => '© {year} استودیو',
    'footer_action_url' => '#project-planner',
) );
expect( 'https://github.com/undo' === $saved['footer_social_github'] && '' === $saved['footer_social_x'], 'Social links accept only HTTP(S) URLs' );
expect( '0912 345 6789' === $saved['footer_contact_phone'], 'Saved phone is normalized' );
$GLOBALS['options']['undo_theme_settings'] = $saved;
expect( 'https://example.test/#project-planner' === undo_footer_action_url(), 'Footer anchor links resolve to the homepage from other pages' );
expect( 1 === count( undo_footer_social_links() ), 'Only configured valid social links render' );
expect( false !== strpos( undo_footer_copyright(), gmdate( 'Y' ) ), 'Copyright year token resolves at render time' );

ob_start();
require dirname( __DIR__ ) . '/undo-theme/footer.php';
$html = ob_get_clean();
expect( false !== strpos( $html, '<footer class="footer"' ) && false !== strpos( $html, 'aria-label="Footer secondary navigation"' ), 'Fallback footer and assigned second menu render' );
expect( false !== strpos( $html, 'tel:09123456789' ) && false !== strpos( $html, 'https://github.com/undo' ) && false === strpos( $html, 'javascript:' ), 'Contact and social links are safe and usable' );
expect( false !== strpos( $html, 'https://example.test/privacy/' ), 'Published privacy link appears in legal area' );
expect( false !== strpos( $html, 'footer-widgets--2' ) && false !== strpos( $html, 'data-widget-area="footer-widget-3"' ) && false === strpos( $html, 'data-widget-area="footer-widget-2"' ), 'Populated footer widget areas render in order' );

$GLOBALS['options']['undo_theme_settings']['footer_show_widgets'] = '0';
expect( array() === undo_active_footer_widget_areas(), 'Footer widgets can be disabled without deleting saved widgets' );
ob_start();
require dirname( __DIR__ ) . '/undo-theme/footer.php';
$disabled_widgets_html = ob_get_clean();
expect( false === strpos( $disabled_widgets_html, 'footer-widgets' ), 'Disabled footer widgets leave no output' );
$GLOBALS['options']['undo_theme_settings']['footer_show_widgets'] = '1';
expect( false !== strpos( undo_footer_widgets_markup(), 'data-widget-area="footer-widget-1"' ), 'Elementor shortcode callback can render the same populated widget areas' );

$GLOBALS['elementor_footer'] = true;
ob_start();
require dirname( __DIR__ ) . '/undo-theme/footer.php';
$elementor_html = ob_get_clean();
expect( false === strpos( $elementor_html, '<footer class="footer"' ), 'Elementor footer location replaces the built-in footer' );
expect( false === strpos( $elementor_html, 'footer-widgets' ), 'Elementor footer location never duplicates the built-in widget areas' );
echo "Footer settings and Elementor fallback checks passed.\n";
