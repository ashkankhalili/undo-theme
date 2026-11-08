# GitHub release and WordPress update workflow

The customer update channel is the public `ashkankhalili/undo-theme` GitHub repository. The theme folder and text domain stay `undo-theme`; its `Update URI` is `https://github.com/ashkankhalili/undo-theme`. WordPress checks the latest published GitHub Release and offers a newer version in **Dashboard → Updates**. An administrator chooses when to install it. Automatic background installation is not enabled.

## One-time bootstrap

The 0.2.2 theme does not contain an updater, so it cannot discover 0.2.3 by itself. Back up the staging database and `wp-content`, then install the exact `undo-theme-0.2.3.zip` from the verified `v0.2.3` GitHub Release once. Keep the `undo-theme` folder name. After that, release 0.2.4 and test its discovery and installation from **Dashboard → Updates** without uploading another ZIP.

## For each later version

1. Develop and review the change. Bump the version in `undo-theme/style.css`, `undo-theme/functions.php`, and `undo-theme/readme.txt`; update the translation catalog header in `tools/build-translations.mjs`.
2. Regenerate POT/PO/MO files with `node tools/build-translations.mjs`. Add release notes to `CHANGELOG.md` and document any migration.
3. Run the relevant staging tests and merge the reviewed change to `main`. GitHub Actions runs PHP syntax and updater checks, translation and JavaScript checks, then builds and checks an installable `undo-theme-X.Y.Z.zip` with one `undo-theme/` root.
4. After checks pass, the release job creates `vX.Y.Z` at the tested commit, attaches that exact ZIP and its `.sha256` file, and verifies the published asset digest. A changed package at an existing version fails; bump the version instead of replacing a release asset.
5. Check the GitHub Actions run, tag commit, Release page, ZIP root, asset names, and SHA-256. Test the update on staging from an older installed version before any customer announcement.
6. On staging, open **Dashboard → Updates → Check Again**, confirm the new version and GitHub release details, select the theme update, and verify the installed version, theme settings, menus, Elementor pages, translations, and PHP log after installation. Record screenshots and results in `docs/staging-reports/`.

The updater uses only the exact versioned GitHub Release ZIP; it never installs GitHub's generated source archive. It requires a SHA-256 digest from GitHub's asset metadata or the matching `.sha256` asset, then checks the downloaded bytes before WordPress replaces the theme. Failed or malformed release metadata offers no update. The GitHub repository and release packages are public; customer-only downloads and license-based eligibility require a separate future decision and infrastructure. Never place a GitHub token in the theme ZIP.
