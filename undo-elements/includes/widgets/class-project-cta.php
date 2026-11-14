<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Undo_Elements_Project_CTA_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'undo-project-cta'; }
    public function get_title() { return __( 'Project invitation', 'undo-elements' ); }
    public function get_icon() { return 'eicon-call-to-action'; }
    public function get_categories() { return array( 'undo-elements' ); }
    public function get_style_depends() { return array( 'undo-elements' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => __( 'Content', 'undo-elements' ) ) );
        $this->add_control( 'eyebrow', array( 'label' => __( 'Eyebrow', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'THE NEXT VERSION STARTS HERE', 'undo-elements' ) ) );
        $this->add_control( 'title', array( 'label' => __( 'Heading', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Let us make it better.', 'undo-elements' ) ) );
        $this->add_control( 'button', array( 'label' => __( 'Button', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Plan a project', 'undo-elements' ) ) );
        $this->add_control( 'link', array( 'label' => __( 'Link', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#project-planner' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $url = isset( $s['link']['url'] ) ? $s['link']['url'] : '';
        echo '<aside class="undo-elements-cta"><div><p>' . esc_html( $s['eyebrow'] ) . '</p><h2>' . esc_html( $s['title'] ) . '</h2></div>';
        if ( $url ) {
            $target = ! empty( $s['link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
            echo '<a href="' . esc_url( $url ) . '"' . $target . '>' . esc_html( $s['button'] ) . '<span aria-hidden="true">↗</span></a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- All dynamic values escaped.
        }
        echo '</aside>';
    }
}
