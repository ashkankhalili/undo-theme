# 0.3.2 Elementor Full Width follow-up

Elementor's Full Width template calls `the_content()` directly between the theme header and footer. If a page has ordinary WordPress content and was never built with Elementor, there is no Elementor content wrapper to receive the 0.3.1 height rule. This is consistent with the owner's third screenshot, where a short page put the footer close to the content.

Version 0.3.2 gives the Full Width page body a viewport-height flex column and pushes the theme or Elementor Pro footer to the bottom. The existing content-wrapper height rule remains for pages actually built in Elementor. Elementor Canvas remains under Elementor's control.

Local browser fixture results: with a plain WordPress paragraph in Elementor Full Width, the footer began at y=700 in a 1440×900 viewport and at y=644 in a 390×844 RTL viewport, ending exactly at each viewport bottom. Neither case had horizontal overflow. With an Elementor-built wrapper at 1440×900, the wrapper height floor placed the footer below the viewport. After updating staging through WordPress, repeat both cases on real pages and record screenshots and version details before closing Stage 4.
