# UNDO premium theme implementation roadmap

Each stage is complete only after template behavior, Persian and English copy, RTL/LTR, responsive design, keyboard access, Elementor fallback, and staging checks pass. Update the changelog at every stage. See [PREMIUM_THEME_BLUEPRINT.md](PREMIUM_THEME_BLUEPRINT.md) for the full product architecture and release gates.

| Stage | Scope | Current status |
| --- | --- | --- |
| 0. Source and online staging | GitHub repository, CI and release checks, exact ZIP install and online update test | 0.2.3 bootstrap, 0.2.4 discovery, and public 0.2.5 installation verified; 0.2.6 details popup and update require live testing |
| 1. Foundation | Persian default, language switcher, RTL CSS, standalone settings dashboard, template hooks, translations | Implemented in 0.2.5; full staging validation pending |
| 2. Header | Logo variants, navigation hierarchy, mobile menu, search and action options, Elementor header fallback | Implemented in 0.2.6; RTL/LTR, mobile, keyboard, settings, and Elementor staging checks pending |
| 3. Single post | Metadata, featured media, typography, related/navigation, comments and sidebar | Basic controls implemented; visual design next |
| 4. Pages | Standard and full-width templates, breadcrumbs, title modes, Elementor canvas compatibility | Basic controls implemented; visual design next |
| 5. Sidebar | Widget spacing, sticky behavior, layout modes, RTL placement | Basic widget area implemented; visual design next |
| 6. Blog | Archive cards, pagination, taxonomy/search states and empty states | Basic controls implemented; visual design next |
| 7. Footer | Menu columns, contact blocks, legal text and social links | Basic controls implemented; visual design next |
| 8. Homepage | Editable sections, content model, accessible motion, Elementor starter layout | Existing landing page; configurable sections next |
| 9. Elementor integration | Elementor Free/Pro/absent-plugin scenarios, page templates and location fallbacks | Basic location hooks implemented; matrix pending |
| 10. UNDO Elements addon | Separate plugin, first Elementor widget set, planner migration | Planned |
| 11. Localization and polish | Content translation integration, complete RTL/LTR visual pass | Planned |
| 12. Release candidate | Theme Check, Plugin Check, WPCS, accessibility, browser matrix, asset licensing, staging install/upgrade | Pending |
| 13. Customer release | GitHub tag, exact tested theme/addon ZIPs, checksums, release notes, customer update test | Pending |

The source repository is `ashkankhalili/undo-theme`; the canonical theme folder is `undo-theme`. Version 0.2.3 adds a public GitHub Releases update endpoint. License-gated downloads and customer support policy remain open decisions. See [GITHUB_UPDATES.md](GITHUB_UPDATES.md).
