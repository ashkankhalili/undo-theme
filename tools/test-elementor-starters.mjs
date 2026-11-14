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
      assert.deepEqual(document.content[0].elements.slice(0, 5).map(element => element.settings._element_id), ['top', 'overview', 'services', 'approach', 'redesign'], `${name}: native Home section order and anchors`);
    }
  }
}
console.log('Ten Elementor starter templates have the expected editable structure.');
