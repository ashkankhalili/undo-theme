<?php
/** Built-in Elementor components for the UNDO Home design. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function undo_elementor_register_category( $manager ) {
    $manager->add_category( 'undo-home', array( 'title' => __( 'UNDO Home', 'undo-theme' ), 'icon' => 'eicon-site-identity' ) );
}
add_action( 'elementor/elements/categories_registered', 'undo_elementor_register_category' );

function undo_elementor_register_widgets( $manager ) {
    if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) { return; }
    require_once get_template_directory() . '/inc/elementor-widgets.php';
    $manager->register( new Undo_Home_Section_Rail_Widget() );
    $manager->register( new Undo_Home_Process_Board_Widget() );
    $manager->register( new Undo_Home_Visual_Icon_Widget() );
    $manager->register( new Undo_Home_Comparison_Widget() );
}
add_action( 'elementor/widgets/register', 'undo_elementor_register_widgets' );
