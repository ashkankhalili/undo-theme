<?php get_header(); ?>
<?php if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) : ?>
<?php elseif ( undo_is_elementor_page() ) : ?>
<main id="main" class="undo-elementor-page"><?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?></main>
<?php else : get_template_part( 'template-parts/landing' ); endif; ?>
<?php get_footer(); ?>
