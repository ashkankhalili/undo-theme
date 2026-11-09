<?php
define( 'ABSPATH', __DIR__ . '/' );
function get_template_directory() { return dirname( __DIR__ ) . '/undo-theme'; }
function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function __( $message, $domain = 'default' ) { return $message; }
function get_option( $key, $default = false ) { return $GLOBALS['options'][ $key ] ?? $default; }
function wp_unslash( $value ) { return stripslashes( $value ); }
function wp_attachment_is_image( $id ) { return 42 === $id; }
function sanitize_text_field( $value ) { return strip_tags( $value ); }
function esc_url( $value ) { return htmlspecialchars( $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ); }
function esc_html( $value ) { return htmlspecialchars( $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ); }
function esc_attr( $value ) { return htmlspecialchars( $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ); }
function wp_strip_all_tags( $value ) { return strip_tags( $value ); }
function home_url( $path = '' ) { return 'https://example.test' . $path; }
function wp_get_post_categories( $post_id, $args = array() ) { return $GLOBALS['test_categories'] ?? array(); }
function is_wp_error( $value ) { return false; }
function get_posts( $args ) { $GLOBALS['related_query'] = $args; return array( (object) array( 'ID' => 12 ) ); }
function expect( $condition, $message ) { if ( ! $condition ) { throw new RuntimeException( $message ); } }

require dirname( __DIR__ ) . '/undo-theme/functions.php';

$defaults = undo_setting_defaults();
expect( 'light' === $defaults['header_style'] && 'standard' === $defaults['header_layout'] && '0' === $defaults['header_show_search'], 'New header options must keep the existing appearance by default' );
$GLOBALS['options']['undo_theme_settings'] = array( 'footer_show_brand' => '0' );
$settings = undo_sanitize_settings( array( 'header_style' => 'invalid', 'header_layout' => 'centered', 'header_show_search' => '1', 'header_logo_light_id' => '42' ) );
expect( 'light' === $settings['header_style'] && 'centered' === $settings['header_layout'] && '1' === $settings['header_show_search'] && '42' === $settings['header_logo_light_id'], 'Header choices must validate and save' );
expect( '0' === $settings['footer_show_brand'], 'Saving the header must preserve settings from other tabs' );
$settings = undo_sanitize_settings( array( 'header_logo_light_id' => '999' ) );
expect( '0' === $settings['header_logo_light_id'], 'Header logos must be image attachments' );

ob_start();
undo_nav_fallback( array() );
$fallback = ob_get_clean();
expect( false !== strpos( $fallback, '<ul class="nav-list"><li>' ) && false !== strpos( $fallback, '</li></ul>' ), 'Fallback navigation must have valid list markup' );
$item = (object) array( 'classes' => array( 'menu-item-has-children' ), 'title' => 'D&D "Studio"' );
$primary = (object) array( 'theme_location' => 'primary' );
$footer = (object) array( 'theme_location' => 'footer' );
$output = undo_primary_menu_submenu_toggle( '<a href="#">Parent</a>', $item, 0, $primary );
expect( false !== strpos( $output, 'class="submenu-toggle"' ) && false !== strpos( $output, 'aria-label="Toggle submenu for D&amp;D &quot;Studio&quot;"' ), 'Primary submenu controls must be labeled and escaped' );
expect( '<a href="#">Parent</a>' === undo_primary_menu_submenu_toggle( '<a href="#">Parent</a>', $item, 0, $footer ), 'Footer menu must be unchanged' );
echo "Header settings and navigation checks passed.\n";
$defaults = undo_setting_defaults();
expect( '0' === $defaults['single_show_related'] && '2' === $defaults['single_related_count'], 'Related posts must stay off by default' );
$GLOBALS['options']['undo_theme_settings'] = array( 'single_show_related' => '1', 'single_related_count' => '3', 'footer_show_brand' => '0' );
$GLOBALS['test_categories'] = array( 4, 7 );
$related = undo_related_posts( 11 );
expect( 1 === count( $related ), 'Related posts must be returned when enabled and categorized' );
expect( 3 === $GLOBALS['related_query']['posts_per_page'] && array( 11 ) === $GLOBALS['related_query']['post__not_in'] && false === $GLOBALS['related_query']['suppress_filters'], 'Related posts must cap count, exclude the current post, and respect language filters' );
$GLOBALS['test_categories'] = array();
expect( array() === undo_related_posts( 11 ), 'Uncategorized posts must not show unrelated items' );
$settings = undo_sanitize_settings( array( 'single_related_count' => '99', 'single_show_related' => '1' ) );
expect( '3' === $settings['single_related_count'] && '0' === $settings['footer_show_brand'], 'Related count must clamp and settings tabs must remain isolated' );
echo "Single post settings and related query checks passed.\n";
