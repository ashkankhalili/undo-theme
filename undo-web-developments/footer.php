<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) : ?>
<footer class="footer" id="finish"><div class="wrap">
<div class="footer-top">
<?php if ( undo_setting_enabled( 'footer_show_brand' ) ) : ?><div><a class="footer-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">UNDO<svg aria-hidden="true"><use href="#icon-undo"></use></svg></a><p><?php esc_html_e( 'Web Developments', 'undo-web-developments' ); ?></p></div><?php endif; ?>
<p><?php echo esc_html( undo_content( 'footer_slogan', __( 'WE REDO IT FOR YOU.', 'undo-web-developments' ) ) ); ?></p>
</div>
<div class="footer-bottom">
<?php if ( undo_setting_enabled( 'footer_show_copyright' ) ) : ?><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> UNDO <?php esc_html_e( 'Web Developments', 'undo-web-developments' ); ?></span><?php endif; ?>
<?php if ( undo_setting_enabled( 'footer_show_navigation' ) ) : ?><nav aria-label="<?php esc_attr_e( 'Footer navigation', 'undo-web-developments' ); ?>"><?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'items_wrap' => '<ul class="nav-list">%3$s</ul>', 'fallback_cb' => 'undo_nav_fallback' ) ); ?></nav><?php endif; ?>
<?php if ( undo_setting_enabled( 'footer_show_contact' ) && undo_setting( 'contact_email' ) ) : ?><a href="mailto:<?php echo esc_attr( undo_setting( 'contact_email' ) ); ?>"><?php echo esc_html( undo_setting( 'contact_email' ) ); ?></a><?php endif; ?>
</div></div></footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body></html>
