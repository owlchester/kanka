export function syncSectionOrder(participants, sectionKey, orderedMembers) {
    const movedIds = new Set(orderedMembers.map(member => member.entity_id));
    const normalized = orderedMembers.map(member => ({ ...member, group: sectionKey }));
    const next = [];
    let inserted = false;

    for (const participant of participants) {
        if (participant.group === sectionKey && !inserted) {
            next.push(...normalized);
            inserted = true;
        }
        if (participant.group === sectionKey || movedIds.has(participant.entity_id)) {
            continue;
        }
        next.push(participant);
    }

    if (!inserted) {
        next.push(...normalized);
    }

    return next;
}

export function moveParticipantToGroup(participants, entityId, targetGroupKey) {
    const target = participants.find(participant => participant.entity_id === entityId);
    if (!target || target.group === targetGroupKey) {
        return participants;
    }

    return [
        ...participants.filter(participant => participant.entity_id !== entityId),
        { ...target, group: targetGroupKey },
    ];
}

export function reorderWithinGroup(participants, entityId, direction) {
    const target = participants.find(participant => participant.entity_id === entityId);
    if (!target) {
        return participants;
    }

    const members = participants.filter(participant => participant.group === target.group);
    const index = members.indexOf(target);
    const neighbour = members[index + direction];
    if (!neighbour) {
        return participants;
    }

    const next = [...participants];
    const a = next.indexOf(target);
    const b = next.indexOf(neighbour);
    [next[a], next[b]] = [next[b], next[a]];

    return next;
}

export function reorderGroups(groups, key, direction) {
    const index = groups.findIndex(group => group.key === key);
    const target = index + direction;
    if (index < 0 || target < 0 || target >= groups.length) {
        return groups;
    }

    const next = [...groups];
    [next[index], next[target]] = [next[target], next[index]];

    return next;
}

export function removeGroupAndUngroup(groups, participants, key) {
    return {
        groups: groups.filter(group => group.key !== key),
        participants: participants.map(participant => (
            participant.group === key ? { ...participant, group: null } : participant
        )),
    };
}

export function mergeParticipants(participants, entities, targetGroupKey) {
    const existingIds = new Set(participants.map(participant => participant.entity_id));
    const additions = entities
        .filter(entity => !existingIds.has(entity.entity_id))
        .map(entity => ({ ...entity, group: targetGroupKey, role: '' }));

    return additions.length ? [...participants, ...additions] : participants;
}
