# Changelog

All changes to the customer theme are recorded here. Use a version number in `style.css`, `functions.php`, and the package filename for every release.

## [Unreleased]

## [0.6.1] - 2026-11-10

### Blog and typography corrections

- Blog Settings now selects a published WordPress page for the posts index. The choice updates WordPress's `page_for_posts` option; a static homepage must be selected in Settings → Reading for that page to serve the posts index. The current WordPress choice is shown even if it was set elsewhere.
- Restored clear labels for the original language-aware font choices from the 0.5.0 design: DM Sans for English body text, Space Grotesk for English headings, Instrument Serif for English accents, and Vazirmatn for Persian. Saved `default` choices retain their original behavior and are not overwritten.
- Replaced one control per line with a horizontal typography table: one row per text role, with family, size, weight, style, line height, spacing, and color together. Word and letter spacing share the spacing cell so existing letter-spacing settings remain editable and intact.
- Added word-spacing output for each typography role. Zero continues to inherit the theme style. The table scrolls horizontally where the admin viewport is narrow.

### فارسی

- انتخاب صفحهٔ نوشته‌ها به تنظیمات وبلاگ اضافه شد و با گزینهٔ اصلی وردپرس هماهنگ است.
- نام قلم‌های اصلی انگلیسی و فارسی در انتخابگرها مشخص شد و تنظیمات هر نوع متن در یک ردیف قرار گرفت. فاصلهٔ واژه‌ها اضافه شد و فاصلهٔ حروف قبلی حفظ شد.

### Validation

- Rebuild translations and package, run PHP and package CI, then verify the exact release ZIP and dashboard update. On staging, check Persian and English font rendering, one-row controls, saved typography values, and posts-page assignment with a static homepage.

## [0.6.0] - 2026-11-10

### Layout, blog, and typography

- Website Layout content width now accepts `320–1920px` or `20–100%`. Existing numeric widths keep their pixel meaning when displayed and saved.
- Sidebar position now offers physical **Left**, **Right**, and **Hidden** choices. Hidden suppresses built-in sidebars on posts, pages, archives, and search. Old logical start/end values are mapped to the same visible side in the current writing direction until saved with the new controls.
- Added three blog designs for the built-in blog index, archives, and search results: image-and-copy **Editorial list**, image-led **Image grid**, and text-first **Journal grid**. Grid column count remains configurable; layouts adapt to narrow screens and RTL.
- Typography roles now include family, pixel size, weight, normal/italic style, line height, letter spacing, and optional hex text color. Role groups fold independently to make the page easier to scan.
- Added a **Load Google Fonts** switch, on by default to preserve existing appearance. The family selector includes the four fonts already used by the theme and four additional curated Google families, alongside system fonts and customer-uploaded WOFF2 fonts. Turning Google loading off removes the external stylesheet request and uses local/system fallbacks for selected Google families; uploaded fonts remain available.

### فارسی

- عرض محتوا اکنون مقدار پیکسلی یا درصدی می‌پذیرد. جایگاه نوار کناری چپ، راست یا پنهان است و مقدارهای قدیمی با جهت قبلی سازگار می‌مانند.
- سه طرح فهرست تحریریه‌ای، شبکه تصویری و شبکه ژورنالی برای وبلاگ اضافه شد.
- تنظیمات قلم برای هر بخش شامل اندازه، ضخامت، حالت، ارتفاع خط، فاصله حروف و رنگ است. بارگذاری قلم‌های گوگل را می‌توان خاموش کرد.

### Validation

- Translation catalogs and package are rebuilt; PHP 7.4/8.3 CI, exact GitHub release asset, and staging dashboard upgrade must pass before customer distribution. Verify all blog designs, physical sidebar placement, Google-off network behavior, and typography controls on staging.

## [0.5.0] - 2026-11-10

### Settings workspace

- Expanded the standalone UNDO Theme Settings screen to the available WordPress admin width. The section sidebar and content panel now join into one workspace, with a full-row selected state and RTL-aware edges.
- Section changes now happen in place without a page reload. Unsaved edits remain in their fields while navigating; one **Save all changes** action submits every section together. The current section remains selected after saving.
- Moved the existing accent color out of Website Layout and into **Colors**, preserving its stored value. Added shared surface/text/border colors and built-in header, content, and footer color controls.
- Added **Typography** with built-in font choices and Media Library WOFF2 uploads (regular plus optional bold) for up to 12 custom families. Font assignments cover body, headings, accent, navigation, buttons, page/post titles, widget titles, and footer. Invalid attachments or missing families are rejected on save. Uploaded fonts remain in WordPress Media Library during theme updates. Elementor widgets with explicit typography or color choices keep those choices.

