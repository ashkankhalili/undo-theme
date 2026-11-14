# Native homepage workflow

The built-in UNDO homepage is used unless the static front page is edited with Elementor or given a supported UNDO page template. Those page layouts take precedence. Their WordPress or Elementor content remains owned by the site, so theme updates never replace it.

## Arrange sections

Open **UNDO Theme Settings → Homepage**. The Hero is always first and Project planner is always last. Use each section's **Up** and **Down** buttons to reorder Overview, Services, Approach, and Redesign. Use **Show** to hide a section. Save all settings once. Section navigation and guided scrolling follow the visible order. If a custom WordPress header menu points to a hidden section, update that menu in **Appearance → Menus**.

## Use normal WordPress pages for copy

Create a normal page for each section you want to customize and publish it. Put the short homepage description in the page's **manual excerpt**. In **Homepage → Linked pages**, select the published page for the Persian or English slot. The section uses its title and excerpt, and the title links to the full page. The three service cards have separate page slots. The front page cannot be selected as a reference, which prevents a self-link. If the excerpt is empty, the built-in description remains. If a referenced page becomes unpublished, the entire section falls back to built-in copy. The page body, including Elementor widgets, is never injected into a homepage section; the link opens that full page instead.

The current language uses its corresponding page slot. The theme's language switcher controls built-in strings and direction. It does not translate the selected page itself; use translated page pairs and a compatible content translation solution for production multilingual routing.

## Elementor Home

When Elementor is active, UNDO creates separate published English and Persian Home starter pages from `home-en.json` and `home-fa.json` on the first administrator load. Select the matching page under **Settings → Reading**, then edit its sections in Elementor. The Homepage section controls apply only to the native landing. Removing the Elementor front page assignment, or disabling Elementor, restores the native landing with its saved settings. See [Elementor starter templates](ELEMENTOR_STARTERS.md) for the full setup and Pro requirements for header, footer, and archive templates.
