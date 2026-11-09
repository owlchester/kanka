import test from 'node:test'
import assert from 'node:assert/strict'
import { getSchema } from '@tiptap/core'
import { EditorState } from '@tiptap/pm/state'
import { history, undo } from '@tiptap/pm/history'
import StarterKit from '@tiptap/starter-kit'
import { TableKit } from '@tiptap/extension-table'
import { Mention } from './Mention.ts'
import { createMentionEntityLoader } from './entityLoader.js'

const schema = getSchema([StarterKit, TableKit, Mention])
const entity = { id: 123, name: 'Character', image: '/avatar.png', image_alt: 'Portrait', url: '/characters/123', aliases: [{ id: 456, name: 'Alias' }] }

function setup(fetchEntities, entities = []) {
    const mention = schema.nodes.mention.create({ id: '123', mention: 'character:123', label: 'Custom label', config: 'alias:456|page:inventory' })
    const paragraph = schema.nodes.paragraph.create(null, [schema.text('Bold ', [schema.marks.bold.create()]), mention])
    const table = schema.nodes.table.create(null, schema.nodes.tableRow.create(null, schema.nodes.tableCell.create(null, paragraph)))
    const editor = {
        state: EditorState.create({ schema, doc: schema.nodes.doc.create(null, [table, paragraph]), plugins: [history()] }),
        isDestroyed: false,
        view: {
            dispatch(tr) {
                editor.state = editor.state.apply(tr)
            },
        },
    }
    const loader = createMentionEntityLoader({
        getEditor: () => editor,
        getEntities: () => entities,
        addEntity: entity => entities.push(entity),
        fetchEntities,
    })
    return { editor, loader, entities }
}

function mentions(editor) {
    const nodes = []
    editor.state.doc.descendants(node => {
        if (node.type.name === 'mention') nodes.push(node)
    })
    return nodes
}

test('loads missing pasted entities once and hydrates images without losing formatting or mention configuration', async () => {
    const requests = []
    const { editor, loader } = setup(async ids => {
        requests.push(ids)
        return [entity]
    })
    await loader.load()
    await loader.load()

    assert.deepEqual(requests, [[123]])
    assert.equal(editor.state.doc.firstChild.type.name, 'table')
    assert.equal(editor.state.doc.firstChild.firstChild.firstChild.firstChild.firstChild.marks[0].type.name, 'bold')
    for (const node of mentions(editor)) {
        assert.equal(node.attrs.entity, entity)
        assert.equal(node.attrs.image, entity.image)
        assert.equal(node.attrs.imageAlt, entity.image_alt)
        assert.equal(node.attrs.url, entity.url)
        assert.equal(node.attrs.name, 'Alias')
        assert.equal(node.attrs.label, 'Custom label')
        assert.equal(node.attrs.config, 'alias:456|page:inventory')
    }
    assert.equal(undo(editor.state), false)
})

test('uses cached entities without requesting them again', async () => {
    const { editor, loader } = setup(() => assert.fail('Unexpected request'), [entity])
    await loader.load()
    assert.equal(mentions(editor)[0].attrs.image, entity.image)
})

test('deduplicates in-flight requests and preserves edits made while loading', async () => {
    let resolve
    let requests = 0
    const { editor, loader } = setup(() => {
        requests++
        return new Promise(done => { resolve = done })
    })
    const pending = loader.load()
    await loader.load()
    editor.view.dispatch(editor.state.tr.insertText('New text ', 4))
    resolve([entity])
    await pending

    assert.equal(requests, 1)
    assert.ok(editor.state.doc.textContent.includes('New text'))
    assert.equal(mentions(editor)[0].attrs.image, entity.image)
})

test('does not recreate mentions deleted while loading', async () => {
    let resolve
    const { editor, loader } = setup(() => new Promise(done => { resolve = done }))
    const pending = loader.load()
    editor.view.dispatch(editor.state.tr.replaceWith(0, editor.state.doc.content.size, schema.nodes.paragraph.create()))
    resolve([entity])
    await pending

    assert.equal(mentions(editor).length, 0)
})

test('does not repeatedly request inaccessible entities', async () => {
    let requests = 0
    const { editor, loader } = setup(async () => { requests++; return [] })
    await loader.load()
    await loader.load()
    assert.equal(requests, 1)
    assert.equal(mentions(editor)[0].attrs.mention, 'character:123')
})

test('failed requests leave mentions intact and can be retried', async () => {
    let requests = 0
    const { editor, loader } = setup(async () => {
        if (++requests === 1) throw new Error('Network error')
        return [entity]
    })
    await loader.load()
    assert.equal(mentions(editor)[0].attrs.entity, null)
    await loader.load()
    assert.equal(mentions(editor)[0].attrs.image, entity.image)
})

test('ignores responses after the component is destroyed', async () => {
    let resolve
    const { editor, loader, entities } = setup(() => new Promise(done => { resolve = done }))
    const pending = loader.load()
    loader.destroy()
    resolve([entity])
    await pending

    assert.deepEqual(entities, [])
    assert.equal(mentions(editor)[0].attrs.entity, null)
})
