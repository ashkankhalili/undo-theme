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
    });
    frame.open();
  });
  remove.addEventListener('click', () => {
    input.value = '0';
    preview.replaceChildren();
  });
});