### فارسی

- صفحه تنظیمات پوسته تمام عرض مدیریتی را به کار می‌گیرد. نوار بخش‌ها و محتوای تنظیمات به هم متصل‌اند و بخش فعال در تمام عرض ردیف مشخص می‌شود.
- جابه‌جایی بین بخش‌ها بدون بارگذاری دوباره صفحه انجام می‌شود و تغییرات ذخیره‌نشده تا فشردن «ذخیره همه تغییرات» باقی می‌مانند.
- رنگ‌ها به بخش مستقل منتقل شدند و بخش تایپوگرافی با امکان بارگذاری قلم WOFF2 و تخصیص آن به نقش‌های متنی اضافه شد.

### Validation

- Local JavaScript syntax and translation generation checked. CI must run PHP 7.4/8.3 checks and package validation. The staging site still needs a dashboard update to 0.5.0 and live verification of section persistence, WOFF2 upload, color and font output, RTL, and Elementor inheritance.

## [0.4.0] - 2026-11-09

### Sidebar milestone

- Added **Lined** and **Panel** widget styles, a 16–64px widget spacing control, optional sticky behavior, and a 0–120px sticky top gap under **UNDO Theme Settings → Sidebar**. Existing position, width, archive, and search settings remain available. The default remains lined and nonsticky.
- Styled classic and block widget headings, lists, links, inputs, and search controls. Logical CSS keeps start/end placement consistent in RTL. On small screens the sidebar follows the main content in document order.
- Sticky mode accounts for the built-in sticky header and activates only when the widget area fits the viewport. Tall widget areas remain in normal page flow without a nested scroll region. An empty widget area reserves no sidebar markup.

### فارسی

- برای نوار کناری، سبک خط‌دار یا کادربندی‌شده، فاصله قابل تنظیم ابزارک‌ها و حالت چسبان اختیاری با فاصله از بالای صفحه اضافه شد. حالت پیش‌فرض همان سبک خط‌دار و غیرچسبان است.
- جایگاه ابتدا/انتها در فارسی راست‌چین آینه می‌شود و در نمایشگر کوچک نوار کناری پس از محتوای اصلی قرار می‌گیرد. نوار کناری بلند چسبان نمی‌شود و بخش ابزارک خالی فضایی اشغال نمی‌کند.

### Validation

- Local browser fixtures checked LTR/RTL position, 390px mobile layout, sticky placement below sticky and static headers, and tall-content fallback. PHP tests cover settings validation and empty/widget sidebar markup. GitHub CI checks PHP 7.4/8.3, translations, and the package. Live WordPress staging verification remains pending.

## [0.3.3] - 2026-11-09

### Added

- Added independent width, minimum side margin, top/bottom margin, and side/top/bottom padding controls for UNDO Reading, Wide, Boxed, and Full Width under **UNDO Theme Settings → Pages**. The shipped starting values use the previous nominal template widths; narrow screens cap side spacing to avoid overflow.
- Replaced horizontal settings tabs with a vertical section sidebar and adjacent content panel that also works in RTL and on small screens.
- Moved the per-page UNDO Custom Width field below the WordPress page editor. Its panel appears only when the Custom Width template is selected in the page template selector.

### Changed

- The initial visitor language now follows WordPress **Site Language**. An explicit header language-switcher choice still persists in the existing cookie. The former theme-level default-language control has been removed.
- Custom Width no longer has a global theme setting. A page without its own width uses `1200px`; existing per-page widths remain in post meta. An old saved global Custom Width default resolves safely to Reading until a supported default is selected.
- UNDO template width and spacing settings apply to ordinary WordPress content and Elementor-built pages using an UNDO template. Elementor Full Width and Canvas retain Elementor's own layout behavior.

### فارسی

