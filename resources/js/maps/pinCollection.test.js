import test from 'node:test'
import assert from 'node:assert/strict'
import { upsertPin } from './pinCollection.js'

test('upsertPin appends a pin that is not in the collection', () => {
    const pins = [{ id: 1, name: 'Waterdeep' }]
    const pin = { id: 2, name: 'Baldur’s Gate' }

    assert.deepEqual(upsertPin(pins, pin), [...pins, pin])
    assert.deepEqual(pins, [{ id: 1, name: 'Waterdeep' }])
})

test('upsertPin replaces an existing pin without changing its position', () => {
    const pins = [
        { id: 1, name: 'Waterdeep' },
        { id: 2, name: 'Baldur’s Gate' },
    ]
    const pin = { id: 1, name: 'Neverwinter' }

    assert.deepEqual(upsertPin(pins, pin), [
        pin,
        { id: 2, name: 'Baldur’s Gate' },
    ])
})

test('upsertPin removes duplicate copies of the same pin', () => {
    const pins = [
        { id: 1, name: 'Old Waterdeep' },
        { id: 2, name: 'Baldur’s Gate' },
        { id: 1, name: 'Duplicate Waterdeep' },
    ]
    const pin = { id: 1, name: 'Waterdeep' }

    assert.deepEqual(upsertPin(pins, pin), [
        pin,
        { id: 2, name: 'Baldur’s Gate' },
    ])
})
