(() => {
  const customTemplate = 'template-custom-width.php';
  const templateSelect = () => document.querySelector('#page_template, select[name="page_template"]');
  const currentTemplate = () => {
    const editor = window.wp?.data?.select?.('core/editor');
    const edited = editor?.getEditedPostAttribute?.('template');
    return typeof edited === 'string' ? edited : (templateSelect()?.value || '');
  };
  const update = () => {
    const panel = document.getElementById('undo-page-width');
    if (panel) panel.hidden = currentTemplate() !== customTemplate;
  };
  document.addEventListener('change', (event) => {
    if (event.target === templateSelect()) update();
  });
  window.wp?.data?.subscribe?.(update);
  const observer = new MutationObserver(() => {
    if (document.getElementById('undo-page-width')) { observer.disconnect(); update(); }
  });
  observer.observe(document.body, { childList: true, subtree: true });
  update();
})();
