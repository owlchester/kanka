import { test } from 'node:test'
import assert from 'node:assert/strict'
import { centroid, serializeVertices } from './polygon.js'

test('centroid averages the vertex coordinates', () => {
    const result = centroid([
        [0, 0],
        [10, 0],
        [10, 10],
        [0, 10],
    ])

    assert.deepEqual(result, [5, 5])
})

test('centroid handles a single vertex', () => {
    assert.deepEqual(centroid([[3, 4]]), [3, 4])
})

test('serializeVertices formats pairs to 3 decimals and joins with spaces', () => {
    const result = serializeVertices([
        [10, 20],
        [11.2, 21.7],
    ])

    assert.equal(result, '10.000,20.000 11.200,21.700')
})
