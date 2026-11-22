const MAX_HISTORY = 50;

export function generateUuid() {
    if (typeof globalThis.crypto?.randomUUID === 'function') {
        return globalThis.crypto.randomUUID();
    }
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, (c) => {
        const r = (Math.random() * 16) | 0;
        const v = c === 'x' ? r : (r & 0x3) | 0x8;
        return v.toString(16);
    });
}

export function emptyGraph() {
    return {
        version: 2,
        settings: {
            direction: 'TB',
            edgeStyle: 'orthogonal',
            compact: false,
        },
        people: [],
        unions: [],
        links: [],
    };
}

function clone(obj) {
    return JSON.parse(JSON.stringify(obj));
}

function normalizeGraph(graph) {
    const base = emptyGraph();
    if (!graph || typeof graph !== 'object') {
        return base;
    }
    return {
        version: 2,
        settings: { ...base.settings, ...(graph.settings || {}) },
        people: Array.isArray(graph.people) ? clone(graph.people) : [],
        unions: Array.isArray(graph.unions) ? clone(graph.unions) : [],
        links: Array.isArray(graph.links) ? clone(graph.links) : [],
    };
}

function makePerson(data) {
    const entityId = data?.entity_id ? Number(data.entity_id) : null;
    const isPlaceholder = !entityId;
    return {
        id: generateUuid(),
        entity_id: entityId,
        placeholder: isPlaceholder
            ? {
                  name: (data?.placeholder?.name ?? data?.name ?? '').trim(),
                  subtitle: (data?.placeholder?.subtitle ?? data?.subtitle ?? '').trim(),
              }
            : null,
        colour: data?.colour ?? null,
        cssClass: data?.cssClass ?? null,
        visibility: Number(data?.visibility ?? 1),
    };
}

