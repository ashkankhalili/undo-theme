import fs from 'node:fs';
import path from 'node:path';
import crypto from 'node:crypto';

// Elementor's documented 0.4 template structure. The four Free page starters are
// provisioned once; other files stay available for manual import.
const output = path.resolve('undo-theme/elementor-templates');
fs.mkdirSync(output, { recursive: true });
let index = 0;
const id = () => crypto.createHash('sha1').update(`undo-starter-${++index}`).digest('hex').slice(0, 8);
const container = (className, elements, settings = {}) => ({
  id: id(), elType: 'container', isInner: false,
  settings: { css_classes: className, ...settings }, elements,
});
const widget = (widgetType, settings = {}) => ({
  id: id(), elType: 'widget', widgetType, isInner: false, settings, elements: [],
});
// New elements use stable IDs so adding them does not renumber existing starters.
const fixedWidget = (key, widgetType, settings = {}) => ({
  id: crypto.createHash('sha1').update(`undo-starter-${key}`).digest('hex').slice(0, 8),
  elType: 'widget', widgetType, isInner: false, settings, elements: [],
});
const fixedContainer = (key, className, elements, settings = {}) => ({
  id: crypto.createHash('sha1').update(`undo-starter-${key}`).digest('hex').slice(0, 8),
  elType: 'container', isInner: false, settings: { css_classes: className, ...settings }, elements,
});
const heading = (title, className, size = 'h2') => widget('heading', { title, header_size: size, _css_classes: className });
const text = (editor, className = '') => widget('text-editor', { editor, _css_classes: className });
const html = (markup, className = '') => widget('html', { html: markup, _css_classes: className });
const button = (label, url) => widget('button', { text: label, link: { url }, _css_classes: 'undo-starter-button' });
const write = (slug, name, type, content) => {
  const data = { title: `UNDO ${name}`, type, version: '0.4', page_settings: [], content };
  fs.writeFileSync(path.join(output, `${slug}.json`), `${JSON.stringify(data, null, 2)}\n`);
};

