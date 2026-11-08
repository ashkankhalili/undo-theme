# Changelog

All changes to the customer theme are recorded here. Use a version number in `style.css`, `functions.php`, and the package filename for every release.

## [Unreleased]

## [0.2.4] - 2026-11-08

### Validation

- Published a higher version to verify that an installed 0.2.3 theme discovers and installs a GitHub Release from WordPress Dashboard → Updates without another ZIP upload.
- No visual, settings, or content behavior changed. Live dashboard discovery and installation must be recorded on staging before this update path is considered verified.

## [0.2.3] - 2026-11-08

### Added

- Added a GitHub Releases update channel through WordPress's `Update URI` hook. Newer versioned release ZIPs appear in the WordPress update dashboard.
- Added SHA-256 verification before WordPress installs the downloaded theme ZIP. The updater accepts only the exact `undo-theme` release asset and rejects an invalid or missing checksum.
- Added PHP checks for update discovery, version handling, release URL validation, checksum fallback, and tampered downloads.

### Build

- Added a GitHub Actions release job that publishes the exact CI-tested ZIP and checksum after PHP and package checks pass, then verifies the release asset digest and tag.

### Upgrade note

- Version 0.2.2 has no updater. Install 0.2.3 once from the GitHub Release ZIP to enable future dashboard updates; verify the 0.2.3-to-0.2.4 update on staging before customer rollout.
- This is a staging bootstrap release. Customer rollout awaits the live dashboard update test and the remaining premium theme quality gates.

## [0.2.2] - 2026-11-08

### Changed

- Standardized the installable theme folder, ZIP root, package filename, and gettext domain as `undo-theme` to match the existing staging installation and support in-place updates.
- Regenerated the Persian and English PO/MO catalogs under the `undo-theme` text domain. Existing `undo_theme_settings` options remain under the same option key.

### Documentation

- Added the first online staging milestone, including exact CI artifact installation, bilingual and RTL checks, Elementor checks, and a dated test record.
- Recorded the owner-provided GitHub repository and staging domain in the roadmap and product decisions.
- Added a premium theme blueprint covering product boundaries, standalone settings, Elementor addon widgets, Persian/English RTL delivery, staged implementation, QA gates, and GitHub customer releases.
- Added a product decision log and updated the implementation roadmap and development workflow to link the blueprint. No theme runtime behavior changed.

### Build

- Fixed source line endings for reproducible ZIPs across Windows and Linux; binary theme assets keep their original bytes.
- Added GitHub Actions checks for PHP syntax on 7.4 and 8.3, JavaScript syntax, generated translation catalogs, installable ZIP integrity, and a downloadable pre-release artifact.

## [0.2.1] - 2026-11-08

### Fixed

- Removed document-wide scroll snapping, which could pull normal pages directly to the footer because it was their only snap target.
- Limited guided section tracking, wheel handling, keyboard handling, and section motion to the built-in landing page.
- Applied the same scroll fix to the hosted static preview.

### Verification

- Browser check: a normal page remained at the requested scroll position, with no section motion or scroll snapping.
- Browser check: the landing page remained at the requested Services position, with no scroll snapping.
- Live WordPress and Elementor staging behavior remains to be verified.

## [0.2.0] - 2026-11-08

### Changed

- Persian is the default visitor language for new installs; English remains supported. Existing saved choices remain intact.
- Theme settings now live in one standalone UNDO Theme Settings dashboard with tabs for website layout, header, single posts, pages, sidebar, blog, footer, and homepage.
- Each tab saves its own fields while retaining settings from other tabs. Values are sanitized and constrained to supported options or ranges.
- The built-in header, footer, page, post, archive, blog, and search templates now honor the relevant controls. Elementor Theme Builder templates continue to take precedence.
- Persian typography selectors now match WordPress's `fa-IR` language attribute.

### Added

- Dedicated `rtl.css` and logical-direction layout refinements.
- Registered widget sidebar with conditional placement in posts, pages, archives, and search.
- Header logo selection from the WordPress media library and adjustable logo width within the standalone dashboard.
- Post card controls for image, date, excerpt, excerpt length, and column count.
- A staged premium-theme development roadmap and expanded test/release gates.

### Migration

- Update the parent theme with the new ZIP. Stored theme options and content remain in the database. The default language changes to Persian only where no visitor or saved theme choice exists.

### Remaining before commercial release

- Live WordPress/Elementor validation, theme review checks, accessibility and browser coverage, asset licensing, and a tested GitHub update channel.

## [0.1.0] - 2026-11-08

### Added

- Initial WordPress classic theme based on the UNDO Web Developments landing design.
- Responsive default landing page, standard page/post/archive/search/404 templates, and theme screenshot.
- Elementor-compatible page content and Elementor Pro header, footer, single, and archive locations.
- Appearance → UNDO Theme Settings with sanitized bilingual hero copy, CTA, colors, contact email, language default, and section rail visibility.
- English and Persian visitor language switcher with RTL styling and a persistent language choice.
- POT, en_US PO/MO, and fa_IR PO/MO translation catalogs.
- Local project brief download in English or Persian.
- Installation, maintenance, and release workflow documentation.

### Known limits

- Customer-authored content needs a multilingual content plugin for translation and SEO URLs.
- GitHub-based updates and customer licensing await a repository and release policy.
- Live WordPress/Elementor activation and Theme Check are pending staging verification.
