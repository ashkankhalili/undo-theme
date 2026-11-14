<?php
/** Shared homepage section navigation for native and Elementor Home pages. */
$visible_sections = isset( $args['sections'] ) && is_array( $args['sections'] ) ? $args['sections'] : undo_home_visible_sections();
$section_labels = undo_home_sections();
$rail_sections = array( 'top' => __( 'Home', 'undo-theme' ) );
foreach ( $visible_sections as $section ) {
    if ( isset( $section_labels[ $section ] ) ) { $rail_sections[ $section ] = $section_labels[ $section ]; }
}
$rail_sections['project-planner'] = __( 'Project planner', 'undo-theme' );
$rail_sections['finish'] = 'UNDO';
if ( undo_setting_enabled( 'show_section_rail' ) ) : ?>
<nav class="section-rail" style="--rail-track-height:<?php echo esc_attr( ( count( $rail_sections ) - 1 ) * 42 ); ?>px" aria-label="<?php esc_attr_e( 'Page sections', 'undo-theme' ); ?>">
<?php $number = 0; foreach ( $rail_sections as $id => $label ) : $number++; ?><a href="#<?php echo esc_attr( $id ); ?>" data-rail-for="<?php echo esc_attr( $id ); ?>" aria-label="<?php echo esc_attr( $label ); ?>" <?php echo 1 === $number ? 'aria-current="location"' : ''; ?>><span><?php echo esc_html( sprintf( '%02d', $number ) ); ?></span><em><?php echo esc_html( $label ); ?></em></a><?php endforeach; ?>
<span class="section-rail__current" aria-hidden="true"><?php esc_html_e( 'Home', 'undo-theme' ); ?></span></nav>
<?php endif; ?>
<div class="mobile-section-progress" aria-hidden="true"><?php foreach ( $rail_sections as $unused ) { echo '<span></span>'; } ?></div>
