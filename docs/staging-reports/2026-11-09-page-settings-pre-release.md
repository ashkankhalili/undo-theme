# 0.3.3 page settings pre-release check

Target: `https://ashkankhalili.ir`. This report records local code and browser checks before the owner installs 0.3.3. It is not evidence of a live WordPress upgrade or an Elementor editor session.

## Scope

- Four reusable page templates have independent width, minimum side margin, vertical margins, and padding values in the standalone Pages settings section. UNDO Custom Width remains a per-page value.
- The settings page uses a vertical navigation sidebar. The WordPress page editor shows the Custom Width panel below the content editor only for the matching page template.
- WordPress Site Language supplies the initial frontend language. An explicit visitor switcher selection persists in the existing cookie.

## Local browser checks

| Case | Result |
| --- | --- |
| Reading at 1440 × 900 | 760px layout width |
| Wide with 80% width, 32px side margin and 64px top padding | 1140px layout width; content begins 64px below the 76px header |
| Boxed in RTL at 1440 × 900 | 1100px layout width; 970px content width after 64px side padding and borders |
| Full Width in RTL at 390 × 844 | 390px layout width, 350px content width after mobile side padding; no horizontal overflow |
| Editor panel | Hidden for Default; shown when UNDO Custom Width is selected |
| Theme Settings in RTL | Vertical navigation appears on the right at desktop width and stacks above the form at 390px without horizontal overflow |

The browser checks used local HTML fixtures and the theme CSS/JavaScript. The PHP behavior checks are in `tests/header-settings.php` and `tests/page-layout.php`; GitHub CI runs them on PHP 7.4 and 8.3. The release workflow verifies the exact ZIP and checksum.

## Staging acceptance still needed

After the owner updates through **Dashboard → Updates**, record the installed theme version and retest the [staging sequence](../STAGING_MILESTONE.md), especially settings persistence, the block editor and Classic Editor template selector, Elementor-built pages under UNDO templates, both site languages and visitor overrides, and narrow RTL screens. Record pass/fail evidence here before customer release.