const copy = {
  en: {
    home: 'Home — English', header: 'Header — English', footer: 'Footer — English', archive: 'Blog Archive — English',
    hero: 'Websites, plugins & apps made better.', intro: 'UNDO creates new digital products and redesigns the ones that no longer serve your business. From the first screen to the working code.',
    overview: 'The right work for the next version of your business.', overviewText: 'Whether the starting point is a blank page or an existing product, UNDO brings design and development together to make it easier to use, easier to manage, and ready to grow.',
    action: 'Plan a project', services: 'What we build.', serviceOne: 'Websites', serviceOneText: 'New sites and thoughtful redesigns that communicate clearly and work across every screen.',
    serviceTwo: 'WordPress plugins', serviceTwoText: 'Custom tools that add the features your website and workflow actually need.',
    serviceThree: 'Mobile apps', serviceThreeText: 'Mobile experiences designed around the people who will use them every day.',
    method: 'Create new. Redo what exists.', methodText: 'Good design starts with understanding what needs to change. We map the problem, shape the experience, then build and refine the result.',
    redesign: 'Keep what works. Redo what does not.', redesignText: 'A better site or product should help people understand, decide, and act. The design follows that job.',
    close: 'Tell us what you want to make.', closeText: 'Start with the essentials. We will shape the next version together.',
    brand: 'UNDO', blog: 'Journal', blogText: 'Notes on designing, building, and making useful things better.',
    footerTitle: 'WE REDO IT FOR YOU.', footerText: 'Websites, WordPress plugins and mobile apps, designed for what comes next.',
    compare: 'Drag to compare', comparisonAria: 'Compare earlier and redesigned website concept', visualAria: 'Interactive concept showing a website before and after a redesign', newPerspective: 'new perspective', workNav: 'Work  About  Contact', mockKicker: 'A website with purpose.', mockHeading: 'Make the first impression count.', mockAction: 'Start here', beforeName: 'COMPANY NAME', beforeNav: 'Home  About  Services  Contact', beforeBanner: 'WELCOME TO OUR WEBSITE', beforeHeading: 'We provide solutions for your needs', before: 'Before', after: 'After', phoneTitle: 'Built for every screen.', phoneAction: 'Get started', stamp: 'DESIGN / BUILD / REDO', processLabel: 'HOW WE WORK', processAria: 'Our process: understand, design, build, refine', steps: [['Understand', 'Goals, users, constraints'], ['Design', 'Structure, content, interface'], ['Build', 'Working product'], ['Refine', 'Details that make it last']],
  },
  fa: {
    home: 'صفحهٔ اصلی — فارسی', header: 'سربرگ — فارسی', footer: 'پایین صفحه — فارسی', archive: 'بایگانی وبلاگ — فارسی',
    hero: 'وب‌سایت‌ها، افزونه‌ها و اپ‌ها؛ بهتر از قبل.', intro: 'UNDO محصولات دیجیتال تازه می‌سازد و آنچه دیگر به کار کسب‌وکار شما نمی‌آید از نو طراحی می‌کند؛ از اولین صفحه تا کد نهایی.',
    overview: 'کار درست برای نسخه بعدی کسب‌وکار شما.', overviewText: 'چه از یک صفحهٔ خالی شروع کنید و چه از محصولی موجود، UNDO طراحی و توسعه را کنار هم می‌آورد تا استفاده و مدیریت آن ساده‌تر شود و برای رشد آماده باشد.',
    action: 'برنامه‌ریزی پروژه', services: 'چه می‌سازیم.', serviceOne: 'وب‌سایت‌ها', serviceOneText: 'طراحی و بازطراحی وب‌سایت‌هایی روشن، کاربردی و سازگار با همهٔ صفحه‌ها.',
    serviceTwo: 'افزونه‌های وردپرس', serviceTwoText: 'ابزارهای اختصاصی برای نیازهای واقعی وب‌سایت و روند کاری شما.',
    serviceThree: 'اپلیکیشن‌های موبایل', serviceThreeText: 'تجربه‌های موبایل بر پایهٔ نیاز کسانی که هر روز از آن‌ها استفاده می‌کنند.',
    method: 'از صفر بسازید. موجود را بازطراحی کنید.', methodText: 'طراحی خوب با شناخت چیزی که باید تغییر کند آغاز می‌شود. مسئله را می‌شناسیم، تجربه را شکل می‌دهیم و نتیجه را می‌سازیم و اصلاح می‌کنیم.',
    redesign: 'خوب‌ها را نگه دارید. بقیه را از نو بسازید.', redesignText: 'وب‌سایت یا محصول بهتر به مردم کمک می‌کند بفهمند، تصمیم بگیرند و اقدام کنند. طراحی باید به همین هدف خدمت کند.',
    close: 'از پروژه‌تان بگویید.', closeText: 'از نکات اصلی شروع کنیم و نسخهٔ بعدی را با هم شکل دهیم.',
    brand: 'UNDO', blog: 'یادداشت‌ها', blogText: 'دربارهٔ طراحی، ساخت و بهتر کردن چیزهای کاربردی.',
    footerTitle: 'برای شما از نو می‌سازیم.', footerText: 'وب‌سایت، افزونهٔ وردپرس و اپلیکیشن موبایل؛ برای آنچه پیش رو دارید.',
    compare: 'برای مقایسه بکشید', comparisonAria: 'مقایسهٔ طرح قدیمی و بازطراحی‌شدهٔ وب‌سایت', visualAria: 'نمونهٔ تعاملی وب‌سایت پیش و پس از بازطراحی', newPerspective: 'نگاهی تازه', workNav: 'نمونه‌کار  درباره  تماس', mockKicker: 'وب‌سایتی با هدف روشن.', mockHeading: 'اولین برخورد را ماندگار کنید.', mockAction: 'از اینجا شروع کنید', beforeName: 'نام شرکت', beforeNav: 'خانه  درباره  خدمات  تماس', beforeBanner: 'به وب‌سایت ما خوش آمدید', beforeHeading: 'برای نیازهای شما راه‌حل داریم', before: 'قبل', after: 'بعد', phoneTitle: 'برای هر صفحه ساخته شده.', phoneAction: 'شروع کنید', stamp: 'طراحی / ساخت / بازطراحی', processLabel: 'روش کار ما', processAria: 'فرایند ما: شناخت، طراحی، ساخت و اصلاح', steps: [['شناخت', 'هدف‌ها، کاربران، محدودیت‌ها'], ['طراحی', 'ساختار، محتوا، رابط'], ['ساخت', 'محصول کارآمد'], ['اصلاح', 'جزئیاتی که ماندگارند']],
  },
};

