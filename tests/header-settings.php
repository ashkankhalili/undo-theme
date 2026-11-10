<?php
define( 'ABSPATH', __DIR__ . '/' );
function get_template_directory() { return dirname( __DIR__ ) . '/undo-theme'; }
function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function __( $message, $domain = 'default' ) { return $message; }
function get_option( $key, $default = false ) { return $GLOBALS['options'][ $key ] ?? $default; }
function get_locale() { return $GLOBALS['site_locale'] ?? 'en_US'; }
function wp_unslash( $value ) { return stripslashes( $value ); }
function wp_attachment_is_image( $id ) { return 42 === $id; }
function get_post_mime_type( $id ) { return $GLOBALS['font_mimes'][ $id ] ?? ''; }
function get_attached_file( $id ) { return $GLOBALS['font_files'][ $id ] ?? ''; }
function sanitize_text_field( $value ) { return strip_tags( $value ); }
function sanitize_hex_color( $value ) { return is_string( $value ) && preg_match( '/^#[0-9a-fA-F]{6}$/', $value ) ? strtolower( $value ) : null; }
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
expect( ! isset( undo_settings_sections()['layout'][2]['accent_color'] ) && isset( undo_settings_sections()['colors'][2]['accent_color'] ), 'Color controls must live in the Colors section' );
expect( isset( undo_settings_sections()['typography'][2]['custom_fonts'] ), 'Typography must provide custom font management' );
$GLOBALS['font_mimes'] = array( 101 => 'font/woff2', 102 => 'application/font-woff2', 103 => 'image/png' );
$GLOBALS['font_files'] = array( 101 => '/uploads/regular.woff2', 102 => '/uploads/bold.woff2', 103 => '/uploads/not-font.png' );
$font_input = array( array( 'id' => 'custom-1', 'name' => 'Studio Sans', 'regular_id' => '101', 'bold_id' => '102' ), array( 'id' => 'custom-2', 'name' => 'Bad File', 'regular_id' => '103' ) );
$settings = undo_sanitize_settings( array( 'custom_fonts_present' => '1', 'custom_fonts' => $font_input, 'font_body' => 'custom-1', 'font_navigation' => 'custom-2', 'accent_color' => '#123456', 'site_layout' => 'boxed' ) );
expect( 1 === count( $settings['custom_fonts'] ) && 'Studio Sans' === $settings['custom_fonts'][0]['name'] && 102 === $settings['custom_fonts'][0]['bold_id'], 'Only valid WOFF2 font attachments must be saved' );
expect( 'custom-1' === $settings['font_body'] && 'default' === $settings['font_navigation'] && '#123456' === $settings['accent_color'] && 'boxed' === $settings['site_layout'], 'All sections must save together and invalid font choices must fall back' );
$GLOBALS['options']['undo_theme_settings'] = $settings;
$settings = undo_sanitize_settings( array( 'custom_fonts_present' => '1', 'font_body' => 'custom-1' ) );
expect( array() === $settings['custom_fonts'] && 'default' === $settings['font_body'], 'Removing the last custom font must clear its typography assignment' );
$GLOBALS['options'] = array();
expect( 'light' === $defaults['header_style'] && 'standard' === $defaults['header_layout'] && '0' === $defaults['header_show_search'], 'New header options must keep the existing appearance by default' );
$GLOBALS['options']['undo_theme_settings'] = array( 'footer_show_brand' => '0' );
$settings = undo_sanitize_settings( array( 'header_style' => 'invalid', 'header_layout' => 'centered', 'header_show_search' => '1', 'header_logo_light_id' => '42' ) );
expect( 'light' === $settings['header_style'] && 'centered' === $settings['header_layout'] && '1' === $settings['header_show_search'] && '42' === $settings['header_logo_light_id'], 'Header choices must validate and save' );
expect( '0' === $settings['footer_show_brand'], 'Saving the header must preserve settings from other tabs' );
$settings = undo_sanitize_settings( array( 'header_logo_light_id' => '999' ) );
expect( '0' === $settings['header_logo_light_id'], 'Header logos must be image attachments' );

