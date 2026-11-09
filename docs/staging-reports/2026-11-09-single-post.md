# Single-post staging read-back — 2026-11-09

Site: `https://ashkankhalili.ir`. The owner reported installing 0.2.7 through the WordPress dashboard. The public theme stylesheet returned HTTP 200 with `Version: 0.2.7` and the expanded theme description.

The connected WordPress site showed one published standard post (ID 6082) using the default WordPress post template, not Elementor. Its public page returned HTTP 200 and included the `single-article`, `single-header`, `single-body`, date, featured media, comments area, and sidebar markup. Persian output used `lang="fa-IR" dir="rtl"`. The same page in English visitor mode used the English interface and LTR layout; the post body remained Persian because the theme's switcher does not translate user content.

Headless Chrome rendered the page at 390 CSS pixels and 1440 CSS pixels. Document widths were 390/390 and 1425/1440 respectively, so no horizontal overflow was observed. The post title, image/caption, body, and sidebar were visually inspected. A separate light logo was not configured on the live dark header; its existing primary logo was nearly invisible. A temporary browser preview of a white-silhouette fallback restored visible contrast. Version 0.2.8 implements that fallback in the theme and needs an installed-site recheck.

Not yet tested: dependent related-post count setting, related card results, previous/next links (only one published post), saving single-post settings, comment submission, Elementor single template replacement, and a long bilingual post with a table and block quote. Do not mark Stage 3 complete until these pass.
