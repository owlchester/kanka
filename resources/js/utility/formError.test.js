import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
import { createContext, runInContext } from 'node:vm'

const source = readFileSync(new URL('./formError.js', import.meta.url), 'utf8')

function setup({ active = false, link = true, pane = true } = {}) {
    const paneClasses = new Set()
    const tabClasses = new Set()
    let focused = false
    let scrolled = false
    const classList = classes => ({
        add: name => classes.add(name),
        remove: name => classes.delete(name),
    })
    const tab = { classList: classList(tabClasses) }
    const previous = { classList: { remove: () => {} } }
    const tabs = {
        querySelector: selector => {
            if (selector === 'a[href="#form-months"]') {
                return link ? { closest: () => tab } : null
            }
            return active ? previous : null
        },
    }
    const firstPane = {
        id: 'form-months',
        classList: classList(paneClasses),
        closest: () => tabs,
    }
    const field = {
        closest: () => pane ? firstPane : null,
        focus: () => { focused = true },
        scrollIntoView: () => { scrolled = true },
    }
    const form = {
        querySelector: selector => selector === '[name="month_name"]' ? field : {},
    }
    const context = createContext({
        window: {},
        document: {
            querySelector: () => { throw new Error('Lookup escaped the submitted form') },
        },
        form,
        errors: { month_name: ['Months are required.'] },
    })
    runInContext(source, context)

    return {
        jump: () => runInContext('jumpToError(form, errors)', context),
        paneClasses,
        tabClasses,
        focused: () => focused && scrolled,
    }
}

test('validation activates the calendar error tab even without an active tab', () => {
    const state = setup()
    state.jump()
    assert.equal(state.paneClasses.has('active'), true)
    assert.equal(state.tabClasses.has('active'), true)
    assert.equal(state.focused(), true)
})

test('validation tolerates a missing tab link', () => {
    const state = setup({ active: true, link: false })
    assert.doesNotThrow(state.jump)
    assert.equal(state.paneClasses.has('active'), false)
    assert.equal(state.focused(), true)
})

test('validation tolerates fields outside tab panes', () => {
    const state = setup({ pane: false })
    assert.doesNotThrow(state.jump)
    assert.equal(state.focused(), true)
})
