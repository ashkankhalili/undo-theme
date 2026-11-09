# 0.4.0 sidebar pre-release check

Target: `https://ashkankhalili.ir`. This records local source and browser checks before the owner installs 0.4.0. It does not establish live WordPress or Elementor behavior.

## Local browser checks

The fixture used the theme CSS and JavaScript with representative widgets and long article content.

| Case | Result |
| --- | --- |
| LTR, sidebar at logical end, 1440 × 900 | Sidebar rendered at x=1077 with a 300px width; no horizontal overflow |
| RTL, sidebar at logical start, 1440 × 900 | Sidebar rendered at x=1077 on the physical right; logical placement mirrored as intended |
| Panel style in RTL, 390 × 844 | Sidebar followed the main content, used a 350px content width, and had no horizontal overflow; sticky mode was inactive |
| Short sidebar with sticky header, after 650px scroll | Inner sidebar top was 100px: 76px header plus 24px configured gap |
| Short sidebar with static header, after 650px scroll | Inner sidebar top was 24px, without a stale header offset |
| Simulated logged-in admin bar with sticky header, after 650px scroll | Header bottom was 108px and inner sidebar top was 132px, preserving the 24px gap |
| Tall widget area, after 650px scroll | `is-sticky-fit` was false; content stayed in normal page flow |

The screenshots and fixture are local ignored QA files in `dist/`. The source checks in `tests/sidebar.php` cover empty and populated output; `tests/header-settings.php` checks defaults, sanitization, and preservation of settings in other sections. GitHub CI runs PHP tests on 7.4 and 8.3, JavaScript syntax, translations, and package integrity.

## Staging acceptance still needed

After updating through **Dashboard → Updates**, record the installed version and run [staging rows 19–20](../STAGING_MILESTONE.md) with real classic and block widgets. Also retest the 0.3.3 page controls if that version was not installed separately. Record pass/fail evidence and PHP/browser errors before any customer release.
