import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
import { runInNewContext } from 'node:vm'

// Exercise the component's actual handler without mounting the editor or its menus.
const source = readFileSync(new URL('./Tiptap.vue', import.meta.url), 'utf8')
const handler = source.match(/handlePaste: (\(view, event, slice\) => \{[\s\S]*?)\s*,\s*handleKeyDown:/)?.[1]
assert.ok(handler)

function paste(plainText, htmlText = '') {
    const inserted = []
    const handlePaste = runInNewContext(`(${handler})`, {
        props: {},
        editor: {
            value: {
                commands: {
                    insertContent: (content) => inserted.push(content),
                },
            },
        },
    })
    const handled = handlePaste({}, {
        clipboardData: {
            getData: (type) => type === 'text/html' ? htmlText : plainText,
        },
    }, {})

    return { handled, inserted }
}

test('rich text containing mentions is left to Tiptap instead of inserted as plain text', () => {
    const html = '<p><strong>Title</strong> [character:123]</p><table><tbody><tr><td><p>Cell</p></td></tr></tbody></table><p>Next paragraph</p>'

    assert.deepEqual(paste('Title [character:123]\nCell\nNext paragraph', html), {
        handled: false,
        inserted: [],
    })
})

test('plain-text mentions still use the mention fallback', () => {
    const text = 'Hello [character:123|Custom name|page:inventory]'

    assert.deepEqual(paste(text), {
        handled: true,
        inserted: [text],
    })
})

test('content without mentions is left to Tiptap for both clipboard formats', () => {
    for (const html of ['', '<p><em>Hello</em></p>']) {
        assert.deepEqual(paste('Hello', html), {
            handled: false,
            inserted: [],
        })
    }
})

test('plain-text clipboard serialization uses the mention identity rather than an undefined type', () => {
    const serializer = source.match(/const serializeMentionToText = (\(node: any\): string => \{[\s\S]*?)\s*const openLinkBubble/)?.[1]
    assert.ok(serializer)
    const serialize = runInNewContext(`(${serializer.replace('(node: any): string', '(node)')})`)

    assert.equal(serialize({ attrs: { id: '123', mention: 'character:123', config: 'page:inventory' } }), '[character:123|page:inventory]')
})