// The Home page uses the same section classes, visual markup, and interaction hooks
// as the native PHP homepage. Copy remains in normal Elementor widgets.
function homeVisual(c) {
  return `<div class="hero-stage" aria-label="${c.visualAria}"><div class="stage-label">${c.compare}</div><div class="browser"><div class="browser-bar"><span class="browser-dots"><i></i><i></i><i></i></span><span class="browser-address">undo / ${c.newPerspective}</span><span class="browser-menu">•••</span></div><div class="mock-site"><div class="mock-nav"><span class="mock-mark">U.</span><span>${c.workNav}</span></div><div class="mock-body"><div class="mock-kicker">${c.mockKicker}</div><div class="mock-heading">${c.mockHeading}</div><div class="mock-line"></div><div class="mock-button">${c.mockAction} ↗</div></div><div class="mock-blocks"><div></div><div></div><div></div></div></div><div class="before-site" aria-hidden="true"><div class="before-top"><span>${c.beforeName}</span><span>${c.beforeNav}</span></div><div class="before-banner">${c.beforeBanner}</div><div class="before-content"><div class="before-heading">${c.beforeHeading}</div><div class="before-lines"><i></i><i></i><i></i><i></i></div><div class="before-boxes"><i></i><i></i><i></i></div></div></div><span class="comparison-label comparison-label--before" aria-hidden="true">${c.before}</span><span class="comparison-label comparison-label--after" aria-hidden="true">${c.after}</span><div class="comparison-divider" aria-hidden="true"><span><svg><use href="#icon-horizontal"></use></svg></span></div><input class="comparison-range" type="range" min="0" max="100" value="38" aria-label="${c.comparisonAria}"></div><div class="phone"><div class="phone-notch"></div><div class="phone-inner"><div class="phone-top">U. <span>☰</span></div><div class="phone-title">${c.phoneTitle}</div><div class="phone-shape"></div><div class="phone-lines"><span></span><span></span></div><div class="phone-cta">${c.phoneAction} ↗</div></div></div><span class="stage-stamp">${c.stamp}</span></div>`;
}
function serviceRow(language, number, title, description, glyph) {
  const symbols = {
    web: '<span class="web-glyph"><i></i><i></i><i></i></span>',
    plugin: '<span class="plugin-glyph"><i></i><i></i><i></i><i></i></span>',
    app: '<span class="app-glyph"><i></i></span>',
  };
  return fixedContainer(`home-${language}-service-${number}`, 'service-row', [
    html(`<div class="service-number">${number}</div>`, 'undo-home-number'),
    fixedContainer(`home-${language}-service-copy-${number}`, 'service-name', [heading(title, '', 'h3'), text(description)]),
    html(`<div class="service-symbol" aria-hidden="true">${symbols[glyph]}</div>`, 'undo-home-symbol'),
  ], { html_tag: 'article', content_width: 'full' });
}
function processBoard(c) {
  return `<div class="process-board" aria-label="${c.processAria}"><div class="process-top">${c.processLabel} <span>UNDO / 04</span></div>${c.steps.map(([title, detail], index) => `<div class="process-step"><span>${String(index + 1).padStart(2, '0')}</span><strong>${title}</strong><small>${detail}</small></div>`).join('')}</div>`;
}
function nativeHome(c, language) {
  const section = (key, className, elements) => fixedContainer(`home-${language}-${key}`, className, elements, { _element_id: key, html_tag: 'section', content_width: 'full' });
  return [fixedContainer(`home-${language}-root`, `undo-native-home undo-elementor-home undo-elementor-home--${language}`, [
    section('top', 'hero', [
      container('wrap hero-grid', [
        container('hero-copy', [heading(c.hero, '', 'h1'), text(c.intro, 'hero-description'), widget('button', { text: c.action, link: { url: '#project-planner' }, _css_classes: 'undo-home-cta' })], { content_width: 'full' }),
        html(homeVisual(c), 'undo-home-visual'),
      ], { content_width: 'full' }),
      container('wrap hero-bottom', [text(c.footerTitle, 'undo-home-slogan')], { content_width: 'full' }),
    ]),
    section('overview', 'intro section', [container('wrap intro-grid', [
      html('<div class="intro-mark" aria-hidden="true"><svg><use href="#icon-undo"></use></svg></div>', 'undo-home-mark'),
      container('intro-copy', [heading(c.overview), text(c.overviewText)], { content_width: 'full' }),
    ], { content_width: 'full' })]),
    section('services', 'services section', [container('wrap', [
      container('section-head', [heading(c.services)], { content_width: 'full' }),
      container('service-list', [serviceRow(language, '01', c.serviceOne, c.serviceOneText, 'web'), serviceRow(language, '02', c.serviceTwo, c.serviceTwoText, 'plugin'), serviceRow(language, '03', c.serviceThree, c.serviceThreeText, 'app')], { content_width: 'full' }),
    ], { content_width: 'full' })]),
    section('approach', 'approach section', [container('wrap approach-grid', [
      container('approach-copy', [heading(c.method), text(c.methodText), widget('button', { text: c.action, link: { url: '#project-planner' }, _css_classes: 'undo-home-text-link' })], { content_width: 'full' }),
      html(processBoard(c), 'undo-home-process'),
    ], { content_width: 'full' })]),
    section('redesign', 'statement section', [container('wrap', [heading(c.redesign), text(c.redesignText)], { content_width: 'full' })]),
    fixedWidget(`home-planner-${language}`, 'shortcode', { shortcode: '[undo_home_planner]', _css_classes: 'undo-home-planner' }),
  ], { content_width: 'full' })];
}

