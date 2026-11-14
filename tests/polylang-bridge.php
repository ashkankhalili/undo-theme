<?php
/** Exercise translated URLs, locale precedence, and Home references without Polylang installed. */
define( 'ABSPATH', __DIR__ . '/' );
function get_template_directory() { return dirname( __DIR__ ) . '/undo-theme'; }
function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_shortcode( $tag, $callback ) {}
function __( $text, $domain = 'default' ) { return $text; }
function get_option( $key, $default = false ) { return $GLOBALS['options'][ $key ] ?? $default; }
function get_locale() { return 'en_US'; }
function is_admin() { return false; }
function wp_doing_ajax() { return false; }
function wp_doing_cron() { return false; }
function load_theme_textdomain( $domain, $path ) {}
function switch_to_locale( $locale ) { $GLOBALS['switched_locale'] = $locale; }
function wp_unslash( $value ) { return stripslashes( $value ); }
function sanitize_key( $value ) { return strtolower( preg_replace( '/[^a-z0-9_\-]/i', '', $value ) ); }
function absint( $value ) { return abs( (int) $value ); }
function home_url( $path = '' ) { return 'https://example.test' . $path; }
function add_query_arg( $key, $value ) { return 'https://example.test/page/?' . $key . '=' . $value; }
function is_front_page() { return false; }
function get_post_type( $id ) { return isset( $GLOBALS['pages'][ $id ] ) ? 'page' : false; }
function get_post_status( $id ) { return $GLOBALS['pages'][ $id ]->post_status ?? false; }
function get_post( $id ) { return $GLOBALS['pages'][ $id ] ?? null; }
function get_the_title( $page ) { return $page->post_title; }
function wp_strip_all_tags( $text ) { return strip_tags( $text ); }
function strip_shortcodes( $text ) { return $text; }
function get_permalink( $id ) { return 'https://example.test/fa/page/' . $id . '/'; }
function pll_current_language( $value = 'slug' ) { return $GLOBALS['polylang_language']; }
function pll_the_languages( $args ) { return $GLOBALS['polylang_links']; }
function pll_home_url( $slug ) { return 'https://example.test/' . $slug . '/'; }
function pll_get_post( $id, $slug ) { return $GLOBALS['translations'][ $id ][ $slug ] ?? 0; }
function expect( $test, $message ) { if ( ! $test ) { throw new RuntimeException( $message ); } }

$GLOBALS['polylang_language'] = 'fa';
$GLOBALS['polylang_links'] = array(
    'en' => array( 'url' => 'https://example.test/en/page/12/' ),
    'fa' => array( 'url' => 'https://example.test/fa/page/22/' ),
);
$GLOBALS['pages'] = array(
    12 => (object) array( 'post_status' => 'publish', 'post_title' => 'English overview', 'post_excerpt' => 'English excerpt' ),
    22 => (object) array( 'post_status' => 'publish', 'post_title' => 'معرفی فارسی', 'post_excerpt' => 'خلاصهٔ فارسی' ),
);
$GLOBALS['translations'] = array( 12 => array( 'en' => 12, 'fa' => 22 ), 22 => array( 'en' => 12, 'fa' => 22 ) );
$GLOBALS['options']['undo_theme_settings'] = array( 'home_overview_page_en' => 12, 'cta_url' => '#project-planner' );
$_COOKIE['undo_lang'] = 'en';
$_GET['undo_lang'] = 'en';

require dirname( __DIR__ ) . '/undo-theme/functions.php';
expect( undo_uses_polylang(), 'Polylang bridge must activate only when its API exists' );
expect( 'fa' === undo_language(), 'Content language must override a stale theme cookie or query value' );
undo_boot_locale();
expect( ! isset( $GLOBALS['switched_locale'] ), 'Theme locale override must not compete with Polylang' );
expect( 'https://example.test/en/page/12/' === undo_language_url( 'en' ), 'Switcher must use a translated content URL' );
expect( 'https://example.test/fa/' === undo_home_url(), 'Home link must use the current language home' );
expect( 'https://example.test/fa/#project-planner' === undo_cta_url(), 'Cross-page CTA must reach the translated Home' );
$reference = undo_home_reference( 'overview', 'Fallback', 'Fallback text' );
expect( 'معرفی فارسی' === $reference['title'] && 'https://example.test/fa/page/22/' === $reference['url'], 'One linked page can resolve its published translation' );
$GLOBALS['translations'][12]['fa'] = 0;
expect( '' === undo_home_reference( 'overview', 'Fallback', 'Fallback text' )['url'], 'Missing translations must not leak another language page' );
$GLOBALS['polylang_links']['en']['url'] = '';
expect( 'https://example.test/en/' === undo_language_url( 'en' ), 'Missing page translations must lead to the target language Home' );
unset( $GLOBALS['polylang_links']['en'] );
expect( '' === undo_language_url( 'en' ), 'Unconfigured languages must not create a false switcher link' );
echo "Polylang bridge checks passed.\n";
