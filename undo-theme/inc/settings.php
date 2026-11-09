<?php
/** All customer theme choices are stored in one option. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function undo_page_template_presets() {
    return array(
        'reading' => array( 'title' => __( 'UNDO Reading', 'undo-theme' ), 'width' => '760px', 'margin_inline' => '48', 'margin_top' => '0', 'margin_bottom' => '0', 'padding_inline' => '0', 'padding_top' => '112', 'padding_bottom' => '160' ),
        'wide' => array( 'title' => __( 'UNDO Wide', 'undo-theme' ), 'width' => '1440px', 'margin_inline' => '48', 'margin_top' => '0', 'margin_bottom' => '0', 'padding_inline' => '0', 'padding_top' => '112', 'padding_bottom' => '160' ),
        'boxed' => array( 'title' => __( 'UNDO Boxed', 'undo-theme' ), 'width' => '1100px', 'margin_inline' => '48', 'margin_top' => '0', 'margin_bottom' => '0', 'padding_inline' => '64', 'padding_top' => '112', 'padding_bottom' => '160' ),
        'full' => array( 'title' => __( 'UNDO Full Width', 'undo-theme' ), 'width' => '100%', 'margin_inline' => '0', 'margin_top' => '0', 'margin_bottom' => '0', 'padding_inline' => '64', 'padding_top' => '112', 'padding_bottom' => '160' ),
    );
}

function undo_page_template_fields() {
    $fields = array();
    foreach ( undo_page_template_presets() as $mode => $preset ) {
        $prefix = 'page_' . $mode . '_';
        $fields[ $prefix . 'width' ] = array( __( 'Maximum width', 'undo-theme' ), 'dimension', $preset['width'] );
        $fields[ $prefix . 'margin_inline' ] = array( __( 'Minimum side margin in pixels', 'undo-theme' ), 'number', $preset['margin_inline'], array( 0, 160 ) );
        $fields[ $prefix . 'margin_top' ] = array( __( 'Top margin in pixels', 'undo-theme' ), 'number', $preset['margin_top'], array( 0, 240 ) );
        $fields[ $prefix . 'margin_bottom' ] = array( __( 'Bottom margin in pixels', 'undo-theme' ), 'number', $preset['margin_bottom'], array( 0, 240 ) );
        $fields[ $prefix . 'padding_inline' ] = array( __( 'Side padding in pixels', 'undo-theme' ), 'number', $preset['padding_inline'], array( 0, 160 ) );
        $fields[ $prefix . 'padding_top' ] = array( __( 'Top padding in pixels', 'undo-theme' ), 'number', $preset['padding_top'], array( 0, 240 ) );
        $fields[ $prefix . 'padding_bottom' ] = array( __( 'Bottom padding in pixels', 'undo-theme' ), 'number', $preset['padding_bottom'], array( 0, 240 ) );
    }
    return $fields;
}

function undo_settings_sections() {
    static $sections = null;
    if ( null !== $sections ) { return $sections; }
    $sections = array(
        'layout' => array( __( 'Website layout', 'undo-theme' ), __( 'Site width and shared colors. The initial language follows WordPress Site Language.', 'undo-theme' ), array(
            'accent_color' => array( __( 'Accent color', 'undo-theme' ), 'color', '#b83b30' ),
            'site_layout' => array( __( 'Site width', 'undo-theme' ), 'select', 'wide', array( 'wide' => __( 'Wide', 'undo-theme' ), 'boxed' => __( 'Boxed', 'undo-theme' ) ) ),
            'content_width' => array( __( 'Content width in pixels', 'undo-theme' ), 'number', '1440', array( 760, 1600 ) ),
        ) ),
        'header' => array( __( 'Header', 'undo-theme' ), __( 'Built-in header settings. Elementor Theme Builder can replace this template.', 'undo-theme' ), array(
            'header_logo_id' => array( __( 'Header logo', 'undo-theme' ), 'media', '0' ),
            'header_logo_light_id' => array( __( 'Light logo for dark header', 'undo-theme' ), 'media', '0' ),
            'header_logo_width' => array( __( 'Maximum logo width in pixels', 'undo-theme' ), 'number', '220', array( 60, 360 ) ),
            'header_style' => array( __( 'Header color style', 'undo-theme' ), 'select', 'light', array( 'light' => __( 'Light', 'undo-theme' ), 'dark' => __( 'Dark', 'undo-theme' ) ) ),
            'header_layout' => array( __( 'Header layout', 'undo-theme' ), 'select', 'standard', array( 'standard' => __( 'Standard', 'undo-theme' ), 'centered' => __( 'Centered navigation', 'undo-theme' ) ) ),
            'header_sticky' => array( __( 'Sticky header', 'undo-theme' ), 'checkbox', '1' ),
            'header_show_navigation' => array( __( 'Show main navigation', 'undo-theme' ), 'checkbox', '1' ),
            'header_show_search' => array( __( 'Show header search', 'undo-theme' ), 'checkbox', '0' ),
            'header_show_language' => array( __( 'Show language switcher', 'undo-theme' ), 'checkbox', '1' ),
            'header_show_action' => array( __( 'Show action button', 'undo-theme' ), 'checkbox', '1' ),
            'header_action_on_mobile' => array( __( 'Show action in mobile menu', 'undo-theme' ), 'checkbox', '1' ),
            'cta_label_fa' => array( __( 'Action label (Persian)', 'undo-theme' ), 'text', 'برنامه‌ریزی پروژه' ),
            'cta_label_en' => array( __( 'Action label (English)', 'undo-theme' ), 'text', 'Plan a project' ),
            'cta_url' => array( __( 'Action URL', 'undo-theme' ), 'url', '#project-planner' ),
        ) ),
        'single' => array( __( 'Single post', 'undo-theme' ), __( 'Post details in the built-in single template.', 'undo-theme' ), array(
            'single_show_featured' => array( __( 'Show featured image', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_excerpt' => array( __( 'Show manually written excerpt', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_date' => array( __( 'Show date', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_author' => array( __( 'Show author', 'undo-theme' ), 'checkbox', '0' ),
            'single_show_categories' => array( __( 'Show categories', 'undo-theme' ), 'checkbox', '0' ),
            'single_show_tags' => array( __( 'Show tags', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_navigation' => array( __( 'Show previous and next posts', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_related' => array( __( 'Show related posts', 'undo-theme' ), 'checkbox', '0' ),
            'single_related_count' => array( __( 'Related post count', 'undo-theme' ), 'number', '2', array( 2, 3 ), 'single_show_related' ),
            'single_show_comments' => array( __( 'Show comments', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_sidebar' => array( __( 'Show post sidebar', 'undo-theme' ), 'checkbox', '0' ),
        ) ),
        'pages' => array( __( 'Pages', 'undo-theme' ), __( 'Set the default page layout, then adjust each UNDO template. Explicit page templates take priority.', 'undo-theme' ), array_merge( array(
            'page_show_title' => array( __( 'Show page title', 'undo-theme' ), 'checkbox', '1' ),
            'page_title_style' => array( __( 'Page title style', 'undo-theme' ), 'select', 'editorial', array( 'editorial' => __( 'Editorial', 'undo-theme' ), 'compact' => __( 'Compact', 'undo-theme' ) ), 'page_show_title' ),
            'page_show_breadcrumbs' => array( __( 'Show page breadcrumbs', 'undo-theme' ), 'checkbox', '0' ),
            'page_show_featured' => array( __( 'Show page featured image', 'undo-theme' ), 'checkbox', '0' ),
            'page_content_width' => array( __( 'Default page layout', 'undo-theme' ), 'select', 'reading', array( 'reading' => __( 'Reading', 'undo-theme' ), 'wide' => __( 'Wide', 'undo-theme' ), 'boxed' => __( 'Boxed', 'undo-theme' ), 'full' => __( 'Full width', 'undo-theme' ) ) ),
            'page_show_sidebar' => array( __( 'Show page sidebar', 'undo-theme' ), 'checkbox', '0' ),
        ), undo_page_template_fields() ) ),
        'sidebar' => array( __( 'Sidebar', 'undo-theme' ), __( 'The sidebar appears only where enabled and when widgets are assigned.', 'undo-theme' ), array(
            'sidebar_position' => array( __( 'Sidebar position', 'undo-theme' ), 'select', 'end', array( 'start' => __( 'Start', 'undo-theme' ), 'end' => __( 'End', 'undo-theme' ) ) ),
            'sidebar_width' => array( __( 'Sidebar width in pixels', 'undo-theme' ), 'number', '300', array( 220, 420 ) ),
            'sidebar_on_archive' => array( __( 'Show on archives', 'undo-theme' ), 'checkbox', '0' ),
            'sidebar_on_search' => array( __( 'Show on search results', 'undo-theme' ), 'checkbox', '0' ),
        ) ),
        'blog' => array( __( 'Blog', 'undo-theme' ), __( 'Post cards in blog, archive, and search results.', 'undo-theme' ), array(
            'blog_show_featured' => array( __( 'Show card images', 'undo-theme' ), 'checkbox', '1' ),
            'blog_show_date' => array( __( 'Show card dates', 'undo-theme' ), 'checkbox', '1' ),
            'blog_show_excerpt' => array( __( 'Show excerpts', 'undo-theme' ), 'checkbox', '1' ),
            'blog_columns' => array( __( 'Card columns', 'undo-theme' ), 'select', '1', array( '1' => '1', '2' => '2', '3' => '3' ) ),
            'blog_excerpt_length' => array( __( 'Excerpt length in words', 'undo-theme' ), 'number', '30', array( 10, 80 ) ),
        ) ),
        'footer' => array( __( 'Footer', 'undo-theme' ), __( 'Built-in footer settings. Elementor Theme Builder can replace this template.', 'undo-theme' ), array(
            'footer_show_brand' => array( __( 'Show footer brand', 'undo-theme' ), 'checkbox', '1' ),
            'footer_show_navigation' => array( __( 'Show footer navigation', 'undo-theme' ), 'checkbox', '1' ),
            'footer_show_contact' => array( __( 'Show contact email', 'undo-theme' ), 'checkbox', '1' ),
            'footer_show_copyright' => array( __( 'Show copyright', 'undo-theme' ), 'checkbox', '1' ),
            'footer_slogan_fa' => array( __( 'Footer slogan (Persian)', 'undo-theme' ), 'text', 'برای شما از نو می‌سازیم.' ),
            'footer_slogan_en' => array( __( 'Footer slogan (English)', 'undo-theme' ), 'text', 'WE REDO IT FOR YOU.' ),
            'contact_email' => array( __( 'Contact email', 'undo-theme' ), 'email', '' ),
        ) ),
        'homepage' => array( __( 'Homepage', 'undo-theme' ), __( 'Built-in landing page copy. Elementor pages use their own content.', 'undo-theme' ), array(
            'hero_title_fa' => array( __( 'Hero title (Persian)', 'undo-theme' ), 'text', 'وب‌سایت‌ها، افزونه‌ها و اپ‌ها؛ بهتر از قبل.' ),
            'hero_lead_fa' => array( __( 'Hero description (Persian)', 'undo-theme' ), 'textarea', 'UNDO وب‌سایت، افزونه و اپلیکیشن می‌سازد و محصولات قدیمی را بازطراحی می‌کند؛ از ایده تا کد نهایی.' ),
            'hero_title_en' => array( __( 'Hero title (English)', 'undo-theme' ), 'text', 'Websites, plugins & apps made better.' ),
            'hero_lead_en' => array( __( 'Hero description (English)', 'undo-theme' ), 'textarea', 'UNDO creates new digital products and redesigns the ones that no longer serve your business. From the first screen to the working code.' ),
            'show_section_rail' => array( __( 'Show section navigation', 'undo-theme' ), 'checkbox', '1' ),
        ) ),
    );
    return $sections;
}
function undo_setting_defaults() {
    $defaults = array();
    foreach ( undo_settings_sections() as $section ) {
        foreach ( $section[2] as $key => $field ) { $defaults[ $key ] = $field[2]; }
    }
    return $defaults;
}
function undo_setting( $key ) {
    $saved = get_option( 'undo_theme_settings', array() );
    $defaults = undo_setting_defaults();
    return isset( $saved[ $key ] ) ? (string) $saved[ $key ] : ( isset( $defaults[ $key ] ) ? (string) $defaults[ $key ] : '' );
}
function undo_setting_enabled( $key ) { return '1' === undo_setting( $key ); }
function undo_sanitize_page_dimension( $value, $fallback = '1200px' ) {
    $value = trim( (string) $value );
    if ( ! preg_match( '/^([0-9]{1,4})(px|%)$/', $value, $match ) ) { return $fallback; }
    $number = (int) $match[1];
    if ( 'px' === $match[2] && $number >= 320 && $number <= 1920 ) { return $number . 'px'; }
    if ( '%' === $match[2] && $number >= 20 && $number <= 100 ) { return $number . '%'; }
    return $fallback;
}
function undo_sanitize_settings( $input ) {
    $input = is_array( $input ) ? $input : array();
    $previous = get_option( 'undo_theme_settings', array() );
    $clean = array_merge( undo_setting_defaults(), is_array( $previous ) ? $previous : array() );
    foreach ( undo_settings_sections() as $section ) {
        foreach ( $section[2] as $key => $field ) {
            if ( ! array_key_exists( $key, $input ) ) { continue; }
            $value = is_scalar( $input[ $key ] ) ? wp_unslash( (string) $input[ $key ] ) : '';
            switch ( $field[1] ) {
                case 'checkbox': $clean[ $key ] = '1' === $value ? '1' : '0'; break;
                case 'color': $clean[ $key ] = sanitize_hex_color( $value ) ?: $field[2]; break;
                case 'select': $clean[ $key ] = isset( $field[3][ $value ] ) ? $value : $field[2]; break;
                case 'number': $clean[ $key ] = (string) max( $field[3][0], min( $field[3][1], (int) $value ) ); break;
                case 'dimension': $clean[ $key ] = undo_sanitize_page_dimension( $value, $field[2] ); break;
                case 'media': $clean[ $key ] = ctype_digit( $value ) && wp_attachment_is_image( (int) $value ) ? $value : '0'; break;
                case 'textarea': $clean[ $key ] = sanitize_textarea_field( $value ); break;
                case 'url': $clean[ $key ] = 0 === strpos( $value, '#' ) ? sanitize_text_field( $value ) : esc_url_raw( $value ); break;
                case 'email': $clean[ $key ] = sanitize_email( $value ); break;
                default: $clean[ $key ] = sanitize_text_field( $value );
            }
        }
    }
    return array_intersect_key( $clean, undo_setting_defaults() );
}
function undo_register_settings() {
    register_setting( 'undo_theme_settings', 'undo_theme_settings', array( 'type' => 'array', 'sanitize_callback' => 'undo_sanitize_settings', 'default' => undo_setting_defaults() ) );
}
add_action( 'admin_init', 'undo_register_settings' );
function undo_add_settings_page() {
    add_menu_page( __( 'UNDO Theme Settings', 'undo-theme' ), __( 'UNDO Theme Settings', 'undo-theme' ), 'manage_options', 'undo-theme-settings', 'undo_render_settings_page', 'dashicons-admin-appearance', 61 );
}
add_action( 'admin_menu', 'undo_add_settings_page' );
function undo_settings_assets( $hook ) {
    if ( 'toplevel_page_undo-theme-settings' !== $hook ) { return; }
    wp_enqueue_media();
    wp_enqueue_style( 'undo-admin-settings', get_theme_file_uri( '/assets/css/admin-settings.css' ), array(), UNDO_THEME_VERSION );
    wp_enqueue_script( 'undo-settings-media', get_theme_file_uri( '/assets/js/admin-settings.js' ), array( 'media-views' ), UNDO_THEME_VERSION, true );
    wp_localize_script( 'undo-settings-media', 'undoSettingsMedia', array( 'title' => __( 'Select header logo', 'undo-theme' ), 'use' => __( 'Use this image', 'undo-theme' ) ) );
}
add_action( 'admin_enqueue_scripts', 'undo_settings_assets' );
function undo_settings_field( $key, $field ) {
    $value = undo_setting( $key );
    $depends = isset( $field[4] ) && is_string( $field[4] ) ? ' data-undo-depends="' . esc_attr( $field[4] ) . '"' : '';
    echo '<tr' . $depends . '><th scope="row"><label for="undo-' . esc_attr( $key ) . '">' . esc_html( $field[0] ) . '</label></th><td>';
    $name = 'undo_theme_settings[' . esc_attr( $key ) . ']';
    if ( 'media' === $field[1] ) {
        $image = $value ? wp_get_attachment_image( (int) $value, 'medium', false, array( 'style' => 'max-width:220px;max-height:80px;width:auto;height:auto;' ) ) : '';
        echo '<div class="undo-media-field"><input type="hidden" class="undo-media-id" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '"><div class="undo-media-preview">' . wp_kses_post( $image ) . '</div><button type="button" class="button undo-media-select">' . esc_html__( 'Select image', 'undo-theme' ) . '</button> <button type="button" class="button undo-media-remove">' . esc_html__( 'Remove image', 'undo-theme' ) . '</button></div>';
    } elseif ( 'textarea' === $field[1] ) {
        echo '<textarea id="undo-' . esc_attr( $key ) . '" name="' . $name . '" rows="3" class="large-text" dir="auto">' . esc_textarea( $value ) . '</textarea>';
    } elseif ( 'select' === $field[1] ) {
        echo '<select id="undo-' . esc_attr( $key ) . '" name="' . $name . '">';
        foreach ( $field[3] as $option => $label ) { echo '<option value="' . esc_attr( $option ) . '"' . selected( $value, (string) $option, false ) . '>' . esc_html( $label ) . '</option>'; }
        echo '</select>';
    } elseif ( 'checkbox' === $field[1] ) {
        echo '<input type="hidden" name="' . $name . '" value="0"><input type="checkbox" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="1"' . checked( $value, '1', false ) . '>';
    } elseif ( 'dimension' === $field[1] ) {
        echo '<input type="text" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '" class="regular-text" dir="ltr" pattern="([0-9]{3,4}px|[0-9]{1,3}%)"><p class="description">' . esc_html__( 'Use 320–1920px or 20–100%, for example 1200px or 80%.', 'undo-theme' ) . '</p>';
    } else {
        $extra = 'number' === $field[1] ? ' min="' . esc_attr( $field[3][0] ) . '" max="' . esc_attr( $field[3][1] ) . '"' : '';
        echo '<input type="' . esc_attr( $field[1] ) . '" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '" class="regular-text" dir="auto"' . $extra . '>';
    }
    echo '</td></tr>';
}
function undo_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) { return; }
    $sections = undo_settings_sections();
    $requested = isset( $_GET['tab'] ) && is_string( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'layout';
    $active = isset( $sections[ $requested ] ) ? $requested : 'layout';
    echo '<div class="wrap undo-settings"><header class="undo-settings__header"><span class="undo-settings__brand">UNDO</span><h1>' . esc_html__( 'UNDO Theme Settings', 'undo-theme' ) . '</h1></header><div class="undo-settings__layout"><nav class="undo-settings__nav" aria-label="' . esc_attr__( 'Theme settings sections', 'undo-theme' ) . '">';
    foreach ( $sections as $slug => $section ) {
        $url = add_query_arg( array( 'page' => 'undo-theme-settings', 'tab' => $slug ), admin_url( 'admin.php' ) );
        echo '<a class="undo-settings__nav-link' . ( $active === $slug ? ' is-active' : '' ) . '" href="' . esc_url( $url ) . '"' . ( $active === $slug ? ' aria-current="page"' : '' ) . '>' . esc_html( $section[0] ) . '</a>';
    }
    echo '</nav><main class="undo-settings__content"><div class="undo-settings__intro"><h2>' . esc_html( $sections[ $active ][0] ) . '</h2><p>' . esc_html( $sections[ $active ][1] ) . '</p></div><form action="options.php" method="post">';
    settings_fields( 'undo_theme_settings' );
    if ( 'pages' === $active ) {
        $template_fields = undo_page_template_fields();
        $common_fields = array_diff_key( $sections[ $active ][2], $template_fields );
        echo '<section class="undo-settings__group"><h3>' . esc_html__( 'Page display', 'undo-theme' ) . '</h3><table class="form-table" role="presentation">';
        foreach ( $common_fields as $key => $field ) { undo_settings_field( $key, $field ); }
        echo '</table></section><p class="undo-settings__hint">' . esc_html__( 'The UNDO Custom Width template uses a width set on each page below the editor.', 'undo-theme' ) . '</p>';
        foreach ( undo_page_template_presets() as $mode => $preset ) {
            echo '<section class="undo-settings__group"><h3>' . esc_html( $preset['title'] ) . '</h3><table class="form-table" role="presentation">';
            foreach ( $template_fields as $key => $field ) { if ( 0 === strpos( $key, 'page_' . $mode . '_' ) ) { undo_settings_field( $key, $field ); } }
            echo '</table></section>';
        }
        echo '<p class="undo-settings__hint">' . esc_html__( 'On screens under 760px, side margins and padding are capped at 20px; top and bottom padding are capped at 58px and 90px.', 'undo-theme' ) . '</p>';
    } else {
        echo '<table class="form-table" role="presentation">';
        foreach ( $sections[ $active ][2] as $key => $field ) { undo_settings_field( $key, $field ); }
        echo '</table>';
    }
    submit_button();
    echo '</form></main></div></div>';
}
