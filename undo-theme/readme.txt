=== UNDO Web Developments ===
Contributors: undowebdevelopments
Tags: translation-ready, rtl-language-support, custom-logo, custom-menu, featured-images
Requires at least: 6.2
Requires PHP: 7.4
Stable tag: 0.3.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A Persian-first WordPress theme for creative agencies and studios, with an English visitor interface and dedicated RTL styles. Includes a responsive landing page, editorial posts, and pages with reading, wide, boxed, full, or custom pixel/percentage layouts. Its standalone settings dashboard controls the header, pages, posts, blog, sidebars, and footer. Supports Elementor page templates and Theme Builder locations, with verified GitHub dashboard updates.

== Features ==
* Persian-first visitor interface, English switcher, compiled translations, and dedicated RTL stylesheet.
* Responsive UNDO landing page with section navigation and a project brief download.
* Standalone UNDO Theme Settings page for site layout, language, colors, header, pages, single posts, blog, sidebar, footer, and homepage copy. Header options include light/dark styles, logo variants, centered navigation, search, and mobile action visibility.
* WordPress menus, widgets, featured images, logo support, and normal post, page, archive, search, and 404 templates.
* Editorial single-post template with optional manual excerpt, metadata, featured image, tags, related posts, comments, post navigation, and sidebar. Related posts are opt-in and matched by category.
* Reading, wide, boxed, full-width, and custom-width page templates. The Pages settings tab sets the default; the WordPress or Elementor page template selector can override it. Custom widths accept pixels or percentages and can be overridden on each page.
* Elementor-compatible page layouts and Elementor Pro Theme Builder location support.
* GitHub Releases updates from the WordPress dashboard with an installable ZIP and SHA-256 verification.

== Limitations ==
Elementor is optional; Elementor Pro is needed for Theme Builder location replacement. User-created pages and posts require a multilingual content solution for translation. Dedicated UNDO Elementor widgets are planned and are not included yet. This theme is still a pre-release under staging validation.

== Installation ==
Upload the theme ZIP under Appearance > Themes, activate it, then open UNDO Theme Settings in the main admin menu.

== Updates ==
Starting with version 0.2.3, installed sites can discover newer versions through WordPress Dashboard > Updates. Starting with version 0.2.5, the update details popup displays release notes inside WordPress. The exact GitHub Release ZIP is checked against its SHA-256 digest before installation.

== Changelog ==
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
