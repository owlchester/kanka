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
