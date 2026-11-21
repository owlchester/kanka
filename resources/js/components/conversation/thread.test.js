import assert from 'node:assert/strict'
import test from 'node:test'
import { groupsWith, mergeMessages, readNewerMessages } from './thread.js'

const message = (id, seconds = 0, speaker = {}) => ({
    id,
    from_id: 1,
    user: null,
    entity: 'Speaker',
    entity_id: 1,
    created_at_iso: new Date(seconds * 1000).toISOString(),
    ...speaker,
})

test('merges overlapping pages in order without duplicating a locally sent message', () => {
    const posted = { ...message(4), message: 'Posted' }
    const fetched = { ...message(4), message: 'Fetched' }

    assert.deepEqual(mergeMessages([message(2), message(3), fetched], [message(1), posted]), [
        message(1), message(2), message(3), posted,
    ])
})

test('groups adjacent messages by the same known speaker within a minute', () => {
    assert.equal(groupsWith(message(2, 59), message(1)), true)
    assert.equal(groupsWith(message(2, 60), message(1)), false)
    assert.equal(groupsWith(message(2, 59, { entity_id: null, entity: null, user: 'Member' }), message(1)), false)
    assert.equal(groupsWith(message(2, 59, { entity: null }), message(1)), false)
    assert.equal(groupsWith(message(2, 59), undefined), false)
})

test('continues from the last received message when refreshing after a partially loaded page sequence', async () => {
    let cursor = 0
    let thread = []
    const load = async after => {
        if (after === 0) return { messages: [message(1), message(2)], more_newer: true }
        throw new Error('Refresh failed')
    }
    const receive = (messages, newest) => {
        thread = mergeMessages(thread, messages)
        cursor = newest
    }

    await assert.rejects(readNewerMessages(cursor, load, receive), /Refresh failed/)
    await readNewerMessages(cursor, async after => {
        assert.equal(after, 2)
        return { messages: [message(3)], more_newer: false }
    }, receive)
    assert.deepEqual(thread.map(item => item.id), [1, 2, 3])
})
