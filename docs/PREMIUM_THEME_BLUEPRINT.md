# UNDO premium WordPress theme blueprint

Status: planning document for the 0.6.0 pre-release. No item marked "planned" is implemented merely because it appears here. The initial visitor language follows WordPress Site Language; Persian (fa_IR) and English (en_US) are supported.

## 1. Product definition and boundaries

**Customer:** agencies and businesses that need a fast, polished Persian-first site and want to edit pages with Elementor. **Product promise:** a coherent theme, a practical settings dashboard, optional UNDO Elementor widgets, updates, documentation, and support. Avoid turning every visual property into a setting; each option must solve a real customer need, have a safe default, and be testable.

The recommended product consists of two installable packages:

| Package | Owns | Must work without |
| --- | --- | --- |
| `undo-theme` parent theme | Site shell, template hierarchy, global design tokens, header/footer, blog/page/post layouts, theme options, RTL, translations, Elementor page and Theme Builder fallbacks | Elementor and the addon plugin |
| `undo-elements` addon plugin | UNDO Elementor widgets, interactive project planner, persistent content types or shortcodes if later needed, widget assets and plugin settings | Elementor Pro or the UNDO parent theme; it should show a clear admin notice when Elementor Free is missing |

A starter child theme can be a third *optional* ZIP for customers who need PHP/CSS overrides. Customer content, theme options, licenses, and media stay in the database or a child theme, never in files replaced by a parent-theme update. Do not bundle or impersonate Elementor or Elementor Pro.

**Distribution default:** sell theme and addon together from UNDO's own site as separate ZIPs. Keep WordPress.org submission as a separate decision. WordPress.org's theme review guidance excludes non-design functionality such as forms from themes, so move the current project brief planner into the addon before considering directory submission.

**Pro dependency:** Elementor Free is optional for the theme and required for the addon widgets. Elementor Pro is optional; when present, its Theme Builder may replace registered header, footer, single, and archive locations.

## 2. Decisions to lock before feature work

Record these in [PRODUCT_DECISIONS.md](PRODUCT_DECISIONS.md) before implementation:

1. Distribution: own store only, WordPress.org directory plus paid addon, or both. Default: own store first.
2. Supported WordPress, PHP, Elementor, and browser versions. Recheck current upstream requirements before setting the release matrix; the current theme header is only a provisional minimum.
3. Product tiers: one complete premium package initially. Avoid a confusing free/pro feature split until customer use shows a need.
4. Update policy: public or customer-only GitHub release assets, license-based update eligibility, support term, and renewal rules. Default: license gates updates/support, not front-end rendering or customer content.
5. Multilingual content workflow: choose and test a supported content translation plugin. Theme PO/MO files translate interface strings, not customer-authored posts, Elementor templates, menus, or SEO URLs.
6. Demo package: one carefully edited Persian demo and one English translation, with licensed images and reversible import. No forced content overwrite.
7. Data policy: project planner submissions stay local or are sent to a chosen service only after explicit form consent and a documented privacy path.

## 3. Design workflow

### A. Research and content map

Write real use cases: business homepage, services, portfolio, blog, article, contact, 404, search, and a long-form content page. Collect realistic Persian and English copy, long titles, empty states, menus, varied image shapes, and mobile content. Define the content hierarchy and calls to action before choosing layouts.

### B. Design system

Create a small token set: canvas/text/accent colors, spacing scale, content widths, type sizes, border radii, and motion durations. Design typography in Persian first, then English. Use licensed, locally hosted fonts; test numerals, punctuation, mixed LTR strings, email addresses, and long Persian words. Build with CSS logical properties (`margin-inline`, `padding-inline`, `inset-inline`, `border-inline`) and use `rtl.css` only for direction-specific refinements.

Specify desktop, tablet, and mobile layouts; keyboard/focus states; hover and touch behavior; reduced-motion behavior; and contrast. Design one component at a time in the same order as the implementation roadmap. Approve each component against real content before coding the next.

### C. Template system

