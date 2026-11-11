<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) :
    $contact_email = undo_setting( 'contact_email' );
    $contact_phone = undo_setting( 'footer_contact_phone' );
    $contact_phone_href = preg_replace( '/[^0-9+]/', '', $contact_phone );
    $contact_location = undo_setting( 'footer_contact_address_' . undo_language() );
    $show_contact = undo_setting_enabled( 'footer_show_contact' ) && ( $contact_email || $contact_phone_href || $contact_location );
    $show_secondary_menu = undo_setting_enabled( 'footer_show_secondary_navigation' ) && has_nav_menu( 'footer_secondary' );
    $social_links = undo_setting_enabled( 'footer_show_social' ) ? undo_footer_social_links() : array();
    $legal_note = undo_setting( 'footer_legal_' . undo_language() );
    $privacy_url = undo_setting_enabled( 'footer_show_legal' ) ? get_privacy_policy_url() : '';
    ?>
<footer class="footer" id="finish"><div class="wrap footer-shell">
  <div class="footer-main">
    <div class="footer-invite">
      <p class="footer-kicker">UNDO <span aria-hidden="true">/</span> <?php esc_html_e( 'Web Developments', 'undo-theme' ); ?></p>
      <h2><?php echo esc_html( undo_content( 'footer_slogan', __( 'WE REDO IT FOR YOU.', 'undo-theme' ) ) ); ?></h2>
      <?php if ( undo_setting_enabled( 'footer_show_action' ) ) : ?>
        <a class="footer-action" href="<?php echo esc_url( undo_footer_action_url() ); ?>"><?php echo esc_html( undo_content( 'footer_action_label', __( 'Plan a project', 'undo-theme' ) ) ); ?><svg aria-hidden="true"><use href="#icon-diagonal"></use></svg></a>
      <?php endif; ?>
    </div>
    <?php if ( undo_setting_enabled( 'footer_show_navigation' ) || $show_secondary_menu || $show_contact || $social_links ) : ?>
    <div class="footer-directory">
      <?php if ( undo_setting_enabled( 'footer_show_navigation' ) ) : ?>
      <nav class="footer-column" aria-label="<?php esc_attr_e( 'Footer navigation', 'undo-theme' ); ?>">
        <h3><?php echo esc_html( undo_content( 'footer_menu_title', __( 'Explore', 'undo-theme' ) ) ); ?></h3>
        <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1, 'items_wrap' => '<ul class="nav-list">%3$s</ul>', 'fallback_cb' => 'undo_nav_fallback' ) ); ?>
      </nav>
      <?php endif; ?>
      <?php if ( $show_secondary_menu ) : ?>
      <nav class="footer-column" aria-label="<?php esc_attr_e( 'Footer secondary navigation', 'undo-theme' ); ?>">
        <h3><?php echo esc_html( undo_content( 'footer_secondary_title', __( 'More', 'undo-theme' ) ) ); ?></h3>
        <?php wp_nav_menu( array( 'theme_location' => 'footer_secondary', 'container' => false, 'depth' => 1, 'items_wrap' => '<ul class="nav-list">%3$s</ul>', 'fallback_cb' => false ) ); ?>
      </nav>
      <?php endif; ?>
      <?php if ( $show_contact ) : ?>
      <div class="footer-column footer-contact">
        <h3><?php esc_html_e( 'Contact', 'undo-theme' ); ?></h3>
        <?php if ( $contact_email ) : ?><a href="mailto:<?php echo esc_attr( $contact_email ); ?>" dir="auto"><?php echo esc_html( $contact_email ); ?></a><?php endif; ?>
        <?php if ( $contact_phone_href ) : ?><a href="tel:<?php echo esc_attr( $contact_phone_href ); ?>" dir="ltr"><?php echo esc_html( $contact_phone ); ?></a><?php endif; ?>
        <?php if ( $contact_location ) : ?><address dir="auto"><?php echo esc_html( $contact_location ); ?></address><?php endif; ?>
      </div>
      <?php endif; ?>
      <?php if ( $social_links ) : ?>
      <div class="footer-column footer-social">
        <h3><?php esc_html_e( 'Follow', 'undo-theme' ); ?></h3>
        <ul><?php foreach ( $social_links as $social ) : ?><li><a href="<?php echo esc_url( $social['url'] ); ?>" rel="me"><?php echo esc_html( $social['label'] ); ?></a></li><?php endforeach; ?></ul>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
  <?php if ( undo_setting_enabled( 'footer_show_brand' ) ) : ?>
  <div class="footer-wordmark"><a class="footer-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'UNDO Web Developments, back to top', 'undo-theme' ); ?>">UNDO<svg aria-hidden="true"><use href="#icon-undo"></use></svg></a></div>
  <?php endif; ?>
  <?php if ( undo_setting_enabled( 'footer_show_copyright' ) || ( undo_setting_enabled( 'footer_show_legal' ) && ( $legal_note || $privacy_url ) ) ) : ?>
  <div class="footer-bottom">
    <?php if ( undo_setting_enabled( 'footer_show_copyright' ) ) : ?><span class="footer-copyright"><?php echo esc_html( undo_footer_copyright() ); ?></span><?php endif; ?>
    <?php if ( undo_setting_enabled( 'footer_show_legal' ) ) : ?><div class="footer-legal"><?php if ( $legal_note ) : ?><span><?php echo esc_html( $legal_note ); ?></span><?php endif; ?><?php if ( $privacy_url ) : ?><a href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'undo-theme' ); ?></a><?php endif; ?></div><?php endif; ?>
  </div>
  <?php endif; ?>
</div></footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body></html>
