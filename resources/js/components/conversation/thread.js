export function mergeMessages(existing, incoming) {
    const messages = new Map(existing.map(message => [message.id, message]))
    for (const message of incoming) messages.set(message.id, message)
    return [...messages.values()].sort((first, second) => first.id - second.id)
}

export function groupsWith(message, previous) {
    if (!message || !previous || (!message.user && !message.entity) || (!previous.user && !previous.entity)) return false
    if (message.from_id !== previous.from_id || message.entity_id !== previous.entity_id) return false
    return Math.abs(Date.parse(message.created_at_iso) - Date.parse(previous.created_at_iso)) < 60_000
}

export async function readNewerMessages(cursor, load, receive) {
    let page
    do {
        page = await load(cursor)
        if (!page.messages.length) return
        cursor = page.messages.at(-1).id
        await receive(page.messages, cursor)
    } while (page.more_newer)
}
