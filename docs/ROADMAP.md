# UNDO premium theme implementation roadmap

Each stage is complete only after template behavior, Persian and English copy, RTL/LTR, responsive design, keyboard access, Elementor fallback, and staging checks pass. Update the changelog at every stage. See [PREMIUM_THEME_BLUEPRINT.md](PREMIUM_THEME_BLUEPRINT.md) for the full product architecture and release gates.

| Stage | Scope | Current status |
| --- | --- | --- |
| 0. Source and online staging | GitHub repository, CI and release checks, exact ZIP install and online update test | 0.2.3 bootstrap, 0.2.4 discovery, 0.2.6 details popup, and 0.2.9 installation confirmed by owner; full settings and template matrix pending |
| 1. Foundation | WordPress Site Language baseline, Persian/English switcher, RTL CSS, standalone settings dashboard, template hooks, translations | Initial Site Language behavior and vertical settings navigation refined in 0.3.3; 0.5.0 adds the full-width, single-save settings workspace, separate Colors and Typography sections, and custom WOFF2 font assignments; staging validation pending |
| 2. Header | Logo variants, navigation hierarchy, mobile menu, search and action options, Elementor header fallback | Implemented in 0.2.6; dark-logo contrast fixed in 0.2.8; static-header section correction in 0.2.9 confirmed by owner; dedicated light logo and Elementor staging checks pending |
| 3. Single post | Metadata, featured media, typography, related/navigation, comments and sidebar | Implemented in 0.2.7; live RTL/LTR post, featured media, metadata, excerpt, content blocks, navigation, comments area and sidebar rendered; related/settings, comment submission and Elementor checks pending |
| 4. Pages | Reading, wide, boxed, full and custom-width templates, breadcrumbs, title modes, Elementor compatibility | 0.3.0 exposed a width bug on staging; 0.3.1 and 0.3.2 fixed the page-width cases; 0.3.3 adds per-template width/spacing controls and the conditional per-page Custom Width panel; live retest pending |
| 5. Sidebar | Widget spacing, sticky behavior, layout modes, RTL placement | Implemented in 0.4.0 with Lined/Panel styles and viewport-fit sticky behavior; live widget, RTL, and Elementor checks pending |
| 6. Blog | Archive cards, pagination, taxonomy/search states and empty states | Basic controls implemented; visual design next |
| 7. Footer | Menu columns, contact blocks, legal text and social links | Basic controls implemented; visual design next |
| 8. Homepage | Editable sections, content model, accessible motion, Elementor starter layout | Existing landing page; configurable sections next |
| 9. Elementor integration | Elementor Free/Pro/absent-plugin scenarios, page templates and location fallbacks | Basic location hooks implemented; matrix pending |
| 10. UNDO Elements addon | Separate plugin, first Elementor widget set, planner migration | Planned |
| 11. Localization and polish | Content translation integration, complete RTL/LTR visual pass | Planned |
| 12. Release candidate | Theme Check, Plugin Check, WPCS, accessibility, browser matrix, asset licensing, staging install/upgrade | Pending |
| 13. Customer release | GitHub tag, exact tested theme/addon ZIPs, checksums, release notes, customer update test | Pending |

The source repository is `ashkankhalili/undo-theme`; the canonical theme folder is `undo-theme`. Version 0.2.3 adds a public GitHub Releases update endpoint. License-gated downloads and customer support policy remain open decisions. See [GITHUB_UPDATES.md](GITHUB_UPDATES.md).
