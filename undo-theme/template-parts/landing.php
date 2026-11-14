<?php
/** Built-in homepage. Customer Elementor pages take precedence in front-page.php. */
$visible_sections = undo_home_visible_sections();
get_template_part( 'template-parts/home/section-rail', null, array( 'sections' => $visible_sections ) );
?>
<main id="main" class="undo-native-home">
<?php get_template_part( 'template-parts/home/hero', null, array( 'cta' => undo_cta_url() ) ); ?>
<?php foreach ( $visible_sections as $section ) { get_template_part( 'template-parts/home/' . $section, null, array( 'cta' => undo_cta_url() ) ); } ?>
<?php if ( function_exists( 'undo_elements_render_planner' ) ) {
    echo undo_elements_render_planner( array( 'id' => 'project-planner' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Plugin renderer escapes dynamic output.
} else {
    get_template_part( 'template-parts/home/project-planner' );
} ?>
</main>
