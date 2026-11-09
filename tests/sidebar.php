<?php
/** Sidebar output contract without a WordPress installation. */
function is_active_sidebar( $id ) { return ! empty( $GLOBALS['sidebar_active'] ); }
function dynamic_sidebar( $id ) { echo '<section class="widget"><h2 class="widget-title">Recent posts</h2></section>'; }
function undo_setting( $key ) { $defaults = array( 'sidebar_widget_style' => 'lined', 'sidebar_widget_spacing' => '32', 'sidebar_sticky_offset' => '24' ); return $GLOBALS['sidebar_options'][ $key ] ?? $defaults[ $key ] ?? ''; }
function undo_setting_enabled( $key ) { return '1' === undo_setting( $key ); }
function esc_attr( $value ) { return htmlspecialchars( (string) $value, ENT_QUOTES, 'UTF-8' ); }
function esc_attr_e( $value, $domain = '' ) { echo esc_attr( $value ); }
function expect( $ok, $message ) { if ( ! $ok ) { throw new RuntimeException( $message ); } }
function render_sidebar() { ob_start(); include dirname( __DIR__ ) . '/undo-theme/sidebar.php'; return ob_get_clean(); }

$GLOBALS['sidebar_active'] = false;
expect( '' === trim( render_sidebar() ), 'An empty widget area must not reserve sidebar markup' );
$GLOBALS['sidebar_active'] = true;
$plain = render_sidebar();
expect( false !== strpos( $plain, 'undo-sidebar--lined' ) && false === strpos( $plain, 'undo-sidebar--sticky' ) && false !== strpos( $plain, '--undo-sidebar-widget-gap:32px' ), 'Default sidebar must remain lined and nonsticky' );
$GLOBALS['sidebar_options'] = array( 'sidebar_widget_style' => 'panel', 'sidebar_widget_spacing' => '48', 'sidebar_sticky' => '1', 'sidebar_sticky_offset' => '36' );
$panel = render_sidebar();
expect( false !== strpos( $panel, 'undo-sidebar--panel undo-sidebar--sticky' ) && false !== strpos( $panel, '--undo-sidebar-widget-gap:48px;--undo-sidebar-sticky-offset:36px' ), 'Panel and sticky options must reach the rendered sidebar' );
expect( false !== strpos( $panel, 'class="undo-sidebar__inner"' ) && false !== strpos( $panel, 'Recent posts' ), 'Widget contents must stay inside the styled sidebar' );
echo "Sidebar markup checks passed.\n";
