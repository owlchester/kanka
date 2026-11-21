import test from 'node:test';
import assert from 'node:assert/strict';
import {
    addItemToTarget,
    buildPreviewItems,
    cleanItems,
    findEmptySections,
    hideSectionItems,
    isSection,
    removeNodeInPlace,
} from './sidebarState.js';

const catalog = {
    'system:dashboard': { id: 'system:dashboard', kind: 'system', label: 'Dashboard', required: true, disabled: false },
    'system:relations': { id: 'system:relations', kind: 'system', label: 'Relations', required: true, disabled: false },
    'category:1': { id: 'category:1', kind: 'category', label: 'Characters', required: false, disabled: false },
    'category:2': { id: 'category:2', kind: 'category', label: 'Locations', required: false, disabled: true },
    'bookmark:10': { id: 'bookmark:10', kind: 'bookmark', label: 'Secret Notes', required: false, disabled: false },
};

test('isSection detects nodes with children arrays', () => {
    assert.equal(isSection({ id: 'world', children: [] }), true);
    assert.equal(isSection({ id: 'category:1' }), false);
});

test('cleanItems strips unknown entries from root and sections', () => {
    const cleaned = cleanItems(
        [
            { id: 'system:dashboard' },
            { id: 'missing:1' },
            { id: 'world', label: 'World', children: [{ id: 'category:1' }, { id: 'missing:2' }] },
        ],
        catalog
    );

    assert.deepEqual(cleaned, [
        { id: 'system:dashboard' },
        { id: 'world', label: 'World', children: [{ id: 'category:1' }] },
    ]);
});

test('removeNodeInPlace splices section children at the section index and protects bookmarks/required items', () => {
    const items = [
        { id: 'system:dashboard' },
        { id: 'world', label: 'World', children: [{ id: 'category:1' }, { id: 'bookmark:10' }] },
        { id: 'bookmarks', label_key: 'entities.bookmarks', children: [] },
    ];

    assert.deepEqual(removeNodeInPlace(items, 0, catalog), { removed: null, promotedCount: 0 });
    assert.deepEqual(removeNodeInPlace(items, 2, catalog), { removed: null, promotedCount: 0 });

    const result = removeNodeInPlace(items, 1, catalog);
    assert.equal(result.promotedCount, 2);
    assert.deepEqual(
        items.map((n) => n.id),
        ['system:dashboard', 'category:1', 'bookmark:10', 'bookmarks']
    );
});

test('hideSectionItems keeps required items and removes optional items', () => {
    const section = {
        id: 'mixed',
        label: 'Mixed',
        children: [{ id: 'system:dashboard' }, { id: 'category:1' }, { id: 'bookmark:10' }],
    };

    const removed = hideSectionItems(section, catalog);
    assert.equal(removed, 2);
    assert.deepEqual(section.children, [{ id: 'system:dashboard' }]);
});

test('addItemToTarget adds to bookmarks and prevents duplicates', () => {
    const items = [{ id: 'bookmarks', label_key: 'entities.bookmarks', children: [] }];
    assert.equal(addItemToTarget(items, 'category:1'), true);
    assert.equal(addItemToTarget(items, 'category:1'), false);
    assert.deepEqual(items[0].children, [{ id: 'category:1' }]);
});

test('findEmptySections returns sections with blank custom labels', () => {
    const items = [
        { id: 'bookmarks', label_key: 'entities.bookmarks', children: [] },
        { id: 's1', label: '   ', children: [] },
        { id: 's2', label: 'World', children: [] },
    ];
    assert.deepEqual(findEmptySections(items), ['s1']);
});

test('buildPreviewItems omits disabled items, empty sections, and inaccessible items when toggled', () => {
    const items = [
        { id: 'system:dashboard' },
        { id: 'world', label_key: 'sidebar.world', children: [{ id: 'category:1' }, { id: 'category:2' }] },
        { id: 'secrets', label: 'Secrets', children: [{ id: 'bookmark:10' }] },
        { id: 'empty', label: 'Empty', children: [] },
    ];
    const inaccessible = { 'bookmark:10': 'private', 'category:1': 'permission' };

    const allVisible = buildPreviewItems(items, catalog, inaccessible, false, { 'sidebar.world': 'World' });
    assert.equal(allVisible.length, 3);
    assert.deepEqual(
        allVisible[1].children.map((c) => c.id),
        ['category:1']
    );

    const roleFiltered = buildPreviewItems(items, catalog, inaccessible, true, { 'sidebar.world': 'World' });
    assert.deepEqual(
        roleFiltered.map((n) => n.id),
        ['system:dashboard']
    );
});
