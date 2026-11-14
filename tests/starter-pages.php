<?php
/** Isolated checks for non-destructive Elementor starter provisioning. */
define( 'ABSPATH', __DIR__ . '/' );
class Fake_Elementor_Plugin {
    public static $instance;
    public $documents;
    public $frontend;
}
class_alias( 'Fake_Elementor_Plugin', 'Elementor\\Plugin' );
class Fake_Documents {
    public function get( $id ) { return new Fake_Document( $id ); }
}
class Fake_Document {
    private $id;
    public function __construct( $id ) { $this->id = $id; }
    public function save( $data ) { $GLOBALS['saved_documents'][ $this->id ] = $data; return true; }
}
class Fake_Frontend {
    public function get_builder_content_for_display( $id, $with_css ) { return '<div>Built page ' . $id . '</div>'; }
}
class WP_Query {
    public $max_num_pages = 3;
    private $position = 0;
    public function __construct( $args ) { $GLOBALS['blog_query_args'] = $args; }
    public function have_posts() { return $this->position < 2; }
    public function the_post() { $this->position++; }
}
Fake_Elementor_Plugin::$instance = new Fake_Elementor_Plugin();
Fake_Elementor_Plugin::$instance->documents = new Fake_Documents();
Fake_Elementor_Plugin::$instance->frontend = new Fake_Frontend();

