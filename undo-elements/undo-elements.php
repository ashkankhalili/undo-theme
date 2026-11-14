<?php
/**
 * Plugin Name: UNDO Elements
 * Plugin URI: https://github.com/ashkankhalili/undo-theme
 * Description: Elementor widgets and a private, browser-only project planner for UNDO websites.
 * Version: 0.1.1
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Author: UNDO Web Developments
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: undo-elements
 * Domain Path: /languages
 * Update URI: https://github.com/ashkankhalili/undo-theme
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'UNDO_ELEMENTS_VERSION', '0.1.1' );
define( 'UNDO_ELEMENTS_FILE', __FILE__ );
define( 'UNDO_ELEMENTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'UNDO_ELEMENTS_URL', plugin_dir_url( __FILE__ ) );

require_once UNDO_ELEMENTS_PATH . 'includes/planner.php';
require_once UNDO_ELEMENTS_PATH . 'includes/github-updater.php';

function undo_elements_load_textdomain() {
    load_plugin_textdomain( 'undo-elements', false, dirname( plugin_basename( UNDO_ELEMENTS_FILE ) ) . '/languages' );
}
add_action( 'init', 'undo_elements_load_textdomain' );

function undo_elements_register_assets() {
    wp_register_style( 'undo-elements', UNDO_ELEMENTS_URL . 'assets/elements.css', array(), UNDO_ELEMENTS_VERSION );
    wp_register_script( 'undo-elements-planner', UNDO_ELEMENTS_URL . 'assets/planner.js', array(), UNDO_ELEMENTS_VERSION, true );
    $content_language = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : '';
    $planner_language = in_array( $content_language, array( 'en', 'fa' ), true ) ? $content_language : substr( determine_locale(), 0, 2 );
    wp_localize_script( 'undo-elements-planner', 'undoElementsPlanner', array(
        'briefTitle' => __( 'Project brief', 'undo-elements' ),
        'project' => __( 'Project', 'undo-elements' ),
        'service' => __( 'Service', 'undo-elements' ),
        'startingPoint' => __( 'Starting point', 'undo-elements' ),
        'goal' => __( 'Goal', 'undo-elements' ),
        'untitled' => __( 'Untitled project', 'undo-elements' ),
        'toDiscuss' => __( 'To discuss', 'undo-elements' ),
        'downloaded' => __( 'Your brief has been downloaded.', 'undo-elements' ),
        'filename' => __( 'undo-project-brief.txt', 'undo-elements' ),
        'language' => $planner_language,
    ) );
    // Queue the native Home and shortcode before wp_head; Elementor uses widget dependencies.
    $post_id = get_queried_object_id();
    $content = $post_id ? (string) get_post_field( 'post_content', $post_id ) : '';
    $elementor_data = $post_id ? (string) get_post_meta( $post_id, '_elementor_data', true ) : '';
    $native_home = is_front_page() && function_exists( 'undo_is_elementor_page' ) && ! undo_is_elementor_page()
        && ( ! is_page() || ! function_exists( 'undo_page_template_layout' ) || ! undo_page_template_layout( get_page_template_slug( $post_id ) ) );
    if ( $native_home || has_shortcode( $content, 'undo_project_planner' ) || false !== strpos( $elementor_data, 'undo_project_planner' ) ) {
        wp_enqueue_style( 'undo-elements' );
        wp_enqueue_script( 'undo-elements-planner' );
    }
}
add_action( 'wp_enqueue_scripts', 'undo_elements_register_assets' );

function undo_elements_print_late_style() {
    if ( wp_style_is( 'undo-elements', 'enqueued' ) && ! wp_style_is( 'undo-elements', 'done' ) ) {
        wp_print_styles( 'undo-elements' );
    }
}
add_action( 'wp_footer', 'undo_elements_print_late_style', 5 );

function undo_elements_register_category( $manager ) {
    $manager->add_category( 'undo-elements', array( 'title' => __( 'UNDO Elements', 'undo-elements' ), 'icon' => 'eicon-undo' ) );
}

function undo_elements_register_widgets( $manager ) {
    require_once UNDO_ELEMENTS_PATH . 'includes/widgets/class-planner.php';
    require_once UNDO_ELEMENTS_PATH . 'includes/widgets/class-service-card.php';
    require_once UNDO_ELEMENTS_PATH . 'includes/widgets/class-project-cta.php';
    $manager->register( new \Undo_Elements_Planner_Widget() );
    $manager->register( new \Undo_Elements_Service_Card_Widget() );
    $manager->register( new \Undo_Elements_Project_CTA_Widget() );
}

function undo_elements_connect_elementor() {
    if ( ! did_action( 'elementor/loaded' ) ) { return; }
    add_action( 'elementor/elements/categories_registered', 'undo_elements_register_category' );
    add_action( 'elementor/widgets/register', 'undo_elements_register_widgets' );
}
add_action( 'plugins_loaded', 'undo_elements_connect_elementor', 20 );

function undo_elements_missing_elementor_notice() {
    if ( did_action( 'elementor/loaded' ) || ! current_user_can( 'activate_plugins' ) ) { return; }
    echo '<div class="notice notice-warning"><p>' . esc_html__( 'UNDO Elements needs Elementor for its widgets. The project planner shortcode remains available.', 'undo-elements' ) . '</p></div>';
}
add_action( 'admin_notices', 'undo_elements_missing_elementor_notice' );
