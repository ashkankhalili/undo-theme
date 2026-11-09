<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
define( 'UNDO_THEME_VERSION', '0.2.8' );
require_once get_template_directory() . '/inc/settings.php';
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

function undo_requested_language() {
    $query = isset( $_GET['undo_lang'] ) && is_string( $_GET['undo_lang'] ) ? sanitize_key( wp_unslash( $_GET['undo_lang'] ) ) : '';
    if ( in_array( $query, array( 'en', 'fa' ), true ) ) { return $query; }
    $cookie = isset( $_COOKIE['undo_lang'] ) && is_string( $_COOKIE['undo_lang'] ) ? sanitize_key( wp_unslash( $_COOKIE['undo_lang'] ) ) : '';
    if ( in_array( $cookie, array( 'en', 'fa' ), true ) ) { return $cookie; }
    return undo_setting( 'default_language' );
}

function undo_boot_locale() {
    load_theme_textdomain( 'undo-theme', get_template_directory() . '/languages' );
    if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) { return; }
    $language = undo_requested_language();
    if ( isset( $_GET['undo_lang'] ) && ! headers_sent() ) {
        setcookie( 'undo_lang', $language, array( 'expires' => time() + YEAR_IN_SECONDS, 'path' => COOKIEPATH ? COOKIEPATH : '/', 'secure' => is_ssl(), 'httponly' => true, 'samesite' => 'Lax' ) );
    }
    if ( function_exists( 'switch_to_locale' ) ) { switch_to_locale( 'fa' === $language ? 'fa_IR' : 'en_US' ); }
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

function undo_theme_assets() {
    $language = undo_language();
    $fonts = 'fa' === $language
        ? 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Vazirmatn:wght@400;500;600;700&display=swap'
        : 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Instrument+Serif:ital@0;1&family=Space+Grotesk:wght@400;500;600;700&display=swap';
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
    $accent = undo_setting( 'accent_color' );
    $width = max( 760, min( 1600, (int) undo_setting( 'content_width' ) ) );
    $sidebar_width = max( 220, min( 420, (int) undo_setting( 'sidebar_width' ) ) );
    $logo_width = max( 60, min( 360, (int) undo_setting( 'header_logo_width' ) ) );
    wp_add_inline_style( 'undo-site', ':root{--red:' . esc_html( sanitize_hex_color( $accent ) ?: '#b83b30' ) . ';--undo-content-width:' . $width . 'px;--undo-sidebar-width:' . $sidebar_width . 'px;--undo-logo-width:' . $logo_width . 'px}' );
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