- برای قالب‌های «مطالعه»، «عریض»، «جعبه‌ای» و «تمام‌عرض»، تنظیمات مستقل عرض، حاشیه و فاصله داخلی در بخش صفحه‌ها اضافه شد. مقدارهای اولیه نمای قبلی را حفظ می‌کنند و فاصله‌های کناری در موبایل محدود می‌شوند.
- ناوبری تنظیمات پوسته به نوار عمودی سازگار با راست‌چین تبدیل شد. کادر عرض سفارشی زیر ویرایشگر صفحه قرار گرفت و فقط با انتخاب قالب «عرض سفارشی» نمایش داده می‌شود.
- زبان آغازین از «زبان سایت» وردپرس خوانده می‌شود؛ انتخاب صریح بازدیدکننده در تغییر‌دهنده زبان همچنان ذخیره می‌شود. تنظیم زبان پیش‌فرض پوسته حذف شد. عرض سفارشی فقط برای هر صفحه تنظیم می‌شود و در صورت خالی بودن، `1200px` خواهد بود.

### Validation

- Local browser fixtures checked template widths and spacing at desktop and mobile sizes, RTL settings navigation, and conditional editor-panel visibility. PHP/CI and exact GitHub release package are checked by the publishing workflow. Live WordPress/Elementor behavior remains a staging test.

## [0.3.2] - 2026-11-09

### Fixed

- Elementor Full Width can print ordinary WordPress content directly inside the page body. Its short pages now keep the theme or Elementor Pro footer at the bottom of the viewport, even when the page has never been built with Elementor. Elementor-built Full Width pages retain the height floor added in 0.3.1.

### فارسی

- در قالب «Elementor Full Width»، صفحه‌های کوتاه با محتوای معمول وردپرس نیز پابرگ را پایین نمایشگر نگه می‌دارند؛ این اصلاح برای صفحه‌های ساخته‌شده با المنتور و صفحه‌های معمولی کار می‌کند.

### Validation

- Local browser checks cover both Elementor-built and ordinary-content variants. The published 0.3.1 release stays immutable; 0.3.2 is the dashboard update for complete staging retest.

## [0.3.1] - 2026-11-09

### Fixed

- Removed the hidden 760px text limit from full-width and wide pages. Global page layouts now visibly change the frontend width for both WordPress content and Elementor-built pages using an UNDO template.
- Kept short pages built with Elementor Full Width at least one viewport high, so the footer follows the page rather than rising immediately after a few lines of content.
- Honored a selected UNDO page template on a static front page instead of always showing the built-in landing layout.

### Added

- Added **UNDO Reading**, **UNDO Wide**, **UNDO Boxed**, and **UNDO Custom Width** page templates alongside **UNDO Full Width**. Each is selectable in the WordPress page editor and Elementor page settings.
- Added a default page layout and a custom width of 320–1920px or 20–100% under **UNDO Theme Settings → Pages**. A page editor width field overrides the global custom width for that page. The theme setting remains the fallback when no UNDO template is selected.

### فارسی

- محدودیت پنهان عرض ۷۶۰ پیکسل از صفحه‌های عریض و تمام‌عرض برداشته شد؛ تنظیم چیدمان اکنون روی محتوای وردپرس و صفحه‌های ساخته‌شده با المنتور که قالب UNDO دارند اثر می‌گذارد.
- قالب‌های مطالعه، عریض، کادربندی‌شده و عرض سفارشی به انتخاب قالب صفحه افزوده شدند. عرض سفارشی با پیکسل یا درصد از تنظیمات پوسته و برای هر صفحه جداگانه قابل تعیین است.
- قالب انتخاب‌شده برای صفحه نخست ایستا رعایت می‌شود و صفحه‌های کوتاه Elementor Full Width ارتفاع کافی پیش از پابرگ دارند.

### Validation

- Browser layout measurements covered all five modes, pixel and percentage custom widths, Elementor wrappers, and mobile RTL overflow. PHP lint, behavioral tests, translation catalogs, and ZIP integrity are enforced by GitHub Actions. Live staging retest follows the 0.3.1 dashboard update.

## [0.3.0] - 2026-11-09

### Added

