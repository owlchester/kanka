export function isSection(node) {
    return Array.isArray(node?.children);
}

export function cleanItems(nodes, catalog) {
    return (nodes ?? [])
        .filter((node) => isSection(node) || Boolean(catalog[node.id]))
        .map((node) => {
            if (!isSection(node)) {
                return node;
            }
            return {
                ...node,
                children: node.children.filter((child) => Boolean(catalog[child.id])),
            };
        });
}

export function removeNodeInPlace(list, index, catalog) {
    const node = list[index];
    if (!node) {
        return { removed: null, promotedCount: 0 };
    }
    if (isSection(node)) {
        if (node.id === 'bookmarks') {
            return { removed: null, promotedCount: 0 };
        }
        const promoted = node.children ?? [];
        list.splice(index, 1, ...promoted);
        return { removed: node, promotedCount: promoted.length };
    }
    if (catalog[node.id]?.required) {
        return { removed: null, promotedCount: 0 };
    }
    list.splice(index, 1);
    return { removed: node, promotedCount: 0 };
}

export function hideSectionItems(section, catalog) {
    if (!isSection(section)) {
        return 0;
    }
    const kept = [];
    let removedCount = 0;
    for (const child of section.children) {
        if (catalog[child.id]?.required) {
            kept.push(child);
        } else {
            removedCount += 1;
        }
    }
    section.children = kept;
    return removedCount;
}

export function addItemToTarget(items, entryId, destination = 'bookmarks') {
    const alreadyUsed = items.some((node) =>
        isSection(node) ? node.children.some((child) => child.id === entryId) : node.id === entryId
    );
    if (alreadyUsed) {
        return false;
    }
    const target = items.find((node) => node.id === destination && isSection(node));
    if (target) {
        target.children.push({ id: entryId });
        return true;
    }
    items.push({ id: entryId });
    return true;
}

export function findEmptySections(items) {
    return items
        .filter((node) => isSection(node) && !node.label_key && !(node.label ?? '').trim())
        .map((node) => node.id);
}

export function buildPreviewItems(items, catalog, inaccessible = {}, hideInaccessible = false, sectionLabels = {}) {
    const visible = (entry) => {
        if (!entry || entry.disabled) {
            return false;
        }
        if (hideInaccessible && inaccessible[entry.id]) {
            return false;
        }
        return true;
    };

    const result = [];
    for (const node of items) {
        if (isSection(node)) {
            const children = [];
            for (const child of node.children) {
                const entry = catalog[child.id];
                if (visible(entry)) {
                    children.push(entry);
                }
            }
            if (children.length > 0) {
                result.push({
                    id: node.id,
                    label: node.label ?? sectionLabels[node.label_key] ?? node.id,
                    children,
                });
            }
        } else {
            const entry = catalog[node.id];
            if (visible(entry)) {
                result.push(entry);
            }
        }
    }
    return result;
}
