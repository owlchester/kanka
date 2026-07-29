import test from 'node:test'
import assert from 'node:assert/strict'
import { initialMarkerPanelState } from './markerPanelState.js'

test('initializes an editing panel from the pin available at mount time', () => {
    assert.deepEqual(
        initialMarkerPanelState({
            name: 'The Silver Citadel',
            isDraggable: true,
            css: 'capital-city',
        }, 'edit'),
        {
            name: 'The Silver Citadel',
            detailLevel: 'full',
            isDraggable: true,
            cssClass: 'capital-city',
        },
    )
})

test('initializes a new marker with safe defaults', () => {
    assert.deepEqual(initialMarkerPanelState(null, 'create'), {
        name: '',
        detailLevel: 'light',
        isDraggable: false,
        cssClass: '',
    })
})
