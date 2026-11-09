<?php if ( post_password_required() || ( ! comments_open() && ! have_comments() ) ) { return; } ?>
<section id="comments" class="comments-area">
<?php if ( have_comments() ) : ?>
<h2><?php comments_number( esc_html__( 'No comments', 'undo-theme' ), esc_html__( 'One comment', 'undo-theme' ), esc_html__( '% comments', 'undo-theme' ) ); ?></h2>
<ol class="comment-list"><?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 48 ) ); ?></ol>
<?php the_comments_pagination(); ?>
<?php endif; ?>
<?php if ( comments_open() ) { comment_form(); } ?>
</section>
