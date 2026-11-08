<?php get_header(); ?>
<?php if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) : ?>
<?php elseif ( undo_is_elementor_page() ) : ?>
<main id="main" class="undo-elementor-page"><?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?></main>
<?php else : ?>
<?php $has_sidebar = undo_has_sidebar( 'page_show_sidebar' ); ?>
<div class="content-layout wrap<?php echo $has_sidebar ? ' has-sidebar sidebar-' . esc_attr( undo_setting( 'sidebar_position' ) ) : ''; ?>">
<main id="main" class="wp-content"><?php while ( have_posts() ) : the_post(); ?><article <?php post_class(); ?>>
<?php if ( undo_setting_enabled( 'page_show_title' ) ) : ?><h1><?php the_title(); ?></h1><?php endif; ?>
<?php the_content(); wp_link_pages(); ?>
</article><?php endwhile; ?></main>
<?php if ( $has_sidebar ) { get_sidebar(); } ?>
</div>
<?php endif; get_footer(); ?>
