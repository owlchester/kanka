import test from 'node:test';
import assert from 'node:assert/strict';
import {
    mergeParticipants,
    moveParticipantToGroup,
    removeGroupAndUngroup,
    reorderGroups,
    reorderWithinGroup,
    syncSectionOrder,
} from './participantState.js';

test('syncSectionOrder reorders participants within the same section', () => {
    const participants = [
        { entity_id: 1, name: 'A', group: 'g1' },
        { entity_id: 2, name: 'B', group: 'g2' },
        { entity_id: 3, name: 'C', group: 'g1' },
    ];

    const updated = syncSectionOrder(participants, 'g1', [participants[2], participants[0]]);

    assert.deepEqual(updated.map(p => [p.entity_id, p.group]), [
        [3, 'g1'],
        [1, 'g1'],
        [2, 'g2'],
    ]);
});

test('syncSectionOrder moves a participant across groups at the dropped index without duplicates', () => {
    const participants = [
        { entity_id: 1, name: 'A', group: 'g1' },
        { entity_id: 2, name: 'B', group: 'g2' },
        { entity_id: 3, name: 'C', group: 'g1' },
    ];

    const updated = syncSectionOrder(participants, 'g1', [
        participants[0],
        participants[1],
        participants[2],
    ]);

    assert.deepEqual(updated.map(p => [p.entity_id, p.group]), [
        [1, 'g1'],
        [2, 'g1'],
        [3, 'g1'],
    ]);
});

test('syncSectionOrder handles dropping into an empty group', () => {
    const participants = [
        { entity_id: 1, name: 'A', group: 'g1' },
        { entity_id: 2, name: 'B', group: null },
    ];

    const updated = syncSectionOrder(participants, 'g2', [participants[1]]);

    assert.deepEqual(updated.map(p => [p.entity_id, p.group]), [
        [1, 'g1'],
        [2, 'g2'],
    ]);
});

test('moveParticipantToGroup moves a participant to the target group', () => {
    const participants = [
        { entity_id: 1, name: 'A', group: 'g1' },
        { entity_id: 2, name: 'B', group: 'g2' },
    ];

    const updated = moveParticipantToGroup(participants, 1, null);

    assert.deepEqual(updated.map(p => [p.entity_id, p.group]), [
        [2, 'g2'],
        [1, null],
    ]);
});

test('reorderWithinGroup swaps adjacent members of the same group', () => {
    const participants = [
        { entity_id: 1, name: 'A', group: 'g1' },
        { entity_id: 2, name: 'B', group: 'g2' },
        { entity_id: 3, name: 'C', group: 'g1' },
    ];

    const updated = reorderWithinGroup(participants, 3, -1);

    assert.deepEqual(updated.map(p => p.entity_id), [3, 2, 1]);
});

test('reorderGroups moves a group up or down', () => {
    const groups = [{ key: 'g1' }, { key: 'g2' }, { key: 'g3' }];

    assert.deepEqual(reorderGroups(groups, 'g2', -1).map(g => g.key), ['g2', 'g1', 'g3']);
    assert.deepEqual(reorderGroups(groups, 'g1', -1).map(g => g.key), ['g1', 'g2', 'g3']);
});

test('removeGroupAndUngroup removes the group and sets members to null', () => {
    const groups = [{ key: 'g1', name: 'Defenders' }, { key: 'g2', name: 'Attackers' }];
    const participants = [
        { entity_id: 1, group: 'g1' },
        { entity_id: 2, group: 'g2' },
    ];

    const result = removeGroupAndUngroup(groups, participants, 'g1');

    assert.deepEqual(result.groups.map(g => g.key), ['g2']);
    assert.deepEqual(result.participants.map(p => [p.entity_id, p.group]), [
        [1, null],
        [2, 'g2'],
    ]);
});

test('mergeParticipants appends only non-duplicate entities into the target group', () => {
    const participants = [{ entity_id: 1, name: 'A', group: 'g1', role: 'Lead' }];
    const updated = mergeParticipants(
        participants,
        [
            { entity_id: 1, name: 'A' },
            { entity_id: 2, name: 'B', type: 'Character' },
        ],
        'g2',
    );

    assert.deepEqual(updated, [
        { entity_id: 1, name: 'A', group: 'g1', role: 'Lead' },
        { entity_id: 2, name: 'B', type: 'Character', group: 'g2', role: '' },
    ]);
});
