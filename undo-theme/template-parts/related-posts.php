<?php
$related_posts = undo_related_posts( get_the_ID() );
if ( ! $related_posts ) { return; }
?>
<aside class="single-related" aria-labelledby="single-related-title">
<div class="single-related-heading"><span><?php echo esc_html__( 'More posts', 'undo-theme' ); ?></span><h2 id="single-related-title"><?php echo esc_html__( 'Related posts', 'undo-theme' ); ?></h2></div>
<div class="single-related-grid<?php echo 3 === count( $related_posts ) ? ' single-related-grid--3' : ''; ?>">
<?php foreach ( $related_posts as $related_post ) : ?>
<article class="single-related-card">
<a href="<?php echo esc_url( get_permalink( $related_post ) ); ?>">
<?php if ( has_post_thumbnail( $related_post ) ) : ?><div class="single-related-image"><?php echo get_the_post_thumbnail( $related_post, 'medium_large', array( 'loading' => 'lazy' ) ); ?></div><?php endif; ?>
<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $related_post ) ); ?>"><?php echo esc_html( get_the_date( '', $related_post ) ); ?></time>
<h3><?php echo esc_html( get_the_title( $related_post ) ); ?></h3>
</a>
</article>
<?php endforeach; ?>
</div>
</aside>
