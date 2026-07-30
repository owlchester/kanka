import test from 'node:test'
import assert from 'node:assert/strict'
import { configureJQuery } from './jquerySetup.js'

test('exposes jQuery globally and configures Laravel CSRF requests', () => {
    const target = {}
    let ajaxConfig
    const jQuery = {
        ajaxSetup(config) {
            ajaxConfig = config
        },
    }

    configureJQuery(target, jQuery, 'csrf-token')

    assert.equal(target.$, jQuery)
    assert.equal(target.jQuery, jQuery)
    assert.deepEqual(ajaxConfig, {
        headers: {
            'X-CSRF-TOKEN': 'csrf-token',
        },
    })
})

test('does not configure an absent CSRF token', () => {
    const target = {}
    let configured = false
    const jQuery = {
        ajaxSetup() {
            configured = true
        },
    }

    configureJQuery(target, jQuery)

    assert.equal(configured, false)
})
