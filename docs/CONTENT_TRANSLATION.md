# English and Persian content workflow

Theme 0.12.0 includes an **optional** Polylang bridge. Without Polylang, the initial language follows **Settings → General → Site Language**, and the existing UNDO header switcher changes theme interface strings. Customer-authored pages, posts, menus and Elementor templates require separately authored translations. No translation plugin is installed by this theme.

## Prepare staging

1. Confirm the installed theme is 0.12.0 and UNDO Elements is 0.1.1. Back up the staging database and files before assigning languages to existing content.
2. Install and configure Polylang with English and Persian; set the desired default in Polylang. Assign a language to existing pages, posts, categories, tags, and menus. Link translations in the WordPress editor. See [Polylang's page and post guide](https://polylang.pro/documentation/support/getting-started/translating-pages-posts-categories-and-tags/).
3. Create and link published Home pages in both languages and use Polylang's language-specific front-page settings. Translate the navigation menu and set the language-specific menu locations.
4. For Elementor-built pages, install the Polylang Connect for Elementor integration described in [Polylang's Elementor guide](https://polylang.pro/how-to-translate-elementor-with-polylang/). Elementor Pro is needed to translate Theme Builder header/footer/archive templates. The theme still provides native template fallbacks when a Pro location is unavailable.
5. In **UNDO Theme Settings → Homepage**, assign relevant published pages for each language. If one assignment points to a linked Polylang translation, UNDO resolves the corresponding page for the current language. A missing translation shows the built-in section text.

## Behavior to verify

- Open a translated page in Persian; its header switcher must lead to the English translation, and back. When a translation is absent, it must lead to that language's Home. If a language has not been configured, the header switcher is hidden.
- Brand, breadcrumb Home, footer wordmark, fallback navigation and cross-page section buttons must lead to the current language's Home. Anchor links on the Home page remain local.
- English and Persian pages, posts, menus, widgets and Elementor templates must show the intended text and direction. Confirm Elementor's page width and theme page-template precedence separately.
- The UNDO Elements project planner must download a brief in the content language. Test Persian and English input, including mixed Latin/Persian names, long words, keyboard focus, and a 320px phone viewport.
- Confirm the public and logged-out URLs after clearing page, object and CDN caches. Check canonical/hreflang output using the installed SEO and translation plugins; UNDO does not generate SEO language tags itself.
- With Polylang disabled, confirm the Site Language baseline and UNDO visitor switcher still work. With the addon disabled, confirm the native Home planner returns.

Record the URL, installed versions, pass/fail evidence and screenshots in a dated `docs/staging-reports/` file. The local isolated PHP tests and static visual harness do not prove the live Elementor editor or cache behavior.

The bridge uses Polylang's documented `pll_current_language`, `pll_the_languages`, `pll_home_url` and `pll_get_post` APIs. See the [function reference](https://polylang.pro/documentation/support/developers/function-reference/).