Define one purpose per template: front page, blog index, archive/taxonomy, search, single post, normal page, 404, comments, and optional full-width page. Each needs an empty state and a no-Elementor fallback. Keep a shared header/footer and accessible skip target. Use `theme.json` for editor-facing tokens and the standalone dashboard for theme-specific structural controls.

## 4. Backend settings contract

Keep **one top-level UNDO Theme Settings page** with tabs, consistent save behavior, help text, keyboard access, Persian/English admin translations, and a link to documentation. Store only validated option keys; define defaults centrally; sanitize on save and escape on output. Saving one tab must not reset another. Add option schema version and migrations before changing stored keys. Make import/export and reset available only after the settings format stabilizes, with preview and confirmation for destructive reset.

| Tab | Customer controls | Dependencies / behavior |
| --- | --- | --- |
| Website layout, Colors, Typography | Site and page widths, boxed/wide layout; separate shared/component colors; built-in and uploaded font choices | WordPress Site Language sets the initial language; widths are bounded, colors are validated, and uploaded WOFF2 attachments are checked before use |
| Header | Logo, mobile logo if needed, height, sticky mode, menu, search, language switcher, action label/URL, mobile drawer | Hide dependent fields when their feature is off; Elementor header template replaces built-in header |
| Footer | Brand, menu columns, contact, legal/copyright text, social links, background style | Contact/social fields appear only when enabled; Elementor footer template wins |
| Blog/archive | Grid/list, columns, card image ratio, metadata, excerpt length, pagination | Responsive column limits; consistent search and taxonomy states |
| Single post | Title/meta, featured image, author, categories, sharing, previous/next, comments, sidebar | Comments follow WordPress discussion settings; addon handles functional sharing if added |
| Pages | Title mode, width, featured image, sidebar, breadcrumbs, full-width template | Elementor-built pages can choose a blank/full-width layout and must avoid duplicate titles |
| Sidebar | Placement, width, sticky mode, widget styling, context toggles | Never reserve empty space when no widgets are active; start/end mirror in RTL |
| Homepage | Section visibility/order and content references, hero copy/CTA, section navigation | Prefer normal WordPress content or Elementor templates over large content blobs in options |
| Advanced | Performance toggles with evidence, motion preference, custom CSS link, import/export, diagnostics | No arbitrary PHP/JS injection; hide experimental controls from customers |

Precedence rule: assigned Elementor Pro Theme Builder template → explicit page/template choice → global theme option → shipped default. Document exceptions. Avoid simultaneous conflicting controls in Elementor and the theme dashboard; show a notice when a built-in option is bypassed by an Elementor template.

## 5. Elementor integration and addon widgets

### Theme integration

Keep normal `the_content()` rendering so Elementor pages remain editable. Register supported Elementor Theme Builder locations and call `elementor_theme_do_location()` only where appropriate, with normal theme-template fallback. Test Elementor Free alone, Elementor Pro, and Elementor deactivated. Confirm header/footer are not duplicated, page titles do not double, and CSS does not override editor controls unexpectedly.

### Addon plugin structure

Use a separate `undo-elements` plugin with its own plugin header, text domain, version, license, minimum dependency checks, namespaced classes, assets, PO/MO files, changelog, and updater. Register widgets on `elementor/widgets/register`. A widget extends `\Elementor\Widget_Base`, defines stable widget IDs, content/style controls, server-side rendering, and script/style dependencies. Load assets only when that widget is used. Never trust widget control values: validate IDs and URLs, escape output, and use WordPress APIs for queries and media.

### First widget set

| Widget | Content controls | Style/behavior controls | Acceptance point |
| --- | --- | --- | --- |
| UNDO Hero | eyebrow, heading, copy, CTA, image/media | alignment, palette, responsive spacing | correct heading order and RTL CTA |
| Services list | manual items or selected service posts if plugin provides type | layout, icon/media, hover behavior | no empty card or broken wrap |
| Before/after | two images, labels, alt text | split start, handle style | keyboard-operable slider; reduced motion |
| Process timeline | repeatable steps | number style, spacing, orientation | readable long Persian text |
| Portfolio grid | selected posts/query, taxonomy | card ratio, columns, pagination | secure query, empty state, mobile layout |
| Project brief planner | questions and labels | presentation and download/submission mode | saved content independent of theme; consent if submitted |

