<?php
get_header();
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) {
    get_footer();
    return;
}
$front_layout = is_page() ? undo_page_template_layout( get_page_template_slug( get_queried_object_id() ) ) : '';
if ( undo_is_elementor_page() && undo_is_generated_starter( get_queried_object_id(), 'home' ) ) { $front_layout = 'full'; }
if ( $front_layout || undo_is_elementor_page() ) {
    get_template_part( 'template-parts/page-layout', null, array( 'layout' => $front_layout ) );
} else {
    get_template_part( 'template-parts/landing' );
}
get_footer();
