<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
define( 'UNDO_THEME_VERSION', '0.14.0' );
require_once get_template_directory() . '/inc/settings.php';
require_once get_template_directory() . '/inc/page-layout.php';
require_once get_template_directory() . '/inc/github-updater.php';
require_once get_template_directory() . '/inc/starter-pages.php';

function undo_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array( 'height' => 72, 'width' => 240, 'flex-height' => true, 'flex-width' => true ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor.css' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'undo_theme_setup' );

function undo_enable_page_excerpts() { add_post_type_support( 'page', 'excerpt' ); }
add_action( 'init', 'undo_enable_page_excerpts', 5 );

function undo_register_menus() {
    register_nav_menus( array( 'primary' => __( 'Primary menu', 'undo-theme' ), 'footer' => __( 'Footer menu', 'undo-theme' ), 'footer_secondary' => __( 'Footer secondary menu', 'undo-theme' ) ) );
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
    for ( $area = 1; $area <= 3; $area++ ) {
        register_sidebar( array(
            'name' => sprintf( __( 'Footer widget area %d', 'undo-theme' ), $area ),
            'id' => 'footer-widget-' . $area,
            'description' => __( 'Add blocks or widgets here to show them above the footer wordmark.', 'undo-theme' ),
            'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
    }
}
add_action( 'widgets_init', 'undo_register_sidebars' );

function undo_active_footer_widget_areas() {
    if ( ! undo_setting_enabled( 'footer_show_widgets' ) ) { return array(); }
    $areas = array();
    for ( $area = 1; $area <= 3; $area++ ) {
        $id = 'footer-widget-' . $area;
        if ( is_active_sidebar( $id ) ) { $areas[] = $id; }
    }
    return $areas;
}

function undo_footer_widgets_markup() {
    $areas = undo_active_footer_widget_areas();
    if ( ! $areas ) { return ''; }
    ob_start();
    echo '<div class="footer-widgets footer-widgets--' . esc_attr( count( $areas ) ) . '" aria-label="' . esc_attr__( 'Footer widgets', 'undo-theme' ) . '">';
    foreach ( $areas as $area ) {
        echo '<div class="footer-widget-area">';
        dynamic_sidebar( $area );
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode( 'undo_footer_widgets', 'undo_footer_widgets_markup' );

function undo_body_classes( $classes ) {
    $classes[] = 'boxed' === undo_setting( 'site_layout' ) ? 'undo-layout-boxed' : 'undo-layout-wide';
    if ( ! undo_setting_enabled( 'header_sticky' ) ) { $classes[] = 'undo-header-static'; }
    return $classes;
}
add_filter( 'body_class', 'undo_body_classes' );

function undo_has_sidebar( $setting ) {
    return 'hidden' !== undo_sidebar_position() && undo_setting_enabled( $setting ) && is_active_sidebar( 'primary-sidebar' );
}

function undo_language_override() {
    $query = isset( $_GET['undo_lang'] ) && is_string( $_GET['undo_lang'] ) ? sanitize_key( wp_unslash( $_GET['undo_lang'] ) ) : '';
    if ( in_array( $query, array( 'en', 'fa' ), true ) ) { return $query; }
    $cookie = isset( $_COOKIE['undo_lang'] ) && is_string( $_COOKIE['undo_lang'] ) ? sanitize_key( wp_unslash( $_COOKIE['undo_lang'] ) ) : '';
    if ( in_array( $cookie, array( 'en', 'fa' ), true ) ) { return $cookie; }
    return '';
}

function undo_uses_polylang() {
    return function_exists( 'pll_current_language' ) && function_exists( 'pll_the_languages' );
}

function undo_requested_language() {
    if ( undo_uses_polylang() ) {
        $language = pll_current_language( 'slug' );
        if ( in_array( $language, array( 'en', 'fa' ), true ) ) { return $language; }
    }
    $override = undo_language_override();
    if ( $override && ! undo_uses_polylang() ) { return $override; }
    return 0 === strpos( strtolower( str_replace( '-', '_', get_locale() ) ), 'fa' ) ? 'fa' : 'en';
}

function undo_boot_locale() {
    load_theme_textdomain( 'undo-theme', get_template_directory() . '/languages' );
    if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || undo_uses_polylang() ) { return; }
    $override = undo_language_override();
    if ( ! $override ) { return; }
    if ( isset( $_GET['undo_lang'] ) && ! headers_sent() ) {
        setcookie( 'undo_lang', $override, array( 'expires' => time() + YEAR_IN_SECONDS, 'path' => COOKIEPATH ? COOKIEPATH : '/', 'secure' => is_ssl(), 'httponly' => true, 'samesite' => 'Lax' ) );
    }
    if ( function_exists( 'switch_to_locale' ) ) { switch_to_locale( 'fa' === $override ? 'fa_IR' : 'en_US' ); }
}
add_action( 'init', 'undo_boot_locale', 1 );

function undo_language() { return 'fa' === undo_requested_language() ? 'fa' : 'en'; }
function undo_home_url() {
    if ( undo_uses_polylang() && function_exists( 'pll_home_url' ) ) {
        $url = pll_home_url( undo_language() );
        if ( is_string( $url ) && '' !== $url ) { return $url; }
    }
    return home_url( '/' );
}
function undo_cta_url() {
    $url = undo_setting( 'cta_url' );
    return '#' === substr( $url, 0, 1 ) && ! is_front_page() ? undo_home_url() . $url : $url;
}
function undo_footer_action_url() {
    $url = undo_setting( 'footer_action_url' );
    return '#' === substr( $url, 0, 1 ) && ! is_front_page() ? undo_home_url() . $url : $url;
}
function undo_footer_copyright() {
    $text = undo_content( 'footer_copyright', '© {year} UNDO Web Developments' );
    return str_replace( '{year}', wp_date( 'Y' ), $text );
}
function undo_footer_social_links() {
    $networks = array( 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'telegram' => 'Telegram', 'github' => 'GitHub', 'youtube' => 'YouTube', 'x' => 'X' );
    $links = array();
    foreach ( $networks as $key => $label ) {
        $url = undo_setting( 'footer_social_' . $key );
        if ( in_array( wp_parse_url( $url, PHP_URL_SCHEME ), array( 'http', 'https' ), true ) ) { $links[] = array( 'label' => $label, 'url' => $url ); }
    }
    return $links;
}
function undo_content( $key, $fallback ) {
    $value = undo_setting( $key . '_' . undo_language() );
    return '' !== trim( $value ) ? $value : $fallback;
}
function undo_home_reference( $slot, $fallback_title, $fallback_description ) {
    $result = array( 'title' => $fallback_title, 'description' => $fallback_description, 'url' => '' );
    $allowed = array( 'overview', 'service_web', 'service_plugin', 'service_app', 'approach', 'redesign' );
    if ( ! in_array( $slot, $allowed, true ) ) { return $result; }
    $language = undo_language();
    $id = absint( undo_setting( 'home_' . $slot . '_page_' . $language ) );
    if ( undo_uses_polylang() && function_exists( 'pll_get_post' ) ) {
        if ( ! $id ) { $id = absint( undo_setting( 'home_' . $slot . '_page_' . ( 'fa' === $language ? 'en' : 'fa' ) ) ); }
        if ( $id ) { $id = absint( pll_get_post( $id, $language ) ); }
    }
    if ( ! $id || $id === absint( get_option( 'page_on_front', 0 ) ) || 'page' !== get_post_type( $id ) || 'publish' !== get_post_status( $id ) ) { return $result; }
    $page = get_post( $id );
    if ( ! $page ) { return $result; }
    $title = trim( get_the_title( $page ) );
    $excerpt = trim( wp_strip_all_tags( strip_shortcodes( $page->post_excerpt ) ) );
    $url = get_permalink( $id );
    if ( $title ) { $result['title'] = $title; }
    if ( $excerpt ) { $result['description'] = $excerpt; }
    if ( $url ) { $result['url'] = $url; }
    return $result;
}
function undo_language_url( $language ) {
    if ( ! in_array( $language, array( 'en', 'fa' ), true ) ) { return ''; }
    if ( undo_uses_polylang() ) {
        $languages = pll_the_languages( array( 'raw' => true, 'hide_if_empty' => false, 'hide_if_no_translation' => false ) );
        if ( is_array( $languages ) && isset( $languages[ $language ] ) ) {
            $url = isset( $languages[ $language ]['url'] ) && is_string( $languages[ $language ]['url'] ) ? $languages[ $language ]['url'] : '';
            if ( '' !== $url ) { return $url; }
            if ( function_exists( 'pll_home_url' ) ) {
                $home = pll_home_url( $language );
                return is_string( $home ) ? $home : '';
            }
        }
        return '';
    }
    return add_query_arg( 'undo_lang', $language );
}

function undo_font_css_family( $choice, $custom_fonts ) {
    $built_in = array(
        'dm-sans' => '"DM Sans",system-ui,sans-serif',
        'space-grotesk' => '"Space Grotesk",system-ui,sans-serif',
        'vazirmatn' => '"Vazirmatn",system-ui,sans-serif',
        'instrument-serif' => '"Instrument Serif",Georgia,serif',
        'inter' => '"Inter",system-ui,sans-serif',
        'manrope' => '"Manrope",system-ui,sans-serif',
        'playfair-display' => '"Playfair Display",Georgia,serif',
        'noto-sans-arabic' => '"Noto Sans Arabic",system-ui,sans-serif',
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
        'inter' => 'family=Inter:wght@400;500;600;700',
        'manrope' => 'family=Manrope:wght@400;500;600;700',
        'playfair-display' => 'family=Playfair+Display:wght@400;500;600;700',
        'noto-sans-arabic' => 'family=Noto+Sans+Arabic:wght@400;500;600;700',
    );
    $load_google = undo_setting_enabled( 'google_fonts_enabled' );
    $needed_fonts = $load_google ? ( 'fa' === $language ? array( 'space-grotesk', 'vazirmatn' ) : array( 'dm-sans', 'instrument-serif', 'space-grotesk' ) ) : array();
    foreach ( array( 'font_body', 'font_headings', 'font_accent', 'font_navigation', 'font_buttons', 'font_page_title', 'font_post_title', 'font_widget_title', 'font_footer' ) as $role ) {
        $choice = undo_setting( $role );
        if ( $load_google && isset( $google_font_queries[ $choice ] ) && ! in_array( $choice, $needed_fonts, true ) ) { $needed_fonts[] = $choice; }
    }
    if ( $needed_fonts ) {
        $fonts = 'https://fonts.googleapis.com/css2?' . implode( '&', array_map( function( $family ) use ( $google_font_queries ) { return $google_font_queries[ $family ]; }, $needed_fonts ) ) . '&display=swap';
        wp_enqueue_style( 'undo-fonts', esc_url_raw( $fonts ), array(), null );
    }
    wp_enqueue_style( 'undo-site', get_theme_file_uri( '/assets/css/site.css' ), $needed_fonts ? array( 'undo-fonts' ) : array(), UNDO_THEME_VERSION );
    wp_enqueue_style( 'undo-theme', get_stylesheet_uri(), array( 'undo-site' ), UNDO_THEME_VERSION );
    wp_enqueue_script( 'undo-site', get_theme_file_uri( '/assets/js/theme.js' ), array(), UNDO_THEME_VERSION, true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
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
    $width = undo_sanitize_site_dimension( undo_setting( 'content_width' ) );
    $sidebar_width = max( 220, min( 420, (int) undo_setting( 'sidebar_width' ) ) );
    $logo_width = max( 60, min( 360, (int) undo_setting( 'header_logo_width' ) ) );
    $colors = array(
        '--red' => 'accent_color', '--paper' => 'paper_color', '--white' => 'surface_color', '--ink' => 'ink_color', '--muted' => 'muted_color', '--line' => 'line_color',
        '--undo-header-light-bg' => 'header_light_bg_color', '--undo-header-light-text' => 'header_light_text_color', '--undo-header-dark-bg' => 'header_dark_bg_color', '--undo-header-dark-text' => 'header_dark_text_color',
        '--undo-content-title' => 'content_title_color', '--undo-content-body' => 'content_body_color', '--undo-content-link' => 'content_link_color', '--undo-footer-bg' => 'footer_bg_color', '--undo-footer-text' => 'footer_text_color',
    );
    $root = ':root{--undo-content-width:' . $width . ';--undo-sidebar-width:' . $sidebar_width . 'px;--undo-logo-width:' . $logo_width . 'px;';
    $defaults = undo_setting_defaults();
    foreach ( $colors as $variable => $key ) { $root .= $variable . ':' . ( sanitize_hex_color( undo_setting( $key ) ) ?: $defaults[ $key ] ) . ';'; }
    $root .= '}';
    $custom_fonts = undo_custom_fonts();
    $font_css = undo_theme_custom_font_css( $custom_fonts );
    $font_roles = array( 'font_body' => '--body', 'font_headings' => '--display', 'font_accent' => '--serif', 'font_navigation' => '--undo-font-navigation', 'font_buttons' => '--undo-font-buttons', 'font_page_title' => '--undo-font-page-title', 'font_post_title' => '--undo-font-post-title', 'font_widget_title' => '--undo-font-widget-title', 'font_footer' => '--undo-font-footer' );
    $chosen = $load_google ? '' : '--body:system-ui,sans-serif;--display:system-ui,sans-serif;--serif:Georgia,serif;';
    foreach ( $font_roles as $setting => $variable ) {
        $choice = undo_setting( $setting );
        $family = ! $load_google && isset( $google_font_queries[ $choice ] ) ? ( in_array( $choice, array( 'instrument-serif', 'playfair-display' ), true ) ? 'Georgia,serif' : 'system-ui,sans-serif' ) : undo_font_css_family( $choice, $custom_fonts );
        if ( '' !== $family ) { $chosen .= $variable . ':' . $family . ';'; }
    }
    if ( $chosen ) { $font_css .= ':root,html[lang^="fa"]{' . $chosen . '}'; }
    $font_css .= undo_theme_typography_css();
    wp_add_inline_style( 'undo-site', $font_css . $root );
}
function undo_theme_typography_css() {
    $selectors = array(
        'body' => 'body',
        'headings' => '.undo-native-home .hero h1,.undo-native-home .section h2,.wp-content h1,.wp-content h2,.page-header h1,.single-header h1,.archive-copy h2,.page-body h2,.page-body h3,.single-body h2,.single-body h3,.single-related-heading h2',
        'accent' => '.undo-native-home .hero h1 .outline,.undo-native-home .statement h2 span,html[lang^="fa"] .undo-native-home .hero h1 .outline,html[lang^="fa"] .undo-native-home .statement h2 span',
        'navigation' => '.site-header .desktop-nav,.site-header .mobile-nav',
        'buttons' => '.site-header .header-action,.mobile-header-action,.button,.brief-form button,.undo-sidebar button',
        'page_title' => '.page-header h1',
        'post_title' => '.single-header h1',
        'widget_title' => '.undo-sidebar .widget-title,.undo-sidebar .wp-block-heading',
        'footer' => '.footer',
    );
    $css = '';
    $custom_fonts = undo_custom_fonts();
    $google_choices = array( 'dm-sans', 'space-grotesk', 'vazirmatn', 'instrument-serif', 'inter', 'manrope', 'playfair-display', 'noto-sans-arabic' );
    foreach ( $selectors as $role => $selector ) {
        $prefix = 'font_' . $role . '_';
        $declarations = '';
        $choice = undo_setting( 'font_' . $role );
        if ( 'default' !== $choice ) {
            $family = ! undo_setting_enabled( 'google_fonts_enabled' ) && in_array( $choice, $google_choices, true ) ? ( in_array( $choice, array( 'instrument-serif', 'playfair-display' ), true ) ? 'Georgia,serif' : 'system-ui,sans-serif' ) : undo_font_css_family( $choice, $custom_fonts );
            if ( $family ) { $declarations .= 'font-family:' . $family . ';'; }
        }
        $size = (int) undo_setting( $prefix . 'size' );
        if ( $size >= 10 && $size <= 160 ) { $declarations .= 'font-size:' . $size . 'px;'; }
        $weight = undo_setting( $prefix . 'weight' );
        if ( in_array( $weight, array( '300', '400', '500', '600', '700', '800' ), true ) ) { $declarations .= 'font-weight:' . $weight . ';'; }
        $style = undo_setting( $prefix . 'style' );
        if ( in_array( $style, array( 'normal', 'italic' ), true ) ) { $declarations .= 'font-style:' . $style . ';'; }
        $line_height = (float) undo_setting( $prefix . 'line_height' );
        if ( $line_height >= 0.8 && $line_height <= 3 ) { $declarations .= 'line-height:' . $line_height . ';'; }
        $letter_spacing = (float) undo_setting( $prefix . 'letter_spacing' );
        if ( $letter_spacing >= -5 && $letter_spacing <= 10 && 0.0 !== $letter_spacing ) { $declarations .= 'letter-spacing:' . $letter_spacing . 'px;'; }
        $word_spacing = (float) undo_setting( $prefix . 'word_spacing' );
        if ( $word_spacing >= -5 && $word_spacing <= 20 && 0.0 !== $word_spacing ) { $declarations .= 'word-spacing:' . $word_spacing . 'px;'; }
        $color = sanitize_hex_color( undo_setting( $prefix . 'color' ) );
        if ( $color ) { $declarations .= 'color:' . $color . ';'; }
        if ( $declarations ) { $css .= $selector . '{' . $declarations . '}'; }
    }
    return $css;
}
add_action( 'wp_enqueue_scripts', 'undo_theme_assets' );

function undo_register_elementor_locations( $manager ) { $manager->register_all_core_location(); }
add_action( 'elementor/theme/register_locations', 'undo_register_elementor_locations' );

function undo_nav_fallback( $args ) {
    $items = array();
    if ( undo_setting_enabled( 'home_show_services' ) ) { $items[ __( 'Services', 'undo-theme' ) ] = '#services'; }
    if ( undo_setting_enabled( 'home_show_approach' ) ) { $items[ __( 'Approach', 'undo-theme' ) ] = '#approach'; }
    $items[ __( 'Project planner', 'undo-theme' ) ] = '#project-planner';
    echo '<ul class="nav-list">';
    foreach ( $items as $label => $anchor ) { echo '<li><a href="' . esc_url( undo_home_url() . $anchor ) . '">' . esc_html( $label ) . '</a></li>'; }
    echo '</ul>';
}

function undo_primary_menu_submenu_toggle( $output, $item, $depth, $args ) {
    if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location || empty( $item->classes ) || ! in_array( 'menu-item-has-children', (array) $item->classes, true ) ) { return $output; }
    $label = sprintf( __( 'Toggle submenu for %s', 'undo-theme' ), wp_strip_all_tags( $item->title ) );
    return $output . '<button class="submenu-toggle" type="button" aria-expanded="false" aria-label="' . esc_attr( $label ) . '"><span aria-hidden="true"></span></button>';
}
add_filter( 'walker_nav_menu_start_el', 'undo_primary_menu_submenu_toggle', 10, 4 );

function undo_elementor_active() { return did_action( 'elementor/loaded' ) > 0; }

function undo_is_elementor_page() {
    return undo_elementor_active() && is_singular() && 'builder' === get_post_meta( get_queried_object_id(), '_elementor_edit_mode', true );
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