Add more only when a use case cannot be handled well with Elementor's existing widgets. Each widget needs editor preview, frontend render, responsive and RTL checks, dynamic data policy, keyboard behavior, asset budget, and translation coverage. Store widget configuration in Elementor's page data; do not mirror it into global theme options.

## 6. Localization and RTL

- Write interface strings with one stable text domain per package. Generate POT, `fa_IR.po/.mo`, and `en_US.po/.mo`; fail the release build when a required Persian string is missing.
- The initial front-end language follows WordPress Site Language. An explicit Persian or English switcher choice persists for that visitor. Admin language follows the WordPress user/site locale.
- Do not treat the query/cookie switcher as a complete multilingual SEO solution. Choose translated content URLs, canonical/hreflang rules, sitemap behavior, cache variation, and Elementor template translation through a tested multilingual-content integration.
- Test `lang`, `dir`, `is_rtl()`, icons with direction, sliders, carousels, form fields, dates/numerals, and mixed Persian/English snippets.
- Use real Persian test content at every stage, not an end-of-project RTL pass.

## 7. Implementation order and exit gates

| Stage | Deliverable | Exit gate |
| --- | --- | --- |
| 0. Product contract | Decisions above, customer personas, supported-version matrix | Scope and distribution agreed |
| 1. Foundation audit | Validate current foundation on online WordPress staging, design tokens, and option schema | Fresh activation and no PHP warnings |
| 2. Header | Built-in desktop/mobile header and settings | Keyboard, Persian/English, RTL/LTR, Elementor fallback pass |
| 3. Single post | Built-in post design, metadata, comments, post navigation | Long-content and Theme Unit Test cases pass |
| 4. Pages | Standard, full-width, and Elementor page layouts | No duplicate titles; long and mixed-language content pass |
| 5. Sidebar | Widget area styles, placement, empty and sticky states | RTL mirroring and no empty reserved space |
| 6. Blog and archives | Blog, archive, search, taxonomy, 404, pagination | Empty and populated states pass |
| 7. Footer | Built-in footer and settings | No duplicate footer; flexible content and responsive pass |
| 8. Homepage | Editable sections and normal content model | No hardcoded demo claims; section motion cannot hijack other pages |
| 9. Elementor theme support | Page templates, locations, style isolation | Free, Pro, and absent-plugin matrix pass |
| 10. Addon plugin | First widget set and planner migration | Widgets survive theme updates; dependency failures handled |
| 11. Localization and polish | Full translations, content-plugin integration, RTL visual pass | Both languages complete at all supported sizes |
| 12. Release candidate | Demo import, docs, accessibility, performance, security and update tests | All release gates below pass |
| 13. Customer release | Reviewed tag, tested ZIPs, checksums, release notes | Installed old versions upgrade without data loss |

Build and review each stage independently; do not begin the next visual component while the current component has unresolved functional regressions.

## 8. Quality gates for a premium release

**Functional:** fresh install, activation/deactivation, settings save/reload and migration, all templates, search/404, comments, menus, widgets, Elementor editor/live preview, plugin missing and Pro missing paths, child theme overrides, old-to-new update, rollback.

**Compatibility:** chosen WordPress/PHP/Elementor versions; desktop Chrome/Firefox/Safari/Edge and mobile Safari/Chrome; common viewport widths; Persian/English and RTL/LTR; cache enabled and disabled.

**Accessibility:** semantic headings and landmarks, visible focus, full keyboard operation, labels, alt text, contrast, screen-reader names, reduced motion, no scroll traps. Set a WCAG 2.2 AA target and log any exception before release.

**Performance:** local fonts, responsive images, no unnecessary page-wide scripts, widget assets on demand, no layout shift from images/fonts, acceptable Core Web Vitals on representative pages. Set numeric budgets only after measuring a real staging baseline.

**Security and code quality:** PHP lint, WordPress Coding Standards/PHPCS, Theme Check, Plugin Check for addon, sanitization/escaping, nonces and capabilities for writes, no secrets in ZIPs, dependency and license review, error log clean. Use real WordPress runtime tests; parser-only validation does not satisfy this gate.

