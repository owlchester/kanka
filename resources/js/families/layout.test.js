import test from 'node:test';
import assert from 'node:assert/strict';
import { layoutGraph } from './layout.js';

test('returns empty arrays for empty graph', async () => {
    const res = await layoutGraph({ version: 2, people: [], unions: [], links: [] });
    assert.deepEqual(res, { nodes: [], edges: [] });
});

test('lays out couple, ex-partner, single-parent child, and adopted child with finite positions', async () => {
    const graph = {
        version: 2,
        settings: { direction: 'TB', edgeStyle: 'orthogonal', compact: false },
        people: [
            { id: 'p-founder', entity_id: 1, placeholder: null },
            { id: 'p-spouse', entity_id: 2, placeholder: null },
            { id: 'p-ex', entity_id: null, placeholder: { name: 'Ex Partner', subtitle: '' } },
            { id: 'p-bio', entity_id: 3, placeholder: null },
            { id: 'p-adopted', entity_id: 4, placeholder: null },
            { id: 'p-single-child', entity_id: 5, placeholder: null },
        ],
        unions: [
            { id: 'u-1', partners: ['p-founder', 'p-spouse'], type: 'married', role: 'King & Queen' },
            { id: 'u-2', partners: ['p-spouse', 'p-ex'], type: 'divorced', role: 'Former' },
        ],
        links: [
            { id: 'l-1', union_id: 'u-1', parent_id: null, child_id: 'p-bio', kind: 'biological' },
            { id: 'l-2', union_id: 'u-1', parent_id: null, child_id: 'p-adopted', kind: 'adopted' },
            { id: 'l-3', union_id: null, parent_id: 'p-founder', child_id: 'p-single-child', kind: 'biological' },
        ],
    };

    const { nodes, edges } = await layoutGraph(graph, {
        1: { id: 1, name: 'Founder' },
        2: { id: 2, name: 'Spouse' },
        3: { id: 3, name: 'Bio Child' },
        4: { id: 4, name: 'Adopted Child' },
        5: { id: 5, name: 'Single Child' },
    });

    assert.equal(nodes.length, 8);
    assert.equal(edges.length, 7);

    for (const node of nodes) {
        assert.equal(Number.isFinite(node.position.x), true);
        assert.equal(Number.isFinite(node.position.y), true);
    }

    const founderNode = nodes.find((n) => n.id === 'p-founder');
    const bioNode = nodes.find((n) => n.id === 'p-bio');
    assert.ok(bioNode.position.y > founderNode.position.y, 'child should be below founder in TB mode');

    const adoptedEdge = edges.find((e) => e.id === 'l-2');
    assert.ok(adoptedEdge.class.includes('kanka-ft-edge--adopted'));
});

test('supports LR direction', async () => {
    const graph = {
        version: 2,
        settings: { direction: 'LR', edgeStyle: 'bezier', compact: true },
        people: [
            { id: 'p-1', entity_id: 1 },
            { id: 'p-2', entity_id: 2 },
        ],
        unions: [],
        links: [{ id: 'l-1', union_id: null, parent_id: 'p-1', child_id: 'p-2', kind: 'biological' }],
    };

    const { nodes } = await layoutGraph(graph);
    const p1 = nodes.find((n) => n.id === 'p-1');
    const p2 = nodes.find((n) => n.id === 'p-2');
    assert.ok(p2.position.x > p1.position.x, 'child should be to the right of parent in LR mode');
});
