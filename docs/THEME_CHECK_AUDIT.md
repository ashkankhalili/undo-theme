# Theme Check review — 2026-11-14

The isolated [WordPress quality audit](https://github.com/ashkankhalili/undo-theme/actions/workflows/quality-audit.yml) ran against v0.13.3. Plugin Check for UNDO Elements exited successfully. Theme Check exited with findings, so its report is retained in the Actions artifact and printed in the job log. A zero-exit audit is not yet claimed.

## Addressed in v0.13.4

- Add `Tested up to: 7.1`, the current stable WordPress series used by the isolated check and staging site. This identifies the tested series, not a completed browser or accessibility matrix.
- Enqueue `comment-reply` when a singular page has open threaded comments.
- Add a restrained block editor stylesheet so headings, body type, links, quotation marks, and RTL direction resemble the native reading view.
- Add visible keyboard focus for `.screen-reader-text` and standard alignments, captions, sticky posts, and author comments to the frontend stylesheet.

## Deliberate commercial distribution exceptions

| Finding | Product reason | Release gate |
| --- | --- | --- |
| `Update URI` in `style.css` | WordPress dashboard updates must discover the exact GitHub Release ZIP. Removing this breaks the established customer update channel. The theme is not being submitted to the WordPress.org theme directory. | Keep and verify dashboard upgrades on staging. |
| `add_shortcode()` in theme | The Elementor Free Home/Blog starters and optional footer widget template use shortcodes with native fallback behavior. Moving them now would break sites that have the theme without the separate addon. | Keep compatibility until a customer-safe addon migration is designed and tested. |
| `upload_mimes` in theme | Theme Settings permits administrators to upload WOFF2 custom fonts through Media Library; the filter is restricted to users with `manage_options`. | Keep while custom-font controls remain built into the theme. |
| Theme name and directory slug differ | The visible product name is `UNDO Web Developments`; the stable folder and text domain are `undo-theme` for updates and existing sites. | Keep folder/text domain stable; document WordPress.org directory implications before any directory submission. |
| `<title>` inside updater detail view | This is a standalone administrative update-details document, not a frontend template title. | Keep a readable title in the details popup. |

Recommended items such as block pattern registration, WordPress default block styles, Custom Header/Background APIs, and Author URI will be considered against the customer product design. They are not evidence that the current features failed. WPCS, accessibility, browser, PHP and WordPress version matrix, exact staging upgrade, and asset licensing remain open Stage 12 gates.
