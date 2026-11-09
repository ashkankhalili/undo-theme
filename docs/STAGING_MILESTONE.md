# First online staging milestone

Target: `https://ashkankhalili.ir` (owner-designated empty WordPress and Elementor test site). This is a pre-release validation environment, not a customer release. Record the exact WordPress, PHP, Elementor, and theme versions before testing.

The owner installed 0.3.0 and supplied screenshots showing that its UNDO Full Width page still constrained ordinary content. Versions 0.3.1 and 0.3.2 corrected those page cases, and the owner reported the problem solved. Version 0.3.3 adds controls for each reusable UNDO page template and follows WordPress Site Language on first visit. Version 0.4.0 adds sidebar styles and optional sticky behavior. Back up the database and `wp-content` and record current settings, menus, widgets, and Customizer state before using the dashboard update to 0.4.0.

## Entry conditions

1. Push this source repository to `ashkankhalili/undo-theme` and confirm the **Theme checks** workflow passes.
2. Verify the current versioned GitHub Release has the exact `undo-theme-X.Y.Z.zip` and `.sha256` assets, and that their SHA-256 values match.
3. Back up the staging database and `wp-content` before updating. Keep admin access on the owner-designated site only; never send credentials in chat or commit them to Git.
4. Open **Dashboard → Updates → Check Again**. If the WordPress app connector becomes available, use it for read-back; otherwise share non-secret screenshots or exportable logs.

## Online test sequence

| Order | Test | Pass evidence |
| --- | --- | --- |
| 1 | Confirm the current theme before the dashboard update | Record the installed `undo-theme` version and confirm the GitHub Update URI; the owner reported installing 0.3.2, but read back the actual version before testing |
| 2 | Open homepage and a standard page at desktop and mobile sizes | Content appears; normal pages scroll freely without jumping to footer |
| 3 | Change WordPress **Settings → General → Site Language** between Persian and English in a clean browser session, then use the header switcher | A first visit follows the WordPress setting; an explicit visitor choice persists; visible strings, `lang`, and `dir` match and layout mirrors cleanly |
| 4 | Save one field in every **UNDO Theme Settings** tab, then reload each tab | Values persist and saving one tab does not clear another |
| 5 | Create a test post, page, menu, sidebar widget, and comments-enabled post | Single, archive, search, 404, menu, sidebar, and footer display correctly |
| 6 | Edit a page with Elementor Free; set it as static homepage | Editor loads, frontend renders, header/footer fallback works |
| 7 | If Elementor Pro is installed, assign and remove each Theme Builder location | Header, footer, single, archive replacements and fallbacks work |
| 8 | Test keyboard, touch, reduced motion, console, PHP error log, and responsive widths | No blocking accessibility, script, or PHP errors |
| 9 | Use **Dashboard → Updates → Check Again** | WordPress lists a newer version for `undo-theme` with an update control; 0.2.4 discovery confirmed by owner screenshot |
| 10 | Before installing 0.4.0, open **View version details** | Same-site popup displays the GitHub Release notes in Persian and English with a GitHub link; no iframe error. The owner already confirmed 0.2.6 notes displayed. |
| 11 | Install the offered update from the dashboard | Version becomes 0.4.0 without a ZIP upload; settings, content, Elementor pages, and folder remain intact with no PHP errors |
| 12 | Test Header settings and navigation | Light/dark and logo variants, centered layout, search, action, nested desktop/mobile menus, keyboard Escape, RTL/LTR, and Elementor header replacement work |
| 13 | Test Single post settings and templates | Manual excerpt, date/author/categories/tags, featured image and caption, previous/next, related posts count and category matching, comments, sidebar, long RTL/LTR content, and Elementor single replacement work |
| 14 | Recheck the dark-header logo fallback | Without a dedicated light logo, the primary logo appears as a readable light silhouette; when a light logo is supplied, it retains its colors |
| 15 | Recheck static and sticky header section alignment | With sticky off, each later homepage section starts at viewport top and fills the viewport. With sticky on, it starts below the header. Wheel, keyboard and rail navigation remain usable. |
| 16 | Test all UNDO page layouts and Pages settings | On the same test page, Default inherits the selected global mode. Change each Reading, Wide, Boxed, and Full Width width, side margin, vertical margins, and padding in **UNDO Theme Settings → Pages**; save and reload. The chosen template applies its own values, and mobile RTL has no horizontal overflow. |
| 17 | Test Custom Width in the WordPress page editor | The panel sits below the editor and appears only for UNDO Custom Width. `960px` and `80%` apply on the frontend; blank uses `1200px`. Switching to another template hides the panel without losing a saved per-page value. No global Custom Width setting appears. |
| 18 | Test page hierarchy and Elementor | A child page shows the Home → parent → current breadcrumb path. Elementor-built pages using an UNDO template follow that template width and spacing; Elementor's own Full Width remains viewport wide and short pages with either ordinary WordPress or Elementor content keep the footer below the viewport; Canvas omits theme header/footer. With Elementor Pro, an assigned single location replaces the built-in layout and returns when unassigned. |
| 19 | Test widget sidebar styles and placement | Add classic and block widgets, including navigation and search. Lined and Panel styles, 16–64px spacing, width and start/end placement respond to settings. RTL mirrors start/end; on mobile the sidebar follows content without horizontal overflow. An empty area reserves no column. |
| 20 | Test optional sticky sidebar | A short widget area stays below the sticky header at the configured gap; with a static header it uses only the gap. A tall widget area scrolls normally without an inner scrollbar. Sticky mode is inactive below 900px. |

Use Persian and English content with long titles, mixed Latin text, and varied images. For multilingual SEO, test a separately chosen content translation plugin and translated URLs; the theme's language cookie only switches built-in strings.

## Test record

Create one dated test report in `docs/staging-reports/` after installation. Record the domain, environment versions, Git commit, ZIP SHA-256, each row's pass/fail result, screenshots/log excerpts for failures, fixes, and retest results. Do not add customer data, credentials, private URLs, or server configuration secrets. A failed row blocks a customer release but does not block continuing development.

## Exit condition

All rows pass or have a documented non-blocking exception. Only then mark Stage 1 validated in the roadmap and start Stage 2 header work. Publishing a customer release requires the later release gates in the blueprint.
