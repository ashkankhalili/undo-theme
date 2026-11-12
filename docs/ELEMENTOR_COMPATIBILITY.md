# Elementor compatibility and validation

UNDO is a classic WordPress theme. It works without Elementor. Elementor Free can edit page content; Elementor Pro can replace the theme's Header, Footer, Single and Archive locations when a published Theme Builder template has a matching display condition. The theme keeps its PHP template when no matching Pro template renders. The bundled English and Persian JSON files are optional starter content and are never imported or rewritten by a theme update.

## Page layout ownership

| Page template | Content and width | Header and footer |
| --- | --- | --- |
| Default or UNDO Reading / Wide / Boxed / Full Width / Custom Width | WordPress or Elementor content inside the selected UNDO layout. Default and UNDO preset widths and spacing come from **UNDO Theme Settings → Pages**. Custom Width uses the per-page field. | Theme header/footer, or matching Elementor Pro Theme Builder locations. |
| Elementor Full Width | Elementor owns the page content and full-width layout. The UNDO page width presets do not constrain it. | Theme header/footer, or matching Pro replacements. |
| Elementor Canvas | Elementor owns the whole canvas. | Canvas omits the theme header and footer. |

An Elementor-authored page suppresses the theme's page title, breadcrumbs, featured image and built-in page sidebar while Elementor is active. The page's own Elementor widgets can supply those elements. If Elementor is disabled, saved builder metadata no longer suppresses the standard WordPress page layout. The ordinary WordPress content field is shown; Elementor widgets need the plugin to render and are not converted into block content. A static Elementor Home with no explicit UNDO template returns to the native UNDO landing when Elementor is disabled. An explicit UNDO front-page template still takes precedence.

## Theme Builder locations

| Location | Theme output when no matching Pro condition renders |
| --- | --- |
| Header | Built-in responsive header and language switcher. |
| Footer | Built-in footer, including enabled and populated widget areas. A Pro footer can show the same areas with `[undo_footer_widgets]`. |
| Single | Built-in page or post content, or native 404 content. |
| Archive | Built-in blog, archive, and search layouts with pagination and sidebar settings. |

The theme registers all four core locations. Elementor Pro owns its display conditions; a template without a matching condition does not replace the theme. Imported Pro starters require review of their widgets and display conditions. The header starter needs a WordPress menu chosen after import. The archive starter uses dynamic Archive Posts, so use it as an Archive Theme Builder template rather than as a normal posts page.

## Staging matrix

1. Record WordPress, PHP, Elementor Free and Pro versions and the installed UNDO version. Capture a baseline for Persian RTL and English LTR on desktop and phone.
2. With Elementor Free active, edit a page and a static Home. Try Default and each UNDO page template with a visibly different Pages width and padding. Confirm one content body, no duplicate title, and the configured theme width. Then choose Elementor Full Width and Canvas and verify their different header/footer behavior.
3. With Pro active, import the Header, Footer and Blog Archive starters on staging. Set a narrow matching display condition, verify one rendered site part, then remove the condition and verify the built-in part returns. Create or use a Single template and repeat. Check archive pagination, the footer widget shortcode, the header menu, and search/404 fallbacks.
4. Deactivate Pro, then Free on staging. Check Home, a previously Elementor-authored ordinary page, post, blog, archive and search. The site must remain navigable and free of PHP errors. Reactivate both and confirm the Elementor layouts and customer edits remain intact.
5. Record pass/fail results in a dated file under `docs/staging-reports/`, with screenshots for width, RTL and missing or duplicated site parts. A failed case stays open in the roadmap.

The connected staging site's Elementor capability listing reported Elementor **4.2.4**, Pro active, and the `nav-menu` and `archive-posts` widgets available on **2026-11-12**. This is a capability check, not an import or frontend rendering result. The full live matrix above remains pending until 0.10.0 is installed.

Elementor documents [Theme Builder location fallbacks](https://developers.elementor.com/theme-locations-api/displaying-locations/), [page layout modes](https://elementor.com/help/page-settings/), and [display conditions](https://elementor.com/help/conditions/).
