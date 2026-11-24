import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
import { runInNewContext } from 'node:vm'
import { postIdFromHash, scrollToSection } from './entities/reader/navigation.js'

const source = readFileSync(new URL('./entities.js', import.meta.url), 'utf8').replace(/^import .*;$/m, '')

test('post anchor loading waits until the application is ready', () => {
    let readyCallback
    let requestedUrl
    const config = {
        dataset: { url: '/posts/0' },
        insertAdjacentHTML() {},
    }

    const sandbox = {
        URLSearchParams,
        postIdFromHash,
        scrollToSection,
        window: {
            location: { hash: '#post-123', search: '' },
            onEvent() {},
            addEventListener() {},
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
            return { then() { return this }, catch() { return this }, finally() {} }
        },
    }
    readyCallback()

    assert.equal(requestedUrl, '/posts/123')
})