**Release integrity:** exact tested ZIP root/folder, version alignment, file list, SHA-256, translations, changelog, screenshot, readme, license, asset licenses, support contacts, and installed upgrade verification.

## 9. GitHub and customer update workflow

1. Maintain the connected `ashkankhalili/undo-theme` GitHub repository and preserve its history. Add the addon plugin as a separately installable package in the product source, or in a second repository if independent releases become necessary.
2. Protect the release branch and require code review plus CI checks. For the theme, CI builds the package from the validated `main` commit, then creates its tag and GitHub Release. Addon packaging will need its own release path. Do not use GitHub's generic source ZIP as a customer package.
3. Keep theme and addon versions explicit. A release record includes compatible WordPress/PHP/Elementor ranges, migrations, changelog, ZIP SHA-256, and rollback instructions.
4. The theme update channel is public GitHub Releases starting in 0.2.3. Keep its `Update URI`, package asset naming, and checksum check stable; test future versions through WordPress Updates. Decide customer-only eligibility separately. Keep credentials and signing keys out of distributed files.
5. Install the previous version on staging, enter customer-like settings/content, apply the update via WordPress's normal updater, then verify options, pages, widgets, Elementor documents, and license state remain intact.
6. Publish the exact tested assets, verify the GitHub tag, Action, release URLs, checksum, and downloaded ZIPs. Announce only after this read-back succeeds.

## 10. Current status and immediate next work

Implemented by 0.6.0: classic theme skeleton, theme.json, reading, wide, boxed, full and custom-width page templates, a full-width single-save settings page, Colors and per-role Typography controls with WOFF2 uploads and optional Google loading, pixel/percentage site width, three blog designs, physical sidebar placement/hiding, Persian/English catalogs, RTL CSS, Elementor Theme Builder location fallback, a packaged ZIP, GitHub Releases updater, configurable built-in header variants, single-post reading template, page controls, and a widget sidebar with Lined/Panel styles and optional sticky behavior. The four reusable page templates have independent width and spacing controls; Custom Width is set per page. The initial language follows WordPress Site Language. The dark-header logo fallback and static-header homepage section alignment were corrected after staging QA. These are a foundation, not a finished premium product.

Outstanding: live WordPress/Elementor and dashboard-update validation; complete header/footer/content design; Elementor widget plugin; migration of project planner functionality; multilingual-content integration; broader accessibility/performance/security checks.

**Current execution milestone:** install 0.8.0 from WordPress Updates. Validate the three optional footer widget areas and import the Home, Header, Footer, and Blog Archive Elementor starters on staging using the [Elementor starter guide](ELEMENTOR_STARTERS.md). Record Elementor Free/Pro versions, RTL/LTR behavior, and native fallbacks. Recheck the 0.7.0 footer and earlier layout, blog page, typography, header, sidebar, and page controls before marking stages complete.

## Primary references

- [WordPress Theme Handbook](https://developer.wordpress.org/themes/) and [required classic theme files](https://developer.wordpress.org/themes/releasing-your-theme/required-theme-files/)
- [WordPress Settings API](https://developer.wordpress.org/apis/settings/) and [theme.json](https://developer.wordpress.org/themes/global-settings-and-styles/introduction-to-theme-json/)
- [Theme testing](https://developer.wordpress.org/themes/releasing-your-theme/testing/) and [release guidance](https://developer.wordpress.org/themes/releasing-your-theme/)
- [Theme internationalization](https://developer.wordpress.org/themes/classic-themes/functionality/internationalization/) and [security](https://developer.wordpress.org/apis/security/)
- [Elementor Theme Builder locations](https://developers.elementor.com/docs/themes/registering-locations/) and [displaying locations](https://developers.elementor.com/theme-locations-api/displaying-locations/)
- [Elementor widget structure](https://developers.elementor.com/docs/widgets/widget-structure), [registration](https://developers.elementor.com/docs/widgets/add-new-widget), [controls](https://developers.elementor.com/docs/editor-controls/using-controls), and [conditional dependencies](https://developers.elementor.com/docs/widgets/widget-dependencies)
