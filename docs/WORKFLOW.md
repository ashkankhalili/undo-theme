# Theme development and release workflow

Read [PREMIUM_THEME_BLUEPRINT.md](PREMIUM_THEME_BLUEPRINT.md) for the full architecture, settings contract, Elementor addon plan, quality gates, and staged implementation order. Track confirmed and open choices in [PRODUCT_DECISIONS.md](PRODUCT_DECISIONS.md). This file is the shorter day-to-day change and release checklist.

The first practical gate is the [online staging milestone](STAGING_MILESTONE.md). Use its exact CI artifact and test record before marking the theme foundation complete. The owner's 0.3.0 page screenshots exposed a width mismatch. Version 0.3.1 corrects it; validate all five page templates, inherited defaults, Elementor's own Full Width and Canvas modes, and custom widths on staging before marking Stage 4 complete.

## Standard premium theme workflow

1. **Define the product contract.** Record supported WordPress, PHP, Elementor, and browser versions; target customers; licensing; update and support terms. Persian is the primary language and RTL is the default visual direction. English remains a complete supported locale.
2. **Build the theme foundation.** Keep the parent-theme folder and text domain stable. Use WordPress template hierarchy, hooks, theme supports, semantic HTML, theme.json presets, and a child-theme-safe extension strategy. Keep customer content and settings in the database, not replaceable parent files.
3. **Implement one component at a time.** For each of header, single post, pages, sidebar, blog, footer, and homepage: define options, build markup, style LTR/RTL, connect Elementor fallbacks, check responsive behavior, then update translations and changelog before moving on. The order is tracked in [ROADMAP.md](ROADMAP.md).
4. **Validate every change.** Run PHP lint and WordPress coding standards, rebuild POT/PO/MO catalogs, inspect RTL at desktop and mobile sizes, test keyboard navigation and reduced motion, and test with and without Elementor. Use realistic Persian and English content.
5. **Test a release candidate on staging.** Install the exact packaged ZIP on a fresh WordPress install and upgrade an older version. Check settings persistence, widgets, menus, posts, pages, archives, search, 404, comments, Elementor editing, RTL, accessibility, and Theme Check. Record results before tagging.
6. **Publish from GitHub after connection.** A protected release workflow should build the final ZIP, checksum it, attach both to a versioned release, and verify that an installed older theme detects and applies the update. Do not expose secrets in the distributable.
7. **Maintain customers.** Keep a support matrix, migration notes, changelog, security contact, tested update path, and compatibility regression suite. Release fixes from reviewed branches and test the exact asset customers receive.

The source remains a classic theme because it already uses PHP templates and Elementor locations. Its `theme.json` supplies compatible global presets; the standalone dashboard stores theme-specific options via the WordPress Settings API.

Reference standards: [required classic theme files](https://developer.wordpress.org/themes/releasing-your-theme/required-theme-files/), [Settings API](https://developer.wordpress.org/apis/settings/), [theme internationalization](https://developer.wordpress.org/themes/classic-themes/functionality/internationalization/), [theme testing tools](https://developer.wordpress.org/themes/getting-started/tools-and-setup/), and [Elementor theme locations](https://developers.elementor.com/docs/themes/registering-locations/). If distributing through the WordPress.org directory, review its [theme release guidelines](https://developer.wordpress.org/themes/releasing-your-theme/) and move non-design functionality such as the project brief planner into a separate plugin before submission.

## Source and release boundaries

Keep the theme source in a dedicated Git repository once created. The WordPress theme directory name, text domain, and ZIP root must stay `undo-theme`. Do not include credentials, customer data, build caches, or source screenshots in release ZIPs. Keep theme version, package version, translation catalogs, and changelog synchronized.

## Work on a change

1. Create a branch from the current main or release branch.
2. Update PHP templates, assets, or settings. Escape all rendered values and sanitize every stored setting.
3. Add any new English gettext literals to `languages/undo-theme.pot` and translate every string in `en_US.po` and `fa_IR.po`; regenerate MO files with `node tools/build-translations.mjs`.
4. Record the customer-visible change in `CHANGELOG.md`. Document migrations, changed defaults, and any compatibility impact.
5. Test on WordPress staging in Persian and English: activation, homepage, a normal page and post, search/404, menus, every settings tab save/reload, sidebar widgets, keyboard and mobile navigation, RTL layout, brief download, and Elementor page editing. Verify that ordinary pages scroll naturally without jumping to the footer, while landing-page section navigation remains usable. Test the homepage with **Sticky header** both enabled and disabled: after wheel, keyboard, and rail navigation, a static-header section must begin at the viewport top and fill it; a sticky-header section must begin below the header. With Elementor Pro, verify each Theme Builder location and the fallback when no template is assigned.
   For a single-post change, include a manual excerpt, image caption, long headings, a block quote and table, tags, comments, category-matched related posts, sidebar widgets, and previous/next navigation. Check both directions and a narrow viewport. Keep unrelated/uncategorized posts out of related results.
   For a page change, test the standard and **UNDO Full Width** templates with each title style, breadcrumbs on a nested page, a featured image, reading/wide widths, optional sidebar, wide/full blocks, and an Elementor-built page. Check RTL/LTR and phone/desktop widths without changing existing customer pages.
6. Run PHP lint on every PHP file, WordPress Theme Check, and an accessibility/browser pass. Test supported WordPress and PHP versions. Do not claim live behavior from a package-only check.

## Prepare a release

1. Increment `Version` in `style.css` and `UNDO_THEME_VERSION` in `functions.php` together; use semantic versions.
2. Regenerate and review POT/PO/MO files. Confirm no empty Persian entry and that Persian catalog loads from `languages/fa_IR.mo`.
3. Update both `CHANGELOG.md` files, README requirements, and screenshot when the appearance changes. For each new feature, revise the theme's `readme.txt` feature list and limitations and the translated `style.css` Description so Appearance → Themes stays accurate. Write release notes that explain the changes; installed versions 0.2.5 and later display them in the WordPress update popup.
4. Run `node tools/package-theme.mjs`; inspect the ZIP root, file list, and SHA-256. Install that exact ZIP on staging and read back the activated version.
5. Merge the reviewed change to `main`. The release job runs only after PHP and package checks pass; it creates the `vX.Y.Z` tag and publishes the exact checked ZIP and checksum as GitHub Release assets.
6. Verify the GitHub Action, tag commit, release asset URL, digest, checksum, and installable ZIP contents. Test the WordPress dashboard upgrade on staging before telling customers the release is available.

## GitHub update channel

The public GitHub Releases channel, `Update URI`, exact asset matching, and checksum verification start in 0.2.3. WordPress dashboard discovery of 0.2.4 on staging is confirmed. The 0.2.3 details popup linked to GitHub, which refused iframe embedding; 0.2.5 added a same-site details view and the owner confirmed it displayed 0.2.6 release notes. Follow [GITHUB_UPDATES.md](GITHUB_UPDATES.md) for the repeatable release and verification sequence. Customer-only updates and license eligibility remain open product decisions; no token or secret is embedded in the theme.

WordPress replaces the theme directory during upgrades, so store customer changes in theme mods/options, a child theme, or content—not edited parent-theme files. Keep the shipped ZIP and update manifest aligned. A customer license server, if added later, needs its own privacy, authentication, and support policy.

## Commercial distribution

The theme is GPL-2.0-or-later and may be sold. Review all bundled assets and font licenses before distribution. Publish support terms, update eligibility, compatibility range, changelog, refund terms, and a secure vulnerability contact. Do not ship a release until staging checks are complete.
