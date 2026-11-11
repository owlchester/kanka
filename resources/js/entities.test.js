import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
import { runInNewContext } from 'node:vm'

const source = readFileSync(new URL('./entities.js', import.meta.url), 'utf8')

test('post anchor loading waits until the application is ready', () => {
    let readyCallback
    let requestedUrl
    const config = {
        dataset: { url: '/posts/0' },
        insertAdjacentHTML() {},
    }

    const sandbox = {
        URLSearchParams,
        window: {
            location: { hash: '#post-123', search: '' },
            onEvent() {},
            onReady: callback => { readyCallback = callback },
        },
        document: {
            querySelector: () => null,
            querySelectorAll: () => [],
            getElementById: id => id === 'post-anchor-loader' ? config : null,
        },
    }
    runInNewContext(source, sandbox)

    assert.equal(typeof readyCallback, 'function')

    // app.js assigns axios after its imports have executed; onReady runs afterward.
    sandbox.axios = {
        get: url => {
            requestedUrl = url
            return { then() {} }
        },
    }
    readyCallback()

    assert.equal(requestedUrl, '/posts/123')
})
