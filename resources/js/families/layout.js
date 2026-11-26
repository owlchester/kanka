import ELK from 'elkjs/lib/elk.bundled.js';

const elk = new ELK();

export const NODE_DIMENSIONS = {
    normal: { width: 220, height: 84 },
    compact: { width: 180, height: 56 },
    union: { width: 32, height: 32 },
    unionWithRole: { width: 110, height: 30 },
};

const UNION_EDGE_CLASSES = {
    married: 'kanka-ft-edge--married',
    partner: 'kanka-ft-edge--partner',
    divorced: 'kanka-ft-edge--divorced',
    affair: 'kanka-ft-edge--affair',
    betrothed: 'kanka-ft-edge--betrothed',
    custom: 'kanka-ft-edge--custom',
};

const LINK_EDGE_CLASSES = {
    biological: 'kanka-ft-edge--biological',
    adopted: 'kanka-ft-edge--adopted',
    foster: 'kanka-ft-edge--foster',
    step: 'kanka-ft-edge--step',
    bastard: 'kanka-ft-edge--bastard',
    custom: 'kanka-ft-edge--custom',
};

export async function layoutGraph(graph, entities = {}, linkedTrees = {}, texts = {}) {
    if (!graph || !Array.isArray(graph.people) || graph.people.length === 0) {
        return { nodes: [], edges: [] };
    }

    const settings = graph.settings || {};
    const direction = settings.direction === 'LR' ? 'LR' : 'TB';
    const edgeStyle = ['orthogonal', 'smoothstep', 'bezier'].includes(settings.edgeStyle)
        ? settings.edgeStyle
        : 'orthogonal';
    const compact = Boolean(settings.compact);

    const personSize = compact ? NODE_DIMENSIONS.compact : NODE_DIMENSIONS.normal;
    const peopleById = new Map(graph.people.map((p) => [p.id, p]));
    const unionsById = new Map((graph.unions || []).map((u) => [u.id, u]));

    const elkChildren = [];
    const elkEdges = [];

    for (const person of graph.people) {
        elkChildren.push({
            id: person.id,
            width: personSize.width,
            height: personSize.height,
        });
    }

    for (const union of graph.unions || []) {
        const hasRole = Boolean(union.role && union.role.trim() !== '');
        const unionSize = hasRole ? NODE_DIMENSIONS.unionWithRole : NODE_DIMENSIONS.union;
        elkChildren.push({
            id: union.id,
            width: unionSize.width,
            height: unionSize.height,
        });

        for (const partnerId of union.partners || []) {
            if (!peopleById.has(partnerId)) {
                continue;
            }
            elkEdges.push({
                id: `elk-u-${union.id}-${partnerId}`,
                sources: [partnerId],
                targets: [union.id],
            });
        }
    }

    for (const link of graph.links || []) {
        if (!peopleById.has(link.child_id)) {
            continue;
        }
        const sourceId = link.union_id && unionsById.has(link.union_id) ? link.union_id : link.parent_id;
        if (!sourceId || (!peopleById.has(sourceId) && !unionsById.has(sourceId))) {
            continue;
        }
        elkEdges.push({
            id: `elk-l-${link.id}`,
            sources: [sourceId],
            targets: [link.child_id],
        });
    }

    const elkGraph = {
        id: 'root',
        layoutOptions: {
            'elk.algorithm': 'layered',
            'elk.direction': direction === 'LR' ? 'RIGHT' : 'DOWN',
            'elk.edgeRouting': 'ORTHOGONAL',
            'elk.layered.crossingMinimization.strategy': 'LAYER_SWEEP',
            'elk.layered.nodePlacement.strategy': 'BRANDES_KOEPF',
            'elk.spacing.nodeNode': direction === 'LR' ? '36' : '44',
            'elk.layered.spacing.nodeNodeBetweenLayers': direction === 'LR' ? '56' : '44',
            'elk.spacing.componentComponent': '64',
        },
        children: elkChildren,
        edges: elkEdges,
    };

    const laidOut = await elk.layout(elkGraph);
    const posMap = new Map();
    for (const child of laidOut.children || []) {
        posMap.set(child.id, {
            x: Number.isFinite(child.x) ? child.x : 0,
            y: Number.isFinite(child.y) ? child.y : 0,
            width: child.width,
            height: child.height,
        });
    }

    // Center 2-partner union badges neatly between their partners when on the same generation axis
    for (const union of graph.unions || []) {
        const partners = (union.partners || []).filter((pid) => posMap.has(pid));
        const uPos = posMap.get(union.id);
        if (!uPos || partners.length !== 2) {
            continue;
        }
        const p1 = posMap.get(partners[0]);
        const p2 = posMap.get(partners[1]);
        if (direction === 'TB' && Math.abs(p1.y - p2.y) < 10) {
            const midX = (p1.x + p1.width / 2 + (p2.x + p2.width / 2)) / 2;
            uPos.x = midX - uPos.width / 2;
        } else if (direction === 'LR' && Math.abs(p1.x - p2.x) < 10) {
            const midY = (p1.y + p1.height / 2 + (p2.y + p2.height / 2)) / 2;
            uPos.y = midY - uPos.height / 2;
        }
    }

    const sourcePos = direction === 'LR' ? 'right' : 'bottom';
    const targetPos = direction === 'LR' ? 'left' : 'top';
    const vfEdgeType = edgeStyle === 'bezier' ? 'default' : 'smoothstep';

    const nodes = [];

    for (const person of graph.people) {
        const pos = posMap.get(person.id) || { x: 0, y: 0 };
        const entity = person.entity_id ? entities[person.entity_id] || null : null;
        const entityLinkedTrees = person.entity_id ? linkedTrees[person.entity_id] || [] : [];

        nodes.push({
            id: person.id,
            type: 'person',
            position: { x: pos.x, y: pos.y },
            sourcePosition: sourcePos,
            targetPosition: targetPos,
            draggable: false,
            connectable: false,
            data: {
                person,
                entity,
                linkedTrees: entityLinkedTrees,
                compact,
                direction,
            },
        });
    }

    for (const union of graph.unions || []) {
        const pos = posMap.get(union.id) || { x: 0, y: 0 };
        nodes.push({
            id: union.id,
            type: 'union',
            position: { x: pos.x, y: pos.y },
            sourcePosition: sourcePos,
            targetPosition: targetPos,
            draggable: false,
            connectable: false,
            data: {
                union,
                direction,
            },
        });
    }

    const edges = [];

    for (const union of graph.unions || []) {
        const unionTypeClass = UNION_EDGE_CLASSES[union.type] || 'kanka-ft-edge--married';
        const style = union.colour ? { stroke: union.colour } : undefined;
        for (const partnerId of union.partners || []) {
            if (!peopleById.has(partnerId)) {
                continue;
            }
            edges.push({
                id: `e-u-${union.id}-${partnerId}`,
                source: partnerId,
                target: union.id,
                type: vfEdgeType,
                class: `kanka-ft-edge kanka-ft-edge--union ${unionTypeClass}`,
                style,
                selectable: true,
                data: {
                    kind: 'union-partner',
                    union,
                },
            });
        }
    }

    for (const link of graph.links || []) {
        if (!peopleById.has(link.child_id)) {
            continue;
        }
        const sourceId = link.union_id && unionsById.has(link.union_id) ? link.union_id : link.parent_id;
        if (!sourceId) {
            continue;
        }
        const linkKindClass = LINK_EDGE_CLASSES[link.kind] || 'kanka-ft-edge--biological';
        const kindText = link.kind && link.kind !== 'biological' ? texts?.link_kinds?.[link.kind] || link.kind : '';
        const edgeLabel = link.label || kindText || undefined;

        edges.push({
            id: link.id,
            source: sourceId,
            target: link.child_id,
            type: vfEdgeType,
            label: edgeLabel,
            class: `kanka-ft-edge kanka-ft-edge--lineage ${linkKindClass}`,
            style: link.colour ? { stroke: link.colour } : undefined,
            selectable: true,
            data: {
                kind: 'lineage',
                link,
            },
        });
    }

    return { nodes, edges };
}