- Added an **UNDO Full Width** page template alongside the standard reading template. Standard pages can now use a reading or wide content width; both templates support full-bleed blocks when the sidebar is absent.
- Added optional page breadcrumbs with the ancestor path, optional featured image, editorial or compact title, and page content width controls under **UNDO Theme Settings → Pages**. Existing page option values are preserved; breadcrumbs and featured images stay off by default.
- Added responsive, RTL-aware page typography and spacing. Elementor-built pages keep their own canvas, while an assigned Elementor Pro single location continues to replace the built-in page template.
- Updated the Appearance → Themes description, readme, English/Persian translation catalogs, and staging checklist for the new page controls.

### فارسی

- قالب «UNDO Full Width» برای صفحه‌های تمام‌عرض افزوده شد. صفحه‌های استاندارد می‌توانند عرض مناسب مطالعه یا عریض داشته باشند.
- مسیر صفحه، تصویر شاخص، سبک عنوان تحریریه‌ای یا فشرده و عرض محتوا از بخش «صفحه‌ها» در تنظیمات مستقل پوسته کنترل می‌شوند.
- تایپوگرافی و فاصله‌گذاری صفحه‌ها برای فارسی راست‌چین و انگلیسی چپ‌چین بهبود یافت. صفحه‌های ساخته‌شده با المنتور همچنان از چیدمان خودشان استفاده می‌کنند.

### Validation

- Page option defaults, validation, and cross-tab persistence are covered by automated checks. PHP syntax, catalogs, ZIP integrity, and the release digest are checked by GitHub Actions. Live page rendering and Elementor behavior require the 0.3.0 dashboard update on staging.

## [0.2.9] - 2026-11-09

### Fixed

- Corrected homepage section alignment when **Sticky header** is disabled. Guided wheel and keyboard navigation now subtracts header height only while the header remains sticky. Static-header sections and the footer use the full viewport height after the first screen.
- Preserved the sticky-header layout and header-aware navigation. Ordinary post and page scrolling is unchanged.

### فارسی

- با غیرفعال‌کردن «سربرگ چسبان»، بخش‌های صفحه اصلی اکنون از بالای صفحه شروع می‌شوند و ارتفاع کامل نمایشگر را می‌گیرند. هنگام جابه‌جایی با چرخ ماوس یا صفحه‌کلید، ارتفاع سربرگ فقط در حالت چسبان کسر می‌شود.

### Staging test

- On installed 0.2.8, browser measurement reproduced the static-header fault: at a 900px viewport the overview section started 76px below the top and was only 824px high. A browser preview of this fix placed static sections at top 0 with 900px height at desktop and top 0 with 844px height at mobile. Sticky-header preview still placed the section at top 76px below its 76px header. Install 0.2.9 through WordPress Updates and recheck the actual saved setting before marking this fixed live.

## [0.2.8] - 2026-11-09

### Fixed

- Made the primary logo readable on a dark header when a separate light logo has not been selected. The fallback is a white silhouette; the dedicated light logo, when supplied, retains its original colors.
- The fix follows live staging visual QA of the 0.2.7 single-post layout. The Persian phone and English desktop pages rendered without horizontal overflow, but the existing dark logo had insufficient contrast against the dark header.

### فارسی

- اگر برای سربرگ تیره نشان روشن جداگانه انتخاب نشده باشد، نشان اصلی به‌صورت روشن نمایش داده می‌شود تا خوانا بماند. نشان روشن اختصاصی بدون تغییر رنگ نمایش داده می‌شود.

### Staging test

- Version 0.2.7 is publicly installed. An existing published post rendered the new single-post template with title, date, author, category, featured image and caption, content, comments, and sidebar in RTL/LTR at 390px and 1440px. Related posts were disabled and there was only one published post, so related cards and previous/next navigation could not be checked. The 0.2.8 fallback still requires a live dashboard update and visual recheck.

## [0.2.7] - 2026-11-09

### Single-post milestone

- Redesigned the built-in single-post template with an editorial title and metadata, optional manually written excerpt, featured media with caption, readable Gutenberg content, tags, previous/next navigation, and comments.
- Added optional category-matched related posts with a two or three card setting. Related posts are disabled by default. The count setting appears only when related posts are enabled.
- Added responsive RTL/LTR reading styles, English and Persian translations, and query/settings tests. Elementor Theme Builder can still replace the entire single template.
- Expanded the Appearance → Themes description and feature readme to reflect the new capabilities.

### فارسی

