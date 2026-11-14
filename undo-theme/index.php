<?php get_header(); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) : ?>
<?php $undo_posts_page_id = is_home() ? absint( get_option( 'page_for_posts', 0 ) ) : 0;
$undo_posts_page_content = $undo_posts_page_id ? undo_elementor_posts_page_content( $undo_posts_page_id ) : '';
if ( '' !== $undo_posts_page_content ) : ?>
<main id="main" class="undo-elementor-blog"><?php echo $undo_posts_page_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor renders its saved document. ?></main>
<?php else : ?>
<?php $has_sidebar = undo_has_sidebar( 'sidebar_on_archive' ); ?>
<div class="content-layout wrap blog-style-<?php echo esc_attr( undo_setting( 'blog_style' ) ); ?><?php echo $has_sidebar ? ' has-sidebar sidebar-' . esc_attr( undo_sidebar_position() ) : ''; ?>">
<main id="main" class="wp-content"><?php if ( have_posts() ) : ?><div class="undo-post-grid columns-<?php echo esc_attr( undo_setting( 'blog_columns' ) ); ?>">
<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/post-card' ); endwhile; ?>
</div><?php the_posts_pagination(); else : ?><p><?php esc_html_e( 'No posts found.', 'undo-theme' ); ?></p><?php endif; ?></main>
<?php if ( $has_sidebar ) { get_sidebar(); } ?></div>
<?php endif; ?>
<?php endif; get_footer(); ?>
