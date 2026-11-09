# 0.3.1 page layout correction: pre-release check

Date: 2026-11-09. Staging: `https://ashkankhalili.ir`. The owner installed 0.3.0 and supplied three screenshots comparing a default page, UNDO Full Width, and Elementor Full Width. The first two showed nearly identical narrow content, while Elementor's own template stretched content to the viewport and put the footer immediately after a short page.

## Cause and correction

- The full-width page wrapper lost its limit, but a descendant rule still capped paragraph and other ordinary content at 760px. The 0.3.1 styles remove that limit and give each page mode its own measurable width.
- Elementor-built content in an UNDO template previously bypassed the page width wrapper. It now uses the selected UNDO layout without duplicate page title or sidebar.
- Elementor's built-in Full Width template bypasses the theme page renderer. A theme stylesheet rule gives its content a viewport-height floor while preserving Elementor's own full-width sections and header/footer choice.
- Explicit UNDO templates on a static front page now take precedence over the built-in landing renderer.

## Local browser evidence

At a 1440px browser viewport, the content widths measured 760px (Reading), 1100px (Boxed), full viewport with page gutters (Full Width), 960px (Custom Width in pixels), and 80% of the viewport (Custom Width in percent). Elementor content inside an UNDO Wide template followed the wide wrapper. At a 390px RTL viewport, Full Width produced no horizontal overflow. This is local fixture evidence; the online theme requires the 0.3.1 dashboard upgrade and direct retest.

## Live staging checklist after update

1. Open **Dashboard → Updates**, inspect the bilingual 0.3.1 release notes, and update without uploading a ZIP. Confirm version 0.3.1 under Appearance → Themes.
2. On the owner's existing test page, compare Default, UNDO Reading, UNDO Wide, UNDO Boxed, UNDO Full Width, and UNDO Custom Width. Save and reload both the global Pages setting and the page editor custom width.
3. Edit a page with Elementor. Check an UNDO template, Elementor Full Width, and Elementor Canvas. Check a short Elementor Full Width page for footer placement.
4. Repeat at phone and desktop widths in Persian and English. Verify RTL, no horizontal overflow, and that a selected template on the static front page works.

Stage 4 remains pending until live staging results are recorded.