for (const [language, c] of Object.entries(copy)) {
  index = 0;
  const langClass = `undo-starter--${language}`;
  write(`home-${language}`, c.home, 'page', nativeHome(c, language));

  write(`header-${language}`, c.header, 'header', [
    container(`undo-starter-header ${langClass}`, [
      heading(c.brand, 'undo-starter-logo', 'div'),
      widget('nav-menu', { _css_classes: 'undo-starter-menu' }),
      text('<a href="?undo_lang=en" lang="en">English</a> / <a href="?undo_lang=fa" lang="fa">فارسی</a>', 'undo-starter-language'),
      button(c.action, '#project-planner'),
    ]),
  ]);

  write(`footer-${language}`, c.footer, 'footer', [
    container(`undo-starter-footer ${langClass}`, [
      container('undo-starter-footer-top', [heading(c.footerTitle, 'undo-starter-footer-title', 'h2'), button(c.action, '#project-planner')]),
      text(c.footerText, 'undo-starter-footer-note'),
      widget('shortcode', { shortcode: '[undo_footer_widgets]', _css_classes: 'undo-starter-widget-shortcode' }),
      heading(c.brand, 'undo-starter-footer-brand', 'div'),
    ]),
  ]);

  write(`blog-archive-${language}`, c.archive, 'archive', [
    container(`undo-starter-archive ${langClass}`, [
      heading(c.blog, 'undo-starter-display', 'h1'),
      text(c.blogText, 'undo-starter-lead'),
      widget('archive-posts', { _css_classes: 'undo-starter-archive-posts' }),
    ]),
  ]);

  write(`blog-page-${language}`, `${c.blog} — ${language.toUpperCase()}`, 'page', [
    container(`undo-starter-archive ${langClass}`, [
      heading(c.blog, 'undo-starter-display', 'h1'),
      text(c.blogText, 'undo-starter-lead'),
      widget('shortcode', { shortcode: '[undo_blog_posts]', _css_classes: 'undo-starter-archive-posts' }),
    ]),
  ]);
}
console.log(`Built ${fs.readdirSync(output).filter(name => name.endsWith('.json')).length} Elementor starter templates.`);
