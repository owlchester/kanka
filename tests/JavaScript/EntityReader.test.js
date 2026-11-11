import assert from 'node:assert/strict';
import { test } from 'node:test';
import { collectSections, postIdFromHash, readHash, scrollToSection, sectionSlug } from '../../resources/js/entities/reader/navigation.js';

test('only exact post anchors can trigger post loading', () => {
    assert.equal(postIdFromHash('#post-42'), '42');
    assert.equal(postIdFromHash('#post%2D42'), '42');
    for (const hash of ['', '#post-0', '#post--1', '#post-2-extra', '#early-years-42', '#entity-details-42', '#reader-section-post-42-age-12', '#%E0%A4%A']) {
        assert.equal(postIdFromHash(hash), null, hash);
    }
});

test('heading hashes support Unicode and fail safely on malformed escaping', () => {
    assert.equal(readHash('#%E5%87%BA%E7%94%9F'), '出生');
    assert.equal(readHash('#early%20years'), 'early years');
    assert.equal(readHash('#%E0%A4%A'), '');
});

test('generated section names are deterministic and support international headings', () => {
    assert.equal(sectionSlug('  Éarly years & adventures! '), 'early-years-adventures');
    assert.equal(sectionSlug('出生'), '出生');
    assert.equal(sectionSlug('!!!'), 'section');
    assert.equal(sectionSlug('a'.repeat(100)).length, 64);
});

// Minimal document fixtures keep outline logic testable without a browser dependency.
const outlineFixture = () => {
    const elements = new Map();
    const document = { getElementById: (id) => elements.get(id) };
    const heading = (text, { id = '', embedded = false } = {}) => {
        const node = {
            textContent: text,
            ownerDocument: document,
            closest: () => embedded ? {} : null,
            get id() { return id; },
            set id(value) {
                id = value;
                elements.set(value, node);
            },
        };
        if (id) {
            elements.set(id, node);
        }
        return node;
    };
    const block = (id, label, headings = []) => ({
        id,
        classList: { contains: () => id.startsWith('post-') },
        querySelector: (selector) => selector === '.post-title'
            ? { textContent: label }
            : { querySelectorAll: () => headings },
    });
    const blocks = [];
    const story = { querySelectorAll: () => blocks };
    return { heading, block, blocks, story };
};

test('the outline follows document order even when posts precede the story', () => {
    const { heading, block, blocks, story } = outlineFixture();
    blocks.push(
        block('post-1', 'Before the story'),
        block('entity-entry-2', '', [heading('Early years')]),
        block('post-3', 'After the story', [heading('Travels')]),
    );
    assert.deepEqual(collectSections(story, 'Story'), [
        { id: 'post-1', label: 'Before the story', nested: false },
        { id: 'entity-entry-2', label: 'Story', nested: false },
        { id: 'reader-section-entity-entry-2-early-years', label: 'Early years', nested: true },
        { id: 'post-3', label: 'After the story', nested: false },
        { id: 'reader-section-post-3-travels', label: 'Travels', nested: true },
    ]);
});

test('existing anchors are preserved and generated anchors avoid collisions', () => {
    const { heading, block, blocks, story } = outlineFixture();
    const authored = heading('Authored', { id: 'reader-section-post-1-travels' });
    const first = heading('Travels');
    const second = heading('Travels');
    blocks.push(block('post-1', 'Journal', [authored, first, second]));

    const sections = collectSections(story, 'Story');
    assert.deepEqual(sections.map(({ id }) => id), [
        'post-1',
        'reader-section-post-1-travels',
        'reader-section-post-1-travels-2',
        'reader-section-post-1-travels-3',
    ]);
    assert.deepEqual(collectSections(story, 'Story'), sections);
});

test('loading more posts extends the outline without changing existing anchors', () => {
    const { heading, block, blocks, story } = outlineFixture();
    blocks.push(block('post-1', 'First', [heading('Travels')]));
    const initial = collectSections(story, 'Story');
    blocks.push(block('post-2', 'Second', [heading('Travels')]));
    const updated = collectSections(story, 'Story');

    assert.deepEqual(updated.slice(0, initial.length), initial);
    assert.equal(updated.at(-1).id, 'reader-section-post-2-travels');
});

