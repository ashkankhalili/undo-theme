<?php
/** Editable section navigation for one-screen Home pages. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Undo_Home_Section_Rail_Widget extends Undo_Home_Widget_Base {
    public function get_name() { return 'undo-section-rail'; }
    public function get_title() { return __( 'Section navigation', 'undo-theme' ); }
    public function get_icon() { return 'eicon-navigation-vertical'; }

    protected function register_controls() {
        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'anchor', array( 'label' => __( 'Section ID', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'overview', 'label_block' => true ) );
        $repeater->add_control( 'label', array( 'label' => __( 'Navigation label', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Section', 'undo-theme' ), 'label_block' => true ) );
        $repeater->add_control( 'number', array( 'label' => __( 'Optional number', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->start_controls_section( 'rail_content', array( 'label' => __( 'Sections', 'undo-theme' ) ) );
        $this->add_control( 'nav_label', array( 'label' => __( 'Accessible navigation name', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Page sections', 'undo-theme' ) ) );
        $this->add_control( 'sections', array(
            'label' => __( 'Section links', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(), 'title_field' => '{{{ label }}}',
            'default' => array(
                array( 'anchor' => 'top', 'label' => __( 'Home', 'undo-theme' ) ),
                array( 'anchor' => 'overview', 'label' => __( 'Overview', 'undo-theme' ) ),
                array( 'anchor' => 'services', 'label' => __( 'Services', 'undo-theme' ) ),
                array( 'anchor' => 'approach', 'label' => __( 'Approach', 'undo-theme' ) ),
                array( 'anchor' => 'redesign', 'label' => __( 'Redesign', 'undo-theme' ) ),
                array( 'anchor' => 'project-planner', 'label' => __( 'Project planner', 'undo-theme' ) ),
                array( 'anchor' => 'finish', 'label' => 'UNDO' ),
            ),
        ) );
        $this->add_control( 'guided_scroll', array( 'label' => __( 'Guided section scrolling', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => __( 'On', 'undo-theme' ), 'label_off' => __( 'Off', 'undo-theme' ), 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_desktop', array( 'label' => __( 'Show desktop rail', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_mobile', array( 'label' => __( 'Show mobile progress', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_current', array( 'label' => __( 'Show current section name', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_tooltips', array( 'label' => __( 'Show labels on hover and focus', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'rail_layout', array( 'label' => __( 'Layout', 'undo-theme' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'side', array( 'label' => __( 'Side', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( 'start' => __( 'Start', 'undo-theme' ), 'end' => __( 'End', 'undo-theme' ) ), 'default' => 'start' ) );
        $this->add_control( 'marker_style', array( 'label' => __( 'Marker style', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( 'number' => __( 'Numbers', 'undo-theme' ), 'dot' => __( 'Dots', 'undo-theme' ) ), 'default' => 'number' ) );
        $this->add_responsive_control( 'rail_offset', array( 'label' => __( 'Side offset', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .section-rail' => '--undo-rail-offset:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'rail_marker_size', array( 'label' => __( 'Marker size', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 10, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .section-rail' => '--undo-rail-marker:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'rail_marker_border', array( 'label' => __( 'Marker border width', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 6 ) ), 'selectors' => array( '{{WRAPPER}} .section-rail a>span' => 'border-width:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'rail_step', array( 'label' => __( 'Marker spacing', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 28, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .section-rail' => '--undo-rail-step:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'rail_vertical', array( 'label' => __( 'Vertical position', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 20, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .section-rail' => 'top:{{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'rail_colors', array( 'label' => __( 'Colors and type', 'undo-theme' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->undo_color( 'rail_color', __( 'Marker color', 'undo-theme' ), '.section-rail' );
        $this->undo_color( 'rail_active_background', __( 'Active marker background', 'undo-theme' ), '.section-rail a[aria-current="location"]>span', 'background-color' );
        $this->undo_color( 'rail_active_text', __( 'Active marker text', 'undo-theme' ), '.section-rail a[aria-current="location"]>span' );
        $this->undo_color( 'rail_inverse_background', __( 'Active marker on dark section', 'undo-theme' ), '.section-rail[data-tone="inverse"] a[aria-current="location"]>span', 'background-color' );
        $this->undo_color( 'rail_inverse_text', __( 'Active text on dark section', 'undo-theme' ), '.section-rail[data-tone="inverse"] a[aria-current="location"]>span' );
        $this->undo_color( 'rail_track', __( 'Track color', 'undo-theme' ), '.section-rail:before', 'background-color' );
        $this->undo_color( 'rail_progress', __( 'Progress color', 'undo-theme' ), '.section-rail:after', 'background-color' );
        $this->undo_color( 'rail_label_background', __( 'Label background', 'undo-theme' ), '.section-rail em', 'background-color' );
        $this->undo_color( 'rail_label_color', __( 'Label text', 'undo-theme' ), '.section-rail em' );
        $this->undo_color( 'rail_current_color', __( 'Current section color', 'undo-theme' ), '.section-rail__current' );
        $this->undo_type( 'rail_number_type', '.section-rail a>span' );
        $this->undo_type( 'rail_label_type', '.section-rail em' );
        $this->undo_type( 'rail_current_type', '.section-rail__current' );
        $this->add_responsive_control( 'rail_label_radius', array( 'label' => __( 'Label corner radius', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 30 ) ), 'selectors' => array( '{{WRAPPER}} .section-rail em' => 'border-radius:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'rail_label_padding', array( 'label' => __( 'Label padding', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .section-rail em' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'rail_mobile', array( 'label' => __( 'Mobile progress', 'undo-theme' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->undo_color( 'mobile_inactive', __( 'Inactive color', 'undo-theme' ), '.mobile-section-progress span', 'background-color' );
        $this->undo_color( 'mobile_active', __( 'Active color', 'undo-theme' ), '.mobile-section-progress span.is-active', 'background-color' );
        $this->add_responsive_control( 'mobile_bar_height', array( 'label' => __( 'Bar height', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 5, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .mobile-section-progress span' => 'height:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'mobile_bar_width', array( 'label' => __( 'Bar width', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 2, 'max' => 20 ) ), 'selectors' => array( '{{WRAPPER}} .mobile-section-progress span' => 'width:{{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $items = array();
        $sections = isset( $s['sections'] ) && is_array( $s['sections'] ) ? $s['sections'] : array();
        foreach ( $sections as $item ) {
            $anchor = isset( $item['anchor'] ) ? sanitize_html_class( $item['anchor'] ) : '';
            if ( '' === $anchor ) { continue; }
            $items[] = array( 'anchor' => $anchor, 'label' => isset( $item['label'] ) ? $item['label'] : $anchor, 'number' => isset( $item['number'] ) ? $item['number'] : '' );
        }
        if ( ! $items ) { return; }
        $side = 'end' === $s['side'] ? 'end' : 'start';
        $marker = 'dot' === $s['marker_style'] ? 'dot' : 'number';
        echo '<nav class="section-rail undo-section-rail undo-section-rail--' . esc_attr( $side ) . ' undo-section-rail--' . esc_attr( $marker ) . ( 'yes' === $s['show_tooltips'] ? '' : ' undo-section-rail--no-tooltips' ) . ( 'yes' === $s['show_desktop'] ? '' : ' undo-section-rail--hidden' ) . '" style="--undo-rail-count:' . esc_attr( count( $items ) - 1 ) . ';--rail-track-height:calc(var(--undo-rail-count) * var(--undo-rail-step,42px))" data-guided-scroll="' . ( 'yes' === $s['guided_scroll'] ? 'yes' : 'no' ) . '" aria-label="' . esc_attr( $s['nav_label'] ) . '">';
            foreach ( $items as $index => $item ) {
                $number = '' !== $item['number'] ? $item['number'] : sprintf( '%02d', $index + 1 );
                echo '<a href="#' . esc_attr( $item['anchor'] ) . '" data-rail-for="' . esc_attr( $item['anchor'] ) . '" aria-label="' . esc_attr( $item['label'] ) . '"' . ( 0 === $index ? ' aria-current="location"' : '' ) . '><span>' . esc_html( $number ) . '</span><em>' . esc_html( $item['label'] ) . '</em></a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- All dynamic values escaped.
            }
            if ( 'yes' === $s['show_current'] ) { echo '<span class="section-rail__current" aria-hidden="true">' . esc_html( $items[0]['label'] ) . '</span>'; }
        echo '</nav>';
        if ( 'yes' === $s['show_mobile'] ) {
            echo '<div class="mobile-section-progress" aria-hidden="true">';
            foreach ( $items as $item ) { echo '<span></span>'; }
            echo '</div>';
        }
    }
}
