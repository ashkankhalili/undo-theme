# GitHub release and WordPress update workflow

The customer update channel is the public `ashkankhalili/undo-theme` GitHub repository. The theme folder and text domain stay `undo-theme`; its `Update URI` is `https://github.com/ashkankhalili/undo-theme`. WordPress checks the latest published GitHub Release and offers a newer version in **Dashboard → Updates**. An administrator chooses when to install it. Automatic background installation is not enabled.

## One-time bootstrap

The 0.2.2 theme did not contain an updater, so it could not discover 0.2.3 by itself. The owner installed the verified 0.2.3 release ZIP. The owner then confirmed that WordPress offered 0.2.4 in **Dashboard → Updates** without another upload. The old update-details link tried to embed GitHub and failed. Public staging inspection now shows 0.2.5 installed; the 0.2.6 update is the first opportunity to test the new WordPress-hosted release-notes popup on that site.

## For each later version

1. Develop and review the change. Bump the version in `undo-theme/style.css`, `undo-theme/functions.php`, and `undo-theme/readme.txt`; update the translation catalog header in `tools/build-translations.mjs`. When adding a feature, refresh the accurate feature list in `undo-theme/readme.txt` and the concise Description in `style.css`, including its Persian translation.
2. Regenerate POT/PO/MO files with `node tools/build-translations.mjs`. Add useful version-specific release notes to both `CHANGELOG.md` files and document any migration. The GitHub Release body is copied from the root changelog and appears in the WordPress update-details popup from installed theme version 0.2.5 onward.
3. Run the relevant staging tests and merge the reviewed change to `main`. GitHub Actions runs PHP syntax and updater checks, translation and JavaScript checks, then builds and checks an installable `undo-theme-X.Y.Z.zip` with one `undo-theme/` root.
4. After checks pass, the release job creates `vX.Y.Z` at the tested commit, attaches that exact ZIP and its `.sha256` file, and verifies the published asset digest. A changed package at an existing version fails; bump the version instead of replacing a release asset.
5. Check the GitHub Actions run, tag commit, Release page, ZIP root, asset names, and SHA-256. Test the update on staging from an older installed version before any customer announcement.
6. On staging, open **Dashboard → Updates → Check Again**, confirm the new version and the WordPress-hosted release details, select the theme update, and verify the installed version, theme settings, menus, Elementor pages, translations, and PHP log after installation. Record screenshots and results in `docs/staging-reports/`.

The updater uses only the exact versioned GitHub Release ZIP; it never installs GitHub's generated source archive. It requires a SHA-256 digest from GitHub's asset metadata or the matching `.sha256` asset, then checks the downloaded bytes before WordPress replaces the theme. Failed or malformed release metadata offers no update. The GitHub repository and release packages are public; customer-only downloads and license-based eligibility require a separate future decision and infrastructure. Never place a GitHub token in the theme ZIP.
