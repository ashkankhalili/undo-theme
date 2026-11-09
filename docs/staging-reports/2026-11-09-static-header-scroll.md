# Static-header section alignment — 2026-11-09

Site: `https://ashkankhalili.ir`. The public stylesheet served 0.2.8. The owner reported that disabling **Sticky header** left a strip of the previous homepage section visible above the active section. The theme's saved setting changed during inspection, so the browser test applied the same `undo-header-static` body class to the live homepage without altering WordPress settings.

## Reproduction

At a 1440 × 900 CSS-pixel viewport, the static header was 76px high. The existing guided navigation subtracted that height even though the header had scrolled away. After navigation, the overview and services sections began at viewport `top: 76px` and each had `height: 824px`. The visible 76px strip exactly matched the reported issue.

## Correction preview

The preview removed the navigation offset when the header's computed position was `relative` and gave later sections and the footer `min-height: 100svh` in static-header mode. The first hero retained `100svh - header height` so the initial screen still includes the header.

| Mode | Viewport | Header | Focused section top | Section height |
| --- | ---: | ---: | ---: | ---: |
| Static, before | 1440 × 900 | 76px | 76px | 824px |
| Static, corrected | 1440 × 900 | 76px | 0px | 900px |
| Static, corrected RTL mobile | 390 × 844 | 66px | 0px | 844px |
| Sticky, corrected | 1440 × 900 | 76px | 76px | 824px |

The preview used the live markup and styles with only the proposed CSS and navigation calculation injected in Chrome. Version 0.2.9 contains those source changes. Once installed, repeat wheel, keyboard, and left-side rail navigation with both header settings; check ordinary pages still scroll freely and no section overlaps at narrow widths.
