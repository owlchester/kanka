import test from 'node:test'
import assert from 'node:assert/strict'
import { layerBounds } from './layerBounds.js'

test('layerBounds uses the layer\'s own dimensions when present', () => {
    const layer = { width: 800, height: 400 }
    const map = { width: 2000, height: 1000 }

    assert.deepEqual(layerBounds(layer, map), [[0, 0], [400, 800]])
})

test('layerBounds falls back to the map dimensions when the layer has none', () => {
    const layer = { width: null, height: null }
    const map = { width: 2000, height: 1000 }

    assert.deepEqual(layerBounds(layer, map), [[0, 0], [1000, 2000]])
})
