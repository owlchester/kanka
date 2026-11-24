import test from 'node:test'
import assert from 'node:assert/strict'
import { mountOnce } from './mountOnce.js'

test('rescanning keeps existing widgets and mounts newly inserted ones', () => {
    const first = {}
    const second = {}
    const inserted = {}
    const mounts = []
    const scan = elements => elements.forEach(element => {
        mountOnce(element, () => ({
            mount(target) {
                mounts.push(target)
                target.selection = null
            },
        }))
    })

    scan([first, second])
    first.selection = 42
    scan([first, second, inserted])
    scan([first, second, inserted])

    assert.equal(mounts.length, 3)
    assert.equal(mounts[0], first)
    assert.equal(mounts[1], second)
    assert.equal(mounts[2], inserted)
    assert.equal(first.selection, 42)
    assert.equal(second.selection, null)
})

test('a failed mount can be retried', () => {
    const element = {}
    const error = new Error('mount failed')

    assert.throws(() => mountOnce(element, () => ({
        mount() {
            throw error
        },
    })), error)

    let mounted = false
    mountOnce(element, () => ({
        mount() {
            mounted = true
        },
    }))
    assert.equal(mounted, true)
})
