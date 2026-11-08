<article <?php post_class( 'archive-item' ); ?>>
<?php if ( undo_setting_enabled( 'blog_show_featured' ) && has_post_thumbnail() ) : ?>
<a class="archive-image" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a>
<?php endif; ?>
<div class="archive-copy">
<?php if ( undo_setting_enabled( 'blog_show_date' ) ) : ?><p class="post-meta"><?php echo esc_html( get_the_date() ); ?></p><?php endif; ?>
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if ( undo_setting_enabled( 'blog_show_excerpt' ) ) : ?><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), (int) undo_setting( 'blog_excerpt_length' ) ) ); ?></p><?php endif; ?>
</div>
</article>
