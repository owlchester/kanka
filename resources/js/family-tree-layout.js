export const FAMILY_TREE_NODE_WIDTH = 200
export const FAMILY_TREE_NODE_HEIGHT = 84
export const FAMILY_TREE_COLUMN_GAP = 40
export const FAMILY_TREE_ROW_GAP = 90

/**
 * Lay out the graph in fixed horizontal slots. Partner nodes share a rank,
 * while child edges always move down one rank. Keeping this calculation pure
 * makes large-tree spacing predictable and straightforward to test.
 */
export function layoutFamilyTree(graph) {
    const nodes = (graph?.nodes || []).map((node) => ({ ...node }))
    const edges = (graph?.edges || []).map((edge) => ({ ...edge }))
    const nodeMap = new Map(nodes.map((node) => [node.id, node]))
    const parent = new Map(nodes.map((node) => [node.id, node.id]))

    const find = (id) => {
        let root = parent.get(id)
        while (root && root !== parent.get(root)) {
            root = parent.get(root)
        }
        return root || id
    }

    const union = (left, right) => {
        const leftRoot = find(left)
        const rightRoot = find(right)
        if (leftRoot !== rightRoot) {
            parent.set(rightRoot, leftRoot)
        }
    }

    edges.filter((edge) => edge.type === 'partner').forEach((edge) => {
        if (nodeMap.has(edge.source) && nodeMap.has(edge.target)) {
            union(edge.source, edge.target)
        }
    })

    const childEdges = edges.filter((edge) => edge.type === 'child')
    const groupRanks = new Map(nodes.map((node) => [find(node.id), 0]))
    for (let pass = 0; pass < nodes.length; pass++) {
        let changed = false
        childEdges.forEach((edge) => {
            if (!nodeMap.has(edge.source) || !nodeMap.has(edge.target)) {
                return
            }
            const sourceGroup = find(edge.source)
            const targetGroup = find(edge.target)
            if (sourceGroup === targetGroup) {
                return
            }
            const nextRank = Math.max(groupRanks.get(targetGroup), groupRanks.get(sourceGroup) + 1)
            if (nextRank !== groupRanks.get(targetGroup)) {
                groupRanks.set(targetGroup, nextRank)
                changed = true
            }
        })
        if (!changed) {
            break
        }
    }

    const ranks = new Map(nodes.map((node) => [node.id, groupRanks.get(find(node.id)) || 0]))

    const rankGroups = new Map()
    nodes.forEach((node) => {
        const rank = ranks.get(node.id) || 0
        if (!rankGroups.has(rank)) {
            rankGroups.set(rank, [])
        }
        rankGroups.get(rank).push(node)
    })

    const rankWidths = new Map()
    rankGroups.forEach((group, rank) => {
        rankWidths.set(rank, group.length * (FAMILY_TREE_NODE_WIDTH + FAMILY_TREE_COLUMN_GAP))
    })
    const canvasWidth = Math.max(...rankWidths.values(), FAMILY_TREE_NODE_WIDTH)
    const laidOutNodes = []
    const nodeOrder = new Map()
    const rankKeys = [...rankGroups.keys()].sort((left, right) => left - right)
    rankKeys.forEach((rank) => {
        const group = rankGroups.get(rank)
        const orderedGroup = [...group].sort((left, right) => {
            const parentOrder = (node) => {
                const orders = childEdges
                    .filter((edge) => edge.target === node.id)
                    .map((edge) => nodeOrder.get(edge.source))
                    .filter((order) => order !== undefined)

                return orders.length ? Math.min(...orders) : Number.MAX_SAFE_INTEGER
            }

            return parentOrder(left) - parentOrder(right)
        })
        const start = (canvasWidth - rankWidths.get(rank)) / 2
        const slotWidth = rankWidths.get(rank) / group.length
        orderedGroup.forEach((node, index) => {
            nodeOrder.set(node.id, index)
            const incomingChildEdges = childEdges.filter((edge) => edge.target === node.id)
            const partnerEdge = edges.find((edge) => edge.type === 'partner' && edge.target === node.id)
            const incomingTypes = incomingChildEdges.map((edge) => Number(edge.child_type || 1))
            const uniqueTypes = [...new Set(incomingTypes)]
            const customRoles = [...new Set(incomingChildEdges
                .filter((edge) => Number(edge.child_type) === 5 && edge.role)
                .map((edge) => edge.role))]
            laidOutNodes.push({
                ...node,
                x: start + (index * slotWidth),
                y: rank * (FAMILY_TREE_NODE_HEIGHT + FAMILY_TREE_ROW_GAP),
                rank,
                childType: uniqueTypes.length === 1 ? uniqueTypes[0] : 0,
                childRole: customRoles.length === 1 ? customRoles[0] : null,
                hasChildRelationship: incomingTypes.length > 0,
                partnerRole: partnerEdge?.role || null,
                partnerStatus: partnerEdge?.partner_status || null,
                hasPartnerRelationship: Boolean(partnerEdge),
            })
        })
    })

    const positions = new Map(laidOutNodes.map((node) => [node.id, node]))
    const laidOutEdges = edges
        .filter((edge) => positions.has(edge.source) && positions.has(edge.target))
        .map((edge) => {
            const source = positions.get(edge.source)
            const target = positions.get(edge.target)
            if (edge.type === 'partner') {
                return {
                    ...edge,
                    path: `M ${source.x + FAMILY_TREE_NODE_WIDTH} ${source.y + FAMILY_TREE_NODE_HEIGHT / 2} L ${target.x} ${target.y + FAMILY_TREE_NODE_HEIGHT / 2}`,
                }
            }

            const sourceX = source.x + FAMILY_TREE_NODE_WIDTH / 2
            const targetX = target.x + FAMILY_TREE_NODE_WIDTH / 2
            const sourceY = source.y + FAMILY_TREE_NODE_HEIGHT
            const targetY = target.y
            const middleY = sourceY + (targetY - sourceY) / 2
            return {
                ...edge,
                path: `M ${sourceX} ${sourceY} L ${sourceX} ${middleY} L ${targetX} ${middleY} L ${targetX} ${targetY}`,
            }
        })

    return {
        nodes: laidOutNodes,
        edges: laidOutEdges,
        width: canvasWidth,
        height: Math.max(...laidOutNodes.map((node) => node.y + FAMILY_TREE_NODE_HEIGHT), FAMILY_TREE_NODE_HEIGHT),
    }
}
