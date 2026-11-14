<?php
/** All customer theme choices are stored in one option. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function undo_page_template_presets() {
    return array(
        'reading' => array( 'title' => __( 'UNDO Reading', 'undo-theme' ), 'width' => '760px', 'margin_inline' => '48', 'margin_top' => '0', 'margin_bottom' => '0', 'padding_inline' => '0', 'padding_top' => '112', 'padding_bottom' => '160' ),
        'wide' => array( 'title' => __( 'UNDO Wide', 'undo-theme' ), 'width' => '1440px', 'margin_inline' => '48', 'margin_top' => '0', 'margin_bottom' => '0', 'padding_inline' => '0', 'padding_top' => '112', 'padding_bottom' => '160' ),
        'boxed' => array( 'title' => __( 'UNDO Boxed', 'undo-theme' ), 'width' => '1100px', 'margin_inline' => '48', 'margin_top' => '0', 'margin_bottom' => '0', 'padding_inline' => '64', 'padding_top' => '112', 'padding_bottom' => '160' ),
        'full' => array( 'title' => __( 'UNDO Full Width', 'undo-theme' ), 'width' => '100%', 'margin_inline' => '0', 'margin_top' => '0', 'margin_bottom' => '0', 'padding_inline' => '64', 'padding_top' => '112', 'padding_bottom' => '160' ),
    );
}

function undo_page_template_fields() {
    $fields = array();
    foreach ( undo_page_template_presets() as $mode => $preset ) {
        $prefix = 'page_' . $mode . '_';
        $fields[ $prefix . 'width' ] = array( __( 'Maximum width', 'undo-theme' ), 'dimension', $preset['width'] );
        $fields[ $prefix . 'margin_inline' ] = array( __( 'Minimum side margin in pixels', 'undo-theme' ), 'number', $preset['margin_inline'], array( 0, 160 ) );
        $fields[ $prefix . 'margin_top' ] = array( __( 'Top margin in pixels', 'undo-theme' ), 'number', $preset['margin_top'], array( 0, 240 ) );
        $fields[ $prefix . 'margin_bottom' ] = array( __( 'Bottom margin in pixels', 'undo-theme' ), 'number', $preset['margin_bottom'], array( 0, 240 ) );
        $fields[ $prefix . 'padding_inline' ] = array( __( 'Side padding in pixels', 'undo-theme' ), 'number', $preset['padding_inline'], array( 0, 160 ) );
        $fields[ $prefix . 'padding_top' ] = array( __( 'Top padding in pixels', 'undo-theme' ), 'number', $preset['padding_top'], array( 0, 240 ) );
        $fields[ $prefix . 'padding_bottom' ] = array( __( 'Bottom padding in pixels', 'undo-theme' ), 'number', $preset['padding_bottom'], array( 0, 240 ) );
    }
    return $fields;
}

function undo_typography_roles() {
    return array(
        'body' => __( 'Body text', 'undo-theme' ), 'headings' => __( 'Headings', 'undo-theme' ),
        'accent' => __( 'Accent text', 'undo-theme' ), 'navigation' => __( 'Navigation', 'undo-theme' ),
        'buttons' => __( 'Buttons', 'undo-theme' ), 'page_title' => __( 'Page titles', 'undo-theme' ),
        'post_title' => __( 'Post titles', 'undo-theme' ), 'widget_title' => __( 'Widget titles', 'undo-theme' ),
        'footer' => __( 'Footer text', 'undo-theme' ),
    );
}
function undo_typography_role_fields() {
    $fields = array();
    foreach ( undo_typography_roles() as $role => $label ) {
        $prefix = 'font_' . $role;
        $fields[ $prefix ] = array( __( 'Font family', 'undo-theme' ), 'font_choice', 'default' );
        $fields[ $prefix . '_size' ] = array( __( 'Font size in pixels (0 = theme default)', 'undo-theme' ), 'number', '0', array( 0, 160 ) );
        $fields[ $prefix . '_weight' ] = array( __( 'Font weight', 'undo-theme' ), 'select', 'default', array( 'default' => __( 'Theme default', 'undo-theme' ), '300' => '300', '400' => '400', '500' => '500', '600' => '600', '700' => '700', '800' => '800' ) );
        $fields[ $prefix . '_style' ] = array( __( 'Font style', 'undo-theme' ), 'select', 'default', array( 'default' => __( 'Theme default', 'undo-theme' ), 'normal' => __( 'Normal', 'undo-theme' ), 'italic' => __( 'Italic', 'undo-theme' ) ) );
        $fields[ $prefix . '_line_height' ] = array( __( 'Line height (0 = theme default)', 'undo-theme' ), 'decimal', '0', array( 0, 3 ) );
        $fields[ $prefix . '_word_spacing' ] = array( __( 'Word spacing in pixels (0 = theme default)', 'undo-theme' ), 'decimal_signed', '0', array( -5, 20 ) );
        $fields[ $prefix . '_letter_spacing' ] = array( __( 'Letter spacing in pixels (0 = theme default)', 'undo-theme' ), 'decimal_signed', '0', array( -5, 10 ) );
        $fields[ $prefix . '_color' ] = array( __( 'Text color (blank = theme default)', 'undo-theme' ), 'optional_color', '' );
    }
    return $fields;
}

function undo_home_sections() {
    return array(
        'overview' => __( 'Overview', 'undo-theme' ),
        'services' => __( 'Services', 'undo-theme' ),
        'approach' => __( 'Approach', 'undo-theme' ),
        'redesign' => __( 'Redesign', 'undo-theme' ),
    );
}

function undo_sanitize_home_section_order( $value ) {
    $allowed = array_keys( undo_home_sections() );
    $order = array();
    foreach ( explode( ',', (string) $value ) as $section ) {
        $section = trim( $section );
        if ( in_array( $section, $allowed, true ) && ! in_array( $section, $order, true ) ) { $order[] = $section; }
    }
    return implode( ',', array_merge( $order, array_diff( $allowed, $order ) ) );
}

function undo_home_section_order() {
    return explode( ',', undo_sanitize_home_section_order( undo_setting( 'home_section_order' ) ) );
}

function undo_home_visible_sections() {
    return array_values( array_filter( undo_home_section_order(), function ( $section ) { return undo_setting_enabled( 'home_show_' . $section ); } ) );
}

function undo_settings_sections() {
    static $sections = null;
    if ( null !== $sections ) { return $sections; }
    $sections = array(
        'layout' => array( __( 'Website layout', 'undo-theme' ), __( 'Set the site width and layout. The initial language follows WordPress Site Language.', 'undo-theme' ), array(
            'site_layout' => array( __( 'Site width', 'undo-theme' ), 'select', 'wide', array( 'wide' => __( 'Wide', 'undo-theme' ), 'boxed' => __( 'Boxed', 'undo-theme' ) ) ),
            'content_width' => array( __( 'Content width (pixels or percent)', 'undo-theme' ), 'site_dimension', '1440px' ),
        ) ),
        'colors' => array( __( 'Colors', 'undo-theme' ), __( 'Set shared colors and the built-in header, content, and footer surfaces.', 'undo-theme' ), array(
            'accent_color' => array( __( 'Accent color', 'undo-theme' ), 'color', '#b83b30' ),
            'paper_color' => array( __( 'Site background', 'undo-theme' ), 'color', '#f8f6f2' ),
            'surface_color' => array( __( 'Surface color', 'undo-theme' ), 'color', '#ffffff' ),
            'ink_color' => array( __( 'Primary text', 'undo-theme' ), 'color', '#242320' ),
            'muted_color' => array( __( 'Secondary text', 'undo-theme' ), 'color', '#5b5a57' ),
            'line_color' => array( __( 'Border color', 'undo-theme' ), 'color', '#dedbd5' ),
            'header_light_bg_color' => array( __( 'Light header background', 'undo-theme' ), 'color', '#f8f6f2' ),
            'header_light_text_color' => array( __( 'Light header text', 'undo-theme' ), 'color', '#20201e' ),
            'header_dark_bg_color' => array( __( 'Dark header background', 'undo-theme' ), 'color', '#20201e' ),
            'header_dark_text_color' => array( __( 'Dark header text', 'undo-theme' ), 'color', '#f8f6f2' ),
            'content_title_color' => array( __( 'Page and post titles', 'undo-theme' ), 'color', '#242320' ),
            'content_body_color' => array( __( 'Page and post body text', 'undo-theme' ), 'color', '#242320' ),
            'content_link_color' => array( __( 'Page and post links', 'undo-theme' ), 'color', '#242320' ),
            'footer_bg_color' => array( __( 'Footer background', 'undo-theme' ), 'color', '#1b1b1b' ),
            'footer_text_color' => array( __( 'Footer text', 'undo-theme' ), 'color', '#ffffff' ),
        ) ),
        'typography' => array( __( 'Typography', 'undo-theme' ), __( 'Set type for each role and choose whether Google Fonts may load.', 'undo-theme' ), array_merge( array(
            'google_fonts_enabled' => array( __( 'Load Google Fonts', 'undo-theme' ), 'checkbox', '1' ),
            'custom_fonts' => array( __( 'Custom font families', 'undo-theme' ), 'font_collection', array() ),
        ), undo_typography_role_fields() ) ),
        'header' => array( __( 'Header', 'undo-theme' ), __( 'Built-in header settings. Elementor Theme Builder can replace this template. With Polylang, the language switcher follows translated content URLs.', 'undo-theme' ), array(
            'header_logo_id' => array( __( 'Header logo', 'undo-theme' ), 'media', '0' ),
            'header_logo_light_id' => array( __( 'Light logo for dark header', 'undo-theme' ), 'media', '0' ),
            'header_logo_width' => array( __( 'Maximum logo width in pixels', 'undo-theme' ), 'number', '220', array( 60, 360 ) ),
            'header_style' => array( __( 'Header color style', 'undo-theme' ), 'select', 'light', array( 'light' => __( 'Light', 'undo-theme' ), 'dark' => __( 'Dark', 'undo-theme' ) ) ),
            'header_layout' => array( __( 'Header layout', 'undo-theme' ), 'select', 'standard', array( 'standard' => __( 'Standard', 'undo-theme' ), 'centered' => __( 'Centered navigation', 'undo-theme' ) ) ),
            'header_sticky' => array( __( 'Sticky header', 'undo-theme' ), 'checkbox', '1' ),
            'header_show_navigation' => array( __( 'Show main navigation', 'undo-theme' ), 'checkbox', '1' ),
            'header_show_search' => array( __( 'Show header search', 'undo-theme' ), 'checkbox', '0' ),
            'header_show_language' => array( __( 'Show language switcher', 'undo-theme' ), 'checkbox', '1' ),
            'header_show_action' => array( __( 'Show action button', 'undo-theme' ), 'checkbox', '1' ),
            'header_action_on_mobile' => array( __( 'Show action in mobile menu', 'undo-theme' ), 'checkbox', '1' ),
            'cta_label_fa' => array( __( 'Action label (Persian)', 'undo-theme' ), 'text', 'برنامه‌ریزی پروژه' ),
            'cta_label_en' => array( __( 'Action label (English)', 'undo-theme' ), 'text', 'Plan a project' ),
            'cta_url' => array( __( 'Action URL', 'undo-theme' ), 'url', '#project-planner' ),
        ) ),
        'single' => array( __( 'Single post', 'undo-theme' ), __( 'Post details in the built-in single template.', 'undo-theme' ), array(
            'single_show_featured' => array( __( 'Show featured image', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_excerpt' => array( __( 'Show manually written excerpt', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_date' => array( __( 'Show date', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_author' => array( __( 'Show author', 'undo-theme' ), 'checkbox', '0' ),
            'single_show_categories' => array( __( 'Show categories', 'undo-theme' ), 'checkbox', '0' ),
            'single_show_tags' => array( __( 'Show tags', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_navigation' => array( __( 'Show previous and next posts', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_related' => array( __( 'Show related posts', 'undo-theme' ), 'checkbox', '0' ),
            'single_related_count' => array( __( 'Related post count', 'undo-theme' ), 'number', '2', array( 2, 3 ), 'single_show_related' ),
            'single_show_comments' => array( __( 'Show comments', 'undo-theme' ), 'checkbox', '1' ),
            'single_show_sidebar' => array( __( 'Show post sidebar', 'undo-theme' ), 'checkbox', '0' ),
        ) ),
        'pages' => array( __( 'Pages', 'undo-theme' ), __( 'Set the default page layout, then adjust each UNDO template. Explicit page templates take priority.', 'undo-theme' ), array_merge( array(
            'page_show_title' => array( __( 'Show page title', 'undo-theme' ), 'checkbox', '1' ),
            'page_title_style' => array( __( 'Page title style', 'undo-theme' ), 'select', 'editorial', array( 'editorial' => __( 'Editorial', 'undo-theme' ), 'compact' => __( 'Compact', 'undo-theme' ) ), 'page_show_title' ),
            'page_show_breadcrumbs' => array( __( 'Show page breadcrumbs', 'undo-theme' ), 'checkbox', '0' ),
            'page_show_featured' => array( __( 'Show page featured image', 'undo-theme' ), 'checkbox', '0' ),
            'page_content_width' => array( __( 'Default page layout', 'undo-theme' ), 'select', 'reading', array( 'reading' => __( 'Reading', 'undo-theme' ), 'wide' => __( 'Wide', 'undo-theme' ), 'boxed' => __( 'Boxed', 'undo-theme' ), 'full' => __( 'Full width', 'undo-theme' ) ) ),
            'page_show_sidebar' => array( __( 'Show page sidebar', 'undo-theme' ), 'checkbox', '0' ),
        ), undo_page_template_fields() ) ),
        'sidebar' => array( __( 'Sidebar', 'undo-theme' ), __( 'The sidebar appears only where enabled and when widgets are assigned.', 'undo-theme' ), array(
            'sidebar_position' => array( __( 'Sidebar position', 'undo-theme' ), 'select', 'right', array( 'left' => __( 'Left', 'undo-theme' ), 'right' => __( 'Right', 'undo-theme' ), 'hidden' => __( 'Hidden', 'undo-theme' ) ) ),
            'sidebar_width' => array( __( 'Sidebar width in pixels', 'undo-theme' ), 'number', '300', array( 220, 420 ) ),
            'sidebar_widget_style' => array( __( 'Widget style', 'undo-theme' ), 'select', 'lined', array( 'lined' => __( 'Lined', 'undo-theme' ), 'panel' => __( 'Panel', 'undo-theme' ) ) ),
            'sidebar_widget_spacing' => array( __( 'Widget spacing in pixels', 'undo-theme' ), 'number', '32', array( 16, 64 ) ),
            'sidebar_sticky' => array( __( 'Keep sidebar visible while scrolling', 'undo-theme' ), 'checkbox', '0' ),
            'sidebar_sticky_offset' => array( __( 'Sticky sidebar top gap in pixels', 'undo-theme' ), 'number', '24', array( 0, 120 ), 'sidebar_sticky' ),
            'sidebar_on_archive' => array( __( 'Show on archives', 'undo-theme' ), 'checkbox', '0' ),
            'sidebar_on_search' => array( __( 'Show on search results', 'undo-theme' ), 'checkbox', '0' ),
        ) ),
        'blog' => array( __( 'Blog', 'undo-theme' ), __( 'Post cards in blog, archive, and search results.', 'undo-theme' ), array(
            'blog_page_id' => array( __( 'Posts page', 'undo-theme' ), 'page_choice', '0' ),
            'blog_style' => array( __( 'Blog design', 'undo-theme' ), 'select', 'editorial', array( 'editorial' => __( 'Editorial list', 'undo-theme' ), 'gallery' => __( 'Image grid', 'undo-theme' ), 'journal' => __( 'Journal grid', 'undo-theme' ) ) ),
            'blog_show_featured' => array( __( 'Show card images', 'undo-theme' ), 'checkbox', '1' ),
            'blog_show_date' => array( __( 'Show card dates', 'undo-theme' ), 'checkbox', '1' ),
            'blog_show_excerpt' => array( __( 'Show excerpts', 'undo-theme' ), 'checkbox', '1' ),
            'blog_columns' => array( __( 'Grid columns', 'undo-theme' ), 'select', '2', array( '1' => '1', '2' => '2', '3' => '3' ) ),
            'blog_excerpt_length' => array( __( 'Excerpt length in words', 'undo-theme' ), 'number', '30', array( 10, 80 ) ),
        ) ),
        'footer' => array( __( 'Footer', 'undo-theme' ), __( 'Build the footer with menus, contact details, social links, and legal copy. Elementor Theme Builder can replace it.', 'undo-theme' ), array(
            'footer_show_brand' => array( __( 'Show footer brand', 'undo-theme' ), 'checkbox', '1' ),
            'footer_show_widgets' => array( __( 'Show footer widget areas', 'undo-theme' ), 'checkbox', '1' ),
            'footer_show_navigation' => array( __( 'Show footer navigation', 'undo-theme' ), 'checkbox', '1' ),
            'footer_show_secondary_navigation' => array( __( 'Show second menu column', 'undo-theme' ), 'checkbox', '0' ),
            'footer_menu_title_fa' => array( __( 'Main menu heading (Persian)', 'undo-theme' ), 'text', 'کاوش', array(), 'footer_show_navigation' ),
            'footer_menu_title_en' => array( __( 'Main menu heading (English)', 'undo-theme' ), 'text', 'Explore', array(), 'footer_show_navigation' ),
            'footer_secondary_title_fa' => array( __( 'Second menu heading (Persian)', 'undo-theme' ), 'text', 'بیشتر', array(), 'footer_show_secondary_navigation' ),
            'footer_secondary_title_en' => array( __( 'Second menu heading (English)', 'undo-theme' ), 'text', 'More', array(), 'footer_show_secondary_navigation' ),
            'footer_show_action' => array( __( 'Show footer action', 'undo-theme' ), 'checkbox', '1' ),
            'footer_action_label_fa' => array( __( 'Footer action label (Persian)', 'undo-theme' ), 'text', 'برنامه‌ریزی پروژه', array(), 'footer_show_action' ),
            'footer_action_label_en' => array( __( 'Footer action label (English)', 'undo-theme' ), 'text', 'Plan a project', array(), 'footer_show_action' ),
            'footer_action_url' => array( __( 'Footer action URL', 'undo-theme' ), 'url', '#project-planner', array(), 'footer_show_action' ),
            'footer_show_contact' => array( __( 'Show contact details', 'undo-theme' ), 'checkbox', '1' ),
            'footer_contact_phone' => array( __( 'Contact phone', 'undo-theme' ), 'phone', '', array(), 'footer_show_contact' ),
            'footer_contact_address_fa' => array( __( 'Contact location (Persian)', 'undo-theme' ), 'text', '', array(), 'footer_show_contact' ),
            'footer_contact_address_en' => array( __( 'Contact location (English)', 'undo-theme' ), 'text', '', array(), 'footer_show_contact' ),
            'footer_show_social' => array( __( 'Show social links', 'undo-theme' ), 'checkbox', '0' ),
            'footer_social_instagram' => array( __( 'Instagram URL', 'undo-theme' ), 'external_url', '', array(), 'footer_show_social' ),
            'footer_social_linkedin' => array( __( 'LinkedIn URL', 'undo-theme' ), 'external_url', '', array(), 'footer_show_social' ),
            'footer_social_telegram' => array( __( 'Telegram URL', 'undo-theme' ), 'external_url', '', array(), 'footer_show_social' ),
            'footer_social_github' => array( __( 'GitHub URL', 'undo-theme' ), 'external_url', '', array(), 'footer_show_social' ),
            'footer_social_youtube' => array( __( 'YouTube URL', 'undo-theme' ), 'external_url', '', array(), 'footer_show_social' ),
            'footer_social_x' => array( __( 'X URL', 'undo-theme' ), 'external_url', '', array(), 'footer_show_social' ),
            'footer_show_copyright' => array( __( 'Show copyright', 'undo-theme' ), 'checkbox', '1' ),
            'footer_copyright_fa' => array( __( 'Copyright line (Persian)', 'undo-theme' ), 'text', '© {year} UNDO Web Developments', array(), 'footer_show_copyright' ),
            'footer_copyright_en' => array( __( 'Copyright line (English)', 'undo-theme' ), 'text', '© {year} UNDO Web Developments', array(), 'footer_show_copyright' ),
            'footer_show_legal' => array( __( 'Show legal links and note', 'undo-theme' ), 'checkbox', '1' ),
            'footer_legal_fa' => array( __( 'Legal note (Persian)', 'undo-theme' ), 'text', '', array(), 'footer_show_legal' ),
            'footer_legal_en' => array( __( 'Legal note (English)', 'undo-theme' ), 'text', '', array(), 'footer_show_legal' ),
            'footer_slogan_fa' => array( __( 'Footer slogan (Persian)', 'undo-theme' ), 'text', 'برای شما از نو می‌سازیم.' ),
            'footer_slogan_en' => array( __( 'Footer slogan (English)', 'undo-theme' ), 'text', 'WE REDO IT FOR YOU.' ),
            'contact_email' => array( __( 'Contact email', 'undo-theme' ), 'email', '' ),
        ) ),
        'homepage' => array( __( 'Homepage', 'undo-theme' ), __( 'Built-in landing page copy. Elementor pages use their own content.', 'undo-theme' ), array(
            'hero_title_fa' => array( __( 'Hero title (Persian)', 'undo-theme' ), 'text', 'وب‌سایت‌ها، افزونه‌ها و اپ‌ها؛ بهتر از قبل.' ),
            'hero_lead_fa' => array( __( 'Hero description (Persian)', 'undo-theme' ), 'textarea', 'UNDO وب‌سایت، افزونه و اپلیکیشن می‌سازد و محصولات قدیمی را بازطراحی می‌کند؛ از ایده تا کد نهایی.' ),
            'hero_title_en' => array( __( 'Hero title (English)', 'undo-theme' ), 'text', 'Websites, plugins & apps made better.' ),
            'hero_lead_en' => array( __( 'Hero description (English)', 'undo-theme' ), 'textarea', 'UNDO creates new digital products and redesigns the ones that no longer serve your business. From the first screen to the working code.' ),
            'show_section_rail' => array( __( 'Show section navigation', 'undo-theme' ), 'checkbox', '1' ),
            'home_section_order' => array( __( 'Section order', 'undo-theme' ), 'section_order', 'overview,services,approach,redesign' ),
            'home_show_overview' => array( __( 'Show Overview', 'undo-theme' ), 'checkbox', '1' ),
            'home_show_services' => array( __( 'Show Services', 'undo-theme' ), 'checkbox', '1' ),
            'home_show_approach' => array( __( 'Show Approach', 'undo-theme' ), 'checkbox', '1' ),
            'home_show_redesign' => array( __( 'Show Redesign', 'undo-theme' ), 'checkbox', '1' ),
            'home_overview_page_fa' => array( __( 'Overview page (Persian)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_overview_page_en' => array( __( 'Overview page (English)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_service_web_page_fa' => array( __( 'Websites page (Persian)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_service_web_page_en' => array( __( 'Websites page (English)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_service_plugin_page_fa' => array( __( 'WordPress plugins page (Persian)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_service_plugin_page_en' => array( __( 'WordPress plugins page (English)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_service_app_page_fa' => array( __( 'Mobile apps page (Persian)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_service_app_page_en' => array( __( 'Mobile apps page (English)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_approach_page_fa' => array( __( 'Approach page (Persian)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_approach_page_en' => array( __( 'Approach page (English)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_redesign_page_fa' => array( __( 'Redesign page (Persian)', 'undo-theme' ), 'home_page_choice', '0' ),
            'home_redesign_page_en' => array( __( 'Redesign page (English)', 'undo-theme' ), 'home_page_choice', '0' ),
        ) ),
    );
    return $sections;
}
function undo_setting_defaults() {
    $defaults = array();
    foreach ( undo_settings_sections() as $section ) {
        foreach ( $section[2] as $key => $field ) { $defaults[ $key ] = $field[2]; }
    }
    return $defaults;
}
function undo_setting( $key ) {
    if ( 'blog_page_id' === $key ) { return (string) absint( get_option( 'page_for_posts', 0 ) ); }
    $saved = get_option( 'undo_theme_settings', array() );
    $defaults = undo_setting_defaults();
    $value = isset( $saved[ $key ] ) ? $saved[ $key ] : ( isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
    return is_scalar( $value ) ? (string) $value : '';
}
function undo_setting_enabled( $key ) { return '1' === undo_setting( $key ); }
function undo_sidebar_position() {
    $position = undo_setting( 'sidebar_position' );
    if ( in_array( $position, array( 'left', 'right', 'hidden' ), true ) ) { return $position; }
    $rtl = function_exists( 'is_rtl' ) && is_rtl();
    if ( 'start' === $position ) { return $rtl ? 'right' : 'left'; }
    return $rtl ? 'left' : 'right';
}
function undo_custom_fonts() {
    $saved = get_option( 'undo_theme_settings', array() );
    return isset( $saved['custom_fonts'] ) && is_array( $saved['custom_fonts'] ) ? $saved['custom_fonts'] : array();
}
function undo_font_attachment_is_valid( $attachment_id ) {
    if ( $attachment_id <= 0 || ! function_exists( 'get_post_mime_type' ) || ! function_exists( 'get_attached_file' ) ) { return false; }
    $mime = get_post_mime_type( $attachment_id );
    $file = get_attached_file( $attachment_id );
    return in_array( $mime, array( 'font/woff2', 'application/font-woff2' ), true ) && is_string( $file ) && 'woff2' === strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );
}
function undo_sanitize_custom_fonts( $fonts ) {
    if ( ! is_array( $fonts ) ) { return array(); }
    $clean = array();
    foreach ( array_slice( $fonts, 0, 12 ) as $font ) {
        if ( ! is_array( $font ) ) { continue; }
        $id = isset( $font['id'] ) && is_scalar( $font['id'] ) ? sanitize_key( $font['id'] ) : '';
        $name = isset( $font['name'] ) && is_scalar( $font['name'] ) ? trim( sanitize_text_field( wp_unslash( (string) $font['name'] ) ) ) : '';
        $regular = isset( $font['regular_id'] ) && is_scalar( $font['regular_id'] ) && ctype_digit( (string) $font['regular_id'] ) ? (int) $font['regular_id'] : 0;
        $bold = isset( $font['bold_id'] ) && is_scalar( $font['bold_id'] ) && ctype_digit( (string) $font['bold_id'] ) ? (int) $font['bold_id'] : 0;
        if ( ! preg_match( '/^custom-[1-9][0-9]{0,2}$/', $id ) || '' === $name || strlen( $name ) > 240 || isset( $clean[ $id ] ) || ! undo_font_attachment_is_valid( $regular ) ) { continue; }
        $clean[ $id ] = array( 'id' => $id, 'name' => $name, 'regular_id' => $regular, 'bold_id' => undo_font_attachment_is_valid( $bold ) ? $bold : 0 );
    }
    return array_values( $clean );
}
function undo_font_choices( $custom_fonts = null ) {
    $choices = array(
        'default' => __( 'Theme default', 'undo-theme' ),
        'dm-sans' => 'DM Sans',
        'space-grotesk' => 'Space Grotesk',
        'vazirmatn' => 'Vazirmatn',
        'instrument-serif' => 'Instrument Serif',
        'inter' => 'Inter',
        'manrope' => 'Manrope',
        'playfair-display' => 'Playfair Display',
        'noto-sans-arabic' => 'Noto Sans Arabic',
        'system-sans' => __( 'System sans-serif', 'undo-theme' ),
        'georgia' => 'Georgia',
    );
    foreach ( null === $custom_fonts ? undo_custom_fonts() : $custom_fonts as $font ) {
        if ( isset( $font['id'], $font['name'] ) ) { $choices[ $font['id'] ] = $font['name']; }
    }
    return $choices;
}
function undo_original_font_label( $key ) {
    if ( in_array( $key, array( 'font_headings', 'font_page_title', 'font_post_title', 'font_widget_title' ), true ) ) { return __( 'Original: Space Grotesk / Vazirmatn', 'undo-theme' ); }
    if ( 'font_accent' === $key ) { return __( 'Original: Instrument Serif / Vazirmatn', 'undo-theme' ); }
    return __( 'Original: DM Sans / Vazirmatn', 'undo-theme' );
}
function undo_allow_font_uploads( $mimes ) {
    if ( current_user_can( 'manage_options' ) ) { $mimes['woff2'] = PHP_VERSION_ID >= 80112 ? 'font/woff2' : 'application/font-woff2'; }
    return $mimes;
}
add_filter( 'upload_mimes', 'undo_allow_font_uploads' );
function undo_sanitize_page_dimension( $value, $fallback = '1200px' ) {
    $value = trim( (string) $value );
    if ( ! preg_match( '/^([0-9]{1,4})(px|%)$/', $value, $match ) ) { return $fallback; }
    $number = (int) $match[1];
    if ( 'px' === $match[2] && $number >= 320 && $number <= 1920 ) { return $number . 'px'; }
    if ( '%' === $match[2] && $number >= 20 && $number <= 100 ) { return $number . '%'; }
    return $fallback;
}
function undo_sanitize_site_dimension( $value ) {
    $value = trim( (string) $value );
    if ( preg_match( '/^[0-9]{3,4}$/', $value ) ) { $value .= 'px'; }
    return undo_sanitize_page_dimension( $value, '1440px' );
}
function undo_sanitize_phone( $value ) {
    $value = strtr( (string) $value, array( '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9' ) );
    return substr( preg_replace( '/[^0-9+() .\-]/', '', $value ), 0, 64 );
}
function undo_sanitize_settings( $input ) {
    $input = is_array( $input ) ? $input : array();
    $previous = get_option( 'undo_theme_settings', array() );
    $clean = array_merge( undo_setting_defaults(), is_array( $previous ) ? $previous : array() );
    foreach ( undo_settings_sections() as $section ) {
        foreach ( $section[2] as $key => $field ) {
            if ( 'font_collection' === $field[1] ) {
                if ( isset( $input['custom_fonts_present'] ) ) { $clean[ $key ] = undo_sanitize_custom_fonts( isset( $input[ $key ] ) ? $input[ $key ] : array() ); }
                continue;
            }
            if ( ! array_key_exists( $key, $input ) ) { continue; }
            $value = is_scalar( $input[ $key ] ) ? wp_unslash( (string) $input[ $key ] ) : '';
            switch ( $field[1] ) {
                case 'checkbox': $clean[ $key ] = '1' === $value ? '1' : '0'; break;
                case 'color': $clean[ $key ] = sanitize_hex_color( $value ) ?: $field[2]; break;
                case 'optional_color': $clean[ $key ] = '' === trim( $value ) ? '' : ( sanitize_hex_color( $value ) ?: '' ); break;
                case 'select': $clean[ $key ] = isset( $field[3][ $value ] ) ? $value : $field[2]; break;
                case 'number':
                    $number = max( $field[3][0], min( $field[3][1], (int) $value ) );
                    if ( 0 === strpos( $key, 'font_' ) && '_size' === substr( $key, -5 ) && $number > 0 ) { $number = max( 10, $number ); }
                    $clean[ $key ] = (string) $number;
                    break;
                case 'dimension': $clean[ $key ] = undo_sanitize_page_dimension( $value, $field[2] ); break;
                case 'site_dimension': $clean[ $key ] = undo_sanitize_site_dimension( $value ); break;
                case 'decimal':
                case 'decimal_signed':
                    $decimal = is_numeric( $value ) ? max( $field[3][0], min( $field[3][1], (float) $value ) ) : (float) $field[2];
                    if ( 'decimal' === $field[1] && $decimal > 0 ) { $decimal = max( .8, $decimal ); }
                    $clean[ $key ] = (string) round( $decimal, 2 );
                    break;
                case 'font_choice':
                    $choices = undo_font_choices( isset( $clean['custom_fonts'] ) ? $clean['custom_fonts'] : array() );
                    $clean[ $key ] = isset( $choices[ $value ] ) ? $value : 'default';
                    break;
                case 'page_choice':
                    $id = absint( $value );
                    $front_id = absint( get_option( 'page_on_front', 0 ) );
                    $clean[ $key ] = (string) ( $id && 'page' === get_post_type( $id ) && 'publish' === get_post_status( $id ) && $id !== $front_id ? $id : 0 );
                    break;
                case 'home_page_choice':
                    $id = absint( $value );
                    $front_id = absint( get_option( 'page_on_front', 0 ) );
                    $clean[ $key ] = (string) ( $id && 'page' === get_post_type( $id ) && 'publish' === get_post_status( $id ) && $id !== $front_id ? $id : 0 );
                    break;
                case 'section_order': $clean[ $key ] = undo_sanitize_home_section_order( $value ); break;
                case 'media': $clean[ $key ] = ctype_digit( $value ) && wp_attachment_is_image( (int) $value ) ? $value : '0'; break;
                case 'textarea': $clean[ $key ] = sanitize_textarea_field( $value ); break;
                case 'url': $clean[ $key ] = 0 === strpos( $value, '#' ) ? sanitize_text_field( $value ) : esc_url_raw( $value ); break;
                case 'email': $clean[ $key ] = sanitize_email( $value ); break;
                case 'phone': $clean[ $key ] = undo_sanitize_phone( $value ); break;
                case 'external_url':
                    $url = esc_url_raw( $value, array( 'http', 'https' ) );
                    $clean[ $key ] = in_array( wp_parse_url( $url, PHP_URL_SCHEME ), array( 'http', 'https' ), true ) ? $url : '';
                    break;
                default: $clean[ $key ] = sanitize_text_field( $value );
            }
        }
    }
    if ( array_key_exists( 'blog_page_id', $input ) && current_user_can( 'manage_options' ) ) {
        update_option( 'page_for_posts', (int) $clean['blog_page_id'] );
    }
    return array_intersect_key( $clean, undo_setting_defaults() );
}
function undo_register_settings() {
    register_setting( 'undo_theme_settings', 'undo_theme_settings', array( 'type' => 'array', 'sanitize_callback' => 'undo_sanitize_settings', 'default' => undo_setting_defaults() ) );
}
add_action( 'admin_init', 'undo_register_settings' );
function undo_add_settings_page() {
    add_menu_page( __( 'UNDO Theme Settings', 'undo-theme' ), __( 'UNDO Theme Settings', 'undo-theme' ), 'manage_options', 'undo-theme-settings', 'undo_render_settings_page', 'dashicons-admin-appearance', 61 );
}
add_action( 'admin_menu', 'undo_add_settings_page' );
function undo_settings_assets( $hook ) {
    if ( 'toplevel_page_undo-theme-settings' !== $hook ) { return; }
    wp_enqueue_media();
    wp_enqueue_style( 'undo-admin-settings', get_theme_file_uri( '/assets/css/admin-settings.css' ), array(), UNDO_THEME_VERSION );
    wp_enqueue_script( 'undo-settings-media', get_theme_file_uri( '/assets/js/admin-settings.js' ), array( 'media-views' ), UNDO_THEME_VERSION, true );
    wp_localize_script( 'undo-settings-media', 'undoSettingsMedia', array(
        'title' => __( 'Select header logo', 'undo-theme' ),
        'use' => __( 'Use this image', 'undo-theme' ),
        'fontTitle' => __( 'Choose a WOFF2 font file', 'undo-theme' ),
        'fontUse' => __( 'Use this font', 'undo-theme' ),
        'fontInvalid' => __( 'Choose a valid WOFF2 file from the Media Library.', 'undo-theme' ),
        'fontNone' => __( 'No file selected', 'undo-theme' ),
        'fontLimit' => __( 'You can add up to 12 font families.', 'undo-theme' ),
        'unsaved' => __( 'Unsaved changes', 'undo-theme' ),
    ) );
}
add_action( 'admin_enqueue_scripts', 'undo_settings_assets' );
function undo_settings_field( $key, $field, $control_only = false ) {
    $value = undo_setting( $key );
    if ( 'sidebar_position' === $key ) { $value = undo_sidebar_position(); }
    if ( 'content_width' === $key ) { $value = undo_sanitize_site_dimension( $value ); }
    $depends = isset( $field[4] ) && is_string( $field[4] ) ? ' data-undo-depends="' . esc_attr( $field[4] ) . '"' : '';
    if ( ! $control_only ) { echo '<tr' . $depends . '><th scope="row"><label for="undo-' . esc_attr( $key ) . '">' . esc_html( $field[0] ) . '</label></th><td>'; }
    $name = 'undo_theme_settings[' . esc_attr( $key ) . ']';
    if ( 'media' === $field[1] ) {
        $image = $value ? wp_get_attachment_image( (int) $value, 'medium', false, array( 'style' => 'max-width:220px;max-height:80px;width:auto;height:auto;' ) ) : '';
        echo '<div class="undo-media-field"><input type="hidden" class="undo-media-id" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '"><div class="undo-media-preview">' . wp_kses_post( $image ) . '</div><button type="button" class="button undo-media-select">' . esc_html__( 'Select image', 'undo-theme' ) . '</button> <button type="button" class="button undo-media-remove">' . esc_html__( 'Remove image', 'undo-theme' ) . '</button></div>';
    } elseif ( 'font_collection' === $field[1] ) {
        undo_render_font_collection();
    } elseif ( 'font_choice' === $field[1] ) {
        echo '<select class="undo-font-choice" data-undo-font-choice id="undo-' . esc_attr( $key ) . '" name="' . $name . '">';
        $choices = undo_font_choices();
        echo '<option value="default"' . selected( $value, 'default', false ) . '>' . esc_html( undo_original_font_label( $key ) ) . '</option><optgroup label="' . esc_attr__( 'Google Fonts', 'undo-theme' ) . '">';
        foreach ( array( 'dm-sans', 'space-grotesk', 'vazirmatn', 'instrument-serif', 'inter', 'manrope', 'playfair-display', 'noto-sans-arabic' ) as $option ) { echo '<option value="' . esc_attr( $option ) . '"' . selected( $value, $option, false ) . '>' . esc_html( $choices[ $option ] ) . '</option>'; }
        echo '</optgroup><optgroup label="' . esc_attr__( 'Local and system fonts', 'undo-theme' ) . '">';
        foreach ( array( 'system-sans', 'georgia' ) as $option ) { echo '<option value="' . esc_attr( $option ) . '"' . selected( $value, $option, false ) . '>' . esc_html( $choices[ $option ] ) . '</option>'; }
        echo '</optgroup><optgroup data-undo-custom-group label="' . esc_attr__( 'Uploaded fonts', 'undo-theme' ) . '">';
        foreach ( undo_custom_fonts() as $font ) { if ( isset( $font['id'], $font['name'] ) ) { echo '<option data-undo-custom-font value="' . esc_attr( $font['id'] ) . '"' . selected( $value, $font['id'], false ) . '>' . esc_html( $font['name'] ) . '</option>'; } }
        echo '</optgroup>';
        echo '</select>';
    } elseif ( 'external_url' === $field[1] || 'phone' === $field[1] ) {
        echo '<input type="' . ( 'external_url' === $field[1] ? 'url' : 'tel' ) . '" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '" class="regular-text" dir="auto">';
    } elseif ( 'page_choice' === $field[1] ) {
        echo '<select id="undo-' . esc_attr( $key ) . '" name="' . $name . '"><option value="0"' . selected( $value, '0', false ) . '>' . esc_html__( 'No dedicated posts page', 'undo-theme' ) . '</option>';
        $front_id = absint( get_option( 'page_on_front', 0 ) );
        foreach ( get_pages( array( 'post_status' => 'publish', 'sort_column' => 'post_title' ) ) as $page ) {
            if ( (int) $page->ID === $front_id ) { continue; }
            echo '<option value="' . esc_attr( $page->ID ) . '"' . selected( $value, (string) $page->ID, false ) . '>' . esc_html( get_the_title( $page ) ) . '</option>';
        }
        echo '</select><p class="description">' . esc_html__( 'Uses the WordPress posts page. Select a static homepage in Settings → Reading to show posts on this page.', 'undo-theme' ) . '</p>';
    } elseif ( 'home_page_choice' === $field[1] ) {
        echo '<select id="undo-' . esc_attr( $key ) . '" name="' . $name . '"><option value="0"' . selected( $value, '0', false ) . '>' . esc_html__( 'Use built-in copy', 'undo-theme' ) . '</option>';
        $front_id = absint( get_option( 'page_on_front', 0 ) );
        foreach ( get_pages( array( 'post_status' => 'publish', 'sort_column' => 'post_title' ) ) as $page ) {
            if ( (int) $page->ID === $front_id ) { continue; }
            echo '<option value="' . esc_attr( $page->ID ) . '"' . selected( $value, (string) $page->ID, false ) . '>' . esc_html( get_the_title( $page ) ) . '</option>';
        }
        echo '</select>';
    } elseif ( 'textarea' === $field[1] ) {
        echo '<textarea id="undo-' . esc_attr( $key ) . '" name="' . $name . '" rows="3" class="large-text" dir="auto">' . esc_textarea( $value ) . '</textarea>';
    } elseif ( 'select' === $field[1] ) {
        echo '<select id="undo-' . esc_attr( $key ) . '" name="' . $name . '">';
        foreach ( $field[3] as $option => $label ) { echo '<option value="' . esc_attr( $option ) . '"' . selected( $value, (string) $option, false ) . '>' . esc_html( $label ) . '</option>'; }
        echo '</select>';
    } elseif ( 'checkbox' === $field[1] ) {
        echo '<input type="hidden" name="' . $name . '" value="0"><input type="checkbox" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="1"' . checked( $value, '1', false ) . '>';
    } elseif ( 'site_dimension' === $field[1] ) {
        echo '<input type="text" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '" class="regular-text" dir="ltr" pattern="([0-9]{3,4}px|[0-9]{1,3}%)"><p class="description">' . esc_html__( 'Use 320–1920px or 20–100%, for example 1440px or 80%.', 'undo-theme' ) . '</p>';
    } elseif ( 'optional_color' === $field[1] ) {
        echo '<div class="undo-optional-color"><input type="color" data-undo-color-picker value="' . esc_attr( $value ?: '#242320' ) . '" aria-label="' . esc_attr( $field[0] ) . '"><input type="text" data-undo-color-text id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '" class="regular-text" placeholder="#242320" pattern="(#[0-9a-fA-F]{6})?" dir="ltr"><button type="button" class="button-link" data-undo-color-clear>' . esc_html__( 'Use theme color', 'undo-theme' ) . '</button></div><p class="description">' . esc_html__( 'Leave blank to inherit the theme color.', 'undo-theme' ) . '</p>';
    } elseif ( 'decimal' === $field[1] || 'decimal_signed' === $field[1] ) {
        echo '<input type="number" step="0.01" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '" min="' . esc_attr( $field[3][0] ) . '" max="' . esc_attr( $field[3][1] ) . '" class="small-text" dir="ltr">';
    } elseif ( 'dimension' === $field[1] ) {
        echo '<input type="text" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '" class="regular-text" dir="ltr" pattern="([0-9]{3,4}px|[0-9]{1,3}%)"><p class="description">' . esc_html__( 'Use 320–1920px or 20–100%, for example 1200px or 80%.', 'undo-theme' ) . '</p>';
    } else {
        $extra = 'number' === $field[1] ? ' min="' . esc_attr( $field[3][0] ) . '" max="' . esc_attr( $field[3][1] ) . '"' : '';
        echo '<input type="' . esc_attr( $field[1] ) . '" id="undo-' . esc_attr( $key ) . '" name="' . $name . '" value="' . esc_attr( $value ) . '" class="regular-text" dir="auto"' . $extra . '>';
    }
    if ( ! $control_only ) { echo '</td></tr>'; }
}
function undo_render_font_row( $index, $font ) {
    $id = isset( $font['id'] ) ? $font['id'] : '';
    $name = isset( $font['name'] ) ? $font['name'] : '';
    $base = 'undo_theme_settings[custom_fonts][' . $index . ']';
    echo '<div class="undo-font-row" data-undo-font-row><input type="hidden" data-undo-font-id name="' . esc_attr( $base . '[id]' ) . '" value="' . esc_attr( $id ) . '">';
    echo '<label class="undo-font-row__name">' . esc_html__( 'Family name', 'undo-theme' ) . '<input type="text" data-undo-font-name name="' . esc_attr( $base . '[name]' ) . '" value="' . esc_attr( $name ) . '" maxlength="80" required></label>';
    foreach ( array( 'regular' => __( 'Regular WOFF2', 'undo-theme' ), 'bold' => __( 'Bold WOFF2 (optional)', 'undo-theme' ) ) as $weight => $label ) {
        $attachment_id = isset( $font[ $weight . '_id' ] ) ? (int) $font[ $weight . '_id' ] : 0;
        $attachment_url = $attachment_id && function_exists( 'wp_get_attachment_url' ) ? wp_get_attachment_url( $attachment_id ) : '';
        $filename = $attachment_url ? wp_basename( $attachment_url ) : __( 'No file selected', 'undo-theme' );
        echo '<div class="undo-font-row__file"><span class="undo-font-row__label">' . esc_html( $label ) . '</span><input type="hidden" data-undo-font-file="' . esc_attr( $weight ) . '" name="' . esc_attr( $base . '[' . $weight . '_id]' ) . '" value="' . esc_attr( $attachment_id ) . '"><span class="undo-font-row__filename" data-undo-font-filename="' . esc_attr( $weight ) . '">' . esc_html( $filename ) . '</span><button type="button" class="button" data-undo-font-upload="' . esc_attr( $weight ) . '">' . esc_html__( 'Choose WOFF2', 'undo-theme' ) . '</button><button type="button" class="button-link" data-undo-font-clear="' . esc_attr( $weight ) . '">' . esc_html__( 'Clear', 'undo-theme' ) . '</button></div>';
    }
    echo '<button type="button" class="button-link-delete undo-font-row__remove" data-undo-font-remove>' . esc_html__( 'Remove family', 'undo-theme' ) . '</button></div>';
}
function undo_render_font_collection() {
    echo '<div class="undo-fonts"><input type="hidden" name="undo_theme_settings[custom_fonts_present]" value="1"><p class="description">' . esc_html__( 'Upload WOFF2 files to the WordPress Media Library. Add a regular file for each family; a bold file is optional. Uploaded files stay in Media Library during theme updates.', 'undo-theme' ) . '</p><div class="undo-fonts__list" data-undo-font-list>';
    foreach ( undo_custom_fonts() as $index => $font ) { undo_render_font_row( $index, $font ); }
    echo '</div><button type="button" class="button button-secondary" data-undo-font-add>' . esc_html__( 'Add font family', 'undo-theme' ) . '</button><p class="description">' . esc_html__( 'Up to 12 families. Choose a font below after naming it and selecting its regular file.', 'undo-theme' ) . '</p><template id="undo-font-row-template">';
    undo_render_font_row( '__INDEX__', array( 'id' => '__ID__', 'name' => '', 'regular_id' => 0, 'bold_id' => 0 ) );
    echo '</template></div>';
}
function undo_render_settings_group( $title, $fields ) {
    echo '<section class="undo-settings__group"><h3>' . esc_html( $title ) . '</h3><table class="form-table" role="presentation">';
    foreach ( $fields as $key => $field ) { undo_settings_field( $key, $field ); }
    echo '</table></section>';
}

function undo_render_home_sections() {
    $sections = undo_home_sections();
    echo '<section class="undo-settings__group"><h3>' . esc_html__( 'Homepage sections', 'undo-theme' ) . '</h3>';
    echo '<p class="undo-settings__hint">' . esc_html__( 'The hero stays first and the project planner stays last so project links keep working. Move the other sections and hide any you do not need.', 'undo-theme' ) . '</p>';
    echo '<input type="hidden" id="undo-home_section_order" name="undo_theme_settings[home_section_order]" value="' . esc_attr( implode( ',', undo_home_section_order() ) ) . '" data-undo-home-order-value>';
    echo '<ol class="undo-home-order" data-undo-home-order>';
    foreach ( undo_home_section_order() as $slug ) {
        $label = $sections[ $slug ];
        $key = 'home_show_' . $slug;
        echo '<li class="undo-home-order__item" data-undo-home-section="' . esc_attr( $slug ) . '"><span class="undo-home-order__name">' . esc_html( $label ) . '</span>';
        echo '<label class="undo-home-order__toggle"><input type="hidden" name="undo_theme_settings[' . esc_attr( $key ) . ']" value="0"><input type="checkbox" id="undo-' . esc_attr( $key ) . '" name="undo_theme_settings[' . esc_attr( $key ) . ']" value="1"' . checked( undo_setting( $key ), '1', false ) . '><span>' . esc_html__( 'Show', 'undo-theme' ) . '</span></label>';
        echo '<span class="undo-home-order__actions"><button type="button" class="button" data-undo-home-move="up" aria-label="' . esc_attr( sprintf( __( 'Move %s up', 'undo-theme' ), $label ) ) . '">' . esc_html__( 'Up', 'undo-theme' ) . '</button><button type="button" class="button" data-undo-home-move="down" aria-label="' . esc_attr( sprintf( __( 'Move %s down', 'undo-theme' ), $label ) ) . '">' . esc_html__( 'Down', 'undo-theme' ) . '</button></span></li>';
    }
    echo '</ol></section>';
}
function undo_render_typography_row( $role, $title, $fields ) {
    echo '<tr><th scope="row">' . esc_html( $title ) . '</th>';
    foreach ( array( '', '_size', '_weight', '_style', '_line_height', '_word_spacing', '_color' ) as $suffix ) {
        $key = 'font_' . $role . $suffix;
        $field = $fields[ $key ];
        echo '<td><label class="screen-reader-text" for="undo-' . esc_attr( $key ) . '">' . esc_html( $title . ': ' . $field[0] ) . '</label>';
        if ( '_word_spacing' === $suffix ) { echo '<div class="undo-typography-spacing"><span>' . esc_html__( 'Word', 'undo-theme' ) . '</span>'; }
        undo_settings_field( $key, $field, true );
        if ( '_word_spacing' === $suffix ) {
            $letter_key = 'font_' . $role . '_letter_spacing';
            echo '<label class="screen-reader-text" for="undo-' . esc_attr( $letter_key ) . '">' . esc_html( $title . ': ' . $fields[ $letter_key ][0] ) . '</label><span>' . esc_html__( 'Letter', 'undo-theme' ) . '</span>';
            undo_settings_field( $letter_key, $fields[ $letter_key ], true );
            echo '</div>';
        }
        echo '</td>';
    }
    echo '</tr>';
}
function undo_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) { return; }
    $sections = undo_settings_sections();
    $requested = isset( $_GET['tab'] ) && is_string( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'layout';
    $active = isset( $sections[ $requested ] ) ? $requested : 'layout';
    echo '<div class="wrap undo-settings"><header class="undo-settings__header"><span class="undo-settings__brand">UNDO</span><h1>' . esc_html__( 'UNDO Theme Settings', 'undo-theme' ) . '</h1></header><form action="options.php" method="post" class="undo-settings__form">';
    settings_fields( 'undo_theme_settings' );
    echo '<div class="undo-settings__layout"><nav class="undo-settings__nav" role="tablist" aria-orientation="vertical" aria-label="' . esc_attr__( 'Theme settings sections', 'undo-theme' ) . '">';
    foreach ( $sections as $slug => $section ) {
        $url = add_query_arg( array( 'page' => 'undo-theme-settings', 'tab' => $slug ), admin_url( 'admin.php' ) );
        echo '<a id="undo-tab-' . esc_attr( $slug ) . '" class="undo-settings__nav-link' . ( $active === $slug ? ' is-active' : '' ) . '" data-undo-tab="' . esc_attr( $slug ) . '" role="tab" aria-controls="undo-panel-' . esc_attr( $slug ) . '" aria-selected="' . ( $active === $slug ? 'true' : 'false' ) . '" href="' . esc_url( $url ) . '">' . esc_html( $section[0] ) . '</a>';
    }
    echo '</nav><main class="undo-settings__content">';
    foreach ( $sections as $slug => $section ) {
        echo '<section id="undo-panel-' . esc_attr( $slug ) . '" class="undo-settings__panel" data-undo-panel="' . esc_attr( $slug ) . '" role="tabpanel" aria-labelledby="undo-tab-' . esc_attr( $slug ) . '"' . ( $active === $slug ? '' : ' hidden' ) . '><div class="undo-settings__intro"><h2>' . esc_html( $section[0] ) . '</h2><p>' . esc_html( $section[1] ) . '</p></div>';
        if ( 'pages' === $slug ) {
            $template_fields = undo_page_template_fields();
            undo_render_settings_group( __( 'Page display', 'undo-theme' ), array_diff_key( $section[2], $template_fields ) );
            echo '<p class="undo-settings__hint">' . esc_html__( 'The UNDO Custom Width template uses a width set on each page below the editor.', 'undo-theme' ) . '</p>';
            echo '<p class="undo-settings__hint">' . esc_html__( 'Elementor pages using a UNDO page template follow the widths and spacing below. Elementor Full Width and Canvas use Elementor layouts instead; Canvas also omits the theme header and footer.', 'undo-theme' ) . '</p>';
            foreach ( undo_page_template_presets() as $mode => $preset ) {
                $fields = array();
                foreach ( $template_fields as $key => $field ) { if ( 0 === strpos( $key, 'page_' . $mode . '_' ) ) { $fields[ $key ] = $field; } }
                undo_render_settings_group( $preset['title'], $fields );
            }
            echo '<p class="undo-settings__hint">' . esc_html__( 'On screens under 760px, side margins and padding are capped at 20px; top and bottom padding are capped at 58px and 90px.', 'undo-theme' ) . '</p>';
        } elseif ( 'colors' === $slug ) {
            undo_render_settings_group( __( 'Shared palette', 'undo-theme' ), array_slice( $section[2], 0, 6, true ) );
            undo_render_settings_group( __( 'Header colors', 'undo-theme' ), array_slice( $section[2], 6, 4, true ) );
            undo_render_settings_group( __( 'Content colors', 'undo-theme' ), array_slice( $section[2], 10, 3, true ) );
            undo_render_settings_group( __( 'Footer colors', 'undo-theme' ), array_slice( $section[2], 13, 2, true ) );
        } elseif ( 'typography' === $slug ) {
            undo_render_settings_group( __( 'Font sources', 'undo-theme' ), array_slice( $section[2], 0, 2, true ) );
            echo '<p class="undo-settings__hint">' . esc_html__( 'Google families use system fallbacks when Google Fonts loading is off. Uploaded WOFF2 families remain available.', 'undo-theme' ) . '</p>';
            echo '<p class="undo-settings__hint">' . esc_html__( 'Original font choices follow the site language: DM Sans body, Space Grotesk headings, and Instrument Serif accents in English; Vazirmatn in Persian.', 'undo-theme' ) . '</p>';
            echo '<div class="undo-typography-scroll"><table class="undo-typography-table"><thead><tr><th scope="col">' . esc_html__( 'Text role', 'undo-theme' ) . '</th><th scope="col">' . esc_html__( 'Font family', 'undo-theme' ) . '</th><th scope="col">' . esc_html__( 'Size (px)', 'undo-theme' ) . '</th><th scope="col">' . esc_html__( 'Weight', 'undo-theme' ) . '</th><th scope="col">' . esc_html__( 'Style', 'undo-theme' ) . '</th><th scope="col">' . esc_html__( 'Line height', 'undo-theme' ) . '</th><th scope="col">' . esc_html__( 'Spacing (px)', 'undo-theme' ) . '</th><th scope="col">' . esc_html__( 'Color', 'undo-theme' ) . '</th></tr></thead><tbody>';
            foreach ( undo_typography_roles() as $role => $label ) {
                $fields = array();
                foreach ( $section[2] as $key => $field ) { if ( $key === 'font_' . $role || 0 === strpos( $key, 'font_' . $role . '_' ) ) { $fields[ $key ] = $field; } }
                undo_render_typography_row( $role, $label, $fields );
            }
            echo '</tbody></table></div>';
        } elseif ( 'footer' === $slug ) {
            $footer_groups = array(
                __( 'Statement and action', 'undo-theme' ) => array( 'footer_show_brand', 'footer_slogan_fa', 'footer_slogan_en', 'footer_show_action', 'footer_action_label_fa', 'footer_action_label_en', 'footer_action_url' ),
                __( 'Menu columns', 'undo-theme' ) => array( 'footer_show_navigation', 'footer_menu_title_fa', 'footer_menu_title_en', 'footer_show_secondary_navigation', 'footer_secondary_title_fa', 'footer_secondary_title_en' ),
                __( 'Widget areas', 'undo-theme' ) => array( 'footer_show_widgets' ),
                __( 'Contact and social', 'undo-theme' ) => array( 'footer_show_contact', 'contact_email', 'footer_contact_phone', 'footer_contact_address_fa', 'footer_contact_address_en', 'footer_show_social', 'footer_social_instagram', 'footer_social_linkedin', 'footer_social_telegram', 'footer_social_github', 'footer_social_youtube', 'footer_social_x' ),
                __( 'Legal and copyright', 'undo-theme' ) => array( 'footer_show_copyright', 'footer_copyright_fa', 'footer_copyright_en', 'footer_show_legal', 'footer_legal_fa', 'footer_legal_en' ),
            );
            foreach ( $footer_groups as $title => $keys ) {
                $group_fields = array();
                foreach ( $keys as $key ) { $group_fields[ $key ] = $section[2][ $key ]; }
                undo_render_settings_group( $title, $group_fields );
            }
            echo '<p class="undo-settings__hint">' . esc_html__( 'Assign the Footer and Footer secondary menu locations in Appearance → Menus. The second column appears only when it has an assigned menu.', 'undo-theme' ) . ' <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Open Menus', 'undo-theme' ) . '</a></p>';
            echo '<p class="undo-settings__hint">' . esc_html__( 'Add blocks to Footer widget areas 1–3 in Appearance → Widgets. Only areas containing widgets appear.', 'undo-theme' ) . ' <a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">' . esc_html__( 'Open Widgets', 'undo-theme' ) . '</a></p>';
            echo '<p class="undo-settings__hint">' . esc_html__( 'Use {year} in copyright text for the current year. The privacy link appears only when a published Privacy Policy page is configured in WordPress.', 'undo-theme' ) . '</p>';
        } elseif ( 'homepage' === $slug ) {
            undo_render_home_sections();
            undo_render_settings_group( __( 'Hero copy', 'undo-theme' ), array_intersect_key( $section[2], array_flip( array( 'hero_title_fa', 'hero_lead_fa', 'hero_title_en', 'hero_lead_en', 'show_section_rail' ) ) ) );
            undo_render_settings_group( __( 'Linked pages', 'undo-theme' ), array_filter( $section[2], function ( $field ) { return 'home_page_choice' === $field[1]; } ) );
            echo '<p class="undo-settings__hint">' . esc_html__( 'For linked pages, the page title and manual excerpt replace the built-in section copy, and the title links to the page. Empty excerpts keep the built-in description. Use separate published pages for Persian and English.', 'undo-theme' ) . '</p>';
        } else {
            echo '<table class="form-table" role="presentation">';
            foreach ( $section[2] as $key => $field ) { undo_settings_field( $key, $field ); }
            echo '</table>';
        }
        echo '</section>';
    }
    echo '<div class="undo-settings__actions"><span data-undo-dirty-status aria-live="polite"></span>';
    submit_button( __( 'Save all changes', 'undo-theme' ) );
    echo '</div></main></div></form></div>';
}
