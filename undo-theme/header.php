<!doctype html>
<html <?php language_attributes(); ?> data-type="service">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<svg class="icon-sprite" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <symbol id="icon-undo" viewBox="0 0 40 40"><path d="M8 17a13 13 0 1 1 3 12" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><path d="M8 9v8h8" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></symbol>
  <symbol id="icon-diagonal" viewBox="0 0 24 24"><path d="M5 19 19 5M8 5h11v11" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
  <symbol id="icon-horizontal" viewBox="0 0 24 24"><path d="m7 7-5 5 5 5M2 12h20m-5-5 5 5-5 5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
  <symbol id="icon-download" viewBox="0 0 24 24"><path d="M12 3v12m-5-5 5 5 5-5M4 20h16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
  <symbol id="icon-globe" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M3.5 12h17M12 3c2.5 2.5 3.8 5.5 3.8 9S14.5 18.5 12 21M12 3C9.5 5.5 8.2 8.5 8.2 12S9.5 18.5 12 21" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></symbol>
</svg>
<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'undo-theme' ); ?></a>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) : ?>
<header class="site-header"><div class="wrap header-inner">
  <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'UNDO Web Developments, back to top', 'undo-theme' ); ?>">
  <?php $logo_id = (int) undo_setting( 'header_logo_id' ); if ( ! $logo_id && has_custom_logo() ) { $logo_id = (int) get_theme_mod( 'custom_logo' ); } $logo_html = $logo_id ? wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'brand-image', 'alt' => get_bloginfo( 'name' ) ) ) : ''; if ( $logo_html ) : echo wp_kses_post( $logo_html ); else : ?>
  <span class="brand-symbol" aria-hidden="true"><svg><use href="#icon-undo"></use></svg></span><span>UNDO<span class="brand-small"><?php esc_html_e( 'Web Developments', 'undo-theme' ); ?></span></span>
  <?php endif; ?></a>
  <?php if ( undo_setting_enabled( 'header_show_navigation' ) ) : ?><nav class="desktop-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'undo-theme' ); ?>"><?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '<ul class="nav-list">%3$s</ul>', 'fallback_cb' => 'undo_nav_fallback' ) ); ?></nav><?php endif; ?>
  <?php if ( undo_setting_enabled( 'header_show_language' ) ) : ?><div class="language-switcher" role="group" aria-label="<?php esc_attr_e( 'Language', 'undo-theme' ); ?>"><svg aria-hidden="true"><use href="#icon-globe"></use></svg><a href="<?php echo esc_url( undo_language_url( 'en' ) ); ?>" lang="en" <?php echo 'en' === undo_language() ? 'aria-current="true"' : ''; ?>>English</a><span aria-hidden="true">/</span><a href="<?php echo esc_url( undo_language_url( 'fa' ) ); ?>" lang="fa" <?php echo 'fa' === undo_language() ? 'aria-current="true"' : ''; ?>>فارسی</a></div><?php endif; ?>
  <?php if ( undo_setting_enabled( 'header_show_action' ) ) : ?><a class="header-action" href="<?php echo esc_url( undo_cta_url() ); ?>"><?php echo esc_html( undo_content( 'cta_label', __( 'Plan a project', 'undo-theme' ) ) ); ?> <svg class="action-icon" aria-hidden="true"><use href="#icon-diagonal"></use></svg></a><?php endif; ?>
  <?php if ( undo_setting_enabled( 'header_show_navigation' ) ) : ?><button class="menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Open menu', 'undo-theme' ); ?>" aria-expanded="false"><span></span><span></span></button><?php endif; ?>
</div><?php if ( undo_setting_enabled( 'header_show_navigation' ) ) : ?><nav class="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'undo-theme' ); ?>" hidden><?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '<ul class="nav-list">%3$s</ul>', 'fallback_cb' => 'undo_nav_fallback' ) ); ?></nav><?php endif; ?></header>
<?php endif; ?>
