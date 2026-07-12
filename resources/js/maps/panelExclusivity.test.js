import { test } from 'node:test'
import assert from 'node:assert/strict'
import { panelsToClose } from './panelExclusivity.js'

test('opening a right-slot panel on desktop closes the other right-slot panels only', () => {
    assert.deepEqual(panelsToClose('detail', false).sort(), ['marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', false).sort(), ['detail', 'settings'])
    assert.deepEqual(panelsToClose('settings', false).sort(), ['detail', 'marker'])
})

test('opening a right-slot panel on mobile also closes legend', () => {
    assert.deepEqual(panelsToClose('detail', true).sort(), ['legend', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', true).sort(), ['detail', 'legend', 'settings'])
    assert.deepEqual(panelsToClose('settings', true).sort(), ['detail', 'legend', 'marker'])
})

test('opening legend on desktop closes nothing', () => {
    assert.deepEqual(panelsToClose('legend', false), [])
})

test('opening legend on mobile closes all right-slot panels', () => {
    assert.deepEqual(panelsToClose('legend', true).sort(), ['detail', 'marker', 'settings'])
})
