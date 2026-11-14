import fs from 'node:fs';
import path from 'node:path';
import assert from 'node:assert/strict';

const directory = path.resolve('undo-theme/elementor-templates');
const expected = { home: 'page', 'blog-page': 'page', header: 'header', footer: 'footer', 'blog-archive': 'archive' };
for (const [slug, type] of Object.entries(expected)) {
  for (const language of ['en', 'fa']) {
    const name = `${slug}-${language}.json`;
    const document = JSON.parse(fs.readFileSync(path.join(directory, name), 'utf8'));
    assert.equal(document.type, type, `${name}: document type`);
    assert.equal(document.version, '0.4', `${name}: Elementor data version`);
    assert.ok(Array.isArray(document.content) && document.content.length, `${name}: nonempty content`);
    const ids = new Set();
    const widgets = [];
    function check(elements) {
      for (const element of elements) {
        assert.match(element.id, /^[a-f0-9]{8}$/, `${name}: element ID`);
        assert.ok(!ids.has(element.id), `${name}: duplicate element ID`);
        ids.add(element.id);
        assert.ok(['container', 'widget'].includes(element.elType), `${name}: supported element`);
        assert.ok(Array.isArray(element.elements), `${name}: nested elements`);
        if (element.elType === 'container') {
          assert.ok(element.settings.css_classes, `${name}: Elementor container CSS classes`);
          assert.ok(!('_css_classes' in element.settings), `${name}: no widget-only CSS class key on containers`);
        }
        if (element.elType === 'widget') widgets.push(element);
        check(element.elements);
      }
    }
    check(document.content);
    assert.ok(widgets.some(widget => widget.widgetType === 'heading'), `${name}: editable heading`);
    if (slug === 'blog-archive') assert.ok(widgets.some(widget => widget.widgetType === 'archive-posts'), `${name}: dynamic archive loop`);
    if (slug === 'blog-page') assert.ok(widgets.some(widget => widget.widgetType === 'shortcode' && widget.settings.shortcode === '[undo_blog_posts]'), `${name}: Free posts loop`);
    if (slug === 'footer') assert.ok(widgets.some(widget => widget.widgetType === 'shortcode' && widget.settings.shortcode === '[undo_footer_widgets]'), `${name}: optional WordPress widget areas`);
    if (slug === 'home') {
      assert.ok(widgets.some(widget => widget.widgetType === 'shortcode' && widget.settings.shortcode === '[undo_home_planner]'), `${name}: working project planner`);
      assert.match(document.content[0].settings.css_classes, /\bundo-native-home\b/, `${name}: native Home styles`);
      assert.match(document.content[0].settings.css_classes, /\bundo-elementor-home\b/, `${name}: Elementor Home styles`);
      assert.deepEqual(document.content[0].elements.slice(0, 5).map(element => element.settings._element_id), ['top', 'overview', 'services', 'approach', 'redesign'], `${name}: native Home section order and anchors`);
      for (const section of document.content[0].elements.slice(0, 5)) {
        assert.equal(section.settings.html_tag, 'section', `${name}: semantic Home section`);
        assert.ok(section.settings.css_classes, `${name}: rendered native section class`);
      }
      const html = widgets.filter(widget => widget.widgetType === 'html').map(widget => widget.settings.html).join('\n');
      for (const feature of ['hero-stage', 'comparison-range', 'before-site', 'phone', 'intro-mark', 'service-number', 'web-glyph', 'plugin-glyph', 'app-glyph', 'process-board', 'process-step']) {
        assert.ok(html.includes(feature), `${name}: native ${feature} markup`);
      }
      assert.equal((html.match(/class="process-step"/g) || []).length, 4, `${name}: four process steps`);
      assert.equal(document.content[0].elements[2].elements[0].elements[1].elements.length, 3, `${name}: three editable service rows`);
      assert.ok(widgets.some(widget => widget.widgetType === 'button' && widget.settings.link?.url === '#project-planner'), `${name}: planner action`);
    }
  }
}
console.log('Ten Elementor starter templates have the expected editable structure.');
