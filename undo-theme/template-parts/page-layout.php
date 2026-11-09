<?php
/** Shared page renderer for the standard and full-width templates. */
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) { return; }
if ( undo_is_elementor_page() ) : ?>
<main id="main" class="undo-elementor-page"><?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?></main>
<?php return; endif;

$full_width = ! empty( $args['full_width'] );
$width = $full_width ? 'full' : ( 'wide' === undo_setting( 'page_content_width' ) ? 'wide' : 'reading' );
$has_sidebar = ! $full_width && undo_has_sidebar( 'page_show_sidebar' );
$title_style = 'compact' === undo_setting( 'page_title_style' ) ? 'compact' : 'editorial';
?>
<div class="content-layout page-layout page-layout--<?php echo esc_attr( $width ); ?> wrap<?php echo $has_sidebar ? ' has-sidebar sidebar-' . esc_attr( undo_setting( 'sidebar_position' ) ) : ''; ?>">
<main id="main" class="wp-content page-content">
<?php while ( have_posts() ) : the_post();
    $page_title = get_the_title() ?: __( 'Untitled page', 'undo-theme' );
    $show_title = undo_setting_enabled( 'page_show_title' );
    $show_breadcrumbs = undo_setting_enabled( 'page_show_breadcrumbs' );
    $ancestors = $show_breadcrumbs ? array_reverse( get_post_ancestors( get_the_ID() ) ) : array();
    ?>
<article <?php post_class( 'page-article' ); ?>>
<?php if ( $show_title || $show_breadcrumbs ) : ?>
<header class="page-header page-header--<?php echo esc_attr( $title_style ); ?><?php echo $show_title ? '' : ' page-header--path-only'; ?>">
<?php if ( $show_breadcrumbs ) : ?>
<nav class="page-breadcrumbs" aria-label="<?php esc_attr_e( 'Page path', 'undo-theme' ); ?>"><ol>
<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'undo-theme' ); ?></a></li>
<?php foreach ( $ancestors as $ancestor_id ) : if ( 'publish' !== get_post_status( $ancestor_id ) ) { continue; } ?><li><a href="<?php echo esc_url( get_permalink( $ancestor_id ) ); ?>"><?php echo esc_html( get_the_title( $ancestor_id ) ); ?></a></li><?php endforeach; ?>
<li aria-current="page"><?php echo esc_html( $page_title ); ?></li>
</ol></nav>
<?php endif; ?>
<?php if ( $show_title ) : ?><h1><?php echo esc_html( $page_title ); ?></h1><?php endif; ?>
</header>
<?php endif; ?>
<?php if ( undo_setting_enabled( 'page_show_featured' ) && has_post_thumbnail() ) : ?><figure class="page-featured"><?php the_post_thumbnail( 'large' ); ?></figure><?php endif; ?>
<div class="page-body entry-content"><?php the_content(); ?><?php wp_link_pages( array( 'before' => '<nav class="page-pagination" aria-label="' . esc_attr__( 'Page navigation', 'undo-theme' ) . '">', 'after' => '</nav>' ) ); ?></div>
</article>
<?php endwhile; ?>
</main>
<?php if ( $has_sidebar ) { get_sidebar(); } ?>
</div>
