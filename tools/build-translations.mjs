import fs from 'node:fs';
import path from 'node:path';

const root = path.resolve('undo-theme');
const domain = 'undo-theme';
const fa = {
  '% comments':'% دیدگاه',
  '%s%% of the earlier layout visible':'%s٪ از طرح قبلی دیده می‌شود',
  'A better site or product should help people understand, decide, and act. The design follows that job.':'یک وب‌سایت یا محصول بهتر باید به مردم کمک کند بفهمند، تصمیم بگیرند و اقدام کنند. طراحی در خدمت همین هدف است.',
  'A redesign':'بازطراحی',
  'A website with purpose.':'وب‌سایتی با هدف روشن.',
  'Accent color':'رنگ تأکیدی',
  'After':'بعد',
  'Approach':'روش کار',
  'Before':'قبل',
  'Brand and language':'برند و زبان',
  'Build':'ساخت',
  'Built for every screen.':'برای هر صفحه‌ای ساخته شده.',
  'Button URL':'نشانی دکمه',
  'Button label (English)':'متن دکمه (انگلیسی)',
  'Button label (Persian)':'متن دکمه (فارسی)',
  'COMPANY NAME':'نام شرکت',
  'Close menu':'بستن منو',
  'Compare earlier and redesigned website concept':'مقایسه نمونه وب‌سایت پیش و پس از بازطراحی',
  'Contact and action':'تماس و اقدام',
  'Contact email':'ایمیل تماس',
  'Create new. Redo what exists.':'از صفر بسازید. موجود را بازطراحی کنید.',
  'Custom tools that add the features your website and workflow actually need.':'ابزارهای اختصاصی که قابلیت‌های موردنیاز وب‌سایت و روند کاری شما را اضافه می‌کنند.',
  'DESIGN / BUILD / REDO':'طراحی / ساخت / بازطراحی',
  'Default visitor language':'زبان پیش‌فرض بازدیدکننده',
  'Describe the problem or the result you want':'مسئله یا نتیجه دلخواهتان را توضیح دهید',
  'Design':'طراحی',
  'Details that make it last':'جزئیاتی که ماندگارند',
  'Download project brief':'دانلود خلاصه پروژه',
  'Drag to compare':'برای مقایسه بکشید',
  'Edit the default landing page and brand. Elementor pages use their own content.':'صفحه اصلی پیش‌فرض و برند را ویرایش کنید. صفحه‌های المنتور محتوای خودشان را دارند.',
  'English content':'محتوای انگلیسی',
  'Footer menu':'فهرست پایین صفحه',
  'Footer navigation':'ناوبری پایین صفحه',
  'Footer slogan (English)':'شعار پایین صفحه (انگلیسی)',
  'Footer slogan (Persian)':'شعار پایین صفحه (فارسی)',
  'Get started':'شروع کنید',
  'Goal':'هدف',
  'Goals, users, constraints':'هدف‌ها، کاربران، محدودیت‌ها',
  'Good design starts with understanding what needs to change. We map the problem, shape the experience, then build and refine the result.':'طراحی خوب از شناخت چیزی آغاز می‌شود که باید تغییر کند. مسئله را روشن می‌کنیم، تجربه را شکل می‌دهیم و سپس محصول را می‌سازیم و بهبود می‌دهیم.',
  'HOW WE WORK':'روند کار ما',
  'Hero description (English)':'توضیح بخش آغازین (انگلیسی)',
  'Hero description (Persian)':'توضیح بخش آغازین (فارسی)',
  'Hero title (English)':'عنوان بخش آغازین (انگلیسی)',
  'Hero title (Persian)':'عنوان بخش آغازین (فارسی)',
  'Home':'خانه',
  'Home  About  Services  Contact':'خانه  درباره ما  خدمات  تماس',
  'Interactive concept showing a website before and after a redesign':'نمونه تعاملی مقایسه وب‌سایت پیش و پس از بازطراحی',
  'Keep what works. Redo what does not.':'خوب‌ها را نگه دارید. بقیه را از نو بسازید.',
  'Language':'زبان',
  'Main navigation':'ناوبری اصلی',
  'Make the first impression count.':'تأثیر اول را ماندگار کنید.',
  'Mobile app':'اپلیکیشن موبایل',
  'Mobile apps':'اپلیکیشن‌های موبایل',
  'Mobile experiences designed around the people who will use them every day.':'تجربه‌های موبایلی که با نیاز کسانی طراحی می‌شوند که هر روز از آن‌ها استفاده می‌کنند.',
  'Mobile navigation':'ناوبری موبایل',
  'Name of your project':'نام پروژه شما',
  'New sites and thoughtful redesigns that communicate clearly and work across every screen.':'وب‌سایت‌های تازه و بازطراحی‌های سنجیده که پیام شما را روشن بیان می‌کنند و در هر صفحه‌ای درست کار می‌کنند.',
  'No comments':'بدون دیدگاه',
  'No posts found.':'نوشته‌ای پیدا نشد.',
  'One comment':'یک دیدگاه',
  'Open menu':'باز کردن منو',
  'Our process: understand, design, build, refine':'روند کار ما: شناخت، طراحی، ساخت و بهبود',
  'Overview':'معرفی',
  'Page not found':'صفحه پیدا نشد',
  'Page sections':'بخش‌های صفحه',
  'Persian content':'محتوای فارسی',
  'Plan a project':'برنامه‌ریزی پروژه',
  'Primary menu':'فهرست اصلی',
  'Project':'پروژه',
  'Project or business name':'نام پروژه یا کسب‌وکار',
  'Project planner':'برنامه‌ریز پروژه',
  'Put the essentials in one place. Download your brief when you are done, so it is ready to share when we connect.':'اطلاعات اصلی را یک‌جا بنویسید. وقتی تمام شد، خلاصه پروژه را دانلود کنید تا برای گفت‌وگوی بعدی آماده باشد.',
  'Redesign':'بازطراحی',
  'Refine':'بهبود',
  'Return home':'بازگشت به خانه',
  'Search results for: %s':'نتایج جست‌وجو برای: %s',
  'Service':'خدمت',
  'Services':'خدمات',
  'Show section navigation':'نمایش ناوبری بخش‌ها',
  'Skip to content':'رفتن به محتوای اصلی',
  'Something new':'پروژه‌ای تازه',
  'Start here':'از اینجا شروع کنید',
  'Starting point':'نقطه شروع',
  'Structure, content, interface':'ساختار، محتوا، رابط کاربری',
  'Tell us what you want to make.':'از پروژه‌ای که در ذهن دارید بگویید.',
  'The page you requested is unavailable.':'صفحه موردنظر شما در دسترس نیست.',
  'The UNDO theme update failed its checksum check.':'بررسی صحت فایل به‌روزرسانی پوسته UNDO ناموفق بود.',
  'The right work for the next version of your business.':'کار درست برای نسخه بعدی کسب‌وکار شما.',
  'To be discussed':'در گفت‌وگو مشخص می‌شود',
  'UNDO Theme Settings':'تنظیمات پوسته UNDO',
  'Unable to verify the UNDO theme update package.':'اعتبار فایل به‌روزرسانی پوسته UNDO تأیید نشد.',
  'UNDO Web Developments — Project brief':'توسعه وب UNDO — خلاصه پروژه',
  'UNDO Web Developments, back to top':'توسعه وب UNDO، بازگشت به ابتدا',
  'UNDO creates new digital products and redesigns the ones that no longer serve your business. From the first screen to the working code.':'UNDO محصولات دیجیتال تازه می‌سازد و آنچه دیگر به کار کسب‌وکار شما نمی‌آید از نو طراحی می‌کند؛ از اولین صفحه تا کد نهایی.',
  'Understand':'شناخت',
  'Untitled project':'پروژه بدون نام',
  'WE REDO IT FOR YOU.':'برای شما از نو می‌سازیم.',
  'WELCOME TO OUR WEBSITE':'به وب‌سایت ما خوش آمدید',
  'We provide solutions for your needs':'برای نیازهای شما راهکار داریم',
  'Web Developments':'توسعه وب',
  'Website':'وب‌سایت',
  'Websites':'وب‌سایت‌ها',
  'Websites, plugins & apps made better.':'وب‌سایت‌ها، افزونه‌ها و اپ‌ها؛ بهتر از قبل.',
  'What do you need?':'به چه چیزی نیاز دارید؟',
  'What should it help you do?':'قرار است چه کمکی به شما بکند؟',
  'What we build.':'چه می‌سازیم.',
  'Where are you starting?':'از کجا شروع می‌کنید؟',
  'Whether the starting point is a blank page or an existing product, UNDO brings design and development together to make it easier to use, easier to manage, and ready to grow.':'چه از یک ایده تازه شروع کنید، چه محصولی آماده داشته باشید، UNDO طراحی و توسعه را کنار هم می‌آورد تا تجربه‌ای ساده‌تر، مدیریتی آسان‌تر و بستری آماده رشد بسازد.',
  'WordPress plugin':'افزونه وردپرس',
  'WordPress plugins':'افزونه‌های وردپرس',
  'Work  About  Contact':'نمونه‌کارها  درباره ما  تماس',
  'Working product':'محصولی که کار می‌کند',
  'Your answers stay in this browser. The brief downloads to your device.':'پاسخ‌های شما در همین مرورگر می‌ماند. خلاصه پروژه روی دستگاهتان دانلود می‌شود.',
  'Your project brief has been downloaded.':'خلاصه پروژه شما دانلود شد.',
  'new perspective':'نگاه تازه',
  'UNDO Web Developments':'توسعه وب UNDO',
  'A bilingual, RTL-ready agency theme with Elementor support and editable brand settings.':'پوسته شرکتی دوزبانه و راست‌چین با پشتیبانی از المنتور و تنظیمات قابل ویرایش برند.'
};

