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
  settings: { _css_classes: className, ...settings }, elements,
});
const widget = (widgetType, settings = {}) => ({
  id: id(), elType: 'widget', widgetType, isInner: false, settings, elements: [],
});
const fixedWidget = (key, widgetType, settings = {}) => ({
  id: crypto.createHash('sha1').update(`undo-starter-${key}`).digest('hex').slice(0, 8),
  elType: 'widget', widgetType, isInner: false, settings, elements: [],
});
const heading = (title, className, size = 'h2') => widget('heading', { title, header_size: size, _css_classes: className });
const text = (editor, className = '') => widget('text-editor', { editor, _css_classes: className });
const button = (label, url) => widget('button', { text: label, link: { url }, _css_classes: 'undo-starter-button' });
const write = (slug, name, type, content) => {
  const data = { title: `UNDO ${name}`, type, version: '0.4', page_settings: [], content };
  fs.writeFileSync(path.join(output, `${slug}.json`), `${JSON.stringify(data, null, 2)}\n`);
};

const copy = {
  en: {
    home: 'Home — English', header: 'Header — English', footer: 'Footer — English', archive: 'Blog Archive — English',
    hero: 'Websites, plugins & apps made better.', intro: 'We create new digital products and redesign the ones that no longer serve your business.',
    action: 'Plan a project', services: 'What we build.', serviceOne: 'Websites', serviceOneText: 'New sites and thoughtful redesigns that communicate clearly and work across every screen.',
    serviceTwo: 'WordPress plugins', serviceTwoText: 'Custom tools that add the features your website and workflow actually need.',
    serviceThree: 'Mobile apps', serviceThreeText: 'Mobile experiences built around the people who use them every day.',
    method: 'Create new. Redo what exists.', methodText: 'We map the problem, shape the experience, then build and refine the result.',
    close: 'Tell us what you want to make.', closeText: 'Start with the essentials. We will shape the next version together.',
    brand: 'UNDO', blog: 'Journal', blogText: 'Notes on designing, building, and making useful things better.',
    footerTitle: 'WE REDO IT FOR YOU.', footerText: 'Websites, WordPress plugins and mobile apps, designed for what comes next.',
  },
  fa: {
    home: 'صفحهٔ اصلی — فارسی', header: 'سربرگ — فارسی', footer: 'پایین صفحه — فارسی', archive: 'بایگانی وبلاگ — فارسی',
    hero: 'وب‌سایت‌ها، افزونه‌ها و اپ‌ها؛ بهتر از قبل.', intro: 'محصولات دیجیتال تازه می‌سازیم و آنچه دیگر پاسخ‌گوی کسب‌وکار شما نیست را بازطراحی می‌کنیم.',
    action: 'برنامه‌ریزی پروژه', services: 'چه می‌سازیم؟', serviceOne: 'وب‌سایت‌ها', serviceOneText: 'طراحی و بازطراحی وب‌سایت‌هایی روشن، کاربردی و سازگار با همهٔ صفحه‌ها.',
    serviceTwo: 'افزونه‌های وردپرس', serviceTwoText: 'ابزارهای اختصاصی برای نیازهای واقعی وب‌سایت و روند کاری شما.',
    serviceThree: 'اپلیکیشن‌های موبایل', serviceThreeText: 'تجربه‌های موبایل بر پایهٔ نیاز کسانی که هر روز از آن‌ها استفاده می‌کنند.',
    method: 'از نو بسازیم. آنچه هست را بهتر کنیم.', methodText: 'مسئله را می‌شناسیم، تجربه را طراحی می‌کنیم و نتیجه را می‌سازیم و اصلاح می‌کنیم.',
    close: 'از پروژه‌تان بگویید.', closeText: 'از نکات اصلی شروع کنیم و نسخهٔ بعدی را با هم شکل دهیم.',
    brand: 'UNDO', blog: 'یادداشت‌ها', blogText: 'دربارهٔ طراحی، ساخت و بهتر کردن چیزهای کاربردی.',
    footerTitle: 'برای شما از نو می‌سازیم.', footerText: 'وب‌سایت، افزونهٔ وردپرس و اپلیکیشن موبایل؛ برای آنچه پیش رو دارید.',
  },
};

for (const [language, c] of Object.entries(copy)) {
  index = 0;
  const langClass = `undo-starter--${language}`;
  write(`home-${language}`, c.home, 'page', [
    container(`undo-starter-home ${langClass}`, [
      container('undo-starter-hero', [
        heading(c.hero, 'undo-starter-display', 'h1'), text(c.intro, 'undo-starter-lead'), button(c.action, '#project-planner'),
      ]),
      container('undo-starter-services', [
        heading(c.services, 'undo-starter-section-title'),
        container('undo-starter-service-list', [
          container('undo-starter-service', [heading(c.serviceOne, '', 'h3'), text(c.serviceOneText)]),
          container('undo-starter-service', [heading(c.serviceTwo, '', 'h3'), text(c.serviceTwoText)]),
          container('undo-starter-service', [heading(c.serviceThree, '', 'h3'), text(c.serviceThreeText)]),
        ]),
      ]),
      container('undo-starter-method', [heading(c.method, 'undo-starter-section-title'), text(c.methodText, 'undo-starter-lead')]),
      container('undo-starter-close', [heading(c.close, 'undo-starter-section-title'), text(c.closeText, 'undo-starter-lead'), button(c.action, '#project-planner')]),
      fixedWidget(`home-planner-${language}`, 'shortcode', { shortcode: '[undo_home_planner]', _css_classes: 'undo-starter-planner' }),
    ]),
  ]);

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
