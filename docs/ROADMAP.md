# UNDO premium theme implementation roadmap

Each stage is complete only after template behavior, Persian and English copy, RTL/LTR, responsive design, keyboard access, Elementor fallback, and staging checks pass. Update the changelog at every stage. See [PREMIUM_THEME_BLUEPRINT.md](PREMIUM_THEME_BLUEPRINT.md) for the full product architecture and release gates.

| Stage | Scope | Current status |
| --- | --- | --- |
| 0. Source and online staging | GitHub repository, CI and release checks, exact ZIP install and online update test | 0.2.3 bootstrap, 0.2.4 discovery, 0.2.6 details popup, and 0.2.9 installation confirmed by owner; full settings and template matrix pending |
| 1. Foundation | WordPress Site Language baseline, Persian/English switcher, RTL CSS, standalone settings dashboard, template hooks, translations | 0.5.0 adds a single-save settings workspace; 0.6.0 adds pixel/percentage width, detailed typography and Google loading control; staging validation pending |
| 2. Header | Logo variants, navigation hierarchy, mobile menu, search and action options, Elementor header fallback | Implemented in 0.2.6; dark-logo contrast fixed in 0.2.8; static-header section correction in 0.2.9 confirmed by owner; dedicated light logo and Elementor staging checks pending |
| 3. Single post | Metadata, featured media, typography, related/navigation, comments and sidebar | Implemented in 0.2.7; live RTL/LTR post, featured media, metadata, excerpt, content blocks, navigation, comments area and sidebar rendered; related/settings, comment submission and Elementor checks pending |
| 4. Pages | Reading, wide, boxed, full and custom-width templates, breadcrumbs, title modes, Elementor compatibility | 0.3.0 exposed a width bug on staging; 0.3.1 and 0.3.2 fixed the page-width cases; 0.3.3 adds per-template width/spacing controls and the conditional per-page Custom Width panel; live retest pending |
| 5. Sidebar | Widget spacing, sticky behavior, layout modes, RTL placement | 0.6.0 adds physical Left/Right/Hidden while mapping earlier logical choices; live widget and RTL checks pending |
| 6. Blog | Archive cards, pagination, taxonomy/search states and empty states | Three list/grid designs implemented in 0.6.0; live archive, search, RTL, and Elementor checks pending |
| 7. Footer | Menu columns, contact blocks, legal text, social links and optional widget areas | 0.7.0 built the footer; 0.8.0 adds three responsive widget areas and a Theme Settings toggle; live staging validation pending |
| 8. Homepage | Editable sections, content model, accessible motion, Elementor starter layout | 0.9.0 adds native section order, visibility and published-page references; 0.8.0 ships editable English/Persian Elementor Home starters; live staging and import validation remain |
| 9. Elementor integration | Elementor Free/Pro/absent-plugin scenarios, page templates and location fallbacks | 0.10.0 guards disabled-plugin pages, scopes native landing styles, adds Free/Pro/absent routing checks and a compatibility guide; live import and fallback matrix pending |
| 10. UNDO Elements addon | Separate plugin, first Elementor widget set, planner migration | 0.11.0 theme and 0.1.0 addon add three widgets, a reusable browser-only planner, fallback routing, translations and independent ZIP updates; live Elementor and updater validation pending |
| 11. Localization and polish | Content translation integration, complete RTL/LTR visual pass | Planned |
| 12. Release candidate | Theme Check, Plugin Check, WPCS, accessibility, browser matrix, asset licensing, staging install/upgrade | Pending |
| 13. Customer release | GitHub tag, exact tested theme/addon ZIPs, checksums, release notes, customer update test | Pending |

The source repository is `ashkankhalili/undo-theme`; the canonical theme folder is `undo-theme`. Version 0.2.3 adds a public GitHub Releases update endpoint. License-gated downloads and customer support policy remain open decisions. See [GITHUB_UPDATES.md](GITHUB_UPDATES.md).
