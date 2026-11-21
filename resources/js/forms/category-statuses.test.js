import test from 'node:test'
import assert from 'node:assert/strict'
import { initCategoryStatuses } from './category-statuses.js'

const makeClassList = (initial = []) => {
    const set = new Set(initial)
    return {
        toggle(name, force) {
            if (force === undefined) {
                if (set.has(name)) set.delete(name)
                else set.add(name)
            } else if (force) {
                set.add(name)
            } else {
                set.delete(name)
            }
        },
        contains: name => set.has(name),
    }
}

function setup(count = 2) {
    const listeners = {}
    let sortableOptions = null
    const addButtons = [
        { disabled: false, hasAttribute: name => name === 'data-status-add', closest: () => null },
        { disabled: false, hasAttribute: name => name === 'data-status-add', closest: () => null },
    ]
    const countBadge = { textContent: '' }
    const emptyState = { classList: makeClassList(count > 0 ? ['hidden'] : []) }
    const footer = { classList: makeClassList(count === 0 ? ['hidden'] : []) }
    const limitHint = { classList: makeClassList(['hidden']) }

    const rows = {
        children: [],
        get firstElementChild() { return this.children[0] },
        get lastElementChild() { return this.children.at(-1) },
        append(row) { this.children.push(row) },
        insertBefore(row, before) {
            this.children.splice(this.children.indexOf(row), 1)
            this.children.splice(before ? this.children.indexOf(before) : this.children.length, 0, row)
        },
    }

    const makeRow = (id = '', isDefault = false, label = '') => {
        const inputs = Object.fromEntries(['id', 'label', 'icon', 'is_default'].map(field => [field, {
            dataset: { statusField: field },
            value: field === 'id' ? id : field === 'is_default' ? (isDefault ? '1' : '0') : field === 'label' ? label : '',
            focus() { this.focused = true },
            hasAttribute: () => false,
            closest: () => null,
        }]))
        const defaultIcon = { className: '' }
        const preview = { className: '' }
        const previewBox = { classList: makeClassList() }
        const labelError = { classList: makeClassList(['hidden']) }
        const iconError = { classList: makeClassList(['hidden']) }
        const buttons = Object.fromEntries(['up', 'down', 'remove', 'default'].map(action => [action, {
            disabled: false,
            attrs: {},
            classList: makeClassList(),
            setAttribute(name, val) { this.attrs[name] = val },
            hasAttribute: name => name === `data-status-${action}`,
            closest: () => row,
        }]))
        const row = {
            inputs, defaultIcon, preview, previewBox, labelError, iconError, buttons,
            closest: () => row,
            querySelectorAll: () => Object.values(inputs),
            querySelector(selector) {
                if (selector === '[data-status-default]') return buttons.default
                if (selector === '[data-status-default-icon]') return defaultIcon
                if (selector === '[data-status-preview]') return preview
                if (selector === '[data-status-preview-box]') return previewBox
                if (selector === '[data-status-label-error]') return labelError
                if (selector === '[data-status-icon-error]') return iconError
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

    rows.children = Array.from({ length: count }, (_, i) => makeRow(String(1000 + i), i === 0, `Status ${i + 1}`))

    const editor = {
        querySelector: selector => ({
            '[data-status-rows]': rows,
            '[data-status-count]': countBadge,
            '[data-status-empty]': emptyState,
            '[data-status-footer]': footer,
            '[data-status-limit-hint]': limitHint,
            '[data-status-template]': { content: { cloneNode: () => makeRow() } },
        })[selector],
        querySelectorAll: selector => selector === '[data-status-add]' ? addButtons : [],
        addEventListener: (event, handler) => { listeners[`editor:${event}`] = handler },
    }
    const form = {
        querySelector: selector => selector === '[data-category-statuses]' ? editor : null,
        hasAttribute: name => name === 'data-maintenance',
        addEventListener: (event, handler) => { listeners[`form:${event}`] = handler },
    }
    const win = {
        addEventListener: (event, handler) => { listeners[`window:${event}`] = handler },
    }

    const instance = initCategoryStatuses(form, {
        window: win,
        Sortable: {
            create(target, options) {
                sortableOptions = { target, options }
            },
        },
    })

    const click = button => listeners['editor:click']({ target: { closest: () => button } })
    const dirty = () => {
        let prevented = false
        listeners['window:beforeunload']({ preventDefault: () => { prevented = true } })
        return prevented
    }

    return {
        rows, addButtons, countBadge, emptyState, footer, limitHint,
        listeners, click, dirty, instance,
        get sortableOptions() { return sortableOptions },
    }
}

test('status rows reorder via buttons and SortableJS and serialize their new positions', () => {
    const state = setup()
    const [first, second] = state.rows.children
    assert.equal(first.inputs.is_default.value, '1')
    assert.equal(first.buttons.up.disabled, true)
    assert.equal(state.sortableOptions.target, state.rows)
    assert.equal(state.sortableOptions.options.handle, '[data-status-handle]')

    state.click(first.buttons.down)
    assert.equal(state.rows.children[1], first)
    assert.equal(first.inputs.id.name, 'statuses[1][id]')
    assert.equal(first.inputs.id.value, '1000')
    assert.equal(first.inputs.is_default.value, '1')
    assert.equal(first.buttons.down.disabled, true)
    assert.equal(state.dirty(), true)

    // Simulate SortableJS moving second back below first
    state.rows.insertBefore(first, second)
    state.sortableOptions.options.onEnd()
    assert.equal(state.rows.children[0], first)
    assert.equal(first.inputs.id.name, 'statuses[0][id]')
})

test('default button toggles on and off and keeps exclusivity across rows', () => {
    const state = setup()
    const [first, second] = state.rows.children
    assert.equal(first.buttons.default.attrs['aria-pressed'], 'true')
    assert.equal(first.defaultIcon.className, 'fa-solid fa-star')
    assert.equal(second.buttons.default.attrs['aria-pressed'], 'false')

    state.click(second.buttons.default)
    assert.equal(first.inputs.is_default.value, '0')
    assert.equal(second.inputs.is_default.value, '1')
    assert.equal(second.buttons.default.attrs['aria-pressed'], 'true')

    // Clicking active default clears default without needing a separate radio
    state.click(second.buttons.default)
    assert.equal(first.inputs.is_default.value, '0')
    assert.equal(second.inputs.is_default.value, '0')
    assert.equal(second.buttons.default.attrs['aria-pressed'], 'false')
    assert.equal(second.defaultIcon.className, 'fa-regular fa-star')
})

test('adding, removing, and applying presets updates empty state and counter', () => {
    const state = setup(0)
    assert.equal(state.countBadge.textContent, '0 / 10')
    assert.equal(state.emptyState.classList.contains('hidden'), false)
    assert.equal(state.footer.classList.contains('hidden'), true)

    const presetButton = {
        hasAttribute: name => name === 'data-status-preset',
        dataset: {
            statusPreset: JSON.stringify([
                { label: 'Draft', icon: 'fa-solid fa-pen-to-square', is_default: true },
                { label: 'Active', icon: 'fa-solid fa-check', is_default: false },
            ]),
        },
        closest: () => null,
    }
    state.click(presetButton)
    assert.equal(state.rows.children.length, 2)
    assert.equal(state.countBadge.textContent, '2 / 10')
    assert.equal(state.emptyState.classList.contains('hidden'), true)
    assert.equal(state.footer.classList.contains('hidden'), false)
    assert.equal(state.rows.children[0].inputs.label.value, 'Draft')
    assert.equal(state.rows.children[0].inputs.is_default.value, '1')

    state.click(state.addButtons[0])
    const added = state.rows.lastElementChild
    assert.equal(added.inputs.label.focused, true)
    assert.equal(added.inputs.label.name, 'statuses[2][label]')

    state.click(added.buttons.remove)
    assert.equal(state.rows.children.length, 2)
})

test('enforces ten-row cap, validates icon previews, detects duplicates, and strips pasted FontAwesome HTML', () => {
    const state = setup(10)
    assert.equal(state.addButtons[0].disabled, true)
    assert.equal(state.limitHint.classList.contains('hidden'), false)
    state.click(state.addButtons[0])
    assert.equal(state.rows.children.length, 10)

    const [first, second] = state.rows.children
    first.inputs.icon.value = 'fa-solid fa-key'
    state.listeners['form:input']()
    assert.equal(first.preview.className, 'fa-solid fa-key')
    assert.equal(first.iconError.classList.contains('hidden'), true)

    first.inputs.icon.value = '<script>alert(1)</script>'
    state.listeners['form:input']()
    assert.equal(first.preview.className, 'fa-solid fa-triangle-exclamation text-error')
    assert.equal(first.previewBox.classList.contains('border-error'), true)
    assert.equal(first.iconError.classList.contains('hidden'), false)

    // Duplicate label check (case-insensitive)
    second.inputs.label.value = '  status 1  '
    state.listeners['form:input']()
    assert.equal(first.labelError.classList.contains('hidden'), false)
    assert.equal(second.labelError.classList.contains('hidden'), false)

    // Paste FontAwesome HTML
    let prevented = false
    state.listeners['editor:paste']({
        target: { closest: sel => sel === 'input[data-paste="fontawesome"]' ? first.inputs.icon : null },
        clipboardData: { getData: () => '<i class="fa-solid fa-dragon"></i>' },
        preventDefault: () => { prevented = true },
    })
    assert.equal(prevented, true)
    assert.equal(first.inputs.icon.value, 'fa-solid fa-dragon')
    assert.equal(first.preview.className, 'fa-solid fa-dragon')
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
