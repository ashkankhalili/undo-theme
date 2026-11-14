<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Render a reusable browser-only brief. No values are sent to WordPress. */
function undo_elements_render_planner( $args = array() ) {
    static $instance = 0;
    $instance++;
    $defaults = array(
        'id' => 1 === $instance ? 'project-planner' : 'project-planner-' . $instance,
        'title' => __( 'Tell us what you want to make.', 'undo-elements' ),
        'description' => __( 'Put the essentials in one place. Download your brief when you are done, so it is ready to share when we connect.', 'undo-elements' ),
        'button' => __( 'Download project brief', 'undo-elements' ),
    );
    $args = wp_parse_args( $args, $defaults );
    $id = sanitize_html_class( $args['id'] );
    if ( '' === $id ) { $id = 'project-planner-' . $instance; }
    $prefix = 'undo-elements-planner-' . $instance;
    wp_enqueue_style( 'undo-elements' );
    wp_enqueue_script( 'undo-elements-planner' );
    ob_start();
    ?>
    <section class="undo-elements-planner planner section" id="<?php echo esc_attr( $id ); ?>" aria-labelledby="<?php echo esc_attr( $prefix ); ?>-title">
      <div class="undo-elements-planner__inner planner-grid">
        <div class="undo-elements-planner__copy planner-copy">
          <p class="undo-elements-kicker"><?php esc_html_e( 'A clearer starting point', 'undo-elements' ); ?></p>
          <h2 id="<?php echo esc_attr( $prefix ); ?>-title"><?php echo esc_html( $args['title'] ); ?></h2>
          <p><?php echo esc_html( $args['description'] ); ?></p>
          <div class="undo-elements-planner__note planner-note"><?php esc_html_e( 'Your answers stay in this browser. The brief downloads to your device.', 'undo-elements' ); ?></div>
        </div>
        <form class="undo-elements-planner__form" data-undo-elements-planner>
          <fieldset><legend><?php esc_html_e( 'What do you need?', 'undo-elements' ); ?></legend>
            <div class="undo-elements-planner__choices">
              <label><input type="radio" name="service" value="Website" checked><span><?php esc_html_e( 'Website', 'undo-elements' ); ?></span></label>
              <label><input type="radio" name="service" value="WordPress plugin"><span><?php esc_html_e( 'WordPress plugin', 'undo-elements' ); ?></span></label>
              <label><input type="radio" name="service" value="Mobile app"><span><?php esc_html_e( 'Mobile app', 'undo-elements' ); ?></span></label>
            </div>
          </fieldset>
          <fieldset><legend><?php esc_html_e( 'Where are you starting?', 'undo-elements' ); ?></legend>
            <div class="undo-elements-planner__choices">
              <label><input type="radio" name="stage" value="A new project" checked><span><?php esc_html_e( 'Something new', 'undo-elements' ); ?></span></label>
              <label><input type="radio" name="stage" value="A redesign"><span><?php esc_html_e( 'A redesign', 'undo-elements' ); ?></span></label>
            </div>
          </fieldset>
          <label for="<?php echo esc_attr( $prefix ); ?>-name"><?php esc_html_e( 'Project or business name', 'undo-elements' ); ?></label>
          <input id="<?php echo esc_attr( $prefix ); ?>-name" name="projectName" type="text" dir="auto" maxlength="120" autocomplete="organization" placeholder="<?php esc_attr_e( 'Name of your project', 'undo-elements' ); ?>">
          <label for="<?php echo esc_attr( $prefix ); ?>-goal"><?php esc_html_e( 'What should it help you do?', 'undo-elements' ); ?></label>
          <textarea id="<?php echo esc_attr( $prefix ); ?>-goal" name="goal" dir="auto" rows="4" maxlength="1200" placeholder="<?php esc_attr_e( 'Describe the problem or the result you want', 'undo-elements' ); ?>"></textarea>
          <button type="submit"><?php echo esc_html( $args['button'] ); ?><span aria-hidden="true">↗</span></button>
          <p class="undo-elements-planner__status" role="status" aria-live="polite"></p>
        </form>
      </div>
    </section>
    <?php
    return ob_get_clean();
}

function undo_elements_planner_shortcode( $attributes ) {
    $attributes = shortcode_atts( array( 'id' => '', 'title' => '', 'description' => '', 'button' => '' ), $attributes, 'undo_project_planner' );
    return undo_elements_render_planner( array_filter( $attributes, 'strlen' ) );
}
add_shortcode( 'undo_project_planner', 'undo_elements_planner_shortcode' );
