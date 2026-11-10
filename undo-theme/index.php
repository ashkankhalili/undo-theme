<?php get_header(); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) : ?>
<?php $has_sidebar = undo_has_sidebar( 'sidebar_on_archive' ); ?>
<div class="content-layout wrap blog-style-<?php echo esc_attr( undo_setting( 'blog_style' ) ); ?><?php echo $has_sidebar ? ' has-sidebar sidebar-' . esc_attr( undo_sidebar_position() ) : ''; ?>">
<main id="main" class="wp-content"><?php if ( have_posts() ) : ?><div class="undo-post-grid columns-<?php echo esc_attr( undo_setting( 'blog_columns' ) ); ?>">
<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/post-card' ); endwhile; ?>
</div><?php the_posts_pagination(); else : ?><p><?php esc_html_e( 'No posts found.', 'undo-theme' ); ?></p><?php endif; ?></main>
<?php if ( $has_sidebar ) { get_sidebar(); } ?></div>
<?php endif; get_footer(); ?>
