import test from 'node:test'
import assert from 'node:assert/strict'
import { toggleTableClass } from './tableClasses.js'

test('enabling borderless removes bordered while preserving striping and custom classes', () => {
    const classes = ['table', 'table-bordered', 'table-striped', 'custom-table']

    assert.deepEqual(toggleTableClass(classes, 'table-borderless', ['table-bordered']), [
        'table', 'table-striped', 'custom-table', 'table-borderless',
    ])
    assert.equal(classes.includes('table-bordered'), true)
})

test('disabling borderless restores default borders without changing other options', () => {
    assert.deepEqual(toggleTableClass(
        ['table', 'table-borderless', 'table-striped', 'table-right'],
        'table-borderless',
        ['table-bordered'],
    ), ['table', 'table-striped', 'table-right'])
})

test('borderless can be enabled on a table with no existing classes', () => {
    assert.deepEqual(toggleTableClass([], 'table-borderless', ['table-bordered']), ['table-borderless'])
})

test('striping remains independently toggleable on borderless tables', () => {
    const classes = toggleTableClass(['table', 'table-borderless'], 'table-striped')

    assert.deepEqual(classes, ['table', 'table-borderless', 'table-striped'])
    assert.deepEqual(toggleTableClass(classes, 'table-striped'), ['table', 'table-borderless'])
})

test('alignment options remain mutually exclusive', () => {
    assert.deepEqual(toggleTableClass(
        ['table', 'table-borderless', 'table-left'], 'table-right', ['table-left'],
    ), ['table', 'table-borderless', 'table-right'])
})
