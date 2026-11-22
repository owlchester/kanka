import test from 'node:test';
import assert from 'node:assert/strict';
import { createGraphStore } from './graphStore.js';

test('adds first person, adds parent above founder, and pairs second parent into a union', () => {
    const store = createGraphStore();
    const bobId = store.addFirstPerson({ entity_id: 1 });
    const momId = store.addParent(bobId, { placeholder: { name: 'Mom' } }, 'biological');

    let state = store.getState();
    assert.equal(state.people.length, 2);
    assert.equal(state.unions.length, 0);
    assert.equal(state.links.length, 1);
    assert.equal(state.links[0].parent_id, momId);
    assert.equal(state.links[0].child_id, bobId);

    const dadId = store.addParent(bobId, { entity_id: 2 }, 'biological');
    state = store.getState();
    assert.equal(state.people.length, 3);
    assert.equal(state.unions.length, 1);
    assert.deepEqual(state.unions[0].partners, [momId, dadId]);
    assert.equal(state.links[0].union_id, state.unions[0].id);
    assert.equal(state.links[0].parent_id, null);
});

test('supports single-parent children, adopted children, and partner ex-spouses', () => {
    const store = createGraphStore();
    const bobId = store.addFirstPerson({ entity_id: 1 });
    const { childId: lindaId } = store.addChildFromPerson(bobId, { entity_id: 2 }, 'biological');
    const { partnerId: aliceId, unionId } = store.addPartner(bobId, { entity_id: 3 }, 'married', 'Wife');
    store.addPartner(aliceId, { placeholder: { name: 'Ex-Husband' } }, 'divorced', 'Ex');
    store.addChildFromUnion(unionId, { entity_id: 4 }, 'adopted');

    const state = store.getState();
    assert.equal(state.people.length, 5);
    assert.equal(state.unions.length, 2);
    assert.equal(state.links.length, 2);
    assert.equal(state.links[0].parent_id, bobId);
    assert.equal(state.links[0].child_id, lindaId);
    assert.equal(state.links[1].union_id, unionId);
    assert.equal(state.links[1].kind, 'adopted');
});

test('undo and redo restore snapshots accurately', () => {
    const store = createGraphStore();
    const p1 = store.addFirstPerson({ entity_id: 1 });
    assert.equal(store.isDirty(), true);
    assert.equal(store.canUndo(), true);

    store.addChildFromPerson(p1, { entity_id: 2 });
    assert.equal(store.getState().people.length, 2);

    assert.equal(store.undo(), true);
    assert.equal(store.getState().people.length, 1);
    assert.equal(store.canRedo(), true);

    assert.equal(store.redo(), true);
    assert.equal(store.getState().people.length, 2);
});

test('deletePerson preserves descendants and cleans dangling links/unions', () => {
    const store = createGraphStore();
    const bobId = store.addFirstPerson({ entity_id: 1 });
    const { childId: lindaId } = store.addChildFromPerson(bobId, { entity_id: 2 });

    store.deletePerson(bobId);
    const state = store.getState();
    assert.equal(state.people.length, 1);
    assert.equal(state.people[0].id, lindaId);
    assert.equal(state.links.length, 0);
});

test('addChildrenFromUnion and addChildrenFromPerson add multiple children in a single undo step', () => {
    const store = createGraphStore();
    const p1 = store.addFirstPerson({ entity_id: 1 });
    const { unionId } = store.addPartner(p1, { entity_id: 2 });

    const created = store.addChildrenFromUnion(unionId, [
        { entity_id: 3 },
        { placeholder: { name: 'Kid 2' } },
        { placeholder: { name: 'Kid 3' } },
    ], 'biological');

    assert.equal(created.length, 3);
    assert.equal(store.getState().people.length, 5);
    assert.equal(store.getState().links.length, 3);

    // Single undo reverts all 3 children at once
    store.undo();
    assert.equal(store.getState().people.length, 2);
    assert.equal(store.getState().links.length, 0);
});