expect( '1' === $defaults['page_show_title'] && 'editorial' === $defaults['page_title_style'] && '0' === $defaults['page_show_breadcrumbs'] && '0' === $defaults['page_show_featured'] && 'reading' === $defaults['page_content_width'], 'New page controls must keep optional elements off by default' );
$GLOBALS['options']['undo_theme_settings'] = array( 'footer_show_brand' => '0', 'header_style' => 'dark' );
$settings = undo_sanitize_settings( array( 'page_title_style' => 'compact', 'page_show_breadcrumbs' => '1', 'page_show_featured' => '1', 'page_content_width' => 'wide' ) );
expect( 'compact' === $settings['page_title_style'] && '1' === $settings['page_show_breadcrumbs'] && '1' === $settings['page_show_featured'] && 'wide' === $settings['page_content_width'], 'Page choices must validate and save' );
expect( 'dark' === $settings['header_style'] && '0' === $settings['footer_show_brand'], 'Saving pages must preserve settings from other tabs' );
$settings = undo_sanitize_settings( array( 'page_title_style' => 'invalid', 'page_content_width' => 'invalid' ) );
expect( 'editorial' === $settings['page_title_style'] && 'reading' === $settings['page_content_width'], 'Invalid page select values must fall back to safe defaults' );
expect( '1200px' === undo_sanitize_page_dimension( '1200px' ) && '80%' === undo_sanitize_page_dimension( '80%' ), 'Page dimensions must accept safe pixel and percentage values' );
expect( '' === undo_sanitize_page_dimension( '200vw', '' ) && '' === undo_sanitize_page_dimension( '0%', '' ) && '' === undo_sanitize_page_dimension( 'url(1)', '' ), 'Invalid page dimensions must be rejected' );
$defaults = undo_setting_defaults();
expect( ! isset( $defaults['page_custom_width'], $defaults['default_language'] ) && '760px' === $defaults['page_reading_width'] && '1440px' === $defaults['page_wide_width'] && '1100px' === $defaults['page_boxed_width'] && '100%' === $defaults['page_full_width'], 'Each reusable template must have a visible default width and Custom Width must remain per page' );
$GLOBALS['options']['undo_theme_settings'] = array( 'footer_show_brand' => '0' );
$settings = undo_sanitize_settings( array( 'page_wide_width' => '80%', 'page_wide_margin_inline' => '180', 'page_boxed_padding_inline' => '72', 'page_full_padding_top' => '24' ) );
expect( '80%' === $settings['page_wide_width'] && '160' === $settings['page_wide_margin_inline'] && '72' === $settings['page_boxed_padding_inline'] && '24' === $settings['page_full_padding_top'], 'Template width and spacing controls must validate and clamp' );
expect( '0' === $settings['footer_show_brand'], 'Saving template controls must preserve other settings tabs' );
$defaults = undo_setting_defaults();
expect( 'lined' === $defaults['sidebar_widget_style'] && '32' === $defaults['sidebar_widget_spacing'] && '0' === $defaults['sidebar_sticky'], 'Sidebar design and sticky behavior must preserve existing defaults' );
$GLOBALS['options']['undo_theme_settings'] = array( 'page_wide_width' => '80%', 'footer_show_brand' => '0' );
$settings = undo_sanitize_settings( array( 'sidebar_position' => 'start', 'sidebar_width' => '999', 'sidebar_widget_style' => 'panel', 'sidebar_widget_spacing' => '8', 'sidebar_sticky' => '1', 'sidebar_sticky_offset' => '200' ) );
expect( 'start' === $settings['sidebar_position'] && '420' === $settings['sidebar_width'] && 'panel' === $settings['sidebar_widget_style'] && '16' === $settings['sidebar_widget_spacing'] && '1' === $settings['sidebar_sticky'] && '120' === $settings['sidebar_sticky_offset'], 'Sidebar controls must validate and clamp' );
expect( '80%' === $settings['page_wide_width'] && '0' === $settings['footer_show_brand'], 'Saving sidebar controls must preserve the new Pages settings and other sections' );
$settings = undo_sanitize_settings( array( 'sidebar_widget_style' => 'invalid' ) );
expect( 'lined' === $settings['sidebar_widget_style'], 'Unknown widget styles must fall back to lined' );
$GLOBALS['site_locale'] = 'fa_IR';
expect( 'fa' === undo_requested_language(), 'WordPress Persian site language must determine the initial theme language' );
$GLOBALS['site_locale'] = 'en_US';
expect( 'en' === undo_requested_language(), 'WordPress English site language must determine the initial theme language' );

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
