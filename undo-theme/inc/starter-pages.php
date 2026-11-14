<?php
/** Create editable starter pages once Elementor is available, without changing Reading settings. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function undo_starter_page_specs() {
    return array(
        'home-fa' => array( 'title' => 'UNDO Home — فارسی', 'file' => 'home-fa.json' ),
        'home-en' => array( 'title' => 'UNDO Home — English', 'file' => 'home-en.json' ),
        'blog-page-fa' => array( 'title' => 'UNDO Blog — فارسی', 'file' => 'blog-page-fa.json' ),
        'blog-page-en' => array( 'title' => 'UNDO Blog — English', 'file' => 'blog-page-en.json' ),
    );
}

function undo_is_generated_starter( $post_id, $type ) {
    $marker = get_post_meta( $post_id, '_undo_starter_page', true );
    return is_string( $marker ) && 0 === strpos( $marker, $type . '-' );
}

function undo_starter_page_document( $filename ) {
    $path = get_template_directory() . '/elementor-templates/' . $filename;
    if ( ! is_readable( $path ) ) { return false; }
    $document = json_decode( file_get_contents( $path ), true );
    return is_array( $document ) && isset( $document['type'], $document['content'] ) && 'page' === $document['type'] && is_array( $document['content'] ) ? $document : false;
}

function undo_starter_existing_page( $key ) {
    $posts = get_posts( array(
        'post_type' => 'page', 'post_status' => 'any', 'posts_per_page' => 1,
        'fields' => 'ids', 'meta_key' => '_undo_starter_page', 'meta_value' => $key,
        'suppress_filters' => true,
    ) );
    return $posts ? absint( $posts[0] ) : 0;
}

function undo_create_starter_page( $key, $spec ) {
    $document_data = undo_starter_page_document( $spec['file'] );
    if ( ! $document_data ) { return 0; }
    $id = wp_insert_post( array(
        'post_type' => 'page', 'post_status' => 'draft', 'post_title' => $spec['title'],
        'post_name' => 'undo-starter-' . $key, 'post_author' => get_current_user_id(),
        'comment_status' => 'closed',
    ), true );
    if ( is_wp_error( $id ) || ! $id ) { return 0; }
    $id = absint( $id );
    update_post_meta( $id, '_elementor_edit_mode', 'builder' );
    try {
        $elementor = \Elementor\Plugin::$instance;
        $document = isset( $elementor->documents ) ? $elementor->documents->get( $id ) : false;
        $saved = $document && method_exists( $document, 'save' ) && true === $document->save( array( 'elements' => $document_data['content'] ) );
    } catch ( \Throwable $error ) {
        $saved = false;
    }
    if ( ! $saved ) {
        wp_delete_post( $id, true );
        return 0;
    }
    update_post_meta( $id, '_undo_starter_page', $key );
    $published = wp_update_post( array( 'ID' => $id, 'post_status' => 'publish' ), true );
    if ( is_wp_error( $published ) || ! $published ) {
        wp_delete_post( $id, true );
        return 0;
    }
    return $id;
}

function undo_link_starter_translations( $pages ) {
    if ( get_option( 'undo_starter_pages_translated', false ) || ! function_exists( 'pll_languages_list' ) || ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_save_post_translations' ) ) { return; }
    $languages = pll_languages_list( array( 'fields' => 'slug' ) );
    if ( ! is_array( $languages ) || ! in_array( 'en', $languages, true ) || ! in_array( 'fa', $languages, true ) ) { return; }
    foreach ( array( 'home', 'blog-page' ) as $type ) {
        $translations = array();
        foreach ( array( 'en', 'fa' ) as $language ) {
            $key = $type . '-' . $language;
            $id = isset( $pages[ $key ] ) ? absint( $pages[ $key ] ) : 0;
            if ( ! $id || 'page' !== get_post_type( $id ) || 'publish' !== get_post_status( $id ) || ! undo_is_generated_starter( $id, $type ) ) { return; }
            pll_set_post_language( $id, $language );
            $translations[ $language ] = $id;
        }
        pll_save_post_translations( $translations );
    }
    update_option( 'undo_starter_pages_translated', 1, false );
}

function undo_maybe_create_starter_pages() {
    if ( ! current_user_can( 'manage_options' ) || ! did_action( 'elementor/loaded' ) || ! class_exists( '\\Elementor\\Plugin' ) ) { return; }
    $pages = get_option( 'undo_starter_pages', array() );
    if ( ! is_array( $pages ) ) { $pages = array(); }
    foreach ( undo_starter_page_specs() as $key => $spec ) {
        if ( array_key_exists( $key, $pages ) ) { continue; }
        $id = undo_starter_existing_page( $key );
        if ( ! $id ) { $id = undo_create_starter_page( $key, $spec ); }
        if ( $id ) {
            $pages[ $key ] = $id;
            update_option( 'undo_starter_pages', $pages, false );
        }
    }
    if ( 4 === count( array_intersect_key( $pages, undo_starter_page_specs() ) ) ) { undo_link_starter_translations( $pages ); }
}
add_action( 'admin_init', 'undo_maybe_create_starter_pages', 20 );

function undo_home_planner_shortcode() {
    if ( function_exists( 'undo_elements_render_planner' ) ) { return undo_elements_render_planner( array( 'id' => 'project-planner' ) ); }
    ob_start();
    get_template_part( 'template-parts/home/project-planner' );
    return ob_get_clean();
}
add_shortcode( 'undo_home_planner', 'undo_home_planner_shortcode' );

function undo_blog_posts_shortcode() {
    $paged = max( 1, (int) get_query_var( 'paged', 1 ) );
    $posts = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'paged' => $paged, 'posts_per_page' => max( 1, (int) get_option( 'posts_per_page', 10 ) ) ) );
    ob_start();
    echo '<div class="undo-starter-posts blog-style-' . esc_attr( undo_setting( 'blog_style' ) ) . '">';
    if ( $posts->have_posts() ) {
        echo '<div class="undo-post-grid columns-' . esc_attr( undo_setting( 'blog_columns' ) ) . '">';
        while ( $posts->have_posts() ) { $posts->the_post(); get_template_part( 'template-parts/post-card' ); }
        echo '</div>';
        $pagination = paginate_links( array( 'total' => $posts->max_num_pages, 'current' => $paged, 'type' => 'list' ) );
        if ( $pagination ) { echo '<nav class="undo-starter-pagination" aria-label="' . esc_attr__( 'Posts navigation', 'undo-theme' ) . '">' . $pagination . '</nav>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WordPress pagination HTML.
        }
    } else {
        echo '<p>' . esc_html__( 'No posts found.', 'undo-theme' ) . '</p>';
    }
    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'undo_blog_posts', 'undo_blog_posts_shortcode' );

function undo_elementor_posts_page_content( $post_id ) {
    if ( ! did_action( 'elementor/loaded' ) || 'page' !== get_post_type( $post_id ) || 'publish' !== get_post_status( $post_id ) || 'builder' !== get_post_meta( $post_id, '_elementor_edit_mode', true ) || ! class_exists( '\\Elementor\\Plugin' ) ) { return ''; }
    $elementor = \Elementor\Plugin::$instance;
    if ( ! isset( $elementor->frontend ) || ! method_exists( $elementor->frontend, 'get_builder_content_for_display' ) ) { return ''; }
    $content = $elementor->frontend->get_builder_content_for_display( $post_id, true );
    return is_string( $content ) ? $content : '';
}
