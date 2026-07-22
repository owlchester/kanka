import { test } from 'node:test'
import assert from 'node:assert/strict'
import { buildGroupTree, filterGroupTree, sortGroups, insertGroupIntoList } from './groupTree.js'

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

test('filterGroupTree with an empty query returns the tree unchanged', () => {
    const tree = buildGroupTree(
        [{ id: 1, name: 'Towns', parent_id: null }],
        [{ id: 10, name: 'Waterdeep', group_id: 1 }, { id: 11, name: 'Loose pin', group_id: null }]
    )

    const filtered = filterGroupTree(tree, '')

    assert.equal(filtered.groups.length, 1)
    assert.equal(filtered.groups[0].pins.length, 1)
    assert.equal(filtered.uncategorised.length, 1)
})

test('filterGroupTree keeps only matching pins and prunes empty branches', () => {
    const groups = [
        { id: 1, name: 'Continent', parent_id: null },
        { id: 2, name: 'Region', parent_id: 1 },
        { id: 3, name: 'Empty branch', parent_id: null },
    ]
    const pins = [
        { id: 10, name: 'Waterdeep', group_id: 2 },
        { id: 11, name: 'Baldurs Gate', group_id: 2 },
        { id: 12, name: 'Uncategorised match', group_id: null },
        { id: 13, name: 'No match here', group_id: null },
    ]
    const tree = buildGroupTree(groups, pins)

    const filtered = filterGroupTree(tree, 'water')

    assert.equal(filtered.groups.length, 1) // "Empty branch" pruned entirely
    assert.equal(filtered.groups[0].id, 1)
    assert.equal(filtered.groups[0].children.length, 1)
    assert.equal(filtered.groups[0].children[0].pins.length, 1)
    assert.equal(filtered.groups[0].children[0].pins[0].name, 'Waterdeep')
    assert.deepEqual(filtered.uncategorised.map((p) => p.id), [])
    assert.ok(filtered.matchedGroupIds.has(1)) // ancestor of the match
    assert.ok(filtered.matchedGroupIds.has(2)) // the group with the direct match
    assert.ok(! filtered.matchedGroupIds.has(3)) // no match anywhere in this branch
})

test('sortGroups orders by position ascending, ties broken by name', () => {
    const groups = [
        { id: 1, name: 'Zebra', position: 1 },
        { id: 2, name: 'Beta', position: 0 },
        { id: 3, name: 'Alpha', position: 0 },
    ]

    const sorted = sortGroups(groups)

    assert.deepEqual(sorted.map((g) => g.id), [3, 2, 1])
})

test('sortGroups treats a null position as 0', () => {
    const groups = [
        { id: 1, name: 'B', position: null },
        { id: 2, name: 'A', position: null },
    ]

    const sorted = sortGroups(groups)

    assert.deepEqual(sorted.map((g) => g.id), [2, 1])
})

test('sortGroups does not mutate the input array', () => {
    const groups = [{ id: 1, name: 'B', position: 1 }, { id: 2, name: 'A', position: 0 }]

    sortGroups(groups)

    assert.deepEqual(groups.map((g) => g.id), [1, 2])
})

test('insertGroupIntoList shifts existing groups at or after the new position and appends the new group', () => {
    const groups = [
        { id: 1, name: 'Alpha', position: 1 },
        { id: 2, name: 'Beta', position: 2 },
    ]
    const newGroup = { id: 3, name: 'Zulu', position: 1 }

    const result = insertGroupIntoList(groups, newGroup)

    assert.deepEqual(result.map((g) => [g.id, g.position]), [[1, 2], [2, 3], [3, 1]])
})

test('insertGroupIntoList leaves groups before the new position untouched', () => {
    const groups = [
        { id: 1, name: 'A', position: 1 },
        { id: 2, name: 'B', position: 2 },
    ]
    const newGroup = { id: 3, name: 'C', position: 2 }

    const result = insertGroupIntoList(groups, newGroup)

    assert.deepEqual(result.map((g) => [g.id, g.position]), [[1, 1], [2, 3], [3, 2]])
})

test('insertGroupIntoList treats a null position as 0 for the shift comparison', () => {
    const groups = [{ id: 1, name: 'A', position: null }]
    const newGroup = { id: 2, name: 'B', position: 1 }

    const result = insertGroupIntoList(groups, newGroup)

    assert.deepEqual(result.map((g) => [g.id, g.position]), [[1, null], [2, 1]])
})
