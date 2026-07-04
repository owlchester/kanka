import { test } from 'node:test'
import assert from 'node:assert/strict'
import { buildGroupTree } from './groupTree.js'

test('nests child groups under their parent, in root order', () => {
    const groups = [
        { id: 2, name: 'Region', parent_id: 1 },
        { id: 1, name: 'Continent', parent_id: null },
    ]

    const tree = buildGroupTree(groups, [])

    assert.equal(tree.groups.length, 1)
    assert.equal(tree.groups[0].id, 1)
    assert.equal(tree.groups[0].children.length, 1)
    assert.equal(tree.groups[0].children[0].id, 2)
})

test('assigns pins to their group and buckets orphans as uncategorised', () => {
    const groups = [{ id: 1, name: 'Towns', parent_id: null }]
    const pins = [
        { id: 10, group_id: 1 },
        { id: 11, group_id: null },
        { id: 12, group_id: 999 },
    ]

    const tree = buildGroupTree(groups, pins)

    assert.deepEqual(tree.groups[0].pins.map((p) => p.id), [10])
    assert.deepEqual(tree.uncategorised.map((p) => p.id), [11, 12])
})
