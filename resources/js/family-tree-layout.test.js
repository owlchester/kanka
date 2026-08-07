import assert from 'node:assert/strict'
import test from 'node:test'
import { layoutFamilyTree } from './family-tree-layout.js'

test('keeps partners on the same rank and children below them', () => {
    const layout = layoutFamilyTree({
        nodes: [{ id: 'parent' }, { id: 'partner' }, { id: 'child' }],
        edges: [
            { id: 'partner-edge', source: 'parent', target: 'partner', type: 'partner' },
            { id: 'child-edge', source: 'parent', target: 'child', type: 'child', child_type: 1 },
        ],
    })

    const parent = layout.nodes.find((node) => node.id === 'parent')
    const partner = layout.nodes.find((node) => node.id === 'partner')
    const child = layout.nodes.find((node) => node.id === 'child')
    assert.equal(parent.rank, partner.rank)
    assert.ok(child.y > parent.y)
})

test('uses a mixed type marker when parents have different child relationships', () => {
    const layout = layoutFamilyTree({
        nodes: [{ id: 'one' }, { id: 'two' }, { id: 'child' }],
        edges: [
            { id: 'one-edge', source: 'one', target: 'child', type: 'child', child_type: 1 },
            { id: 'two-edge', source: 'two', target: 'child', type: 'child', child_type: 2 },
        ],
    })

    assert.equal(layout.nodes.find((node) => node.id === 'child').childType, 0)
})

test('does not create overlapping slots for a wide branch', () => {
    const layout = layoutFamilyTree({
        nodes: Array.from({ length: 7 }, (_, index) => ({ id: String(index) })),
        edges: Array.from({ length: 6 }, (_, index) => ({
            id: `edge-${index}`,
            source: '0',
            target: String(index + 1),
            type: 'child',
            child_type: 1,
        })),
    })
    const children = layout.nodes.filter((node) => node.id !== '0')
    assert.equal(new Set(children.map((node) => node.x)).size, children.length)
})

test('places partner metadata on the partner cards with normal spacing', () => {
    const layout = layoutFamilyTree({
        nodes: [{ id: 'person' }, { id: 'current' }, { id: 'former' }],
        edges: [
            { id: 'current-edge', source: 'person', target: 'current', type: 'partner', partner_status: 'current' },
            { id: 'former-edge', source: 'person', target: 'former', type: 'partner', partner_status: 'former' },
        ],
    })
    const current = layout.nodes.find((node) => node.id === 'current')
    const former = layout.nodes.find((node) => node.id === 'former')

    assert.equal(current.hasPartnerRelationship, true)
    assert.equal(current.partnerStatus, 'current')
    assert.equal(former.partnerStatus, 'former')
    assert.equal(former.x - current.x, 240)
})

test('passes a custom child role to the child card', () => {
    const layout = layoutFamilyTree({
        nodes: [{ id: 'parent' }, { id: 'child' }],
        edges: [{ id: 'child-edge', source: 'parent', target: 'child', type: 'child', child_type: 5, role: 'Ward' }],
    })

    const child = layout.nodes.find((node) => node.id === 'child')
    assert.equal(child.childType, 5)
    assert.equal(child.childRole, 'Ward')
})

test('groups direct children before children of a partner', () => {
    const layout = layoutFamilyTree({
        nodes: [
            { id: 'founder' },
            { id: 'direct-child' },
            { id: 'partner' },
            { id: 'partner-child' },
            { id: 'second-direct-child' },
        ],
        edges: [
            { id: 'partner-edge', source: 'founder', target: 'partner', type: 'partner' },
            { id: 'direct-edge', source: 'founder', target: 'direct-child', type: 'child', child_type: 1 },
            { id: 'partner-child-edge', source: 'partner', target: 'partner-child', type: 'child', child_type: 1 },
            { id: 'second-direct-edge', source: 'founder', target: 'second-direct-child', type: 'child', child_type: 1 },
        ],
    })

    const directChild = layout.nodes.find((node) => node.id === 'direct-child')
    const secondDirectChild = layout.nodes.find((node) => node.id === 'second-direct-child')
    const partnerChild = layout.nodes.find((node) => node.id === 'partner-child')

    assert.ok(directChild.x < secondDirectChild.x)
    assert.ok(secondDirectChild.x < partnerChild.x)
})
