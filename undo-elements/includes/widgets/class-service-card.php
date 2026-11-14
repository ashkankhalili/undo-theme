<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Undo_Elements_Service_Card_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'undo-service-card'; }
    public function get_title() { return __( 'Service card', 'undo-elements' ); }
    public function get_icon() { return 'eicon-info-box'; }
    public function get_categories() { return array( 'undo-elements' ); }
    public function get_style_depends() { return array( 'undo-elements' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => __( 'Content', 'undo-elements' ) ) );
        $this->add_control( 'number', array( 'label' => __( 'Index', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '01' ) );
        $this->add_control( 'title', array( 'label' => __( 'Heading', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Websites', 'undo-elements' ) ) );
        $this->add_control( 'description', array( 'label' => __( 'Description', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => __( 'Clear, useful digital experiences built around your business.', 'undo-elements' ) ) );
        $this->add_control( 'link', array( 'label' => __( 'Link', 'undo-elements' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $url = isset( $s['link']['url'] ) ? $s['link']['url'] : '';
        $tag = $url ? 'a' : 'div';
        $attributes = $url ? ' href="' . esc_url( $url ) . '"' : '';
        if ( $url && ! empty( $s['link']['is_external'] ) ) { $attributes .= ' target="_blank" rel="noopener noreferrer"'; }
        echo '<' . $tag . ' class="undo-elements-service"' . $attributes . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Tag is fixed and attributes escaped.
        echo '<span class="undo-elements-service__number">' . esc_html( $s['number'] ) . '</span>';
        echo '<span class="undo-elements-service__body"><strong>' . esc_html( $s['title'] ) . '</strong><span>' . esc_html( $s['description'] ) . '</span></span>';
        if ( $url ) { echo '<span class="undo-elements-service__arrow" aria-hidden="true">↗</span>'; }
        echo '</' . $tag . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Tag is fixed.
    }
}
