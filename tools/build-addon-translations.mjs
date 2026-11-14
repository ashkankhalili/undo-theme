import fs from 'node:fs';
import path from 'node:path';

const root = path.resolve('undo-elements');
const fa = {
  'A clearer starting point':'نقطهٔ شروعی روشن‌تر',
  'A redesign':'بازطراحی',
  'Button':'دکمه',
  'Clear, useful digital experiences built around your business.':'تجربه‌های دیجیتال روشن و کاربردی، متناسب با کسب‌وکار شما.',
  'Content':'محتوا',
  'Describe the problem or the result you want':'مسئله یا نتیجه‌ای را که می‌خواهید شرح دهید',
  'Description':'توضیحات',
  'Download project brief':'دریافت خلاصهٔ پروژه',
  'Elementor widgets and a browser-only project brief for UNDO websites.':'ابزارک‌های المنتور و خلاصهٔ پروژهٔ خصوصی برای وب‌سایت‌های UNDO.',
  'Eyebrow':'عنوان کوچک',
  'Goal':'هدف',
  'Heading':'عنوان',
  'Index':'شماره',
  'Let us make it better.':'بیایید بهترش کنیم.',
  'Link':'پیوند',
  'Mobile app':'اپلیکیشن موبایل',
  'Name of your project':'نام پروژهٔ شما',
  'Plan a project':'برنامه‌ریزی پروژه',
  'Project':'پروژه',
  'Project brief':'خلاصهٔ پروژه',
  'Project invitation':'دعوت به پروژه',
  'Project or business name':'نام پروژه یا کسب‌وکار',
  'Project planner':'برنامه‌ریز پروژه',
  'Put the essentials in one place. Download your brief when you are done, so it is ready to share when we connect.':'اطلاعات اصلی را در یک جا جمع کنید. پس از پایان، خلاصهٔ پروژه را دریافت کنید تا برای گفت‌وگو آماده باشد.',
  'Service':'خدمت',
  'Service card':'کارت خدمات',
  'Something new':'یک پروژهٔ تازه',
  'Starting point':'نقطهٔ شروع',
  'THE NEXT VERSION STARTS HERE':'نسخهٔ بعدی از اینجا آغاز می‌شود',
  'Tell us what you want to make.':'بگویید چه می‌خواهید بسازید.',
  'The UNDO Elements update failed its checksum check.':'اعتبارسنجی کد SHA-256 به‌روزرسانی UNDO Elements ناموفق بود.',
  'To discuss':'برای گفت‌وگو',
  'UNDO Elements':'المان‌های UNDO',
  'UNDO Elements needs Elementor for its widgets. The project planner shortcode remains available.':'ابزارک‌های UNDO Elements به المنتور نیاز دارند. کد کوتاه برنامه‌ریز پروژه همچنان در دسترس است.',
  'Unable to verify the UNDO Elements update package.':'امکان اعتبارسنجی بستهٔ به‌روزرسانی UNDO Elements وجود ندارد.',
  'Untitled project':'پروژهٔ بدون نام',
  'Website':'وب‌سایت',
  'Websites':'وب‌سایت‌ها',
  'What do you need?':'به چه چیزی نیاز دارید؟',
  'What should it help you do?':'قرار است به چه کاری کمک کند؟',
  'Where are you starting?':'از کجا شروع می‌کنید؟',
  'WordPress plugin':'افزونهٔ وردپرس',
  'Your answers stay in this browser. The brief downloads to your device.':'پاسخ‌های شما در همین مرورگر می‌مانند. خلاصهٔ پروژه روی دستگاه شما دریافت می‌شود.',
  'Your brief has been downloaded.':'خلاصهٔ پروژه دریافت شد.',
  'undo-project-brief.txt':'undo-project-brief-fa.txt',
};
const files = [];
function walk(dir) { for (const name of fs.readdirSync(dir)) { const file = path.join(dir,name); if (fs.statSync(file).isDirectory()) walk(file); else if (file.endsWith('.php')) files.push(file); } }
walk(root);
const refs = new Map();
const pattern = /(?:__|_e|esc_html__|esc_html_e|esc_attr__|esc_attr_e)\(\s*'([^']+)'\s*,\s*'undo-elements'/g;
for (const file of files) {
  const source = fs.readFileSync(file,'utf8');
  for (const match of source.matchAll(pattern)) {
    const id=match[1];
    if (!refs.has(id)) refs.set(id,[]);
    refs.get(id).push(`${path.relative(root,file).replaceAll('\\','/')}:${source.slice(0,match.index).split('\n').length}`);
  }
}
const ids=[...refs.keys()].sort((a,b)=>Buffer.compare(Buffer.from(a),Buffer.from(b)));
const missing=ids.filter(id=>!Object.hasOwn(fa,id));
if(missing.length) throw new Error('Missing Persian translations: '+missing.join(' | '));
const header=locale=>[
  'Project-Id-Version: UNDO Elements 0.1.0','Report-Msgid-Bugs-To: UNDO Web Developments',
  'Content-Type: text/plain; charset=UTF-8','Content-Transfer-Encoding: 8bit',
  'Language: '+locale,'Plural-Forms: nplurals=2; plural=(n != 1);'
].join('\n')+'\n';
const languages=path.join(root,'languages');fs.mkdirSync(languages,{recursive:true});
function po(locale,translations){let out=`msgid ""\nmsgstr ${JSON.stringify(header(locale))}\n\n`;for(const id of ids)out+=`#: ${refs.get(id).join(' ')}\nmsgid ${JSON.stringify(id)}\nmsgstr ${JSON.stringify(translations[id]??'')}\n\n`;return out.trimEnd()+'\n';}
fs.writeFileSync(path.join(languages,'undo-elements.pot'),po('',{}));
fs.writeFileSync(path.join(languages,'undo-elements-en_US.po'),po('en_US',Object.fromEntries(ids.map(id=>[id,id]))));
fs.writeFileSync(path.join(languages,'undo-elements-fa_IR.po'),po('fa_IR',fa));
function mo(locale,translations){
  const rows=[['',header(locale)],...ids.map(id=>[id,translations[id]])];
  const count=rows.length,originalTable=28,translatedTable=originalTable+count*8;
  let cursor=translatedTable+count*8;
  const originals=rows.map(([id])=>{const bytes=Buffer.from(id);const entry={bytes,offset:cursor};cursor+=bytes.length+1;return entry;});
  const values=rows.map(([,value])=>{const bytes=Buffer.from(value);const entry={bytes,offset:cursor};cursor+=bytes.length+1;return entry;});
  const buffer=Buffer.alloc(cursor);buffer.writeUInt32LE(0x950412de,0);buffer.writeUInt32LE(0,4);buffer.writeUInt32LE(count,8);buffer.writeUInt32LE(originalTable,12);buffer.writeUInt32LE(translatedTable,16);
  for(let i=0;i<count;i++){buffer.writeUInt32LE(originals[i].bytes.length,originalTable+i*8);buffer.writeUInt32LE(originals[i].offset,originalTable+i*8+4);buffer.writeUInt32LE(values[i].bytes.length,translatedTable+i*8);buffer.writeUInt32LE(values[i].offset,translatedTable+i*8+4);originals[i].bytes.copy(buffer,originals[i].offset);values[i].bytes.copy(buffer,values[i].offset);}
  fs.writeFileSync(path.join(languages,`undo-elements-${locale}.mo`),buffer);
}
mo('en_US',Object.fromEntries(ids.map(id=>[id,id])));mo('fa_IR',fa);
console.log(`Built UNDO Elements POT and en_US/fa_IR PO/MO for ${ids.length} strings.`);
