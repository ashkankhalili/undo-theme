<?php get_header(); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) : ?>
<main id="main" class="wp-content wrap"><h1><?php esc_html_e( 'Page not found', 'undo-web-developments' ); ?></h1><p><?php esc_html_e( 'The page you requested is unavailable.', 'undo-web-developments' ); ?></p><a class="button button-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return home', 'undo-web-developments' ); ?></a></main>
<?php endif; ?>
<?php get_footer(); ?>
