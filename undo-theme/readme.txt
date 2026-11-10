=== UNDO Web Developments ===
Contributors: undowebdevelopments
Tags: translation-ready, rtl-language-support, custom-logo, custom-menu, featured-images
Requires at least: 6.2
Requires PHP: 7.4
Stable tag: 0.5.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A bilingual WordPress theme for creative agencies and studios. The initial language follows WordPress Site Language, with a visitor switcher for Persian and English and dedicated RTL styles. Includes a responsive landing page, editorial posts, and reading, wide, boxed, and full-width page templates with configurable width and spacing. Custom page widths are set per page. The full-width, single-save settings dashboard controls layout, colors, typography, uploaded WOFF2 fonts, header, pages, posts, blog, sidebars, and footer. Supports Elementor page templates and Theme Builder locations, with GitHub dashboard updates.

== Features ==
* Initial language follows WordPress Site Language; Persian and English visitor overrides, compiled translations, and dedicated RTL stylesheet are included.
* Responsive UNDO landing page with section navigation and a project brief download.
* Standalone, full-width UNDO Theme Settings page with a joined vertical sidebar. Switching sections keeps unsaved values in place; Save all changes stores every section at once.
* Separate layout, colors, and typography sections. Colors cover the shared palette and built-in header, page/post content, and footer. Typography assigns built-in or uploaded WOFF2 font families to body, headings, navigation, buttons, titles, widgets, and footer. Header options include light/dark styles, logo variants, centered navigation, search, and mobile action visibility.
* WordPress menus, widgets, featured images, logo support, and normal post, page, archive, search, and 404 templates.
* Editorial single-post template with optional manual excerpt, metadata, featured image, tags, related posts, comments, post navigation, and sidebar. Related posts are opt-in and matched by category.
* Reading, wide, boxed, and full-width page templates each have width, margin, and padding controls in Pages settings. The default can be overridden in the WordPress or Elementor page template selector. UNDO Custom Width uses only a per-page pixel/percentage field below the WordPress editor, visible when that template is selected.
* Configurable start/end widget sidebar with lined or panel styling, adjustable width and spacing, context visibility, and optional sticky behavior that stops when the widget area is too tall. On small screens the sidebar follows the main content.
* Elementor-compatible page layouts and Elementor Pro Theme Builder location support.
* GitHub Releases updates from the WordPress dashboard with an installable ZIP and SHA-256 verification.

== Limitations ==
Elementor is optional; Elementor Pro is needed for Theme Builder location replacement. Elementor widgets with explicit colors or fonts keep their own styling. User-created pages and posts require a multilingual content solution for translation. Dedicated UNDO Elementor widgets are planned and are not included yet. This theme is still a pre-release under staging validation.

== Installation ==
Upload the theme ZIP under Appearance > Themes, activate it, then open UNDO Theme Settings in the main admin menu.

== Updates ==
Starting with version 0.2.3, installed sites can discover newer versions through WordPress Dashboard > Updates. Starting with version 0.2.5, the update details popup displays release notes inside WordPress. The exact GitHub Release ZIP is checked against its SHA-256 digest before installation.

== Changelog ==
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