Object.assign(fa, {
  'Header logo': 'نشان سربرگ',
  'Maximum logo width in pixels': 'بیشترین عرض نشان به پیکسل',
  'Select header logo': 'انتخاب نشان سربرگ',
  'Use this image': 'استفاده از این تصویر',
  'Select image': 'انتخاب تصویر',
  'Remove image': 'حذف تصویر',
  "Action URL": "نشانی دکمه اقدام",
  "Action label (English)": "متن دکمه اقدام (انگلیسی)",
  "Action label (Persian)": "متن دکمه اقدام (فارسی)",
  "Blog": "وبلاگ",
  "Boxed": "محدود",
  "Built-in footer settings. Elementor Theme Builder can replace this template.": "تنظیمات پانوشت داخلی. قالب‌ساز المنتور می‌تواند این قالب را جایگزین کند.",
  "Built-in header settings. Elementor Theme Builder can replace this template.": "تنظیمات سربرگ داخلی. قالب‌ساز المنتور می‌تواند این قالب را جایگزین کند.",
  "Built-in landing page copy. Elementor pages use their own content.": "متن صفحه اصلی داخلی. صفحه‌های المنتور محتوای خود را دارند.",
  "Card columns": "تعداد ستون‌های کارت",
  "Content width in pixels": "عرض محتوا به پیکسل",
  "End": "انتهای جهت نوشتار",
  "English": "انگلیسی",
  "Excerpt length in words": "طول خلاصه به واژه",
  "Footer": "پانوشت",
  "Header": "سربرگ",
  "Homepage": "صفحه اصلی",
  "Language, width, and shared colors.": "زبان، عرض و رنگ‌های مشترک.",
  "Normal WordPress pages. Elementor pages use their own layout.": "صفحه‌های معمولی وردپرس. صفحه‌های المنتور چیدمان خود را دارند.",
  "Pages": "صفحه‌ها",
  "Persian": "فارسی",
  "Post cards in blog, archive, and search results.": "کارت‌های نوشته در وبلاگ، بایگانی و نتایج جست‌وجو.",
  "Post details in the built-in single template.": "جزئیات نوشته در قالب داخلی نوشته.",
  "Primary sidebar": "نوار کناری اصلی",
  "Show action button": "نمایش دکمه اقدام",
  "Show author": "نمایش نویسنده",
  "Show card dates": "نمایش تاریخ کارت‌ها",
  "Show card images": "نمایش تصویر کارت‌ها",
  "Show categories": "نمایش دسته‌ها",
  "Show comments": "نمایش دیدگاه‌ها",
  "Show contact email": "نمایش ایمیل تماس",
  "Show copyright": "نمایش حق نشر",
  "Show date": "نمایش تاریخ",
  "Show excerpts": "نمایش خلاصه‌ها",
  "Show featured image": "نمایش تصویر شاخص",
  "Show footer brand": "نمایش برند پانوشت",
  "Show footer navigation": "نمایش فهرست پانوشت",
  "Show language switcher": "نمایش تغییر زبان",
  "Show main navigation": "نمایش فهرست اصلی",
  "Show on archives": "نمایش در بایگانی‌ها",
  "Show on search results": "نمایش در نتایج جست‌وجو",
  "Show page sidebar": "نمایش نوار کناری صفحه",
  "Show page title": "نمایش عنوان صفحه",
  "Show post sidebar": "نمایش نوار کناری نوشته",
  "Show previous and next posts": "نمایش نوشته‌های قبلی و بعدی",
  "Sidebar": "نوار کناری",
  "Sidebar position": "جایگاه نوار کناری",
  "Sidebar width in pixels": "عرض نوار کناری به پیکسل",
  "Single post": "تک‌نوشته",
  "Site width": "عرض وب‌سایت",
  "Start": "ابتدای جهت نوشتار",
  "Sticky header": "سربرگ چسبان",
  "The sidebar appears only where enabled and when widgets are assigned.": "نوار کناری فقط در بخش‌های فعال و پس از افزودن ابزارک نمایش داده می‌شود.",
  "Theme settings sections": "بخش‌های تنظیمات پوسته",
  "Website layout": "چیدمان وب‌سایت",
  "Wide": "عریض",
  "Widgets shown beside posts, pages, or archives when enabled in UNDO Theme Settings.": "ابزارک‌هایی که با فعال‌سازی در تنظیمات پوسته UNDO کنار نوشته‌ها، صفحه‌ها یا بایگانی‌ها نمایش داده می‌شوند.",
});