test('empty headings and embedded component headings do not clutter the outline', () => {
    const { heading, block, blocks, story } = outlineFixture();
    blocks.push(block('entity-entry-2', '', [
        heading('  '),
        heading('Map controls', { embedded: true }),
        heading('  Early\n years  '),
    ]));
    assert.deepEqual(collectSections(story, 'Story').map(({ label }) => label), ['Story', 'Early years']);
});

test('pages without story content have no jump navigation', () => {
    assert.deepEqual(collectSections(null, 'Story'), []);
});

test('jumping reveals collapsed content, focuses the target, and clears both fixed navigation bars', (context) => {
    const previousDocument = globalThis.document;
    const previousWindow = globalThis.window;
    context.after(() => {
        globalThis.document = previousDocument;
        globalThis.window = previousWindow;
    });
    const removed = [];
    const post = {
        querySelector: (selector) => ({ classList: { remove: (name) => removed.push([selector, name]) } }),
    };
    const details = { tagName: 'DETAILS', open: false, parentElement: null };
    let focused = false;
    let tabindex;
    let scrolled;
    const target = {
        closest: (selector) => selector === '.post-block'
            ? post
            : { querySelector: () => ({ getBoundingClientRect: () => ({ height: 100 }) }) },
        parentElement: details,
        hasAttribute: () => false,
        setAttribute: (name, value) => { tabindex = [name, value]; },
        focus: (options) => { focused = options.preventScroll; },
        getBoundingClientRect: () => ({ top: 400 }),
    };
    globalThis.document = { getElementById: () => ({ getBoundingClientRect: () => ({ height: 52 }) }) };
    globalThis.window = {
        scrollY: 200,
        matchMedia: () => ({ matches: true }),
        scrollTo: (options) => { scrolled = options; },
    };

    scrollToSection(target);

    assert.equal(details.open, true);
    assert.equal(focused, true);
    assert.deepEqual(tabindex, ['tabindex', '-1']);
    assert.deepEqual(removed, [
        ['.entity-content', 'hidden'],
        ['.element-toggle', 'animate-collapsed'],
        ['.post-title', 'collapsed'],
    ]);
    assert.deepEqual(scrolled, { top: 432, behavior: 'instant' });
});

test('collapse controls bind once after pagination and expose their expanded state', async (context) => {
    const previousDocument = globalThis.document;
    const previousWindow = globalThis.window;
    context.after(() => {
        globalThis.document = previousDocument;
        globalThis.window = previousWindow;
    });
    const classList = () => {
        const classes = new Set();
        return {
            contains: (name) => classes.has(name),
            toggle: (name) => classes.has(name) ? classes.delete(name) : classes.add(name),
        };
    };
    const handlers = [];
    const body = { classList: classList() };
    const attributes = new Map([['aria-expanded', 'true']]);
    const control = {
        dataset: { target: '#body' },
        classList: classList(),
        addEventListener: (type, handler) => handlers.push(handler),
        hasAttribute: (name) => attributes.has(name),
        setAttribute: (name, value) => attributes.set(name, value),
    };
    let reinitialize;
    globalThis.document = {
        querySelectorAll: (selector) => selector === '[data-animate="collapse"]'
            ? [control]
            : selector === '#body' ? [body] : [],
    };
    globalThis.window = { onEvent: (callback) => { reinitialize = callback; } };
    await import('../../resources/js/animations.js');
    reinitialize();
    reinitialize();

    assert.equal(handlers.length, 1);
    const event = { target: { type: 'button', closest: () => null }, preventDefault() {} };
    handlers[0].call(control, event);
    assert.equal(body.classList.contains('hidden'), true);
    assert.equal(attributes.get('aria-expanded'), 'false');
    handlers[0].call(control, event);
    assert.equal(body.classList.contains('hidden'), false);
    assert.equal(attributes.get('aria-expanded'), 'true');
});
