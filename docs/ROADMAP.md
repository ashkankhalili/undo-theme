# UNDO premium theme implementation roadmap

Each stage is complete only after template behavior, Persian and English copy, RTL/LTR, responsive design, keyboard access, Elementor fallback, and staging checks pass. Update the changelog at every stage. See [PREMIUM_THEME_BLUEPRINT.md](PREMIUM_THEME_BLUEPRINT.md) for the full product architecture and release gates.

| Stage | Scope | Current status |
| --- | --- | --- |
| 0. Source and online staging | GitHub repository, CI package checks, exact ZIP install and online test record | In progress; see [STAGING_MILESTONE.md](STAGING_MILESTONE.md) |
| 1. Foundation | Persian default, language switcher, RTL CSS, standalone settings dashboard, template hooks, translations | Implemented locally in 0.2.1; staging validation pending |
| 2. Header | Logo variants, navigation hierarchy, mobile menu, search and action options, Elementor header fallback | Next |
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

The source repository is `ashkankhalili/undo-theme`. Customer release visibility, distribution policy, and update endpoint remain open decisions. No automatic updater is claimed in 0.2.1.
