import test from 'node:test'
import assert from 'node:assert/strict'
import { suggestionPopupDimensions } from './suggestionPopup.js'

test('suggestion popup fits within the available viewport', () => {
    assert.deepEqual(suggestionPopupDimensions(640, 180), {
        maxWidth: 640,
        maxHeight: 180,
    })
})

test('suggestion popup keeps its normal maximum height when space permits', () => {
    assert.deepEqual(suggestionPopupDimensions(640, 800), {
        maxWidth: 640,
        maxHeight: 300,
    })
})

test('suggestion popup dimensions never become negative', () => {
    assert.deepEqual(suggestionPopupDimensions(-20, -40), {
        maxWidth: 0,
        maxHeight: 0,
    })
})
