<?php
/** Editable before/after website concept used in the Home hero. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Undo_Home_Comparison_Widget extends Undo_Home_Widget_Base {
    public function get_name() { return 'undo-comparison'; }
    public function get_title() { return __( 'Before and after comparison', 'undo-theme' ); }
    public function get_icon() { return 'eicon-image-before-after'; }

    protected function register_controls() {
        $this->start_controls_section( 'comparison_content', array( 'label' => __( 'Content', 'undo-theme' ) ) );
        $fields = array(
            'visual_label' => array( __( 'Accessible visual description', 'undo-theme' ), __( 'Interactive concept showing a website before and after a redesign', 'undo-theme' ) ),
            'comparison_label' => array( __( 'Accessible slider description', 'undo-theme' ), __( 'Compare earlier and redesigned website concept', 'undo-theme' ) ),
            'drag_label' => array( __( 'Instruction', 'undo-theme' ), __( 'Drag to compare', 'undo-theme' ) ),
            'perspective' => array( __( 'Browser address', 'undo-theme' ), __( 'new perspective', 'undo-theme' ) ),
            'mock_navigation' => array( __( 'New site navigation', 'undo-theme' ), __( 'Work  About  Contact', 'undo-theme' ) ),
            'mock_kicker' => array( __( 'New site eyebrow', 'undo-theme' ), __( 'A website with purpose.', 'undo-theme' ) ),
            'mock_heading' => array( __( 'New site heading', 'undo-theme' ), __( 'Make the first impression count.', 'undo-theme' ) ),
            'mock_action' => array( __( 'New site action', 'undo-theme' ), __( 'Start here', 'undo-theme' ) ),
            'before_name' => array( __( 'Old site name', 'undo-theme' ), __( 'COMPANY NAME', 'undo-theme' ) ),
            'before_navigation' => array( __( 'Old site navigation', 'undo-theme' ), __( 'Home  About  Services  Contact', 'undo-theme' ) ),
            'before_banner' => array( __( 'Old site banner', 'undo-theme' ), __( 'WELCOME TO OUR WEBSITE', 'undo-theme' ) ),
            'before_heading' => array( __( 'Old site heading', 'undo-theme' ), __( 'We provide solutions for your needs', 'undo-theme' ) ),
            'before_label' => array( __( 'Before label', 'undo-theme' ), __( 'Before', 'undo-theme' ) ),
            'after_label' => array( __( 'After label', 'undo-theme' ), __( 'After', 'undo-theme' ) ),
            'phone_heading' => array( __( 'Phone heading', 'undo-theme' ), __( 'Built for every screen.', 'undo-theme' ) ),
            'phone_action' => array( __( 'Phone action', 'undo-theme' ), __( 'Get started', 'undo-theme' ) ),
            'stamp' => array( __( 'Edge caption', 'undo-theme' ), __( 'DESIGN / BUILD / REDO', 'undo-theme' ) ),
        );
        foreach ( $fields as $key => $field ) {
            $this->add_control( $key, array( 'label' => $field[0], 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $field[1], 'label_block' => true ) );
        }
        $this->add_control( 'show_phone', array( 'label' => __( 'Show mobile mockup', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_labels', array( 'label' => __( 'Show before and after labels', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_instruction', array( 'label' => __( 'Show drag instruction', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'split', array( 'label' => __( 'Initial comparison split', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 38, 'unit' => '%' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'comparison_images', array( 'label' => __( 'Images', 'undo-theme' ) ) );
        $this->add_control( 'holder_image', array( 'label' => __( 'Holder background image', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'before_image', array( 'label' => __( 'Before image', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'before_image_alt', array( 'label' => __( 'Before image alternative text', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( 'after_image', array( 'label' => __( 'After image', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'after_image_alt', array( 'label' => __( 'After image alternative text', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'comparison_layout', array( 'label' => __( 'Layout', 'undo-theme' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'stage_height', array( 'label' => __( 'Visual height', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vh' ), 'range' => array( 'px' => array( 'min' => 200, 'max' => 900 ), 'vh' => array( 'min' => 20, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .hero-stage' => 'height:{{SIZE}}{{UNIT}};min-height:0;' ) ) );
        $this->add_responsive_control( 'browser_width', array( 'label' => __( 'Browser width', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 50, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .browser' => 'width:{{SIZE}}{{UNIT}};' ) ) );
        $image_units = array( 'px', '%', 'vw', 'vh' );
        $image_range = array( 'px' => array( 'min' => 50, 'max' => 1400 ), '%' => array( 'min' => 10, 'max' => 150 ), 'vw' => array( 'min' => 5, 'max' => 100 ), 'vh' => array( 'min' => 5, 'max' => 100 ) );
        foreach ( array( 'holder' => __( 'Holder', 'undo-theme' ), 'before' => __( 'Before', 'undo-theme' ), 'after' => __( 'After', 'undo-theme' ) ) as $key => $label ) {
            $selector = 'holder' === $key ? '.undo-comparison-holder-image' : '.undo-comparison-' . $key . '-image';
            $this->add_responsive_control( $key . '_image_width', array( 'label' => sprintf( __( '%s image width', 'undo-theme' ), $label ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => $image_units, 'range' => $image_range, 'selectors' => array( '{{WRAPPER}} ' . $selector => 'width:{{SIZE}}{{UNIT}};' ) ) );
            $this->add_responsive_control( $key . '_image_height', array( 'label' => sprintf( __( '%s image height', 'undo-theme' ), $label ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => $image_units, 'range' => $image_range, 'selectors' => array( '{{WRAPPER}} ' . $selector => 'height:{{SIZE}}{{UNIT}};' ) ) );
            $this->add_control( $key . '_image_fit', array( 'label' => sprintf( __( '%s image fit', 'undo-theme' ), $label ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( 'cover' => __( 'Cover', 'undo-theme' ), 'contain' => __( 'Contain', 'undo-theme' ), 'fill' => __( 'Fill', 'undo-theme' ) ), 'default' => 'cover', 'selectors' => array( '{{WRAPPER}} ' . $selector => 'object-fit:{{VALUE}};' ) ) );
            $this->add_control( $key . '_image_position', array( 'label' => sprintf( __( '%s image position', 'undo-theme' ), $label ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( 'center center' => __( 'Center', 'undo-theme' ), 'left center' => __( 'Left', 'undo-theme' ), 'right center' => __( 'Right', 'undo-theme' ), 'center top' => __( 'Top', 'undo-theme' ), 'center bottom' => __( 'Bottom', 'undo-theme' ) ), 'default' => 'center center', 'selectors' => array( '{{WRAPPER}} ' . $selector => 'object-position:{{VALUE}};' ) ) );
        }
        $this->add_responsive_control( 'browser_radius', array( 'label' => __( 'Browser corner radius', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .browser' => 'border-radius:{{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'phone_width', array( 'label' => __( 'Phone width', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 15, 'max' => 55 ) ), 'selectors' => array( '{{WRAPPER}} .phone' => 'width:{{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'comparison_colors', array( 'label' => __( 'Colors and type', 'undo-theme' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->undo_color( 'new_site_background', __( 'New site background', 'undo-theme' ), '.mock-site', 'background-color' );
        $this->undo_color( 'old_site_background', __( 'Old site background', 'undo-theme' ), '.before-site', 'background-color' );
        $this->undo_color( 'new_heading_color', __( 'New site heading', 'undo-theme' ), '.mock-heading' );
        $this->undo_color( 'accent_color', __( 'Accent color', 'undo-theme' ), '.comparison-divider span', 'background-color' );
        $this->undo_color( 'phone_background', __( 'Phone background', 'undo-theme' ), '.phone', 'background-color' );
        $this->undo_color( 'label_color', __( 'Instruction color', 'undo-theme' ), '.stage-label' );
        $this->undo_color( 'handle_background', __( 'Handle background', 'undo-theme' ), '.comparison-handle', 'background-color' );
        $this->undo_color( 'handle_color', __( 'Handle arrows', 'undo-theme' ), '.comparison-handle' );
        $this->add_responsive_control( 'handle_size', array( 'label' => __( 'Handle size', 'undo-theme' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 28, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .comparison-handle' => 'width:{{SIZE}}{{UNIT}};height:{{SIZE}}{{UNIT}};' ) ) );
        $this->undo_type( 'new_heading_type', '.mock-heading' );
        $this->undo_type( 'phone_heading_type', '.phone-title' );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $split = isset( $s['split']['size'] ) ? max( 0, min( 100, (int) $s['split']['size'] ) ) : 38;
        ?>
        <div class="hero-stage undo-comparison-widget" role="group" aria-label="<?php echo esc_attr( $s['visual_label'] ); ?>">
            <?php if ( ! empty( $s['holder_image']['url'] ) ) : ?><img class="undo-comparison-holder-image" src="<?php echo esc_url( $s['holder_image']['url'] ); ?>" alt="" loading="lazy" decoding="async"><?php endif; ?>
            <?php if ( 'yes' === $s['show_instruction'] ) : ?><div class="stage-label"><?php echo esc_html( $s['drag_label'] ); ?></div><?php endif; ?>
            <div class="browser" style="--split:<?php echo esc_attr( $split ); ?>%">
                <div class="browser-bar"><span class="browser-dots"><i></i><i></i><i></i></span><span class="browser-address">undo / <?php echo esc_html( $s['perspective'] ); ?></span><span class="browser-menu">•••</span></div>
                <div class="mock-site<?php echo ! empty( $s['after_image']['url'] ) ? ' undo-comparison-image-mode' : ''; ?>"><?php if ( ! empty( $s['after_image']['url'] ) ) : ?><img class="undo-comparison-after-image" src="<?php echo esc_url( $s['after_image']['url'] ); ?>" alt="<?php echo esc_attr( $s['after_image_alt'] ); ?>" loading="lazy" decoding="async"><?php else : ?><div class="mock-nav"><span class="mock-mark">U.</span><span><?php echo esc_html( $s['mock_navigation'] ); ?></span></div><div class="mock-body"><div class="mock-kicker"><?php echo esc_html( $s['mock_kicker'] ); ?></div><div class="mock-heading"><?php echo esc_html( $s['mock_heading'] ); ?></div><div class="mock-line"></div><div class="mock-button"><?php echo esc_html( $s['mock_action'] ); ?> ↗</div></div><div class="mock-blocks"><div></div><div></div><div></div></div><?php endif; ?></div>
                <div class="before-site<?php echo ! empty( $s['before_image']['url'] ) ? ' undo-comparison-image-mode' : ''; ?>"<?php echo empty( $s['before_image']['url'] ) ? ' aria-hidden="true"' : ''; ?>><?php if ( ! empty( $s['before_image']['url'] ) ) : ?><img class="undo-comparison-before-image" src="<?php echo esc_url( $s['before_image']['url'] ); ?>" alt="<?php echo esc_attr( $s['before_image_alt'] ); ?>" loading="lazy" decoding="async"><?php else : ?><div class="before-top"><span><?php echo esc_html( $s['before_name'] ); ?></span><span><?php echo esc_html( $s['before_navigation'] ); ?></span></div><div class="before-banner"><?php echo esc_html( $s['before_banner'] ); ?></div><div class="before-content"><div class="before-heading"><?php echo esc_html( $s['before_heading'] ); ?></div><div class="before-lines"><i></i><i></i><i></i><i></i></div><div class="before-boxes"><i></i><i></i><i></i></div></div><?php endif; ?></div>
                <?php if ( 'yes' === $s['show_labels'] ) : ?><span class="comparison-label comparison-label--before" aria-hidden="true"><?php echo esc_html( $s['before_label'] ); ?></span><span class="comparison-label comparison-label--after" aria-hidden="true"><?php echo esc_html( $s['after_label'] ); ?></span><?php endif; ?><div class="comparison-divider" aria-hidden="true"><span class="comparison-handle"><svg><use href="#icon-horizontal"></use></svg></span></div><input class="comparison-range" type="range" min="0" max="100" value="<?php echo esc_attr( $split ); ?>" aria-label="<?php echo esc_attr( $s['comparison_label'] ); ?>">
            </div>
            <?php if ( 'yes' === $s['show_phone'] ) : ?><div class="phone"><div class="phone-notch"></div><div class="phone-inner"><div class="phone-top">U. <span>☰</span></div><div class="phone-title"><?php echo esc_html( $s['phone_heading'] ); ?></div><div class="phone-shape"></div><div class="phone-lines"><span></span><span></span></div><div class="phone-cta"><?php echo esc_html( $s['phone_action'] ); ?> ↗</div></div></div><?php endif; ?>
            <span class="stage-stamp"><?php echo esc_html( $s['stamp'] ); ?></span>
        </div>
        <?php
    }
}