function add_action( $name, $callback, $priority = 10 ) {}
function add_shortcode( $name, $callback ) { $GLOBALS['shortcodes'][ $name ] = $callback; }
function current_user_can( $capability ) { return true; }
function did_action( $name ) { return $GLOBALS['elementor_loaded'] ?? 0; }
function get_template_directory() { return dirname( __DIR__ ) . '/undo-theme'; }
function get_current_user_id() { return 1; }
function get_option( $key, $default = false ) { return $GLOBALS['options'][ $key ] ?? $default; }
function get_query_var( $key, $default = 0 ) { return 2; }
function undo_setting( $key ) { return 'blog_style' === $key ? 'journal' : '2'; }
function esc_attr( $value ) { return htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' ); }
function esc_attr__( $text, $domain ) { return $text; }
function esc_html__( $text, $domain ) { return $text; }
function paginate_links( $args ) { return '<ul><li>2 of ' . $args['total'] . '</li></ul>'; }
function wp_reset_postdata() { $GLOBALS['postdata_reset'] = true; }
function update_option( $key, $value, $autoload = null ) { $GLOBALS['options'][ $key ] = $value; return true; }
function absint( $value ) { return abs( (int) $value ); }
function is_wp_error( $value ) { return false; }
function wp_insert_post( $data, $return_error = false ) {
    $id = count( $GLOBALS['pages'] ) + 1;
    $GLOBALS['pages'][ $id ] = (object) array( 'ID' => $id, 'post_type' => $data['post_type'], 'post_status' => $data['post_status'], 'post_title' => $data['post_title'] );
    return $id;
}
function wp_update_post( $data, $return_error = false ) { $GLOBALS['pages'][ $data['ID'] ]->post_status = $data['post_status']; return $data['ID']; }
function wp_delete_post( $id, $force = false ) { unset( $GLOBALS['pages'][ $id ] ); return true; }
function update_post_meta( $id, $key, $value ) { $GLOBALS['meta'][ $id ][ $key ] = $value; }
function get_post_meta( $id, $key, $single = false ) { return $GLOBALS['meta'][ $id ][ $key ] ?? ''; }
function get_post_type( $id ) { return $GLOBALS['pages'][ $id ]->post_type ?? false; }
function get_post_status( $id ) { return $GLOBALS['pages'][ $id ]->post_status ?? false; }
function get_posts( $args ) {
    foreach ( $GLOBALS['meta'] ?? array() as $id => $meta ) {
        if ( isset( $meta[ $args['meta_key'] ] ) && $meta[ $args['meta_key'] ] === $args['meta_value'] ) { return array( $id ); }
    }
    return array();
}
function pll_languages_list( $args ) { return $GLOBALS['configured_languages'] ?? array(); }
function pll_set_post_language( $id, $language ) { $GLOBALS['post_languages'][ $id ] = $language; }
function pll_save_post_translations( $translations ) { $GLOBALS['translation_pairs'][] = $translations; }
function get_template_part( $slug ) { echo 'template-parts/post-card' === $slug ? '<article>Post</article>' : '<section id="project-planner"></section>'; }
function expect( $condition, $message ) { if ( ! $condition ) { throw new RuntimeException( $message ); } }

$GLOBALS['options'] = array( 'show_on_front' => 'page', 'page_on_front' => 777, 'page_for_posts' => 888, 'posts_per_page' => 5 );
$GLOBALS['pages'] = array();
require dirname( __DIR__ ) . '/undo-theme/inc/starter-pages.php';
undo_maybe_create_starter_pages();
expect( 0 === count( $GLOBALS['pages'] ), 'No pages are created when Elementor is absent' );

$GLOBALS['elementor_loaded'] = 1;
undo_maybe_create_starter_pages();
$ids = get_option( 'undo_starter_pages' );
expect( 4 === count( $ids ) && 4 === count( $GLOBALS['pages'] ), 'Four published English/Persian pages are created' );
foreach ( $ids as $key => $id ) {
    expect( 'publish' === get_post_status( $id ) && $key === get_post_meta( $id, '_undo_starter_page', true ), 'Starter pages are published and marked' );
    expect( 'builder' === get_post_meta( $id, '_elementor_edit_mode', true ) && ! empty( $GLOBALS['saved_documents'][ $id ]['elements'] ), 'Starter content is saved through Elementor' );
}
expect( 'page' === get_option( 'show_on_front' ) && 777 === get_option( 'page_on_front' ) && 888 === get_option( 'page_for_posts' ), 'Existing Reading choices stay untouched' );
$GLOBALS['pages'][ $ids['home-fa'] ]->post_title = 'Customer edited title';
undo_maybe_create_starter_pages();
expect( 4 === count( $GLOBALS['pages'] ) && 'Customer edited title' === $GLOBALS['pages'][ $ids['home-fa'] ]->post_title, 'Subsequent admin loads do not overwrite content' );
expect( undo_is_generated_starter( $ids['home-fa'], 'home' ) && ! undo_is_generated_starter( $ids['home-fa'], 'blog-page' ), 'Starter type is resolved from its marker' );
expect( false !== strpos( undo_home_planner_shortcode(), 'project-planner' ), 'Native planner remains available without the addon' );
$blog = undo_blog_posts_shortcode();
expect( 2 === substr_count( $blog, '<article>' ) && false !== strpos( $blog, '2 of 3' ) && ! empty( $GLOBALS['postdata_reset'] ), 'Free blog starter renders posts and pagination safely' );
expect( 2 === $GLOBALS['blog_query_args']['paged'] && 5 === $GLOBALS['blog_query_args']['posts_per_page'], 'Blog shortcode follows Reading pagination settings' );
expect( false !== strpos( undo_elementor_posts_page_content( $ids['blog-page-fa'] ), 'Built page' ), 'Reading posts page can render saved Elementor content' );
$GLOBALS['elementor_loaded'] = 0;
expect( '' === undo_elementor_posts_page_content( $ids['blog-page-fa'] ), 'Posts page returns to native loop when Elementor is disabled' );
$GLOBALS['elementor_loaded'] = 1;
$GLOBALS['configured_languages'] = array( 'en', 'fa' );
undo_link_starter_translations( $ids );
expect( 2 === count( $GLOBALS['translation_pairs'] ) && 'fa' === $GLOBALS['post_languages'][ $ids['blog-page-fa'] ], 'Polylang pairs are linked when both languages exist' );
undo_link_starter_translations( $ids );
expect( 2 === count( $GLOBALS['translation_pairs'] ), 'Translation pairing is one time' );
echo "Starter page provisioning checks passed.\n";
