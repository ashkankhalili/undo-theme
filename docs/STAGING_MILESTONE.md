# First online staging milestone

Target: `https://ashkankhalili.ir` (owner-designated empty WordPress and Elementor test site). This is a pre-release validation environment, not a customer release. Record the exact WordPress, PHP, Elementor, and theme versions before testing.

Public inspection on 2026-11-08 found UNDO Web Developments 0.2.1 active under the `undo-theme` folder. The source package in this repository uses the intended `undo-web-developments` folder, so installing its ZIP creates a separate theme entry. Keep the existing theme installed for rollback. Record the current settings, menus, widgets, and Customizer state before activating the new folder. The standalone `undo_theme_settings` option may persist across the folder change, but theme mods and menu assignments can be stylesheet-specific; verify and restore them explicitly.

## Entry conditions

1. Push this source repository to `ashkankhalili/undo-theme` and confirm the **Theme checks** workflow passes.
2. Download the `theme-pre-release` artifact from the successful run. Extract `undo-web-developments-0.2.1.zip` and its `.sha256` file. Check the SHA-256 locally before installation.
3. Back up the staging database and `wp-content` before activation. Keep admin access on the owner-designated site only; never send credentials in chat or commit them to Git.
4. Connect the staging site to the WordPress app in Codex if its connector supports theme installation and read-back. Otherwise install the exact ZIP through **Appearance → Themes → Add New → Upload Theme** and share non-secret screenshots or exportable logs for verification.

## Online test sequence

| Order | Test | Pass evidence |
| --- | --- | --- |
| 1 | Install and activate the exact ZIP; reload **Appearance → Themes** | `undo-web-developments` folder active, version 0.2.1, no fatal error or admin warning; old `undo-theme` entry retained for rollback |
| 2 | Open homepage and a standard page at desktop and mobile sizes | Content appears; normal pages scroll freely without jumping to footer |
| 3 | Set Persian as default; switch to English and back | Visible strings change, `lang` and `dir` match, layout mirrors cleanly |
| 4 | Save one field in every **UNDO Theme Settings** tab, then reload each tab | Values persist and saving one tab does not clear another |
| 5 | Create a test post, page, menu, sidebar widget, and comments-enabled post | Single, archive, search, 404, menu, sidebar, and footer display correctly |
| 6 | Edit a page with Elementor Free; set it as static homepage | Editor loads, frontend renders, header/footer fallback works |
| 7 | If Elementor Pro is installed, assign and remove each Theme Builder location | Header, footer, single, archive replacements and fallbacks work |
| 8 | Test keyboard, touch, reduced motion, console, PHP error log, and responsive widths | No blocking accessibility, script, or PHP errors |
| 9 | Run Theme Check and an upgrade from the previous package | Record warnings; confirm settings and content survive the upgrade |

Use Persian and English content with long titles, mixed Latin text, and varied images. For multilingual SEO, test a separately chosen content translation plugin and translated URLs; the theme's language cookie only switches built-in strings.

## Test record

Create one dated test report in `docs/staging-reports/` after installation. Record the domain, environment versions, Git commit, ZIP SHA-256, each row's pass/fail result, screenshots/log excerpts for failures, fixes, and retest results. Do not add customer data, credentials, private URLs, or server configuration secrets. A failed row blocks a customer release but does not block continuing development.

## Exit condition

All rows pass or have a documented non-blocking exception. Only then mark Stage 1 validated in the roadmap and start Stage 2 header work. Publishing a customer release requires the later release gates in the blueprint.