export function createGraphStore(initialGraph = null) {
    let original = normalizeGraph(initialGraph);
    let current = clone(original);
    let undoStack = [];
    let redoStack = [];
    let dirty = false;

    function pushHistory() {
        undoStack.push(clone(current));
        if (undoStack.length > MAX_HISTORY) {
            undoStack.shift();
        }
        redoStack = [];
        dirty = true;
    }

    function resolveOrAddPerson(draft, personData) {
        if (personData?.existingPersonId) {
            const existing = draft.people.find((p) => p.id === personData.existingPersonId);
            if (existing) {
                return existing.id;
            }
        }
        const person = makePerson(personData);
        draft.people.push(person);
        return person.id;
    }

    return {
        getState() {
            return clone(current);
        },
        setInitial(graph) {
            original = normalizeGraph(graph);
            current = clone(original);
            undoStack = [];
            redoStack = [];
            dirty = false;
        },
        canUndo() {
            return undoStack.length > 0;
        },
        canRedo() {
            return redoStack.length > 0;
        },
        isDirty() {
            return dirty;
        },
        markClean(savedGraph = null) {
            if (savedGraph) {
                current = normalizeGraph(savedGraph);
            }
            original = clone(current);
            undoStack = [];
            redoStack = [];
            dirty = false;
        },
        undo() {
            if (undoStack.length === 0) {
                return false;
            }
            redoStack.push(clone(current));
            current = undoStack.pop();
            dirty = JSON.stringify(current) !== JSON.stringify(original);
            return true;
        },
        redo() {
            if (redoStack.length === 0) {
                return false;
            }
            undoStack.push(clone(current));
            current = redoStack.pop();
            dirty = JSON.stringify(current) !== JSON.stringify(original);
            return true;
        },
        reset() {
            current = clone(original);
            undoStack = [];
            redoStack = [];
            dirty = false;
        },
        clear() {
            pushHistory();
            current = emptyGraph();
        },
        addFirstPerson(personData) {
            pushHistory();
            const person = makePerson(personData);
            current.people.push(person);
            return person.id;
        },
        addParent(childPersonId, parentData, linkKind = 'biological', label = null) {
            const child = current.people.find((p) => p.id === childPersonId);
            if (!child) {
                return null;
            }
            pushHistory();
            const parentId = resolveOrAddPerson(current, parentData);

            // If the child has an existing single-parent link of the same kind, pair them into a union
            const singleParentLink = current.links.find(
                (l) => l.child_id === childPersonId && !l.union_id && l.parent_id && l.parent_id !== parentId && l.kind === linkKind
            );

            if (singleParentLink) {
                const union = {
                    id: generateUuid(),
                    partners: [singleParentLink.parent_id, parentId],
                    type: 'married',
                    role: null,
                    colour: null,
                    cssClass: null,
                    visibility: singleParentLink.visibility ?? 1,
                    order: current.unions.length,
                };
                current.unions.push(union);
                singleParentLink.union_id = union.id;
                singleParentLink.parent_id = null;
                return parentId;
            }

            current.links.push({
                id: generateUuid(),
                union_id: null,
                parent_id: parentId,
                child_id: childPersonId,
                kind: linkKind,
                label: label || null,
                colour: null,
                visibility: Number(parentData?.visibility ?? 1),
                order: current.links.filter((l) => l.child_id === childPersonId).length,
            });
            return parentId;
        },
        addPartner(personId, partnerData, unionType = 'married', role = null) {
            const person = current.people.find((p) => p.id === personId);
            if (!person) {
                return null;
            }
            pushHistory();
            const partnerId = resolveOrAddPerson(current, partnerData);
            const union = {
                id: generateUuid(),
                partners: personId === partnerId ? [personId] : [personId, partnerId],
                type: unionType,
                role: role || null,
                colour: null,
                cssClass: null,
                visibility: Number(partnerData?.visibility ?? 1),
                order: current.unions.filter((u) => u.partners.includes(personId)).length,
            };
            current.unions.push(union);
            return { partnerId, unionId: union.id };
        },
        addChildFromPerson(parentId, childData, kind = 'biological', label = null) {
            const res = this.addChildrenFromPerson(parentId, [childData], kind, label);
            return res ? res[0] : null;
        },
        addChildrenFromPerson(parentId, childrenDataList, kind = 'biological', label = null) {
            const parent = current.people.find((p) => p.id === parentId);
            if (!parent || !Array.isArray(childrenDataList) || childrenDataList.length === 0) {
                return null;
            }
            pushHistory();
            const created = [];
            let orderOffset = current.links.filter((l) => l.parent_id === parentId).length;
            for (const childData of childrenDataList) {
                const childId = resolveOrAddPerson(current, childData);
                const link = {
                    id: generateUuid(),
                    union_id: null,
                    parent_id: parentId,
                    child_id: childId,
                    kind,
                    label: label || null,
                    colour: null,
                    visibility: Number(childData?.visibility ?? 1),
                    order: orderOffset++,
                };
                current.links.push(link);
                created.push({ childId, linkId: link.id });
            }
            return created;
        },
        addChildFromUnion(unionId, childData, kind = 'biological', label = null) {
            const res = this.addChildrenFromUnion(unionId, [childData], kind, label);
            return res ? res[0] : null;
        },
        addChildrenFromUnion(unionId, childrenDataList, kind = 'biological', label = null) {
            const union = current.unions.find((u) => u.id === unionId);
            if (!union || !Array.isArray(childrenDataList) || childrenDataList.length === 0) {
                return null;
            }
            pushHistory();
            const created = [];
            let orderOffset = current.links.filter((l) => l.union_id === unionId).length;
            for (const childData of childrenDataList) {
                const childId = resolveOrAddPerson(current, childData);
                const link = {
                    id: generateUuid(),
                    union_id: unionId,
                    parent_id: null,
                    child_id: childId,
                    kind,
                    label: label || null,
                    colour: null,
                    visibility: Number(childData?.visibility ?? 1),
                    order: orderOffset++,
                };
                current.links.push(link);
                created.push({ childId, linkId: link.id });
            }
            return created;
        },
        updatePerson(personId, patch) {
            const person = current.people.find((p) => p.id === personId);
            if (!person) {
                return false;
            }
            pushHistory();
            Object.assign(person, patch);
            if (person.entity_id) {
                person.entity_id = Number(person.entity_id);
                person.placeholder = null;
            } else {
                person.entity_id = null;
                person.placeholder = {
                    name: (person.placeholder?.name ?? '').trim(),
                    subtitle: (person.placeholder?.subtitle ?? '').trim(),
                };
            }
            return true;
        },
        promotePlaceholder(personId, entityId) {
            return this.updatePerson(personId, {
                entity_id: Number(entityId),
                placeholder: null,
            });
        },
        updateUnion(unionId, patch) {
            const union = current.unions.find((u) => u.id === unionId);
            if (!union) {
                return false;
            }
            pushHistory();
            Object.assign(union, patch);
            return true;
        },
        updateLink(linkId, patch) {
            const link = current.links.find((l) => l.id === linkId);
            if (!link) {
                return false;
            }
            pushHistory();
            Object.assign(link, patch);
            return true;
        },
        deletePerson(personId) {
            const exists = current.people.some((p) => p.id === personId);
            if (!exists) {
                return false;
            }
            pushHistory();
            current.people = current.people.filter((p) => p.id !== personId);

            const removedUnionIds = new Set();
            current.unions = current.unions
                .map((u) => ({
                    ...u,
                    partners: u.partners.filter((pid) => pid !== personId),
                }))
                .filter((u) => {
                    if (u.partners.length === 0) {
                        removedUnionIds.add(u.id);
                        return false;
                    }
                    return true;
                });

            current.links = current.links.filter((l) => {
                if (l.child_id === personId || l.parent_id === personId) {
                    return false;
                }
                if (l.union_id && removedUnionIds.has(l.union_id)) {
                    return false;
                }
                return true;
            });
            return true;
        },
        deleteUnion(unionId) {
            const exists = current.unions.some((u) => u.id === unionId);
            if (!exists) {
                return false;
            }
            pushHistory();
            current.unions = current.unions.filter((u) => u.id !== unionId);
            current.links = current.links.filter((l) => l.union_id !== unionId);
            return true;
        },
        deleteLink(linkId) {
            const exists = current.links.some((l) => l.id === linkId);
            if (!exists) {
                return false;
            }
            pushHistory();
            current.links = current.links.filter((l) => l.id !== linkId);
            return true;
        },
        updateSettings(patch) {
            pushHistory();
            current.settings = { ...current.settings, ...patch };
        },
    };
}
