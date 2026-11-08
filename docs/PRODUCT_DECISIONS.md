# UNDO premium theme product decisions

Use this log before changing product scope. "Confirmed" comes from the user's instructions; "Working assumption" is a planning default that can be changed; "Open" needs a decision before release. Never treat a working assumption as a published policy.

| Topic | Status | Current direction | Decision gate |
| --- | --- | --- | --- |
| Product identity | Confirmed | UNDO Web Developments premium customer theme | Keep theme folder/text domain stable |
| Theme slug | Confirmed | `undo-theme` for folder, text domain, and installable ZIP root | Preserve for all customer updates |
| Source repository | Confirmed | Public `ashkankhalili/undo-theme` repository supplied by owner | Keep credentials and customer data out of source |
| Online staging | Confirmed | `https://ashkankhalili.ir` is owner-designated WordPress and Elementor test site | Confirm exact installed ZIP and environment versions |
| Primary language | Confirmed | Persian/fa_IR first; English/en_US fully supported | Verify frontend, admin translation, RTL/LTR |
| Theme settings | Confirmed | One standalone UNDO Theme Settings dashboard with component tabs | Validate settings persistence and Elementor precedence |
| Elementor | Confirmed | Theme-compatible plus UNDO-specific widgets/addons | Build widget code as a separate installable plugin |
| Theme architecture | Working assumption | Keep current classic PHP theme with theme.json design tokens | Revisit only if a proven Site Editor need appears |
| Package architecture | Working assumption | Parent theme and `undo-elements` addon are separate ZIPs | Verify independent install/update/rollback |
| Elementor Pro | Working assumption | Optional for Theme Builder; Elementor Free baseline for addon widgets | Test both modes |
| Sales channel | Working assumption | Sell from UNDO's own site first | Confirm storefront, support and refund terms |
| WordPress.org listing | Open | Possible later, not part of first commercial release | Review directory rules and move planner out of theme |
| WordPress/PHP/Elementor versions | Open | Current theme header is provisional | Set support matrix after live compatibility tests |
| Multilingual content system | Open | Use a compatible content translation plugin | Choose and test translated URLs, templates, menus, SEO, cache |
| Customer updates | Confirmed | Public GitHub Release ZIPs appear in WordPress Updates from theme version 0.2.3; an admin installs them | Verify 0.2.3-to-0.2.4 on staging; license-gated downloads remain open |
| Licensing | Open | Never disable customer content or rendering on license expiry | Define update/support eligibility and renewal terms |
| Demo import | Working assumption | One Persian demo with an English counterpart; reversible import | Confirm licensed assets and import behavior |
| Planner data | Open | Move planner to addon; browser-only by default | Choose optional submission/storage/consent design |
| Accessibility target | Working assumption | WCAG 2.2 AA for shipped UI | Audit and record any exception before release |

The full technical plan is in [PREMIUM_THEME_BLUEPRINT.md](PREMIUM_THEME_BLUEPRINT.md). Update this log whenever a decision changes, then revise the roadmap and release documentation as needed.
