<?php get_header(); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) : ?>
<?php $has_sidebar = undo_has_sidebar( 'single_show_sidebar' ); ?>
<div class="content-layout wrap<?php echo $has_sidebar ? ' has-sidebar sidebar-' . esc_attr( undo_setting( 'sidebar_position' ) ) : ''; ?>">
<main id="main" class="wp-content"><?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class(); ?>>
<h1><?php the_title(); ?></h1>
<?php if ( undo_setting_enabled( 'single_show_date' ) ) : ?><p class="post-meta"><?php echo esc_html( get_the_date() ); ?></p><?php endif; ?>
<?php if ( undo_setting_enabled( 'single_show_author' ) ) : ?><p class="post-meta"><?php echo esc_html( get_the_author() ); ?></p><?php endif; ?>
<?php if ( undo_setting_enabled( 'single_show_categories' ) ) : ?><p class="post-meta"><?php the_category( ', ' ); ?></p><?php endif; ?>
<?php if ( undo_setting_enabled( 'single_show_featured' ) && has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } ?>
<?php the_content(); wp_link_pages(); ?>
<?php if ( undo_setting_enabled( 'single_show_navigation' ) ) { the_post_navigation(); } ?>
<?php if ( undo_setting_enabled( 'single_show_comments' ) && ( comments_open() || get_comments_number() ) ) { comments_template(); } ?>
</article><?php endwhile; ?></main>
<?php if ( $has_sidebar ) { get_sidebar(); } ?>
</div>
<?php endif; get_footer(); ?>
