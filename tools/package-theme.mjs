import fs from 'node:fs';
import path from 'node:path';
import crypto from 'node:crypto';

const project = process.cwd();
const theme = path.join(project, 'undo-theme');
const slug = path.basename(theme);
const stylesheet = fs.readFileSync(path.join(theme, 'style.css'), 'utf8');
const version = stylesheet.match(/^Version:\s*([^\r\n]+)/m)?.[1];
const textDomain = stylesheet.match(/^Text Domain:\s*([^\r\n]+)/m)?.[1];
const phpVersion = fs.readFileSync(path.join(theme, 'functions.php'), 'utf8').match(/UNDO_THEME_VERSION',\s*'([^']+)'/)?.[1];
const stableTag = fs.readFileSync(path.join(theme, 'readme.txt'), 'utf8').match(/^Stable tag:\s*([^\r\n]+)/m)?.[1];
if (!version || version !== phpVersion || version !== stableTag) throw new Error('Theme version mismatch');
if (textDomain !== slug) throw new Error(`Theme text domain must match folder: ${slug}`);
fs.copyFileSync(path.join(project, 'CHANGELOG.md'), path.join(theme, 'CHANGELOG.md'));
const outputDir = path.join(project, 'dist');
fs.mkdirSync(outputDir, { recursive: true });
const output = path.join(outputDir, `${slug}-${version}.zip`);
const files = [];
function walk(dir) {
  for (const name of fs.readdirSync(dir)) {
    if (name.startsWith('.') || name === 'node_modules') continue;
    const absolute = path.join(dir, name);
    if (fs.statSync(absolute).isDirectory()) walk(absolute);
    else files.push({ name: slug + '/' + path.relative(theme, absolute).replaceAll('\\', '/'), data: fs.readFileSync(absolute) });
  }
}
walk(theme);
files.sort((a, b) => a.name.localeCompare(b.name));
const crcTable = Array.from({ length: 256 }, (_, n) => { let c = n; for (let i = 0; i < 8; i++) c = c & 1 ? 0xedb88320 ^ (c >>> 1) : c >>> 1; return c >>> 0; });
function crc32(data) { let c = 0xffffffff; for (const byte of data) c = crcTable[(c ^ byte) & 255] ^ (c >>> 8); return (c ^ 0xffffffff) >>> 0; }
const chunks = [], central = [];
let offset = 0;
for (const file of files) {
  const name = Buffer.from(file.name, 'utf8'), crc = crc32(file.data);
  const local = Buffer.alloc(30);
  local.writeUInt32LE(0x04034b50, 0); local.writeUInt16LE(20, 4); local.writeUInt16LE(0x0800, 6);
  local.writeUInt32LE(crc, 14); local.writeUInt32LE(file.data.length, 18); local.writeUInt32LE(file.data.length, 22); local.writeUInt16LE(name.length, 26);
  chunks.push(local, name, file.data);
  const record = Buffer.alloc(46);
  record.writeUInt32LE(0x02014b50, 0); record.writeUInt16LE(20, 4); record.writeUInt16LE(20, 6); record.writeUInt16LE(0x0800, 8);
  record.writeUInt32LE(crc, 16); record.writeUInt32LE(file.data.length, 20); record.writeUInt32LE(file.data.length, 24);
  record.writeUInt16LE(name.length, 28); record.writeUInt32LE(offset, 42);
  central.push(record, name);
  offset += local.length + name.length + file.data.length;
}
const directory = Buffer.concat(central);
const end = Buffer.alloc(22);
end.writeUInt32LE(0x06054b50, 0); end.writeUInt16LE(files.length, 8); end.writeUInt16LE(files.length, 10);
end.writeUInt32LE(directory.length, 12); end.writeUInt32LE(offset, 16);
const archive = Buffer.concat([...chunks, directory, end]);
fs.writeFileSync(output, archive);
const sha = crypto.createHash('sha256').update(archive).digest('hex');
fs.writeFileSync(output + '.sha256', `${sha}  ${path.basename(output)}\n`);
console.log(JSON.stringify({ output, files: files.length, bytes: archive.length, sha256: sha }));
