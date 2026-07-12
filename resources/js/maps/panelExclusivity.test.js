import { test } from 'node:test'
import assert from 'node:assert/strict'
import { panelsToClose } from './panelExclusivity.js'

test('opening a right-slot panel on desktop closes the other right-slot panels only', () => {
    assert.deepEqual(panelsToClose('detail', false).sort(), ['edit', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', false).sort(), ['detail', 'edit', 'settings'])
    assert.deepEqual(panelsToClose('edit', false).sort(), ['detail', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('settings', false).sort(), ['detail', 'edit', 'marker'])
})

test('opening a right-slot panel on mobile also closes legend', () => {
    assert.deepEqual(panelsToClose('detail', true).sort(), ['edit', 'legend', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', true).sort(), ['detail', 'edit', 'legend', 'settings'])
    assert.deepEqual(panelsToClose('edit', true).sort(), ['detail', 'legend', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('settings', true).sort(), ['detail', 'edit', 'legend', 'marker'])
})

test('opening legend on desktop closes nothing', () => {
    assert.deepEqual(panelsToClose('legend', false), [])
})

test('opening legend on mobile closes all right-slot panels', () => {
    assert.deepEqual(panelsToClose('legend', true).sort(), ['detail', 'edit', 'marker', 'settings'])
})
