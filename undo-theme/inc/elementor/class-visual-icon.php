<?php
/** Editable native service glyphs and the UNDO mark. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Undo_Home_Visual_Icon_Widget extends Undo_Home_Widget_Base {
    public function get_name() { return 'undo-visual-icon'; }
    public function get_title() { return __( 'Visual icon', 'undo-theme' ); }
    public function get_icon() { return 'eicon-icon-box'; }

    protected function register_controls() {
        $this->start_controls_section( 'icon_content', array( 'label' => __( 'Icon', 'undo-theme' ) ) );
        $this->add_control( 'icon_type', array(
            'label' => __( 'Icon design', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SELECT,
            'options' => array( 'web' => __( 'Website', 'undo-theme' ), 'plugin' => __( 'Plugin', 'undo-theme' ), 'app' => __( 'Mobile app', 'undo-theme' ), 'undo' => __( 'UNDO mark', 'undo-theme' ), 'library' => __( 'Elementor icon library', 'undo-theme' ) ),
            'default' => 'web',
        ) );
        $this->add_control( 'library_icon', array( 'label' => __( 'Choose icon', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::ICONS, 'condition' => array( 'icon_type' => 'library' ) ) );
        $this->add_control( 'decorative', array( 'label' => __( 'Decorative icon', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'accessible_label', array( 'label' => __( 'Accessible label', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'condition' => array( 'decorative!' => 'yes' ) ) );
        $this->add_control( 'title', array( 'label' => __( 'Title', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'label_block' => true ) );
        $this->add_control( 'description', array( 'label' => __( 'Description', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '', 'label_block' => true ) );
        $this->add_control( 'title_tag', array( 'label' => __( 'Title HTML tag', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'div' => 'DIV' ), 'default' => 'h3', 'condition' => array( 'title!' => '' ) ) );
        $this->add_control( 'content_direction', array( 'label' => __( 'Text direction', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( 'inherit' => __( 'Inherit', 'undo-theme' ), 'ltr' => 'LTR', 'rtl' => 'RTL' ), 'default' => 'inherit' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'icon_style', array( 'label' => __( 'Appearance', 'undo-theme' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->undo_color( 'icon_background', __( 'Background', 'undo-theme' ), '.service-symbol', 'background-color' );
        $this->undo_color( 'icon_color', __( 'Main color', 'undo-theme' ), '.undo-visual-icon', '--ink' );
        $this->undo_color( 'icon_accent', __( 'Accent color', 'undo-theme' ), '.undo-visual-icon', '--red' );
        $this->add_responsive_control( 'icon_box_size', array( 'label' => __( 'Box size', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 32, 'max' => 220 ) ), 'selectors' => array( '{{WRAPPER}} .service-symbol' => 'width:{{SIZE}}{{UNIT}};height:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'icon_glyph_scale', array( 'label' => __( 'Glyph scale', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 50, 'max' => 200 ) ), 'selectors' => array( '{{WRAPPER}} .undo-visual-icon' => '--undo-glyph-scale:calc({{SIZE}} / 100);' ) ) );
        $this->add_responsive_control( 'icon_radius', array( 'label' => __( 'Corner radius', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 110 ) ), 'selectors' => array( '{{WRAPPER}} .service-symbol' => 'border-radius:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'icon_alignment', array( 'label' => __( 'Alignment', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array(
            'start' => array( 'title' => __( 'Start', 'undo-theme' ), 'icon' => 'eicon-text-align-left' ),
            'center' => array( 'title' => __( 'Center', 'undo-theme' ), 'icon' => 'eicon-text-align-center' ),
            'end' => array( 'title' => __( 'End', 'undo-theme' ), 'icon' => 'eicon-text-align-right' ),
        ), 'selectors' => array( '{{WRAPPER}} .undo-visual-icon' => 'justify-content:{{VALUE}};' ) ) );
        $this->add_responsive_control( 'content_alignment', array( 'label' => __( 'Text alignment', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'start' => array( 'title' => __( 'Start', 'undo-theme' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => __( 'Center', 'undo-theme' ), 'icon' => 'eicon-text-align-center' ), 'end' => array( 'title' => __( 'End', 'undo-theme' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .undo-visual-icon__content' => 'text-align:{{VALUE}};' ) ) );
        $this->add_responsive_control( 'content_gap', array( 'label' => __( 'Icon to text spacing', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'em' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), 'em' => array( 'min' => 0, 'max' => 8 ) ), 'selectors' => array( '{{WRAPPER}} .undo-visual-icon--with-content' => 'gap:{{SIZE}}{{UNIT}};' ) ) );
        $this->undo_color( 'title_color', __( 'Title color', 'undo-theme' ), '.undo-visual-icon__title' );
        $this->undo_color( 'description_color', __( 'Description color', 'undo-theme' ), '.undo-visual-icon__description' );
        $this->undo_type( 'title_type', '.undo-visual-icon__title' );
        $this->undo_type( 'description_type', '.undo-visual-icon__description' );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $allowed = array( 'web', 'plugin', 'app', 'undo', 'library' );
        $type = in_array( $s['icon_type'], $allowed, true ) ? $s['icon_type'] : 'web';
        $has_content = ! empty( $s['title'] ) || ! empty( $s['description'] );
        $a11y = 'yes' === $s['decorative'] || empty( $s['accessible_label'] )
            ? ' aria-hidden="true"' : ' role="img" aria-label="' . esc_attr( $s['accessible_label'] ) . '"';
        $dir = isset( $s['content_direction'] ) && in_array( $s['content_direction'], array( 'ltr', 'rtl' ), true ) ? ' dir="' . esc_attr( $s['content_direction'] ) . '"' : '';
        echo '<div class="undo-visual-icon undo-visual-icon--' . esc_attr( $type ) . ( $has_content ? ' undo-visual-icon--with-content' : '' ) . '"' . $dir . '><div class="undo-visual-icon__glyph"' . $a11y . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Controlled type and escaped label.
        if ( 'undo' === $type ) {
            echo '<div class="intro-mark"><svg aria-hidden="true"><use href="#icon-undo"></use></svg></div>';
        } else {
            echo '<div class="service-symbol">';
            if ( 'web' === $type ) { echo '<span class="web-glyph"><i></i><i></i><i></i></span>'; }
            if ( 'plugin' === $type ) { echo '<span class="plugin-glyph"><i></i><i></i><i></i><i></i></span>'; }
            if ( 'app' === $type ) { echo '<span class="app-glyph"><i></i></span>'; }
            if ( 'library' === $type && ! empty( $s['library_icon']['value'] ) ) {
                \Elementor\Icons_Manager::render_icon( $s['library_icon'], array( 'aria-hidden' => 'true' ) );
            }
            echo '</div>';
        }
        echo '</div>';
        if ( $has_content ) {
            $tag = isset( $s['title_tag'] ) && in_array( $s['title_tag'], array( 'h2', 'h3', 'h4', 'div' ), true ) ? $s['title_tag'] : 'h3';
            echo '<div class="undo-visual-icon__content">';
            if ( ! empty( $s['title'] ) ) { echo '<' . esc_attr( $tag ) . ' class="undo-visual-icon__title">' . esc_html( $s['title'] ) . '</' . esc_attr( $tag ) . '>'; }
            if ( ! empty( $s['description'] ) ) { echo '<p class="undo-visual-icon__description">' . esc_html( $s['description'] ) . '</p>'; }
            echo '</div>';
        }
        echo '</div>';
    }
}
