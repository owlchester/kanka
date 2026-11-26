import test from 'node:test'
import assert from 'node:assert/strict'
import {
    applyImageNodeViewStyles,
    buildImageStyle,
    filterImageClasses,
    parseFloatStyle,
    parsePercentWidth,
    parsePixelDimension,
} from './imageStyles.js'

const makeElement = (attrs = {}) => ({
    getAttribute: (name) => attrs[name] ?? null,
})

const makeMockDomElement = () => {
    const attributes = new Map()
    return {
        style: {},
        setAttribute(name, value) {
            attributes.set(name, String(value))
        },
        removeAttribute(name) {
            attributes.delete(name)
        },
        getAttribute(name) {
            return attributes.has(name) ? attributes.get(name) : null
        },
    }
}

test('parses pixel width and height from inline style or HTML attributes', () => {
    assert.equal(parsePixelDimension(makeElement({ style: 'width: 320px; height: 240px;' }), 'width'), 320)
    assert.equal(parsePixelDimension(makeElement({ style: 'width: 320px; height: 240px;' }), 'height'), 240)
    assert.equal(parsePixelDimension(makeElement({ width: '400', height: '300' }), 'width'), 400)
    assert.equal(parsePixelDimension(makeElement({ style: 'width: 50%;' }), 'width'), null)
})

test('parses percentage width from inline style', () => {
    assert.equal(parsePercentWidth(makeElement({ style: 'width: 50%; float: left' })), '50%')
    assert.equal(parsePercentWidth(makeElement({ style: 'width: 320px;' })), null)
})

test('parses float style from inline style and legacy classes', () => {
    assert.equal(parseFloatStyle(makeElement({ style: 'float: right;' })), 'right')
    assert.equal(parseFloatStyle(makeElement({ class: 'note-float-left img-fluid' })), 'left')
    assert.equal(parseFloatStyle(makeElement({ class: 'float-right' })), 'right')
    assert.equal(parseFloatStyle(makeElement({ class: 'rounded' })), null)
})

test('filters legacy float classes while preserving custom classes', () => {
    assert.equal(filterImageClasses(makeElement({ class: 'note-float-left rounded shadow' })), 'rounded shadow')
    assert.equal(filterImageClasses(makeElement({ class: 'float-right' })), null)
})

test('buildImageStyle formats percentage, pixel, unlocked height, and float styles', () => {
    assert.equal(
        buildImageStyle({ width: 300, height: 200, widthStyle: '50%', floatStyle: 'left' }),
        'width: 50%; float: left; margin-right: 0.5rem'
    )
    assert.equal(
        buildImageStyle({ width: 320, height: null, widthStyle: null, floatStyle: 'right' }),
        'width: 320px; float: right; margin-left: 0.5rem'
    )
    assert.equal(
        buildImageStyle({ width: 320, height: 180, widthStyle: null, floatStyle: null }),
        'width: 320px; height: 180px'
    )
    assert.equal(
        buildImageStyle({ width: null, height: null, widthStyle: null, floatStyle: null }),
        null
    )
})

test('applyImageNodeViewStyles syncs alt, title, pixel dimensions, percent widths, and floats', () => {
    const el = makeMockDomElement()
    const container = makeMockDomElement()

    applyImageNodeViewStyles(
        { width: 320, height: null, widthStyle: null, floatStyle: 'left', alt: 'Dragon', title: 'Red dragon' },
        el,
        container
    )

    assert.equal(el.getAttribute('alt'), 'Dragon')
    assert.equal(el.getAttribute('title'), 'Red dragon')
    assert.equal(el.style.width, '320px')
    assert.equal(el.style.height, 'auto')
    assert.equal(container.style.width, '')
    assert.equal(container.style.float, 'left')
    assert.equal(container.style.marginRight, '0.5rem')

    applyImageNodeViewStyles(
        { width: null, height: null, widthStyle: '75%', floatStyle: null, alt: null, title: '' },
        el,
        container
    )

    assert.equal(el.getAttribute('alt'), null)
    assert.equal(el.getAttribute('title'), null)
    assert.equal(container.style.width, '75%')
    assert.equal(el.style.width, '100%')
    assert.equal(el.style.height, 'auto')
    assert.equal(container.style.float, '')
    assert.equal(container.style.marginRight, '')
})
