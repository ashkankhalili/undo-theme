<?php
/** Page layout resolution and a small per-page width control. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function undo_page_template_layout( $template ) {
    $templates = array(
        'template-reading.php' => 'reading',
        'template-wide.php' => 'wide',
        'template-boxed.php' => 'boxed',
        'template-full-width.php' => 'full',
        'template-custom-width.php' => 'custom',
    );
    return isset( $templates[ $template ] ) ? $templates[ $template ] : '';
}

function undo_page_layout_mode( $requested = '' ) {
    $allowed = array( 'reading', 'wide', 'boxed', 'full', 'custom' );
    if ( in_array( $requested, $allowed, true ) ) { return $requested; }
    $default = undo_setting( 'page_content_width' );
    return in_array( $default, array( 'reading', 'wide', 'boxed', 'full' ), true ) ? $default : 'reading';
}

function undo_page_custom_width( $post_id = 0 ) {
    $override = $post_id ? get_post_meta( $post_id, '_undo_page_custom_width', true ) : '';
    return undo_sanitize_page_dimension( $override ?: '1200px' );
}

function undo_page_layout_style( $layout, $post_id = 0 ) {
    $presets = undo_page_template_presets();
    $mode = 'custom' === $layout ? 'reading' : $layout;
    $preset = isset( $presets[ $mode ] ) ? $presets[ $mode ] : $presets['reading'];
    $width = 'custom' === $layout ? undo_page_custom_width( $post_id ) : undo_sanitize_page_dimension( undo_setting( 'page_' . $mode . '_width' ), $preset['width'] );
    $values = array( '--undo-page-width:' . $width );
    foreach ( array( 'margin_inline' => 160, 'margin_top' => 240, 'margin_bottom' => 240, 'padding_inline' => 160, 'padding_top' => 240, 'padding_bottom' => 240 ) as $part => $maximum ) {
        $setting = 'custom' === $layout ? $preset[ $part ] : undo_setting( 'page_' . $mode . '_' . $part );
        $value = max( 0, min( $maximum, (int) $setting ) );
        $values[] = '--undo-page-' . str_replace( '_', '-', $part ) . ':' . $value . 'px';
    }
    return implode( ';', $values );
}

function undo_register_page_width_metabox() {
    add_meta_box( 'undo-page-width', __( 'UNDO custom page width', 'undo-theme' ), 'undo_render_page_width_metabox', 'page', 'normal', 'high' );
}
add_action( 'add_meta_boxes_page', 'undo_register_page_width_metabox' );

function undo_render_page_width_metabox( $post ) {
    $override = get_post_meta( $post->ID, '_undo_page_custom_width', true );
    wp_nonce_field( 'undo_page_width', 'undo_page_width_nonce' );
    echo '<div class="undo-custom-width-panel"><p>' . esc_html__( 'This width applies only when the page template is UNDO Custom Width. Leave the field blank for 1200px.', 'undo-theme' ) . '</p>';
    echo '<label for="undo-page-width-value">' . esc_html__( 'Width in pixels or percent', 'undo-theme' ) . '</label>';
    echo '<input id="undo-page-width-value" name="undo_page_custom_width" type="text" class="widefat" dir="ltr" value="' . esc_attr( $override ) . '" placeholder="1200px / 80%" pattern="([0-9]{3,4}px|[0-9]{1,3}%)">';
    echo '<p class="description">' . esc_html__( 'Use 320–1920px or 20–100%.', 'undo-theme' ) . '</p></div>';
}

function undo_page_width_editor_assets( $hook ) {
    if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || ! function_exists( 'get_current_screen' ) ) { return; }
    $screen = get_current_screen();
    if ( ! $screen || 'page' !== $screen->id ) { return; }
    wp_enqueue_style( 'undo-page-width-editor', get_theme_file_uri( '/assets/css/admin-page-width.css' ), array(), UNDO_THEME_VERSION );
    wp_enqueue_script( 'undo-page-width-editor', get_theme_file_uri( '/assets/js/admin-page-width.js' ), array( 'wp-data', 'wp-dom-ready' ), UNDO_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'undo_page_width_editor_assets' );

function undo_save_page_width( $post_id ) {
    if ( ! isset( $_POST['undo_page_width_nonce'], $_POST['undo_page_custom_width'] ) || ! is_string( $_POST['undo_page_width_nonce'] ) || ! is_string( $_POST['undo_page_custom_width'] ) ) { return; }
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['undo_page_width_nonce'] ) ), 'undo_page_width' ) || ! current_user_can( 'edit_post', $post_id ) || wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) { return; }
    $value = trim( wp_unslash( $_POST['undo_page_custom_width'] ) );
    if ( '' === $value ) { delete_post_meta( $post_id, '_undo_page_custom_width' ); return; }
    $clean = undo_sanitize_page_dimension( $value, '' );
    if ( '' !== $clean ) { update_post_meta( $post_id, '_undo_page_custom_width', $clean ); }
}
add_action( 'save_post_page', 'undo_save_page_width' );
