# Elementor starter provisioning on staging — 2026-11-14

Site: `https://ashkankhalili.ir` (WordPress Site Language: `fa-IR`). This report records read-only checks through the connected WordPress app. It does not certify a frontend route or an installed theme version.

| Starter | Page ID | Published URL | Elementor document |
| --- | ---: | --- | --- |
| Home, Persian | 6174 | `/undo-starter-home-fa/` | Builder page; six sections and `[undo_home_planner]` |
| Home, English | 6177 | `/undo-starter-home-en/` | Builder page; six sections and `[undo_home_planner]` |
| Blog, Persian | 6180 | `/undo-starter-blog-page-fa/` | Builder page with `[undo_blog_posts]` |
| Blog, English | 6183 | `/undo-starter-blog-page-en/` | Builder page with `[undo_blog_posts]` |

All four pages were returned as published, with Elementor builder data present. The WordPress app reported Elementor 4.2.4 and Elementor Pro active. The owner reported that **Settings → Reading** currently uses other pages or has no Home/Posts pair selected. The theme intentionally leaves these assignments untouched. To exercise the new Home and Blog routes, choose one matching language pair in Reading; keep the other pair available for a multilingual content workflow.

## v0.14.0 Home layout refresh

The two generated Home pages had not been modified since initial creation. Before replacing their layouts, their original Elementor data was saved locally under `dist/staging-home-6174-before-v0.14.0.json` and `dist/staging-home-6177-before-v0.14.0.json` (ignored by Git and excluded from release packages). The connected WordPress Elementor ability then replaced **only** these two page layouts. Both remained published and each now has 51 Elementor elements. Its render preview confirms the `undo-native-home` class, five native styled section classes and anchors, the compare control, process board, and a rendered planner anchor in both languages. This verifies Elementor HTML output, not browser appearance or interaction. The revised theme CSS and page wrapper reach staging after the v0.14.0 theme update.

## Still to verify

- Installed theme and UNDO Elements versions, exact active theme, and update result on staging. The connected WordPress app does not expose these values.
- Public frontend visual rendering after the v0.14.0 theme update, planner interaction, posts pagination, and both language directions. The Elementor render preview verified HTML structure; direct public browser access from this environment could not resolve the site.
- Elementor Free only, Elementor disabled, Elementor Pro archive precedence, and Polylang translation links on staging.
- Site-wide keyboard, responsive, accessibility, and browser checks from the release-candidate matrix.

Do not mark the starter routes or Stage 12 complete until the checks above are recorded.
