# Single-post staging read-back — 2026-11-09

Site: `https://ashkankhalili.ir`. The owner reported installing 0.2.7 through the WordPress dashboard. The public theme stylesheet returned HTTP 200 with `Version: 0.2.7` and the expanded theme description.

The connected WordPress site showed one published standard post (ID 6082) using the default WordPress post template, not Elementor. Its public page returned HTTP 200 and included the `single-article`, `single-header`, `single-body`, date, featured media, comments area, and sidebar markup. Persian output used `lang="fa-IR" dir="rtl"`. The same page in English visitor mode used the English interface and LTR layout; the post body remained Persian because the theme's switcher does not translate user content.

Headless Chrome rendered the page at 390 CSS pixels and 1440 CSS pixels. Document widths were 390/390 and 1425/1440 respectively, so no horizontal overflow was observed. The post title, image/caption, body, and sidebar were visually inspected. A separate light logo was not configured on the live dark header; its existing primary logo was nearly invisible. A temporary browser preview of a white-silhouette fallback restored visible contrast. Version 0.2.8 implements that fallback in the theme and needs an installed-site recheck.

After the first read-back, a temporary staging post (ID 6102) was created with a manual excerpt, mixed Persian/English heading, block quote, and table. It was briefly published so the theme could be inspected through a public URL, then returned to draft. Public checks in Persian and English returned HTTP 200 while published, rendered the manual excerpt and content blocks, and displayed previous/next navigation. The English visitor interface used `lang="en-US"` and the browser's default LTR direction. A cache-busted public request after unpublishing returned HTTP 404. The draft remains available for later controlled tests.

Not yet tested: dependent related-post count setting, related card results, saving single-post settings, comment submission, Elementor single template replacement, and a long translated English post. Do not mark Stage 3 complete until these pass.
