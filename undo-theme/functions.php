<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
define( 'UNDO_THEME_VERSION', '0.5.0' );
require_once get_template_directory() . '/inc/settings.php';
require_once get_template_directory() . '/inc/page-layout.php';
require_once get_template_directory() . '/inc/github-updater.php';

function undo_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array( 'height' => 72, 'width' => 240, 'flex-height' => true, 'flex-width' => true ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'undo_theme_setup' );

function undo_register_menus() {
    register_nav_menus( array( 'primary' => __( 'Primary menu', 'undo-theme' ), 'footer' => __( 'Footer menu', 'undo-theme' ) ) );
}
add_action( 'init', 'undo_register_menus', 2 );

function undo_register_sidebars() {
    register_sidebar( array(
        'name' => __( 'Primary sidebar', 'undo-theme' ),
        'id' => 'primary-sidebar',
        'description' => __( 'Widgets shown beside posts, pages, or archives when enabled in UNDO Theme Settings.', 'undo-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ) );
}
add_action( 'widgets_init', 'undo_register_sidebars' );

function undo_body_classes( $classes ) {
    $classes[] = 'boxed' === undo_setting( 'site_layout' ) ? 'undo-layout-boxed' : 'undo-layout-wide';
    if ( ! undo_setting_enabled( 'header_sticky' ) ) { $classes[] = 'undo-header-static'; }
    return $classes;
}
add_filter( 'body_class', 'undo_body_classes' );

function undo_has_sidebar( $setting ) {
    return undo_setting_enabled( $setting ) && is_active_sidebar( 'primary-sidebar' );
}

function undo_language_override() {
    $query = isset( $_GET['undo_lang'] ) && is_string( $_GET['undo_lang'] ) ? sanitize_key( wp_unslash( $_GET['undo_lang'] ) ) : '';
    if ( in_array( $query, array( 'en', 'fa' ), true ) ) { return $query; }
    $cookie = isset( $_COOKIE['undo_lang'] ) && is_string( $_COOKIE['undo_lang'] ) ? sanitize_key( wp_unslash( $_COOKIE['undo_lang'] ) ) : '';
    if ( in_array( $cookie, array( 'en', 'fa' ), true ) ) { return $cookie; }
    return '';
}

function undo_requested_language() {
    $override = undo_language_override();
    if ( $override ) { return $override; }
    return 0 === strpos( strtolower( str_replace( '-', '_', get_locale() ) ), 'fa' ) ? 'fa' : 'en';
}

function undo_boot_locale() {
    load_theme_textdomain( 'undo-theme', get_template_directory() . '/languages' );
    if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) { return; }
    $override = undo_language_override();
    if ( ! $override ) { return; }
    if ( isset( $_GET['undo_lang'] ) && ! headers_sent() ) {
        setcookie( 'undo_lang', $override, array( 'expires' => time() + YEAR_IN_SECONDS, 'path' => COOKIEPATH ? COOKIEPATH : '/', 'secure' => is_ssl(), 'httponly' => true, 'samesite' => 'Lax' ) );
    }
    if ( function_exists( 'switch_to_locale' ) ) { switch_to_locale( 'fa' === $override ? 'fa_IR' : 'en_US' ); }
}
add_action( 'init', 'undo_boot_locale', 1 );

function undo_language() { return 'fa' === undo_requested_language() ? 'fa' : 'en'; }
function undo_cta_url() {
    $url = undo_setting( 'cta_url' );
    return '#' === substr( $url, 0, 1 ) && ! is_front_page() ? home_url( '/' ) . $url : $url;
}
function undo_content( $key, $fallback ) {
    $value = undo_setting( $key . '_' . undo_language() );
    return '' !== trim( $value ) ? $value : $fallback;
}
function undo_language_url( $language ) { return add_query_arg( 'undo_lang', $language ); }

function undo_font_css_family( $choice, $custom_fonts ) {
    $built_in = array(
        'dm-sans' => '"DM Sans",system-ui,sans-serif',
        'space-grotesk' => '"Space Grotesk",system-ui,sans-serif',
        'vazirmatn' => '"Vazirmatn",system-ui,sans-serif',
        'instrument-serif' => '"Instrument Serif",Georgia,serif',
        'system-sans' => 'system-ui,sans-serif',
        'georgia' => 'Georgia,serif',
    );
    if ( isset( $built_in[ $choice ] ) ) { return $built_in[ $choice ]; }
    foreach ( $custom_fonts as $font ) {
        if ( isset( $font['id'], $font['regular_id'] ) && $font['id'] === $choice && undo_font_attachment_is_valid( (int) $font['regular_id'] ) ) { return '"UNDO Custom ' . $choice . '",system-ui,sans-serif'; }
    }
    return '';
}

function undo_theme_custom_font_css( $custom_fonts ) {
    $css = '';
    foreach ( $custom_fonts as $font ) {
        if ( ! isset( $font['id'] ) || ! preg_match( '/^custom-[1-9][0-9]{0,2}$/', $font['id'] ) ) { continue; }
        foreach ( array( 'regular_id' => 400, 'bold_id' => 700 ) as $key => $weight ) {
            $attachment_id = isset( $font[ $key ] ) ? (int) $font[ $key ] : 0;
            if ( ! undo_font_attachment_is_valid( $attachment_id ) ) { continue; }
            $url = wp_get_attachment_url( $attachment_id );
            if ( ! $url ) { continue; }
            $css .= '@font-face{font-family:"UNDO Custom ' . $font['id'] . '";src:url(' . wp_json_encode( esc_url_raw( $url ) ) . ') format("woff2");font-weight:' . $weight . ';font-style:normal;font-display:swap}';
        }
    }
    return $css;
}

function undo_theme_assets() {
    $language = undo_language();
    $google_font_queries = array(
        'dm-sans' => 'family=DM+Sans:wght@400;500;600;700',
        'instrument-serif' => 'family=Instrument+Serif:ital@0;1',
        'space-grotesk' => 'family=Space+Grotesk:wght@400;500;600;700',
        'vazirmatn' => 'family=Vazirmatn:wght@400;500;600;700',
    );
    $needed_fonts = 'fa' === $language ? array( 'space-grotesk', 'vazirmatn' ) : array( 'dm-sans', 'instrument-serif', 'space-grotesk' );
    foreach ( array( 'font_body', 'font_headings', 'font_accent', 'font_navigation', 'font_buttons', 'font_page_title', 'font_post_title', 'font_widget_title', 'font_footer' ) as $role ) {
        $choice = undo_setting( $role );
        if ( isset( $google_font_queries[ $choice ] ) && ! in_array( $choice, $needed_fonts, true ) ) { $needed_fonts[] = $choice; }
    }
    $fonts = 'https://fonts.googleapis.com/css2?' . implode( '&', array_map( function( $family ) use ( $google_font_queries ) { return $google_font_queries[ $family ]; }, $needed_fonts ) ) . '&display=swap';
    wp_enqueue_style( 'undo-fonts', esc_url_raw( $fonts ), array(), null );
    wp_enqueue_style( 'undo-site', get_theme_file_uri( '/assets/css/site.css' ), array( 'undo-fonts' ), UNDO_THEME_VERSION );
    wp_enqueue_style( 'undo-theme', get_stylesheet_uri(), array( 'undo-site' ), UNDO_THEME_VERSION );
    wp_enqueue_script( 'undo-site', get_theme_file_uri( '/assets/js/theme.js' ), array(), UNDO_THEME_VERSION, true );
    wp_localize_script( 'undo-site', 'undoTheme', array(
        'language' => $language,
        'menuOpen' => __( 'Open menu', 'undo-theme' ),
        'menuClose' => __( 'Close menu', 'undo-theme' ),
        'searchOpen' => __( 'Open search', 'undo-theme' ),
        'searchClose' => __( 'Close search', 'undo-theme' ),
        'comparisonValue' => __( '%s%% of the earlier layout visible', 'undo-theme' ),
        'briefTitle' => __( 'UNDO Web Developments — Project brief', 'undo-theme' ),
        'project' => __( 'Project', 'undo-theme' ),
        'service' => __( 'Service', 'undo-theme' ),
        'startingPoint' => __( 'Starting point', 'undo-theme' ),
        'goal' => __( 'Goal', 'undo-theme' ),
        'untitled' => __( 'Untitled project', 'undo-theme' ),
        'toDiscuss' => __( 'To be discussed', 'undo-theme' ),
        'downloaded' => __( 'Your project brief has been downloaded.', 'undo-theme' ),
        'serviceLabels' => array(
            'Website' => __( 'Website', 'undo-theme' ),
            'WordPress plugin' => __( 'WordPress plugin', 'undo-theme' ),
            'Mobile app' => __( 'Mobile app', 'undo-theme' ),
        ),
        'stageLabels' => array(
            'A new project' => __( 'Something new', 'undo-theme' ),
            'A redesign' => __( 'A redesign', 'undo-theme' ),
        ),
    ) );
    $width = max( 760, min( 1600, (int) undo_setting( 'content_width' ) ) );
    $sidebar_width = max( 220, min( 420, (int) undo_setting( 'sidebar_width' ) ) );
    $logo_width = max( 60, min( 360, (int) undo_setting( 'header_logo_width' ) ) );
    $colors = array(
        '--red' => 'accent_color', '--paper' => 'paper_color', '--white' => 'surface_color', '--ink' => 'ink_color', '--muted' => 'muted_color', '--line' => 'line_color',
        '--undo-header-light-bg' => 'header_light_bg_color', '--undo-header-light-text' => 'header_light_text_color', '--undo-header-dark-bg' => 'header_dark_bg_color', '--undo-header-dark-text' => 'header_dark_text_color',
        '--undo-content-title' => 'content_title_color', '--undo-content-body' => 'content_body_color', '--undo-content-link' => 'content_link_color', '--undo-footer-bg' => 'footer_bg_color', '--undo-footer-text' => 'footer_text_color',
    );
    $root = ':root{--undo-content-width:' . $width . 'px;--undo-sidebar-width:' . $sidebar_width . 'px;--undo-logo-width:' . $logo_width . 'px;';
    $defaults = undo_setting_defaults();
    foreach ( $colors as $variable => $key ) { $root .= $variable . ':' . ( sanitize_hex_color( undo_setting( $key ) ) ?: $defaults[ $key ] ) . ';'; }
    $root .= '}';
    $custom_fonts = undo_custom_fonts();
    $font_css = undo_theme_custom_font_css( $custom_fonts );
    $font_roles = array( 'font_body' => '--body', 'font_headings' => '--display', 'font_accent' => '--serif', 'font_navigation' => '--undo-font-navigation', 'font_buttons' => '--undo-font-buttons', 'font_page_title' => '--undo-font-page-title', 'font_post_title' => '--undo-font-post-title', 'font_widget_title' => '--undo-font-widget-title', 'font_footer' => '--undo-font-footer' );
    $chosen = '';
    foreach ( $font_roles as $setting => $variable ) {
        $family = undo_font_css_family( undo_setting( $setting ), $custom_fonts );
        if ( '' !== $family ) { $chosen .= $variable . ':' . $family . ';'; }
    }
    if ( $chosen ) { $font_css .= ':root,html[lang^="fa"]{' . $chosen . '}'; }
    wp_add_inline_style( 'undo-site', $font_css . $root );
}
add_action( 'wp_enqueue_scripts', 'undo_theme_assets' );

function undo_register_elementor_locations( $manager ) { $manager->register_all_core_location(); }
add_action( 'elementor/theme/register_locations', 'undo_register_elementor_locations' );

function undo_nav_fallback( $args ) {
    $items = array(
        __( 'Services', 'undo-theme' ) => '#services',
        __( 'Approach', 'undo-theme' ) => '#approach',
        __( 'Project planner', 'undo-theme' ) => '#project-planner',
    );
    echo '<ul class="nav-list">';
    foreach ( $items as $label => $anchor ) { echo '<li><a href="' . esc_url( home_url( '/' ) . $anchor ) . '">' . esc_html( $label ) . '</a></li>'; }
    echo '</ul>';
}

function undo_primary_menu_submenu_toggle( $output, $item, $depth, $args ) {
    if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location || empty( $item->classes ) || ! in_array( 'menu-item-has-children', (array) $item->classes, true ) ) { return $output; }
    $label = sprintf( __( 'Toggle submenu for %s', 'undo-theme' ), wp_strip_all_tags( $item->title ) );
    return $output . '<button class="submenu-toggle" type="button" aria-expanded="false" aria-label="' . esc_attr( $label ) . '"><span aria-hidden="true"></span></button>';
}
add_filter( 'walker_nav_menu_start_el', 'undo_primary_menu_submenu_toggle', 10, 4 );

function undo_is_elementor_page() {
    return is_singular() && 'builder' === get_post_meta( get_queried_object_id(), '_elementor_edit_mode', true );
}

function undo_related_posts( $post_id ) {
    if ( ! undo_setting_enabled( 'single_show_related' ) ) { return array(); }
    $categories = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
    if ( is_wp_error( $categories ) || ! is_array( $categories ) || ! $categories ) { return array(); }
    $count = max( 2, min( 3, (int) undo_setting( 'single_related_count' ) ) );
    return get_posts( array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $count,
        'post__not_in' => array( (int) $post_id ),
        'category__in' => array_map( 'intval', $categories ),
        'suppress_filters' => false,
        'ignore_sticky_posts' => true,
        'no_found_rows' => true,
    ) );
}
