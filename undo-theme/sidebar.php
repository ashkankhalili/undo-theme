<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
<aside class="undo-sidebar" aria-label="<?php esc_attr_e( 'Primary sidebar', 'undo-theme' ); ?>">
<?php dynamic_sidebar( 'primary-sidebar' ); ?>
</aside>
<?php endif; ?>
