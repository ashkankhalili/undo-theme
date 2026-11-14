<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Undo_Elements_Planner_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'undo-project-planner'; }
    public function get_title() { return __( 'Project planner', 'undo-elements' ); }
    public function get_icon() { return 'eicon-form-horizontal'; }
    public function get_categories() { return array( 'undo-elements' ); }
    public function get_style_depends() { return array( 'undo-elements' ); }
    public function get_script_depends() { return array( 'undo-elements-planner' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => __( 'Content', 'undo-elements' ) ) );
        $this->add_control( 'title', array( 'label' => __( 'Heading', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Tell us what you want to make.', 'undo-elements' ) ) );
        $this->add_control( 'description', array( 'label' => __( 'Description', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => __( 'Put the essentials in one place. Download your brief when you are done, so it is ready to share when we connect.', 'undo-elements' ) ) );
        $this->add_control( 'button', array( 'label' => __( 'Button', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Download project brief', 'undo-elements' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        echo undo_elements_render_planner( array(
            'id' => 'undo-planner-' . $this->get_id(),
            'title' => $settings['title'],
            'description' => $settings['description'],
            'button' => $settings['button'],
        ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Renderer escapes every field.
    }
}
