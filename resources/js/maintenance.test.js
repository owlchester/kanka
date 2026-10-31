import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
import { runInNewContext } from 'node:vm'

const source = readFileSync(new URL('./maintenance.js', import.meta.url), 'utf8')

function setup(formErrorHandler = () => {}) {
    const buttons = [new Set(), new Set()]
    let listener
    let attempts = 0
    let submitted = false
    const form = {
        addEventListener: (event, handler) => { listener = handler },
        getAttribute: () => '/calendars',
        querySelectorAll: () => buttons.map(classes => ({
            classList: {
                add: (...names) => names.forEach(name => classes.add(name)),
                remove: (...names) => names.forEach(name => classes.delete(name)),
            },
        })),
        submit: () => { submitted = true },
    }
    const response = { status: 422, data: { errors: { weekday: ['Weekdays are required.'] } } }
    runInNewContext(source, {
        document: { querySelectorAll: () => [form] },
        window: { onEvent: () => {}, formErrorHandler },
        FormData: class {},
        axios: {
            post: () => ++attempts === 1
                ? Promise.reject({ response })
                : Promise.resolve(),
        },
    })

    return {
        buttons,
        response,
        form,
        submit: () => listener({ target: form, preventDefault: () => {} }),
        submitted: () => submitted,
    }
}

test('a rejected calendar save releases all save buttons and allows a retry', async () => {
    let reported
    const state = setup((response, form) => { reported = { response, form } })

    const firstAttempt = state.submit()
    assert.equal(state.buttons[0].has('loading'), true)
    assert.equal(state.buttons.every(button => button.has('btn-disabled')), true)
    await firstAttempt

    assert.deepEqual(reported, { response: state.response, form: state.form })
    assert.equal(state.buttons.every(button => button.size === 0), true)
    assert.equal(state.submitted(), false)

    await state.submit()
    assert.equal(state.submitted(), true)
})

test('save buttons recover even when validation error rendering throws', async () => {
    const renderingError = new Error('Missing validation tab')
    const state = setup(() => { throw renderingError })

    await assert.rejects(state.submit(), error => error === renderingError)
    assert.equal(state.buttons.every(button => button.size === 0), true)

    await state.submit()
    assert.equal(state.submitted(), true)
})
