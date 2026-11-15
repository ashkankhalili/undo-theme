<?php
/** Shared controls for the theme's built-in Elementor Home widgets. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

abstract class Undo_Home_Widget_Base extends \Elementor\Widget_Base {
    public function get_categories() { return array( 'undo-home' ); }
    public function get_style_depends() { return array( 'undo-site' ); }

    protected function undo_color( $name, $label, $selector, $property = 'color' ) {
        $this->add_control( $name, array(
            'label' => $label,
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} ' . $selector => $property . ':{{VALUE}};' ),
        ) );
    }

    protected function undo_type( $name, $selector ) {
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => $name,
            'selector' => '{{WRAPPER}} ' . $selector,
        ) );
    }
}

require_once __DIR__ . '/elementor/class-section-rail.php';
require_once __DIR__ . '/elementor/class-process-board.php';
require_once __DIR__ . '/elementor/class-visual-icon.php';
require_once __DIR__ . '/elementor/class-comparison.php';
