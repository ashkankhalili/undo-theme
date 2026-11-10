<?php get_header(); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) : ?>
<?php $has_sidebar = undo_has_sidebar( 'single_show_sidebar' ); ?>
<div class="content-layout wrap<?php echo $has_sidebar ? ' has-sidebar sidebar-' . esc_attr( undo_sidebar_position() ) : ''; ?>">
<main id="main" class="wp-content single-content">
<?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'single-article' ); ?>>
<header class="single-header">
<?php if ( undo_setting_enabled( 'single_show_categories' ) ) : ?><div class="single-kicker"><?php the_category( ' / ' ); ?></div><?php endif; ?>
<h1><?php the_title(); ?></h1>
<?php if ( undo_setting_enabled( 'single_show_excerpt' ) && has_excerpt() ) : ?><p class="single-deck"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
<?php if ( undo_setting_enabled( 'single_show_date' ) || undo_setting_enabled( 'single_show_author' ) ) : ?>
<div class="single-meta">
<?php if ( undo_setting_enabled( 'single_show_date' ) ) : ?><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><?php endif; ?>
<?php if ( undo_setting_enabled( 'single_show_author' ) ) : ?><span><?php echo esc_html( sprintf( __( 'By %s', 'undo-theme' ), get_the_author() ) ); ?></span><?php endif; ?>
</div>
<?php endif; ?>
</header>
<?php if ( undo_setting_enabled( 'single_show_featured' ) && has_post_thumbnail() ) : ?><figure class="single-featured"><?php the_post_thumbnail( 'large' ); ?><?php $caption = get_the_post_thumbnail_caption(); if ( $caption ) : ?><figcaption><?php echo esc_html( $caption ); ?></figcaption><?php endif; ?></figure><?php endif; ?>
<div class="single-body entry-content"><?php the_content(); ?><?php wp_link_pages( array( 'before' => '<nav class="single-page-links" aria-label="' . esc_attr__( 'Post pages', 'undo-theme' ) . '">', 'after' => '</nav>' ) ); ?></div>
<?php if ( undo_setting_enabled( 'single_show_tags' ) && has_tag() ) : ?><div class="single-tags"><span><?php echo esc_html__( 'Tags', 'undo-theme' ); ?></span><?php echo wp_kses_post( get_the_tag_list( '', '', '' ) ); ?></div><?php endif; ?>
<?php if ( undo_setting_enabled( 'single_show_navigation' ) ) : ?><?php the_post_navigation( array( 'prev_text' => '<span class="post-navigation-label">' . esc_html__( 'Previous post', 'undo-theme' ) . '</span><strong>%title</strong>', 'next_text' => '<span class="post-navigation-label">' . esc_html__( 'Next post', 'undo-theme' ) . '</span><strong>%title</strong>', 'screen_reader_text' => esc_html__( 'Post navigation', 'undo-theme' ) ) ); ?><?php endif; ?>
<?php get_template_part( 'template-parts/related-posts' ); ?>
<?php if ( undo_setting_enabled( 'single_show_comments' ) && ( comments_open() || get_comments_number() ) ) { comments_template(); } ?>
</article>
<?php endwhile; ?>
</main>
<?php if ( $has_sidebar ) { get_sidebar(); } ?>
</div>
<?php endif; get_footer(); ?>
