# Elementor starter templates

For template precedence, page width behavior, and Free/Pro/disabled-plugin checks, see [Elementor compatibility](ELEMENTOR_COMPATIBILITY.md).

Version 0.13.1 ships ten editable Elementor JSON templates in `undo-theme/elementor-templates/`: Home, Blog Page, Header, Footer, and Blog Archive in English and Persian. The Home starters follow the native section order and anchors: Hero, Overview, Services, Approach, Redesign and Project Planner. When Elementor Free or Pro is active, the theme creates four published Home and Blog pages from the page starters on the first administrator load. It marks them as UNDO starters and stores their IDs so later loads and theme updates never rewrite them. Existing pages and **Settings → Reading** choices remain untouched. If Elementor is absent, no pages are created and the native Home and blog remain.

## Which Elementor edition is needed?

| Site part | Elementor Free | Elementor Pro |
| --- | --- | --- |
| Home page | Created automatically; `home-en.json` and `home-fa.json` remain available for manual import | Also works |
| Header | Built-in UNDO header remains | Import `header-*.json` into Theme Builder > Header; assign display conditions |
| Footer | Built-in UNDO footer and footer widget areas remain | Import `footer-*.json` into Theme Builder > Footer; assign display conditions |
| Blog page | Created automatically with a live `[undo_blog_posts]` listing | Also works; an optional `blog-archive-*.json` Theme Builder archive can replace it |

The `nav-menu` and `archive-posts` elements in the site-part starters use Elementor Pro. WordPress normally ignores the body of a page selected as the Posts page; UNDO renders its Elementor document there when Elementor is active. The Free Blog Page starter includes `[undo_blog_posts]` so new posts and pagination remain automatic. An Elementor Pro Archive template takes precedence when its display condition matches. The header starter's Nav Menu widget needs the customer's WordPress menu selected in Elementor after import.

## Install and assign

1. After activation or update, open WordPress admin once with Elementor active. Find the four published **UNDO Home** and **UNDO Blog** pages under **Pages**. Edit the matching language pair in Elementor. They are also included as `home-*.json` and `blog-page-*.json` files for manual import. Existing pages with similar titles are not altered.
2. Under **Settings → Reading**, choose **A static page**, then select one generated Home as **Homepage** and the corresponding Blog as **Posts page**. This is an explicit site-owner choice; the theme does not change it automatically. The Home includes a working project planner shortcode, including the native planner fallback when UNDO Elements is not installed. Test the project button's `#project-planner` target. The Blog includes the live post listing shortcode; keep it in the Elementor layout unless another listing is provided.
3. For Header, Footer, and Blog Archive, use **Elementor Pro → Theme Builder → Import** to add the corresponding JSON file. Review each imported widget, choose the header's WordPress menu, and set **Display Conditions** before publishing. Use **Entire Site** for a header/footer only when it should replace the built-in part everywhere. Use the posts archive condition for the blog starter. Check the front end after each assignment for a single header and footer.
4. In **Appearance → Widgets**, add blocks to Footer widget areas 1–3. They appear in the built-in footer automatically when enabled under **UNDO Theme Settings → Footer → Widget areas**. The Pro footer starter includes `[undo_footer_widgets]` so those same areas can appear when its footer template replaces the built-in footer. Remove that Shortcode widget in Elementor if you want an Elementor-only footer.

## Language and update behavior

The theme's language switcher translates theme strings and changes direction. It does **not** translate Elementor-authored page content by itself. The English/Persian starter pairs contain separately authored copy. If Polylang is configured with both languages when the pages are created, UNDO assigns and links each pair; if Polylang is configured later, it links them on a later admin load. Configure the language-specific front pages and Elementor template conditions using [the content translation workflow](CONTENT_TRANSLATION.md). Without a content translation plugin, WordPress Reading can select only one Home/Blog pair at a time.

The starter JSON files are versioned in GitHub with the theme. Updating the theme changes the bundled examples and CSS, but it does not rewrite created or imported Elementor documents or display conditions. Deleting a generated page does not make the theme recreate it; manually import the bundled JSON if needed. The built-in header, footer, landing page, and blog archive continue to work without Elementor Pro or with Elementor disabled.

## Staging acceptance check

Test each imported file in the currently installed Elementor version. Verify editor load, preview, responsive widths, RTL/LTR, menu selection, dynamic blog listing and pagination, footer widget shortcode, and display conditions. Then deactivate Elementor Pro and Elementor Free separately to confirm the built-in fallbacks return. Record the installed plugin versions and results in `docs/staging-reports/` before calling the integration production ready.
