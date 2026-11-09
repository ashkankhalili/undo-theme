# UNDO Web Developments theme

Version **0.3.1** is an installable classic WordPress theme for the UNDO agency design. Persian is the default visitor language; English remains available. It includes dedicated RTL styles, editorial post and page templates, a standalone **UNDO Theme Settings** dashboard, and Elementor page/Theme Builder integration.

## Install

1. In WordPress, open **Appearance → Themes → Add New → Upload Theme**.
2. For a new site, upload `undo-theme-0.3.1.zip`, install, and activate. On an existing updater-enabled site, use **Dashboard → Updates** after backing up; do not upload another ZIP.
3. Open **UNDO Theme Settings** in the main admin sidebar. Its tabs cover website layout, header, single posts, pages, sidebar, blog, footer, and homepage. Each tab saves independently without clearing other tabs.
4. Set header logos, light/dark style, centered navigation, search, and mobile action visibility in **UNDO Theme Settings → Header**. Assign menus in **Appearance → Menus**.
5. Configure metadata, featured media, tags, comments, navigation, sidebar, and category-matched related posts in **UNDO Theme Settings → Single post**. Related posts are off by default.
6. Configure page breadcrumbs, title style, featured image, default layout, and custom pixel/percentage width in **UNDO Theme Settings → Pages**. In the page editor or Elementor Page Settings, choose an UNDO Reading, Wide, Boxed, Full Width, or Custom Width template to override the default. The custom width field in the page editor overrides the theme setting for that page.
7. If using Elementor, install it separately. Edit a page with Elementor and assign it as the static homepage to replace the default landing content. Elementor Pro Theme Builder can replace header, footer, single, and archive locations.

The language switcher uses `?undo_lang=en` and `?undo_lang=fa` and remembers the choice in a cookie. The theme's built-in strings and default landing page are translated. Customer-created posts, pages, menus, and Elementor content require a multilingual content plugin or separate translated pages. For public multilingual SEO, use translated URLs and hreflang from that plugin; the theme switcher alone is not an SEO translation system. Configure page cache to vary by `undo_lang` and its cookie, or exclude language-specific responses from shared cache.

The project planner downloads a text file locally in the browser. It does not submit personal data to the site.

## GitHub updates

The theme uses `Update URI: https://github.com/ashkankhalili/undo-theme` and checks the latest published GitHub Release. When a newer version has the exact `undo-theme-X.Y.Z.zip` asset and a SHA-256 digest or matching `.sha256` asset, WordPress lists it under **Dashboard → Updates**. An administrator starts the update there. The updater verifies the downloaded ZIP checksum before WordPress replaces the theme folder. GitHub's generic source ZIP is never used.

Version 0.2.2 cannot discover GitHub updates because it shipped before this updater. The staging site completed its one-time 0.2.3 bootstrap, the owner confirmed WordPress offered 0.2.4 in the dashboard, and the owner confirmed the 0.2.9 header fix. The public GitHub repository means release packages are public; customer license-gated updates are a separate future product decision.

Starting with installed version 0.2.5, **View version details** opens a WordPress-hosted popup containing the latest GitHub Release notes. The owner confirmed that the 0.2.6 popup displayed release notes. The current feature list and limitations are maintained in [the theme readme](undo-theme/readme.txt); expand the Appearance → Themes description as real features are added.

## Requirements and status

- WordPress 6.2 or later; PHP 7.4 or later.
- Elementor is optional; Elementor Pro is required for Theme Builder location replacement.
- This is a **pre-release theme package**. PHP syntax and live WordPress activation must be checked on a WordPress staging install before customer sale.
- Fonts currently load from Google Fonts. For WordPress.org directory submission or privacy-sensitive customer deployments, self-host licensed font files and run Theme Check.
- GitHub Releases update checks are included. Automatic background installation and license-gated downloads are not enabled.

New visitors see Persian unless the default is changed in theme settings. See the [premium theme blueprint](docs/PREMIUM_THEME_BLUEPRINT.md), [product decisions](docs/PRODUCT_DECISIONS.md), [development workflow](docs/WORKFLOW.md), [implementation roadmap](docs/ROADMAP.md), and [changelog](CHANGELOG.md).

## First online milestone

Source repository: `https://github.com/ashkankhalili/undo-theme`. The owner-designated staging site is `https://ashkankhalili.ir`. The owner tested 0.3.0 and identified a full-width page bug. Follow the [staging milestone](docs/STAGING_MILESTONE.md): update to 0.3.1 through WordPress, then compare the five page layouts, custom widths, RTL/LTR, and Elementor behavior. A GitHub push or passing CI does not by itself validate live WordPress behavior.
