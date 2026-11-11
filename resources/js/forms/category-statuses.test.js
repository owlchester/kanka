import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
import { runInNewContext } from 'node:vm'

const source = readFileSync(new URL('./category-statuses.js', import.meta.url), 'utf8')

function setup(count = 2) {
    const listeners = {}
    const none = { checked: false }
    const add = { disabled: false, hasAttribute: name => name === 'data-status-add', closest: () => null }
    const rows = {
        children: [],
        get lastElementChild() { return this.children.at(-1) },
        append(row) { this.children.push(row) },
        insertBefore(row, before) {
            this.children.splice(this.children.indexOf(row), 1)
            this.children.splice(this.children.indexOf(before), 0, row)
        },
    }
    const makeRow = (id = '', isDefault = false) => {
        const inputs = Object.fromEntries(['id', 'label', 'icon', 'is_default'].map(field => [field, {
            dataset: { statusField: field }, value: field === 'id' ? id : '', focus() { this.focused = true },
        }]))
        const radio = { checked: isDefault }
        const preview = {}
        const buttons = Object.fromEntries(['up', 'down', 'remove'].map(action => [action, {
            disabled: false,
            hasAttribute: name => name === `data-status-${action}`,
            closest: () => row,
        }]))
        const row = {
            inputs, radio, preview, buttons,
            querySelectorAll: () => Object.values(inputs),
            querySelector(selector) {
                if (selector === '[data-status-default]') return radio
                if (selector === '[data-status-preview]') return preview
                const field = selector.match(/data-status-field="([^"]+)"/)
                if (field) return inputs[field[1]]
                return buttons[selector.slice(13, -1)]
            },
            get previousElementSibling() { return rows.children[rows.children.indexOf(row) - 1] },
            get nextElementSibling() { return rows.children[rows.children.indexOf(row) + 1] },
            remove() { rows.children.splice(rows.children.indexOf(row), 1) },
        }
        return row
    }
    rows.children = Array.from({ length: count }, (_, i) => makeRow(String(1000 + i), i === 0))
    const editor = {
        querySelector: selector => ({
            '[data-status-rows]': rows,
            '[data-status-add]': add,
            '[data-status-default-none]': none,
            '[data-status-template]': { content: { cloneNode: () => makeRow() } },
        })[selector],
        addEventListener: (event, handler) => { listeners[`editor:${event}`] = handler },
    }
    const form = {
        querySelector: () => editor,
        hasAttribute: name => name === 'data-maintenance',
        addEventListener: (event, handler) => { listeners[`form:${event}`] = handler },
    }
    runInNewContext(source, {
        document: { querySelector: () => form },
        window: { addEventListener: (event, handler) => { listeners[`window:${event}`] = handler } },
    })
    const click = button => listeners['editor:click']({ target: { closest: () => button } })
    const dirty = () => {
        let prevented = false
        listeners['window:beforeunload']({ preventDefault: () => { prevented = true } })
        return prevented
    }
    return { rows, add, none, listeners, click, dirty }
}

test('status rows reorder by identity and serialize their new positions', () => {
    const state = setup()
    const first = state.rows.children[0]
    assert.equal(first.inputs.is_default.value, '1')
    assert.equal(first.buttons.up.disabled, true)
    state.click(first.buttons.down)
    assert.equal(state.rows.children[1], first)
    assert.equal(first.inputs.id.name, 'statuses[1][id]')
    assert.equal(first.inputs.id.value, '1000')
    assert.equal(first.inputs.is_default.value, '1')
    assert.equal(first.buttons.down.disabled, true)
    assert.equal(state.dirty(), true)
})

test('adding and removing unsaved rows preserves contiguous field names', () => {
    const state = setup()
    state.click(state.add)
    const added = state.rows.lastElementChild
    assert.equal(added.inputs.label.focused, true)
    assert.equal(added.inputs.label.name, 'statuses[2][label]')
    added.radio.checked = true
    state.click(added.buttons.remove)
    assert.equal(state.rows.children.length, 2)
    assert.equal(state.none.checked, true)
})

test('the editor enforces its ten-row cap and rejects unsafe icon previews', () => {
    const state = setup(10)
    assert.equal(state.add.disabled, true)
    state.click(state.add)
    assert.equal(state.rows.children.length, 10)
    const first = state.rows.children[0]
    first.inputs.icon.value = 'fa-solid fa-key'
    state.listeners['form:input']()
    assert.equal(first.preview.className, 'fa-solid fa-key')
    first.inputs.icon.value = '<script>alert(1)</script>'
    state.listeners['form:input']()
    assert.equal(first.preview.className, '')
})

test('unsaved warnings survive failed preflight and clear only when validation succeeds', () => {
    const state = setup()
    state.listeners['form:input']()
    state.listeners['form:submit']()
    assert.equal(state.dirty(), true)
    state.listeners['form:maintenance:validated']()
    assert.equal(state.dirty(), false)
    state.listeners['form:change']()
    assert.equal(state.dirty(), true)
})