- قالب تک‌نوشته با عنوان و فراداده، خلاصه دستی، تصویر شاخص و توضیح آن، متن خوانا، برچسب‌ها، ناوبری و دیدگاه‌ها بازطراحی شد.
- نوشته‌های مرتبط بر اساس دسته‌بندی و با تعداد دو یا سه کارت به‌صورت اختیاری اضافه شدند؛ این قابلیت به‌طور پیش‌فرض خاموش است.
- استایل واکنش‌گرا برای هر دو جهت نوشتار و ترجمه‌های فارسی و انگلیسی به‌روز شدند.

### Staging test

- The owner confirmed that WordPress displayed the 0.2.6 release notes in its update-details popup and installed 0.2.6. Public read-back confirmed the new stylesheet and Persian/English pages. The light header was checked at mobile and desktop widths with no horizontal overflow; the mobile menu opened and closed with Escape. Dark/centered/search settings and Elementor fallback still need live admin checks. The 0.2.7 single-post options and rendering need a staging update and test post.

## [0.2.6] - 2026-11-09

### Header milestone

- Added light and dark header styles, a separate light logo for dark headers, and a centered navigation layout. The existing layout remains the default.
- Added an optional site search panel and a setting for showing the action button in the mobile menu.
- Added explicit submenu controls to the primary WordPress menu, improved mobile menu state and Escape/outside-click behavior, and kept the built-in header replaceable by Elementor Theme Builder.
- Updated the fallback navigation markup, Persian and English catalogues, and RTL header spacing.

### فارسی

- حالت روشن و تیره سربرگ، نشان روشن برای حالت تیره و چیدمان ناوبری وسط‌چین اضافه شد.
- جست‌وجوی اختیاری، دکمه اقدام در فهرست موبایل و کنترل زیرمنوها به سربرگ افزوده شد.
- رفتار باز و بسته شدن فهرست موبایل با صفحه‌کلید و کلیک بیرون از فهرست بهبود یافت.

### Staging test

- The owner confirmed the 0.2.6 version-details popup displayed release notes and later installed 0.2.6. Basic public header checks passed; configurable variants and Elementor fallback remain for staging validation.

## [0.2.5] - 2026-11-08

### Fixed

- Replaced the GitHub page used by WordPress's update-details popup with a same-site, administrator-only release-notes view. GitHub blocks embedding its pages in the WordPress popup.
- Displayed the exact latest GitHub Release notes in the popup, with a direct link to the full release. Release-note text is escaped before display.

### Theme information

- Expanded the English and Persian descriptions shown under Appearance → Themes to accurately summarize the current features.
- Added a maintained feature and limitation list to the theme readme. Future feature releases must update this list and the theme description as needed.

### فارسی

- پنجره جزئیات به‌روزرسانی اکنون یادداشت‌های انتشار را در خود وردپرس نمایش می‌دهد و پیوندی به انتشار گیت‌هاب دارد.
- توضیح پوسته در بخش نمایش ← پوسته‌ها کامل‌تر شد و قابلیت‌ها و محدودیت‌های فعلی در راهنمای پوسته ثبت شدند.

### Upgrade note

- Sites running 0.2.3 or 0.2.4 still use their installed updater's GitHub iframe link when viewing 0.2.5 details. Install 0.2.5 through WordPress Updates; subsequent update details will use the WordPress-hosted popup. Do not upload a ZIP for routine upgrades.

## [0.2.4] - 2026-11-08

### Validation

- Published a higher version to verify that an installed 0.2.3 theme discovers and installs a GitHub Release from WordPress Dashboard → Updates without another ZIP upload.
- No visual, settings, or content behavior changed. Live dashboard discovery and installation must be recorded on staging before this update path is considered verified.

## [0.2.3] - 2026-11-08

### Added

- Added a GitHub Releases update channel through WordPress's `Update URI` hook. Newer versioned release ZIPs appear in the WordPress update dashboard.
- Added SHA-256 verification before WordPress installs the downloaded theme ZIP. The updater accepts only the exact `undo-theme` release asset and rejects an invalid or missing checksum.
- Added PHP checks for update discovery, version handling, release URL validation, checksum fallback, and tampered downloads.

### Build

- Added a GitHub Actions release job that publishes the exact CI-tested ZIP and checksum after PHP and package checks pass, then verifies the release asset digest and tag.

