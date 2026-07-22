export function buildGroupTree(groups, pins) {
    const byId = new Map(groups.map((group) => [group.id, { ...group, children: [], pins: [] }]))
    const roots = []

    byId.forEach((group) => {
        const parent = group.parent_id ? byId.get(group.parent_id) : null
        if (parent) {
            parent.children.push(group)
        } else {
            roots.push(group)
        }
    })

    const uncategorised = []
    pins.forEach((pin) => {
        const group = pin.group_id ? byId.get(pin.group_id) : null
        if (group) {
            group.pins.push(pin)
        } else {
            uncategorised.push(pin)
        }
    })

    return { groups: roots, uncategorised }
}

export function filterGroupTree(tree, query) {
    const matchedGroupIds = new Set()

    if (! query) {
        return { groups: tree.groups, uncategorised: tree.uncategorised, matchedGroupIds }
    }

    const q = query.toLowerCase()
    const matchesPin = (pin) => pin.name.toLowerCase().includes(q)

    function filterGroup(group) {
        const pins = group.pins.filter(matchesPin)
        const children = group.children.map(filterGroup).filter(Boolean)

        if (pins.length === 0 && children.length === 0) {
            return null
        }

        matchedGroupIds.add(group.id)

        return { ...group, pins, children }
    }

    const groups = tree.groups.map(filterGroup).filter(Boolean)
    const uncategorised = tree.uncategorised.filter(matchesPin)

    return { groups, uncategorised, matchedGroupIds }
}

export function insertGroupIntoList(groups, newGroup) {
    const shifted = groups.map((group) =>
        (group.position ?? 0) >= newGroup.position
            ? { ...group, position: group.position + 1 }
            : group
    )

    return [...shifted, newGroup]
}

export function sortGroups(groups) {
    return [...groups].sort((a, b) => {
        const positionDiff = (a.position ?? 0) - (b.position ?? 0)
        if (positionDiff !== 0) {
            return positionDiff
        }

        return a.name.localeCompare(b.name)
    })
}
