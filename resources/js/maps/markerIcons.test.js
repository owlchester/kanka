import test from 'node:test'
import assert from 'node:assert/strict'
import { pinIconRender, restoredCustomIcon, svgIconDataUrl } from './markerIcons.js'

test('converts raw svg markup into an image-safe data url', () => {
    const svg = '<svg xmlns="http://www.w3.org/2000/svg"><circle r="4"/></svg>'
    const url = svgIconDataUrl(svg)

    assert.ok(url.startsWith('data:image/svg+xml;charset=utf-8,'))
    assert.equal(decodeURIComponent(url.split(',')[1]), svg)
})

test('keeps a server-provided svg data url unchanged', () => {
    const url = 'data:image/svg+xml;base64,PHN2Zz48L3N2Zz4='

    assert.equal(svgIconDataUrl(url), url)
})

test('classifies a custom svg separately from font icon classes', () => {
    const svg = '<svg xmlns="http://www.w3.org/2000/svg"></svg>'

    assert.deepEqual(pinIconRender(1, svg), {
        type: 'svg',
        value: svgIconDataUrl(svg),
    })
    assert.deepEqual(pinIconRender(1, 'fa-solid fa-skull'), {
        type: 'fa',
        value: 'fa-solid fa-skull',
    })
})

test('does not interpolate unsafe custom icon text into a class attribute', () => {
    assert.deepEqual(pinIconRender(1, 'fa-solid fa-skull" onmouseover="alert(1)'), {
        type: 'fa',
        value: 'fa-solid fa-map-pin',
    })
})

test('restoredCustomIcon falls back to the remembered icon once a preset shape click clears it', () => {
    assert.equal(restoredCustomIcon(null, 'fa-solid fa-skull'), 'fa-solid fa-skull')
})

test('restoredCustomIcon prefers the pin\'s current custom icon over the remembered one', () => {
    assert.equal(restoredCustomIcon('fa-solid fa-crow', 'fa-solid fa-skull'), 'fa-solid fa-crow')
})

test('restoredCustomIcon returns null when neither the pin nor memory has a custom icon', () => {
    assert.equal(restoredCustomIcon(null, ''), null)
})
