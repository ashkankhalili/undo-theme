# First online staging milestone

Target: `https://ashkankhalili.ir` (owner-designated empty WordPress and Elementor test site). This is a pre-release validation environment, not a customer release. Record the exact WordPress, PHP, Elementor, and theme versions before testing.

Public inspection on 2026-11-08 confirmed UNDO Web Developments 0.2.3 under the `undo-theme` folder with `Update URI: https://github.com/ashkankhalili/undo-theme`. The owner completed the one-time 0.2.3 bootstrap and supplied screenshots proving WordPress offered 0.2.4 in **Dashboard → Updates** without a ZIP upload. The screenshot also showed that the old version-details popup tried to embed GitHub, which refused the connection. Version 0.2.5 provides a WordPress-hosted details view for later updates. Back up the database and `wp-content` and record current settings, menus, widgets, and Customizer state before using the dashboard update.

## Entry conditions

1. Push this source repository to `ashkankhalili/undo-theme` and confirm the **Theme checks** workflow passes.
2. Verify the current versioned GitHub Release has the exact `undo-theme-X.Y.Z.zip` and `.sha256` assets, and that their SHA-256 values match.
3. Back up the staging database and `wp-content` before updating. Keep admin access on the owner-designated site only; never send credentials in chat or commit them to Git.
4. Open **Dashboard → Updates → Check Again**. If the WordPress app connector becomes available, use it for read-back; otherwise share non-secret screenshots or exportable logs.

## Online test sequence

| Order | Test | Pass evidence |
| --- | --- | --- |
| 1 | Confirm the current theme before the dashboard update | `undo-theme` is active at version 0.2.3 with the GitHub Update URI |
| 2 | Open homepage and a standard page at desktop and mobile sizes | Content appears; normal pages scroll freely without jumping to footer |
| 3 | Set Persian as default; switch to English and back | Visible strings change, `lang` and `dir` match, layout mirrors cleanly |
| 4 | Save one field in every **UNDO Theme Settings** tab, then reload each tab | Values persist and saving one tab does not clear another |
| 5 | Create a test post, page, menu, sidebar widget, and comments-enabled post | Single, archive, search, 404, menu, sidebar, and footer display correctly |
| 6 | Edit a page with Elementor Free; set it as static homepage | Editor loads, frontend renders, header/footer fallback works |
| 7 | If Elementor Pro is installed, assign and remove each Theme Builder location | Header, footer, single, archive replacements and fallbacks work |
| 8 | Test keyboard, touch, reduced motion, console, PHP error log, and responsive widths | No blocking accessibility, script, or PHP errors |
| 9 | Use **Dashboard → Updates → Check Again** | WordPress lists a newer version for `undo-theme` with an update control; 0.2.4 discovery confirmed by owner screenshot |
| 10 | Install the offered update from the dashboard | Version becomes 0.2.5 or later without a ZIP upload; settings, content, Elementor pages, and folder remain intact with no PHP errors |
| 11 | On the next version after 0.2.5, open **View version details** | Same-site popup displays the GitHub Release notes and link; no GitHub iframe error |

Use Persian and English content with long titles, mixed Latin text, and varied images. For multilingual SEO, test a separately chosen content translation plugin and translated URLs; the theme's language cookie only switches built-in strings.

## Test record

Create one dated test report in `docs/staging-reports/` after installation. Record the domain, environment versions, Git commit, ZIP SHA-256, each row's pass/fail result, screenshots/log excerpts for failures, fixes, and retest results. Do not add customer data, credentials, private URLs, or server configuration secrets. A failed row blocks a customer release but does not block continuing development.

## Exit condition

All rows pass or have a documented non-blocking exception. Only then mark Stage 1 validated in the roadmap and start Stage 2 header work. Publishing a customer release requires the later release gates in the blueprint.
