=== UNDO Web Developments ===
Contributors: undowebdevelopments
Tags: translation-ready, rtl-language-support, custom-logo, custom-menu, featured-images
Requires at least: 6.2
Requires PHP: 7.4
Stable tag: 0.13.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A bilingual WordPress theme for creative agencies and studios. The initial language follows WordPress Site Language, with a visitor switcher for Persian and English and dedicated RTL styles. Includes a responsive landing page, three blog layouts, editorial posts, and reading, wide, boxed, and full-width page templates with configurable width and spacing. The single-save settings dashboard controls layout, colors, typography, header, pages, posts, blog, sidebar, and a configurable footer. Supports Elementor page templates and Theme Builder locations, with GitHub dashboard updates.

== Features ==
* Initial language follows WordPress Site Language; Persian and English visitor overrides, compiled translations, and dedicated RTL stylesheet are included. Optional Polylang support sends visitors to translated content and language-specific Home pages.
* Responsive UNDO landing page with section navigation, adjustable section order and visibility, linked published-page titles and excerpts per language, and a project brief download.
* Standalone, full-width UNDO Theme Settings page with a joined vertical sidebar. Switching sections keeps unsaved values in place; Save all changes stores every section at once.
* Separate layout, colors, and typography sections. Site content width accepts pixels or percent. Typography shows each text role on a single row with its original language-aware font named explicitly, plus size, weight, style, line height, word and letter spacing, and color controls. Google, system, and uploaded WOFF2 font families are available; Google font loading can be disabled. Header options include light/dark styles, logo variants, centered navigation, search, and mobile action visibility.
* WordPress menus, widgets, featured images, logo support, and normal post, page, archive, search, and 404 templates.
* Editorial single-post template with optional manual excerpt, metadata, featured image, tags, related posts, comments, post navigation, and sidebar. Related posts are opt-in and matched by category.
* Reading, wide, boxed, and full-width page templates each have width, margin, and padding controls in Pages settings. The default can be overridden in the WordPress or Elementor page template selector. UNDO Custom Width uses only a per-page pixel/percentage field below the WordPress editor, visible when that template is selected.
* Physical left/right or hidden widget sidebar with lined or panel styling, adjustable width and spacing, context visibility, and optional sticky behavior that stops when the widget area is too tall. On small screens the sidebar follows the main content.
* Editorial list, image grid, and journal grid for blog indexes, archives, and search results; grid column count is configurable. Blog Settings can choose a published WordPress posts page, which follows Settings > Reading.
* Footer stage: responsive statement and action, two optional menu columns, email/phone/location, validated social links, copyright with a current-year token, the configured WordPress Privacy Policy link, and three optional widget areas. Text settings have Persian and English values; Elementor Pro's footer template can replace the built-in footer.
* With Elementor Free or Pro active, the theme creates editable English/Persian Home and Blog starter pages once, without changing Settings > Reading or existing pages. The Reading posts page renders the Elementor Blog starter and its live post loop; Elementor Pro archive templates take precedence. Without Elementor, native Home and blog layouts remain. Header, Footer and Blog Archive starters for Pro remain manual imports. Theme updates never rewrite created pages. The separately installed UNDO Elements addon supplies three Elementor widgets and a reusable project planner.
* GitHub Releases updates from the WordPress dashboard with an installable ZIP and SHA-256 verification.

== Limitations ==
Elementor is optional; Elementor Pro is needed for Theme Builder location replacement and the Header, Footer and Blog Archive starters. The automatically created Free pages are published but are not assigned in Settings > Reading; review and select the matching Home and Blog pair. Elementor widgets with explicit colors or fonts keep their own styling. The theme does not translate customer-authored pages, posts, menus, or Elementor templates by itself. Polylang is the first supported content translation workflow; Elementor template translations additionally need an integration plugin. Automatic starter creation and the multilingual workflow still need live staging validation. This theme is still a pre-release.

== Installation ==
Upload the theme ZIP under Appearance > Themes, activate it, then open UNDO Theme Settings in the main admin menu.

== Updates ==
Starting with version 0.2.3, installed sites can discover newer versions through WordPress Dashboard > Updates. Starting with version 0.2.5, the update details popup displays release notes inside WordPress. The exact GitHub Release ZIP is checked against its SHA-256 digest before installation.

