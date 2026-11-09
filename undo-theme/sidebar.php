<?php if ( is_active_sidebar( 'primary-sidebar' ) ) :
    $style = 'panel' === undo_setting( 'sidebar_widget_style' ) ? 'panel' : 'lined';
    $sticky = undo_setting_enabled( 'sidebar_sticky' );
    $spacing = max( 16, min( 64, (int) undo_setting( 'sidebar_widget_spacing' ) ) );
    $offset = max( 0, min( 120, (int) undo_setting( 'sidebar_sticky_offset' ) ) );
    ?>
<aside class="undo-sidebar undo-sidebar--<?php echo esc_attr( $style ); ?><?php echo $sticky ? ' undo-sidebar--sticky' : ''; ?>" aria-label="<?php esc_attr_e( 'Primary sidebar', 'undo-theme' ); ?>" style="--undo-sidebar-widget-gap:<?php echo esc_attr( $spacing ); ?>px;--undo-sidebar-sticky-offset:<?php echo esc_attr( $offset ); ?>px">
<div class="undo-sidebar__inner">
<?php dynamic_sidebar( 'primary-sidebar' ); ?>
</div>
</aside>
<?php endif; ?>
