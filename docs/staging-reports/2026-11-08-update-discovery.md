# Staging update discovery — 2026-11-08

Site: `https://ashkankhalili.ir` (owner-designated staging site). The owner supplied two WordPress administrator screenshots in the project conversation. Screenshots are not stored in the public repository.

| Observation | Result |
| --- | --- |
| Installed theme before update | UNDO Web Developments 0.2.3, shown as active in Appearance → Themes |
| WordPress update discovery | WordPress offered 0.2.4 with an update control, without a ZIP upload |
| Update-details popup | Failed: the popup embedded the GitHub Release page, and GitHub refused the iframe connection |
| Update installation | Not confirmed by the screenshots; verify separately before marking upgrade successful |

Fix prepared in 0.2.5: the updater sends future details links to an administrator-only, same-site WordPress view. The view fetches the latest GitHub Release body, renders headings and bullets as escaped text, and links to the full release. This fix cannot alter the link supplied by an older version already installed. After installing 0.2.5 through WordPress Updates, test its details view against a later release. Keep the theme's `style.css` description and `readme.txt` feature list accurate with each feature release.

2026-11-09 public read-back: the staging stylesheet serves version 0.2.5. This confirms the new files reached the site, but does not prove settings persistence or the update-details popup behavior. Version 0.2.6 is the first live test of that popup.

2026-11-09 owner update: a WordPress administrator screenshot showed the 0.2.6 release notes inside the same-site update-details popup. The owner then confirmed updating the theme. Public read-back served the 0.2.6 stylesheet; Persian and English homepages returned HTTP 200 with matching language and direction attributes. Headless Chrome checks at 390px and 1440px found no horizontal overflow; the default light header and mobile menu rendered, and Escape closed the open menu. Dark/centered/search header options and Elementor replacement remain untested. For 0.2.7, update from Dashboard → Updates, then check a post with a manual excerpt, image/caption, comments, category-matched related posts, long Persian/English content, sidebar widget, and Elementor single replacement.