### Upgrade note

- Version 0.2.2 has no updater. Install 0.2.3 once from the GitHub Release ZIP to enable future dashboard updates; verify the 0.2.3-to-0.2.4 update on staging before customer rollout.
- This is a staging bootstrap release. Customer rollout awaits the live dashboard update test and the remaining premium theme quality gates.

## [0.2.2] - 2026-11-08

### Changed

- Standardized the installable theme folder, ZIP root, package filename, and gettext domain as `undo-theme` to match the existing staging installation and support in-place updates.
- Regenerated the Persian and English PO/MO catalogs under the `undo-theme` text domain. Existing `undo_theme_settings` options remain under the same option key.

### Documentation

- Added the first online staging milestone, including exact CI artifact installation, bilingual and RTL checks, Elementor checks, and a dated test record.
- Recorded the owner-provided GitHub repository and staging domain in the roadmap and product decisions.
- Added a premium theme blueprint covering product boundaries, standalone settings, Elementor addon widgets, Persian/English RTL delivery, staged implementation, QA gates, and GitHub customer releases.
- Added a product decision log and updated the implementation roadmap and development workflow to link the blueprint. No theme runtime behavior changed.

### Build

- Fixed source line endings for reproducible ZIPs across Windows and Linux; binary theme assets keep their original bytes.
- Added GitHub Actions checks for PHP syntax on 7.4 and 8.3, JavaScript syntax, generated translation catalogs, installable ZIP integrity, and a downloadable pre-release artifact.

## [0.2.1] - 2026-11-08

### Fixed

- Removed document-wide scroll snapping, which could pull normal pages directly to the footer because it was their only snap target.
- Limited guided section tracking, wheel handling, keyboard handling, and section motion to the built-in landing page.
- Applied the same scroll fix to the hosted static preview.

### Verification

- Browser check: a normal page remained at the requested scroll position, with no section motion or scroll snapping.
- Browser check: the landing page remained at the requested Services position, with no scroll snapping.
- Live WordPress and Elementor staging behavior remains to be verified.

## [0.2.0] - 2026-11-08

### Changed

- Persian is the default visitor language for new installs; English remains supported. Existing saved choices remain intact.
- Theme settings now live in one standalone UNDO Theme Settings dashboard with tabs for website layout, header, single posts, pages, sidebar, blog, footer, and homepage.
- Each tab saves its own fields while retaining settings from other tabs. Values are sanitized and constrained to supported options or ranges.
- The built-in header, footer, page, post, archive, blog, and search templates now honor the relevant controls. Elementor Theme Builder templates continue to take precedence.
- Persian typography selectors now match WordPress's `fa-IR` language attribute.

### Added

- Dedicated `rtl.css` and logical-direction layout refinements.
- Registered widget sidebar with conditional placement in posts, pages, archives, and search.
- Header logo selection from the WordPress media library and adjustable logo width within the standalone dashboard.
- Post card controls for image, date, excerpt, excerpt length, and column count.
- A staged premium-theme development roadmap and expanded test/release gates.

### Migration

- Update the parent theme with the new ZIP. Stored theme options and content remain in the database. The default language changes to Persian only where no visitor or saved theme choice exists.

### Remaining before commercial release

- Live WordPress/Elementor validation, theme review checks, accessibility and browser coverage, asset licensing, and a tested GitHub update channel.

## [0.1.0] - 2026-11-08

### Added

- Initial WordPress classic theme based on the UNDO Web Developments landing design.
- Responsive default landing page, standard page/post/archive/search/404 templates, and theme screenshot.
- Elementor-compatible page content and Elementor Pro header, footer, single, and archive locations.
- Appearance → UNDO Theme Settings with sanitized bilingual hero copy, CTA, colors, contact email, language default, and section rail visibility.
- English and Persian visitor language switcher with RTL styling and a persistent language choice.
- POT, en_US PO/MO, and fa_IR PO/MO translation catalogs.
- Local project brief download in English or Persian.
- Installation, maintenance, and release workflow documentation.

### Known limits

- Customer-authored content needs a multilingual content plugin for translation and SEO URLs.
- GitHub-based updates and customer licensing await a repository and release policy.
- Live WordPress/Elementor activation and Theme Check are pending staging verification.
