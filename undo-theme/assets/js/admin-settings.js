const settingsForm = document.querySelector('.undo-settings__form');
const dirtyStatus = document.querySelector('[data-undo-dirty-status]');
const markDirty = () => { if (dirtyStatus) dirtyStatus.textContent = undoSettingsMedia.unsaved; };
settingsForm?.addEventListener('input', markDirty);
settingsForm?.addEventListener('change', markDirty);
settingsForm?.querySelectorAll('.undo-optional-color').forEach((field) => {
  const picker = field.querySelector('[data-undo-color-picker]');
  const text = field.querySelector('[data-undo-color-text]');
  picker?.addEventListener('input', () => { text.value = picker.value; markDirty(); });
  text?.addEventListener('input', () => { if (/^#[0-9a-f]{6}$/i.test(text.value)) picker.value = text.value; });
  field.querySelector('[data-undo-color-clear]')?.addEventListener('click', () => { text.value = ''; markDirty(); text.focus(); });
});

const tabs = [...document.querySelectorAll('[data-undo-tab]')];
const panels = [...document.querySelectorAll('[data-undo-panel]')];
function showSettingsTab(slug, updateUrl = true) {
  if (!tabs.some((tab) => tab.dataset.undoTab === slug)) return;
  tabs.forEach((tab) => {
    const selected = tab.dataset.undoTab === slug;
    tab.classList.toggle('is-active', selected);
    tab.setAttribute('aria-selected', String(selected));
    tab.tabIndex = selected ? 0 : -1;
  });
  panels.forEach((panel) => { panel.hidden = panel.dataset.undoPanel !== slug; });
  if (updateUrl) {
    const url = new URL(location.href);
    url.searchParams.set('tab', slug);
    history.replaceState(history.state, '', url);
    const referer = settingsForm?.querySelector('input[name="_wp_http_referer"]');
    if (referer) referer.value = url.pathname + url.search;
  }
}
tabs.forEach((tab, index) => {
  tab.addEventListener('click', (event) => { event.preventDefault(); showSettingsTab(tab.dataset.undoTab); });
  tab.addEventListener('keydown', (event) => {
    const next = event.key === 'ArrowDown' ? index + 1 : event.key === 'ArrowUp' ? index - 1 : event.key === 'Home' ? 0 : event.key === 'End' ? tabs.length - 1 : null;
    if (next === null) return;
    event.preventDefault();
    const target = tabs[(next + tabs.length) % tabs.length];
    showSettingsTab(target.dataset.undoTab);
    target.focus();
  });
});
showSettingsTab(new URL(location.href).searchParams.get('tab') || 'layout', false);

document.querySelectorAll('.undo-media-field').forEach((field) => {
  const input = field.querySelector('.undo-media-id');
  const preview = field.querySelector('.undo-media-preview');
  const select = field.querySelector('.undo-media-select');
  const remove = field.querySelector('.undo-media-remove');
  select.addEventListener('click', () => {
    const frame = wp.media({
      title: undoSettingsMedia.title,
      button: { text: undoSettingsMedia.use },
      library: { type: 'image' },
      multiple: false,
    });
    frame.on('select', () => {
      const attachment = frame.state().get('selection').first().toJSON();
      input.value = String(attachment.id);
      preview.replaceChildren();
      const image = document.createElement('img');
      image.src = attachment.sizes?.medium?.url || attachment.url;
      image.alt = '';
      image.style.cssText = 'max-width:220px;max-height:80px;width:auto;height:auto;';
      preview.append(image);
      markDirty();
    });
    frame.open();
  });
  remove.addEventListener('click', () => {
    input.value = '0';
    preview.replaceChildren();
    markDirty();
  });
});

document.querySelectorAll('[data-undo-depends]').forEach((row) => {
  const [key, expected] = row.dataset.undoDepends.split(':');
  const controller = document.getElementById(`undo-${key}`);
  if (!controller) return;
  const update = () => {
    const visible = controller.type === 'checkbox' ? controller.checked : controller.value === expected;
    row.hidden = !visible;
    row.style.display = visible ? '' : 'none';
  };
  controller.addEventListener('change', update);
  update();
});

const fontList = document.querySelector('[data-undo-font-list]');
const fontTemplate = document.getElementById('undo-font-row-template');
const fontChoices = [...document.querySelectorAll('[data-undo-font-choice]')];
let nextFontIndex = fontList?.children.length || 0;
const usedFontIds = new Set([...(fontList?.querySelectorAll('[data-undo-font-id]') || [])].map((input) => input.value));
let nextFontId = 1;
function newFontId() {
  while (usedFontIds.has(`custom-${nextFontId}`) && nextFontId < 1000) nextFontId++;
  const id = `custom-${nextFontId}`;
  usedFontIds.add(id);
  nextFontId++;
  return id;
}
function refreshFontChoices() {
  const available = [...(fontList?.querySelectorAll('[data-undo-font-row]') || [])].map((row) => ({
    id: row.querySelector('[data-undo-font-id]')?.value,
    name: row.querySelector('[data-undo-font-name]')?.value.trim(),
    regular: row.querySelector('[data-undo-font-file="regular"]')?.value,
  })).filter((font) => font.id && font.name && Number(font.regular) > 0);
  fontChoices.forEach((select) => {
    const selected = select.value;
    select.querySelectorAll('[data-undo-custom-font]').forEach((option) => option.remove());
    available.forEach((font) => {
      const option = new Option(font.name, font.id);
      option.dataset.undoCustomFont = '1';
      (select.querySelector('[data-undo-custom-group]') || select).append(option);
    });
    select.value = available.some((font) => font.id === selected) || [...select.options].some((option) => option.value === selected) ? selected : 'default';
  });
}
document.querySelector('[data-undo-font-add]')?.addEventListener('click', () => {
  if (!fontList || !fontTemplate) return;
  if (fontList.children.length >= 12) { window.alert(undoSettingsMedia.fontLimit); return; }
  const html = fontTemplate.innerHTML.replaceAll('__INDEX__', String(nextFontIndex++)).replaceAll('__ID__', newFontId());
  fontList.insertAdjacentHTML('beforeend', html);
  fontList.lastElementChild?.querySelector('[data-undo-font-name]')?.focus();
  markDirty();
});
fontList?.addEventListener('input', (event) => { if (event.target.matches('[data-undo-font-name]')) refreshFontChoices(); });
fontList?.addEventListener('click', (event) => {
  const row = event.target.closest('[data-undo-font-row]');
  if (!row) return;
  if (event.target.closest('[data-undo-font-remove]')) { row.remove(); refreshFontChoices(); markDirty(); return; }
  const clear = event.target.closest('[data-undo-font-clear]');
  if (clear) {
    const weight = clear.dataset.undoFontClear;
    row.querySelector(`[data-undo-font-file="${weight}"]`).value = '0';
    row.querySelector(`[data-undo-font-filename="${weight}"]`).textContent = undoSettingsMedia.fontNone;
    refreshFontChoices(); markDirty(); return;
  }
  const upload = event.target.closest('[data-undo-font-upload]');
  if (!upload) return;
  const weight = upload.dataset.undoFontUpload;
  const frame = wp.media({ title: undoSettingsMedia.fontTitle, button: { text: undoSettingsMedia.fontUse }, library: { type: ['font/woff2', 'application/font-woff2'] }, multiple: false });
  frame.on('select', () => {
    const attachment = frame.state().get('selection').first()?.toJSON();
    if (!attachment || !['font/woff2', 'application/font-woff2'].includes(attachment.mime) || !/\.woff2$/i.test(attachment.filename || '')) { window.alert(undoSettingsMedia.fontInvalid); return; }
    row.querySelector(`[data-undo-font-file="${weight}"]`).value = String(attachment.id);
    row.querySelector(`[data-undo-font-filename="${weight}"]`).textContent = attachment.filename;
    refreshFontChoices(); markDirty();
  });
  frame.open();
});
refreshFontChoices();
