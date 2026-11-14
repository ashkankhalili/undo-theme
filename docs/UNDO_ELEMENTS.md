# UNDO Elements addon

`undo-elements` is a separately installable plugin. Version 0.1.0 accompanies theme 0.11.0. Install the theme ZIP first, then the plugin ZIP. Elementor Free is needed for the three editor widgets; the shortcode works without Elementor. Elementor Pro is optional. The addon also works with a different WordPress theme.

## What ships

| Widget | Elementor ID | Main controls |
| --- | --- | --- |
| Project Planner | `undo-project-planner` | Heading, description, button copy |
| Service Card | `undo-service-card` | Index, heading, description, link |
| Project Invitation | `undo-project-cta` | Eyebrow, heading, button, link |

The planner is also available as `[undo_project_planner]`. Use only one instance with the `project-planner` anchor on a page; subsequent shortcode instances receive numbered anchors. The native UNDO Home uses the addon renderer when it is active. If the addon is deactivated, the theme's original planner and `#project-planner` navigation remain. Elementor widgets are registered only after Elementor has loaded; without it, an admin notice explains why widgets are unavailable.

The planner has no submit endpoint. JavaScript builds a UTF-8 text file in the visitor's browser and downloads it; it does not store or send form answers. The downloaded filename and form copy follow the active WordPress locale, including the theme visitor language override. A future server-side intake workflow needs an explicit privacy and consent design.

## Install and update

1. From the matching GitHub Release, download `undo-elements-0.1.0.zip` and its `.sha256` file. Check the checksum, then upload the ZIP in **Plugins → Add New → Upload Plugin**. Activate it.
2. With Elementor Free active, open an Elementor page and find the **UNDO Elements** category. Add each widget and edit its controls. Check the preview and public page in Persian RTL and English LTR.
3. On the native UNDO Home, check that the planner replaces the fallback, retains `#project-planner`, and downloads a local brief. Deactivate the addon and confirm the original theme planner returns. Reactivate it.
4. Future addon versions are discovered in **Dashboard → Updates** from the latest public release in `ashkankhalili/undo-theme`. The plugin version is read from the addon asset name, so it can differ from the theme release tag. The upgrader checks the downloaded ZIP against the GitHub asset SHA-256 digest or paired checksum file.

The repository release job packages both products on each theme tag. When the addon has no code change, its current versioned ZIP still appears in the new release. When the addon changes, bump its header, constant, readme, catalogs, and changelog, and bump the theme release tag as the shared release channel. Never embed a GitHub token in customer code. Before a customer release, verify both digests, the ZIP roots, updater discovery and a real staging upgrade.

## Acceptance checks on staging

- Install the addon with Elementor active; verify all three widgets appear, can be edited, and render once on public pages with a different theme or an isolated test site if available.
- Check service card links, external-link `noopener`, empty links, long English/Persian copy, phone width, keyboard focus, and RTL spacing.
- Download a Persian and English brief; inspect the file text and encoding. Confirm browser Network shows no form submission and WordPress has no stored form record.
- Test addon deactivation, Elementor deactivation/reactivation, native Home fallback, shortcode use, and absence of a PHP fatal.
- For the first addon update, install 0.1.0 then publish a higher addon version and confirm WordPress detects it, shows release details, upgrades from the dashboard, and leaves the theme intact.

Record results in a dated file under `docs/staging-reports/`. Passing CI proves package structure and isolated behavior; the live Elementor editor and dashboard upgrade still need this staging record.
