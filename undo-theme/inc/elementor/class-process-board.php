<?php
/** Editable process board matching the native Home component. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Undo_Home_Process_Board_Widget extends Undo_Home_Widget_Base {
    public function get_name() { return 'undo-process-board'; }
    public function get_title() { return __( 'Process board', 'undo-theme' ); }
    public function get_icon() { return 'eicon-post-list'; }

    protected function register_controls() {
        $step = new \Elementor\Repeater();
        $step->add_control( 'number', array( 'label' => __( 'Number', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '01' ) );
        $step->add_control( 'title', array( 'label' => __( 'Step title', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Understand', 'undo-theme' ), 'label_block' => true ) );
        $step->add_control( 'detail', array( 'label' => __( 'Step description', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '', 'label_block' => true ) );
        $this->start_controls_section( 'board_content', array( 'label' => __( 'Content', 'undo-theme' ) ) );
        $this->add_control( 'eyebrow', array( 'label' => __( 'Eyebrow', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'HOW WE WORK', 'undo-theme' ) ) );
        $this->add_control( 'brand_code', array( 'label' => __( 'Board code', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'UNDO / 04' ) );
        $this->add_control( 'aria_label', array( 'label' => __( 'Accessible description', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Our process: understand, design, build, refine', 'undo-theme' ), 'label_block' => true ) );
        $this->add_control( 'steps', array(
            'label' => __( 'Process steps', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $step->get_controls(), 'title_field' => '{{{ title }}}',
            'default' => array(
                array( 'number' => '01', 'title' => __( 'Understand', 'undo-theme' ), 'detail' => __( 'Goals, users, constraints', 'undo-theme' ) ),
                array( 'number' => '02', 'title' => __( 'Design', 'undo-theme' ), 'detail' => __( 'Structure, content, interface', 'undo-theme' ) ),
                array( 'number' => '03', 'title' => __( 'Build', 'undo-theme' ), 'detail' => __( 'Working product', 'undo-theme' ) ),
                array( 'number' => '04', 'title' => __( 'Refine', 'undo-theme' ), 'detail' => __( 'Details that make it last', 'undo-theme' ) ),
            ),
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'board_box', array( 'label' => __( 'Board', 'undo-theme' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->undo_color( 'board_background', __( 'Background', 'undo-theme' ), '.process-board', 'background-color' );
        $this->undo_color( 'board_text', __( 'Text color', 'undo-theme' ), '.process-board' );
        $this->add_responsive_control( 'board_padding', array( 'label' => __( 'Padding', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .process-board' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'board_width', array( 'label' => __( 'Maximum width', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 240, 'max' => 1000 ), '%' => array( 'min' => 20, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .process-board' => 'max-width:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'board_radius', array( 'label' => __( 'Corner radius', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .process-board' => 'border-radius:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'board_border', 'selector' => '{{WRAPPER}} .process-board' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'board_shadow', 'selector' => '{{WRAPPER}} .process-board' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'board_heading', array( 'label' => __( 'Heading and steps', 'undo-theme' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->undo_color( 'board_accent', __( 'Accent color', 'undo-theme' ), '.process-board', '--undo-board-accent' );
        $this->undo_color( 'board_divider', __( 'Divider color', 'undo-theme' ), '.process-step', 'border-color' );
        $this->undo_color( 'board_detail', __( 'Description color', 'undo-theme' ), '.process-step small' );
        $this->undo_type( 'board_eyebrow_type', '.process-top' );
        $this->undo_type( 'board_title_type', '.process-step strong' );
        $this->undo_type( 'board_detail_type', '.process-step small' );
        $this->add_responsive_control( 'step_padding', array( 'label' => __( 'Step padding', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .process-step' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $steps = isset( $s['steps'] ) && is_array( $s['steps'] ) ? $s['steps'] : array();
        echo '<div class="process-board undo-process-board" aria-label="' . esc_attr( $s['aria_label'] ) . '"><div class="process-top">' . esc_html( $s['eyebrow'] ) . ' <span>' . esc_html( $s['brand_code'] ) . '</span></div>';
        foreach ( $steps as $index => $item ) {
            $number = isset( $item['number'] ) && '' !== $item['number'] ? $item['number'] : sprintf( '%02d', $index + 1 );
            echo '<div class="process-step"><span>' . esc_html( $number ) . '</span><strong>' . esc_html( isset( $item['title'] ) ? $item['title'] : '' ) . '</strong><small>' . esc_html( isset( $item['detail'] ) ? $item['detail'] : '' ) . '</small></div>';
        }
        echo '</div>';
    }
}
