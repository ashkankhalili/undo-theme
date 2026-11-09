# 0.3.0 Pages milestone: pre-release check

Date: 2026-11-09. Source milestone: Stage 4 Pages. Target staging site: `https://ashkankhalili.ir` after the owner installs 0.3.0 from the WordPress dashboard.

## Source and browser checks

- The new Pages settings keep the old defaults: title on; breadcrumbs, featured image, and sidebar off; editorial title and reading width selected. Automated PHP checks cover option validation and preservation of settings from other tabs.
- POT, English PO/MO, and Persian PO/MO catalogs were regenerated for 215 strings. The package builder produced `undo-theme-0.3.0.zip` with one `undo-theme/` root and a SHA-256 file; GitHub Actions must repeat and verify these checks on the published commit.
- A local browser fixture using the release CSS was rendered at 1440 × 900 and 390 × 844 in English LTR and Persian RTL, for reading and full-width variants. The reported document widths were 1425/1440 and 390/390 respectively, with no horizontal overflow. This fixture does not exercise WordPress template loading or Elementor.

## Required online checks after dashboard update

1. Confirm the WordPress update-details popup includes the 0.3.0 page changes; install the theme through **Dashboard → Updates** and read back version 0.3.0.
2. Create a disposable standard page and choose **UNDO Full Width** in the page editor. Compare reading, wide, and full-width rendering at desktop and phone widths in both languages. Add a wide block, full-width block, and featured image.
3. Toggle page title, title style, breadcrumbs, featured image, and sidebar in **UNDO Theme Settings → Pages**. Use a child page to check the ancestor path. Verify another settings tab remains unchanged after saving Pages.
4. Open an Elementor-built page and confirm its canvas remains intact. If Elementor Pro is available, assign and remove a single template and confirm replacement and fallback. Check keyboard focus, RTL direction, console, and PHP error log.

The 0.3.0 page milestone remains **pending live staging verification** until these checks are recorded.