== Changelog ==
= 0.13.1 =
* Expanded both generated Elementor Home starters to match the native Home section order: Hero, Overview, Services, Approach, Redesign and a working Project Planner.
= 0.13.0 =
* Creates editable English and Persian Elementor Home and Blog pages once when Elementor Free or Pro is active, without changing existing Reading choices or customer pages.
* Adds a live blog posts shortcode for the Elementor Free Reading posts page and keeps the native fallback when Elementor is disabled.
= 0.12.0 =
* Added optional Polylang-aware language links, Home URLs, and translated Homepage references while keeping the WordPress Site Language and visitor switcher behavior when Polylang is absent.
* Polished 320px header spacing, Persian type rhythm, and mixed-direction planner input in the separately versioned UNDO Elements addon.
= 0.11.0 =
* The native Home uses the UNDO Elements plugin planner when available and retains its existing browser-only planner when the addon is inactive.
* The separate UNDO Elements package adds Project Planner, Service Card and Project Invitation Elementor widgets.
= 0.10.0 =
* Improved the Elementor Free, Pro and disabled-plugin paths: builder page styling is used only while Elementor is loaded, and the native front page returns when an Elementor page is unavailable.
* Scoped native landing heading and section styles to the built-in homepage so Elementor content can retain its own headings and layout.
* Added page-setting guidance and automated front-page fallback checks; documented the Elementor compatibility and staging matrix.
= 0.9.0 =
* Added Homepage settings for section visibility and keyboard-accessible ordering while keeping the hero and project planner as fixed destinations.
* Added published-page references for overview, services, approach, and redesign copy, with separate Persian and English choices and links to the selected pages.
* Made guided section navigation follow the rendered order and tolerate hidden sections or an Elementor footer.
= 0.8.0 =
* Added three optional, responsive footer widget areas, with a Theme Settings toggle and support for the [undo_footer_widgets] shortcode in an Elementor Pro footer.
* Bundled importable Home page starters for Elementor Free and Header, Footer and dynamic Blog Archive starters for Elementor Pro in English and Persian.
* Kept theme PHP templates as reliable fallbacks and documented import, language and upgrade behavior.
= 0.7.0 =
* Built the footer stage with responsive layout, two menu locations, contact and social links, copyright/legal text, and automatic Privacy Policy link.
* Added grouped bilingual footer settings and kept Elementor Theme Builder replacement behavior.
= 0.6.1 =
* Added a published-page selector for the WordPress posts page in Blog Settings.
* Named the original English/Persian font choices and arranged all typography controls for each text role on one horizontal row.
* Added word spacing while retaining existing letter spacing values and controls.
= 0.6.0 =
* Added pixel/percentage site content width and left/right/hidden sidebar position, while preserving legacy saved choices.
* Added editorial list, image grid, and journal grid designs for blog, archive, and search.
* Added per-role typography details and a Google Fonts on/off control with curated families and system fallbacks.
= 0.5.0 =
* Expanded the Theme Settings workspace to full width with a joined sidebar, full-row selected state, and instant section switching without losing unsaved edits.
* Moved colors out of Website Layout into a dedicated Colors section; added shared, header, content, and footer controls.
* Added Typography font roles and Media Library WOFF2 uploads for custom families, with regular and optional bold files.
= 0.4.0 =
* Added lined and panel sidebar styles, adjustable widget spacing, and optional sticky behavior with a top gap.
* Sticky mode engages only when the sidebar fits the viewport; tall widgets scroll normally. Start/end placement mirrors in RTL, and empty widget areas reserve no sidebar markup.
= 0.3.3 =
* Added width, margin, and padding settings for the Reading, Wide, Boxed, and Full Width page templates, with safe defaults and responsive limits.
* Moved Custom Width to a conditional per-page panel below the editor; removed its global width setting.
* Redesigned UNDO Theme Settings with a vertical RTL-friendly sidebar. The initial language now follows WordPress Site Language.
= 0.3.2 =
* Kept the footer below the viewport on Elementor Full Width pages that display ordinary WordPress content as well as Elementor-built content.
= 0.3.1 =
* Fixed full-width pages so ordinary content uses the available page width instead of a hidden 760px limit.
* Added reading, wide, boxed, and custom-width page templates, plus a pixel/percentage width control in the Pages settings tab and page editor.
* Applied the chosen theme width to Elementor-built pages using UNDO templates, with full-width Elementor and Canvas templates retaining Elementor's own layout behavior.
* Honored explicit page templates on a static front page.
= 0.3.0 =
* Added standard and UNDO Full Width page templates with responsive editorial typography and full-bleed block support.
* Added page breadcrumbs, featured image, title style, and content width controls in the standalone Pages settings tab, with Persian and English translations.
* Preserved Elementor-built page canvas behavior and Elementor Pro single location replacement.
= 0.2.9 =
* Fixed homepage section alignment when the sticky header setting is disabled. Guided scrolling now offsets only a sticky header, and subsequent sections fill the viewport when the header scrolls away.
* Verified the static-header correction at desktop and mobile widths while preserving sticky-header alignment.
= 0.2.8 =
* Fixed dark header readability when the separate light logo is not configured. The primary logo is rendered as a white silhouette until a light logo is supplied.
* Confirmed the 0.2.7 post template loads in Persian and English at phone and desktop widths without horizontal overflow on staging.
= 0.2.7 =
* Redesigned the single-post reading layout with responsive typography, featured media, metadata, navigation, related posts, tags, and comments.
* Added dependent single-post settings and English/Persian translations. Related posts remain off by default.
= 0.2.6 =
* Added configurable light/dark header, light logo option, centered navigation, optional search, mobile action, accessible submenu controls, and improved mobile menu behavior.
* The first update offered to an installed 0.2.5 theme exercises the WordPress-hosted release-notes popup.
= 0.2.5 =
* Added WordPress-hosted update details with release notes and a direct GitHub Release link.
* Expanded and translated the description shown in Appearance > Themes; documented the current feature set and limits.
= 0.2.4 =
* Validation release for the first WordPress dashboard update from 0.2.3; no visual or settings changes.
= 0.2.3 =
* Added GitHub Releases updates in WordPress Updates, with SHA-256 verification of the installable ZIP.
= 0.2.2 =
* Standardized the theme folder, ZIP root, and translation domain as undo-theme for in-place updates on existing installs.
= 0.2.1 =
* Fixed automatic jumps to the footer by removing global document scroll snapping and limiting guided section navigation to the landing page.
= 0.2.0 =
* Persian default, dedicated RTL stylesheet, standalone settings dashboard and connected template controls.
= 0.1.0 =
* Initial theme package with bilingual landing page, RTL layout, Elementor support and theme settings.
