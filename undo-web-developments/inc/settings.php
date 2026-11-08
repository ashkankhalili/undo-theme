<?php
/** All customer theme choices are stored in one option. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function undo_settings_sections() {
    static $sections = null;
    if ( null !== $sections ) { return $sections; }
    $sections = array(
        'layout' => array( __( 'Website layout', 'undo-web-developments' ), __( 'Language, width, and shared colors.', 'undo-web-developments' ), array(
            'default_language' => array( __( 'Default visitor language', 'undo-web-developments' ), 'select', 'fa', array( 'fa' => __( 'Persian', 'undo-web-developments' ), 'en' => __( 'English', 'undo-web-developments' ) ) ),
            'accent_color' => array( __( 'Accent color', 'undo-web-developments' ), 'color', '#b83b30' ),
            'site_layout' => array( __( 'Site width', 'undo-web-developments' ), 'select', 'wide', array( 'wide' => __( 'Wide', 'undo-web-developments' ), 'boxed' => __( 'Boxed', 'undo-web-developments' ) ) ),
            'content_width' => array( __( 'Content width in pixels', 'undo-web-developments' ), 'number', '1440', array( 760, 1600 ) ),
        ) ),
        'header' => array( __( 'Header', 'undo-web-developments' ), __( 'Built-in header settings. Elementor Theme Builder can replace this template.', 'undo-web-developments' ), array(
            'header_logo_id' => array( __( 'Header logo', 'undo-web-developments' ), 'media', '0' ),
            'header_logo_width' => array( __( 'Maximum logo width in pixels', 'undo-web-developments' ), 'number', '220', array( 60, 360 ) ),
            'header_sticky' => array( __( 'Sticky header', 'undo-web-developments' ), 'checkbox', '1' ),
            'header_show_navigation' => array( __( 'Show main navigation', 'undo-web-developments' ), 'checkbox', '1' ),
            'header_show_language' => array( __( 'Show language switcher', 'undo-web-developments' ), 'checkbox', '1' ),
            'header_show_action' => array( __( 'Show action button', 'undo-web-developments' ), 'checkbox', '1' ),
            'cta_label_fa' => array( __( 'Action label (Persian)', 'undo-web-developments' ), 'text', 'برنامه‌ریزی پروژه' ),
            'cta_label_en' => array( __( 'Action label (English)', 'undo-web-developments' ), 'text', 'Plan a project' ),
            'cta_url' => array( __( 'Action URL', 'undo-web-developments' ), 'url', '#project-planner' ),
        ) ),
        'single' => array( __( 'Single post', 'undo-web-developments' ), __( 'Post details in the built-in single template.', 'undo-web-developments' ), array(
            'single_show_featured' => array( __( 'Show featured image', 'undo-web-developments' ), 'checkbox', '1' ),
            'single_show_date' => array( __( 'Show date', 'undo-web-developments' ), 'checkbox', '1' ),
            'single_show_author' => array( __( 'Show author', 'undo-web-developments' ), 'checkbox', '0' ),
            'single_show_categories' => array( __( 'Show categories', 'undo-web-developments' ), 'checkbox', '0' ),
            'single_show_navigation' => array( __( 'Show previous and next posts', 'undo-web-developments' ), 'checkbox', '1' ),
            'single_show_comments' => array( __( 'Show comments', 'undo-web-developments' ), 'checkbox', '1' ),
            'single_show_sidebar' => array( __( 'Show post sidebar', 'undo-web-developments' ), 'checkbox', '0' ),
        ) ),
        'pages' => array( __( 'Pages', 'undo-web-developments' ), __( 'Normal WordPress pages. Elementor pages use their own layout.', 'undo-web-developments' ), array(
            'page_show_title' => array( __( 'Show page title', 'undo-web-developments' ), 'checkbox', '1' ),
            'page_show_sidebar' => array( __( 'Show page sidebar', 'undo-web-developments' ), 'checkbox', '0' ),
        ) ),
        'sidebar' => array( __( 'Sidebar', 'undo-web-developments' ), __( 'The sidebar appears only where enabled and when widgets are assigned.', 'undo-web-developments' ), array(
            'sidebar_position' => array( __( 'Sidebar position', 'undo-web-developments' ), 'select', 'end', array( 'start' => __( 'Start', 'undo-web-developments' ), 'end' => __( 'End', 'undo-web-developments' ) ) ),
            'sidebar_width' => array( __( 'Sidebar width in pixels', 'undo-web-developments' ), 'number', '300', array( 220, 420 ) ),
            'sidebar_on_archive' => array( __( 'Show on archives', 'undo-web-developments' ), 'checkbox', '0' ),
            'sidebar_on_search' => array( __( 'Show on search results', 'undo-web-developments' ), 'checkbox', '0' ),
        ) ),
        'blog' => array( __( 'Blog', 'undo-web-developments' ), __( 'Post cards in blog, archive, and search results.', 'undo-web-developments' ), array(
            'blog_show_featured' => array( __( 'Show card images', 'undo-web-developments' ), 'checkbox', '1' ),
            'blog_show_date' => array( __( 'Show card dates', 'undo-web-developments' ), 'checkbox', '1' ),
            'blog_show_excerpt' => array( __( 'Show excerpts', 'undo-web-developments' ), 'checkbox', '1' ),
            'blog_columns' => array( __( 'Card columns', 'undo-web-developments' ), 'select', '1', array( '1' => '1', '2' => '2', '3' => '3' ) ),
            'blog_excerpt_length' => array( __( 'Excerpt length in words', 'undo-web-developments' ), 'number', '30', array( 10, 80 ) ),
        ) ),
        'footer' => array( __( 'Footer', 'undo-web-developments' ), __( 'Built-in footer settings. Elementor Theme Builder can replace this template.', 'undo-web-developments' ), array(
            'footer_show_brand' => array( __( 'Show footer brand', 'undo-web-developments' ), 'checkbox', '1' ),
            'footer_show_navigation' => array( __( 'Show footer navigation', 'undo-web-developments' ), 'checkbox', '1' ),
            'footer_show_contact' => array( __( 'Show contact email', 'undo-web-developments' ), 'checkbox', '1' ),
            'footer_show_copyright' => array( __( 'Show copyright', 'undo-web-developments' ), 'checkbox', '1' ),
            'footer_slogan_fa' => array( __( 'Footer slogan (Persian)', 'undo-web-developments' ), 'text', 'برای شما از نو می‌سازیم.' ),
            'footer_slogan_en' => array( __( 'Footer slogan (English)', 'undo-web-developments' ), 'text', 'WE REDO IT FOR YOU.' ),
            'contact_email' => array( __( 'Contact email', 'undo-web-developments' ), 'email', '' ),
        ) ),
        'homepage' => array( __( 'Homepage', 'undo-web-developments' ), __( 'Built-in landing page copy. Elementor pages use their own content.', 'undo-web-developments' ), array(
            'hero_title_fa' => array( __( 'Hero title (Persian)', 'undo-web-developments' ), 'text', 'وب‌سایت‌ها، افزونه‌ها و اپ‌ها؛ بهتر از قبل.' ),
            'hero_lead_fa' => array( __( 'Hero description (Persian)', 'undo-web-developments' ), 'textarea', 'UNDO وب‌سایت، افزونه و اپلیکیشن می‌سازد و محصولات قدیمی را بازطراحی می‌کند؛ از ایده تا کد نهایی.' ),
            'hero_title_en' => array( __( 'Hero title (English)', 'undo-web-developments' ), 'text', 'Websites, plugins & apps made better.' ),
            'hero_lead_en' => array( __( 'Hero description (English)', 'undo-web-developments' ), 'textarea', 'UNDO creates new digital products and redesigns the ones that no longer serve your business. From the first screen to the working code.' ),
            'show_section_rail' => array( __( 'Show section navigation', 'undo-web-developments' ), 'checkbox', '1' ),
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
    add_menu_page( __( 'UNDO Theme Settings', 'undo-web-developments' ), __( 'UNDO Theme Settings', 'undo-web-developments' ), 'manage_options', 'undo-theme-settings', 'undo_render_settings_page', 'dashicons-admin-appearance', 61 );
}
add_action( 'admin_menu', 'undo_add_settings_page' );
function undo_settings_assets( $hook ) {
    if ( 'toplevel_page_undo-theme-settings' !== $hook ) { return; }
    wp_enqueue_media();
    wp_enqueue_script( 'undo-settings-media', get_theme_file_uri( '/assets/js/admin-settings.js' ), array( 'media-views' ), UNDO_THEME_VERSION, true );
    wp_localize_script( 'undo-settings-media', 'undoSettingsMedia', array( 'title' => __( 'Select header logo', 'undo-web-developments' ), 'use' => __( 'Use this image', 'undo-web-developments' ) ) );
}
add_action( 'admin_enqueue_scripts', 'undo_settings_assets' );
function undo_settings_field( $key, $field ) {
    $value = undo_setting( $key );
    echo '<tr><th scope="row"><label for="undo-' . esc_attr( $key ) . '">' . esc_html( $field[0] ) . '</label></th><td>';
    $name = 'undo_theme_settings[' . esc_attr( $key ) . ']';
    if ( 'media' === $field[1] ) {
        $image = $value ? wp_get_attachment_image( (int) $value, 'medium', false, array( 'style' => 'max-width:220px;max-height:80px;width:auto;height:auto;' ) ) : '';
        echo '<div class="undo-media-field"><input type="hidden" class="undo-media-id" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '"><div class="undo-media-preview">' . wp_kses_post( $image ) . '</div><button type="button" class="button undo-media-select">' . esc_html__( 'Select image', 'undo-web-developments' ) . '</button> <button type="button" class="button undo-media-remove">' . esc_html__( 'Remove image', 'undo-web-developments' ) . '</button></div>';
    } elseif ( 'textarea' === $field[1] ) {
        echo '<textarea id="undo-' . esc_attr( $key ) . '" name="' . $name . '" rows="3" class="large-text" dir="auto">' . esc_textarea( $value ) . '</textarea>';
    } elseif ( 'select' === $field[1] ) {
        echo '<select id="undo-' . esc_attr( $key ) . '" name="' . $name . '">';
        foreach ( $field[3] as $option => $label ) { echo '<option value="' . esc_attr( $option ) . '"' . selected( $value, (string) $option, false ) . '>' . esc_html( $label ) . '</option>'; }
        echo '</select>';
    } elseif ( 'checkbox' === $field[1] ) {
        echo '<input type="hidden" name="' . $name . '" value="0"><input type="checkbox" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="1"' . checked( $value, '1', false ) . '>';
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
    echo '<div class="wrap"><h1>' . esc_html__( 'UNDO Theme Settings', 'undo-web-developments' ) . '</h1><nav class="nav-tab-wrapper" aria-label="' . esc_attr__( 'Theme settings sections', 'undo-web-developments' ) . '">';
    foreach ( $sections as $slug => $section ) {
        $url = add_query_arg( array( 'page' => 'undo-theme-settings', 'tab' => $slug ), admin_url( 'admin.php' ) );
        echo '<a class="nav-tab' . ( $active === $slug ? ' nav-tab-active' : '' ) . '" href="' . esc_url( $url ) . '"' . ( $active === $slug ? ' aria-current="page"' : '' ) . '>' . esc_html( $section[0] ) . '</a>';
    }
    echo '</nav><h2>' . esc_html( $sections[ $active ][0] ) . '</h2><p>' . esc_html( $sections[ $active ][1] ) . '</p><form action="options.php" method="post">';
    settings_fields( 'undo_theme_settings' );
    echo '<table class="form-table" role="presentation">';
    foreach ( $sections[ $active ][2] as $key => $field ) { undo_settings_field( $key, $field ); }
    echo '</table>';
    submit_button();
    echo '</form></div>';
}