const files = [];
function walk(dir) { for (const name of fs.readdirSync(dir)) { const file = path.join(dir, name); if (fs.statSync(file).isDirectory()) walk(file); else if (file.endsWith('.php')) files.push(file); } }
walk(root);
const refs = new Map();
const pattern = /(?:__|_e|esc_html__|esc_html_e|esc_attr__|esc_attr_e)\(\s*'([^']+)'\s*,\s*'undo-theme'/g;
for (const file of files) {
  const source = fs.readFileSync(file, 'utf8');
  for (const match of source.matchAll(pattern)) {
    const id = match[1];
    const line = source.slice(0, match.index).split('\n').length;
    if (!refs.has(id)) refs.set(id, []);
    refs.get(id).push(`${path.relative(root, file).replaceAll('\\', '/')}:${line}`);
  }
}
for (const id of ['UNDO Web Developments', 'A bilingual, RTL-ready agency theme with Elementor support and editable brand settings.']) refs.set(id, ['style.css:1']);
const ids = [...refs.keys()].sort((a, b) => Buffer.compare(Buffer.from(a), Buffer.from(b)));
const missing = ids.filter(id => !fa[id]);
if (missing.length) throw new Error('Missing Persian translations: ' + missing.join(' | '));
const quote = value => JSON.stringify(value);
const header = locale => [
  'Project-Id-Version: UNDO Web Developments 0.2.4',
  'Report-Msgid-Bugs-To: UNDO Web Developments',
  'Content-Type: text/plain; charset=UTF-8',
  'Content-Transfer-Encoding: 8bit',
  'Language: ' + locale,
  'Plural-Forms: nplurals=2; plural=(n != 1);'
].join('\n') + '\n';
const languages = path.join(root, 'languages');
fs.mkdirSync(languages, { recursive: true });
function po(locale, translations) {
  let output = `msgid ""\nmsgstr ${quote(header(locale))}\n\n`;
  for (const id of ids) output += `#: ${refs.get(id).join(' ')}\nmsgid ${quote(id)}\nmsgstr ${quote(translations[id] ?? '')}\n\n`;
  return output;
}
fs.writeFileSync(path.join(languages, domain + '.pot'), po('', {}));
fs.writeFileSync(path.join(languages, 'en_US.po'), po('en_US', Object.fromEntries(ids.map(id => [id, id]))));
fs.writeFileSync(path.join(languages, 'fa_IR.po'), po('fa_IR', fa));
function mo(locale, translations) {
  const rows = [['', header(locale)], ...ids.map(id => [id, translations[id]])];
  const count = rows.length, originalTable = 28, translatedTable = originalTable + count * 8;
  let cursor = translatedTable + count * 8;
  const originals = rows.map(([id]) => { const bytes = Buffer.from(id); const entry = { bytes, offset: cursor }; cursor += bytes.length + 1; return entry; });
  const values = rows.map(([, value]) => { const bytes = Buffer.from(value); const entry = { bytes, offset: cursor }; cursor += bytes.length + 1; return entry; });
  const buffer = Buffer.alloc(cursor);
  buffer.writeUInt32LE(0x950412de, 0); buffer.writeUInt32LE(0, 4); buffer.writeUInt32LE(count, 8);
  buffer.writeUInt32LE(originalTable, 12); buffer.writeUInt32LE(translatedTable, 16);
  for (let i = 0; i < count; i++) {
    buffer.writeUInt32LE(originals[i].bytes.length, originalTable + i * 8);
    buffer.writeUInt32LE(originals[i].offset, originalTable + i * 8 + 4);
    buffer.writeUInt32LE(values[i].bytes.length, translatedTable + i * 8);
    buffer.writeUInt32LE(values[i].offset, translatedTable + i * 8 + 4);
    originals[i].bytes.copy(buffer, originals[i].offset);
    values[i].bytes.copy(buffer, values[i].offset);
  }
  fs.writeFileSync(path.join(languages, locale + '.mo'), buffer);
}
mo('en_US', Object.fromEntries(ids.map(id => [id, id])));
mo('fa_IR', fa);
console.log(`Built POT, en_US and fa_IR PO/MO files for ${ids.length} strings.`);
