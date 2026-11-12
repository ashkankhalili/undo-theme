# Elementor starter templates

For template precedence, page width behavior, and Free/Pro/disabled-plugin checks, see [Elementor compatibility](ELEMENTOR_COMPATIBILITY.md).

Version 0.8.0 ships eight editable Elementor JSON templates in `undo-theme/elementor-templates/`: Home, Header, Footer, and Blog Archive, each in English and Persian. They are **starter content**. A theme update never imports or overwrites a customer's pages or Elementor templates. The existing PHP templates remain the live defaults until the site owner assigns a replacement.

## Which Elementor edition is needed?

| Site part | Elementor Free | Elementor Pro |
| --- | --- | --- |
| Home page | Import `home-en.json` or `home-fa.json` into a normal page | Also works |
| Header | Built-in UNDO header remains | Import `header-*.json` into Theme Builder > Header; assign display conditions |
| Footer | Built-in UNDO footer and footer widget areas remain | Import `footer-*.json` into Theme Builder > Footer; assign display conditions |
| Blog page | Built-in archive uses the Blog settings | Import `blog-archive-*.json` into Theme Builder > Archive; assign the Posts Archive condition |

The `nav-menu` and `archive-posts` elements in the site-part starters use Elementor Pro. A posts page selected in WordPress Reading is an archive; its own page body is not the post listing template. The archive starter uses Elementor's dynamic Archive Posts widget so new posts and pagination remain automatic. The header starter's Nav Menu widget needs the customer's WordPress menu selected in Elementor after import.

## Install and assign

1. Extract the **current theme ZIP** locally and open `undo-theme/elementor-templates/`. Pick the English or Persian file matching the page or site part you are building. Keep a backup of the current site and test imports on staging first.
2. For Home, create or edit a WordPress page with Elementor. In Elementor's Template Library, upload the `home-*.json` file and insert it. Set the page template to **Elementor Full Width** or **UNDO Full Width** if you want the theme header/footer around the editable page. Publish the page and choose it under **Settings → Reading → Your homepage displays → A static page**. Check the project button's `#project-planner` target after editing.
3. For Header, Footer, and Blog Archive, use **Elementor Pro → Theme Builder → Import** to add the corresponding JSON file. Review each imported widget, choose the header's WordPress menu, and set **Display Conditions** before publishing. Use **Entire Site** for a header/footer only when it should replace the built-in part everywhere. Use the posts archive condition for the blog starter. Check the front end after each assignment for a single header and footer.
4. In **Appearance → Widgets**, add blocks to Footer widget areas 1–3. They appear in the built-in footer automatically when enabled under **UNDO Theme Settings → Footer → Widget areas**. The Pro footer starter includes `[undo_footer_widgets]` so those same areas can appear when its footer template replaces the built-in footer. Remove that Shortcode widget in Elementor if you want an Elementor-only footer.

## Language and update behavior

The theme's language switcher translates theme strings and changes direction. It does **not** translate Elementor-authored page content or change Elementor Theme Builder display conditions. The English/Persian starter pairs are separate content examples. For a production bilingual site, translate pages and site parts with a compatible multilingual content plugin and connect its language routing to the theme switcher during the planned localization stage. Until then, publish only the starter matching the site's content language or edit the imported content yourself.

The starter JSON files are versioned in GitHub with the theme. Updating the theme changes the bundled examples and CSS, but it does not rewrite an imported Elementor document or its display conditions. This protects customer edits. The built-in header, footer, landing page, and blog archive continue to work without Elementor Pro or with Elementor disabled.

## Staging acceptance check

Test each imported file in the currently installed Elementor version. Verify editor load, preview, responsive widths, RTL/LTR, menu selection, dynamic blog listing and pagination, footer widget shortcode, and display conditions. Then deactivate Elementor Pro and Elementor Free separately to confirm the built-in fallbacks return. Record the installed plugin versions and results in `docs/staging-reports/` before calling the integration production ready.
