import test, { beforeEach, afterEach } from 'node:test'
import assert from 'node:assert/strict'
import { Schema } from '@tiptap/pm/model'
import { tableNodes } from '@tiptap/pm/tables'
import { CustomTableView } from './CustomTableView.ts'

// TableView only needs element creation and column styles; no browser layout is
// involved in these tests. Use the real ProseMirror nodes and upstream TableView.
class Element {
    constructor(tagName) {
        this.tagName = tagName
        this.children = []
        this.attributes = new Map()
        this.style = { setProperty(name, value) { this[name] = value } }
    }

    appendChild(child) {
        child.parentNode = this
        this.children.push(child)
        return child
    }

    removeChild(child) {
        this.children.splice(this.children.indexOf(child), 1)
    }

    get firstChild() {
        return this.children[0] ?? null
    }

    get nextSibling() {
        return this.parentNode.children[this.parentNode.children.indexOf(this) + 1] ?? null
    }

    setAttribute(name, value) {
        this.attributes.set(name, String(value))
    }

    getAttribute(name) {
        return this.attributes.get(name) ?? null
    }

    removeAttribute(name) {
        this.attributes.delete(name)
    }
}

const tables = tableNodes({ tableGroup: 'block', cellContent: 'paragraph+' })
const schema = new Schema({
    nodes: {
        doc: { content: 'block+' },
        paragraph: { content: 'text*', group: 'block' },
        text: {},
        ...tables,
        table: {
            ...tables.table,
            attrs: { class: { default: null } },
        },
    },
})

function table(className = null, widths = [80, 120]) {
    return schema.node('table', { class: className }, [
        schema.node('table_row', null, widths.map(width =>
            schema.node('table_cell', { colwidth: [width] }, [schema.node('paragraph')]),
        )),
    ])
}

let originalDocument

beforeEach(() => {
    originalDocument = Object.getOwnPropertyDescriptor(globalThis, 'document')
    globalThis.document = { createElement: tagName => new Element(tagName) }
})

afterEach(() => {
    if (originalDocument) {
        Object.defineProperty(globalThis, 'document', originalDocument)
    } else {
        delete globalThis.document
    }
})

test('applies saved striping, border, alignment, and custom classes to the live table', () => {
    const classes = 'table table-striped table-bordered table-left custom-table'
    const view = new CustomTableView(table(classes), 25, undefined)

    assert.equal(view.table.getAttribute('class'), classes)
    assert.equal(view.dom.className, 'tableWrapper')
    assert.equal(view.contentDOM.tagName, 'tbody')
})

test('updates classes immediately without replacing the table or its editable body', () => {
    const view = new CustomTableView(table('table table-striped custom-table'), 25, undefined)
    const originalTable = view.table
    const originalBody = view.contentDOM

    assert.equal(view.update(table('table table-bordered table-right custom-table')), true)
    assert.equal(view.table.getAttribute('class'), 'table table-bordered table-right custom-table')
    assert.equal(view.table, originalTable)
    assert.equal(view.contentDOM, originalBody)
})

test('removes classes when the document no longer has any', () => {
    const view = new CustomTableView(table('table table-striped'), 25, undefined)

    assert.equal(view.update(table()), true)
    assert.equal(view.table.getAttribute('class'), null)
})

test('borderless changes appear in the live table and survive a document round trip', () => {
    const view = new CustomTableView(table('table table-bordered table-striped'), 25, undefined)
    const borderless = table('table table-striped table-borderless')

    assert.equal(view.update(borderless), true)
    assert.equal(view.table.getAttribute('class'), 'table table-striped table-borderless')

    const restored = new CustomTableView(schema.nodeFromJSON(borderless.toJSON()), 25, undefined)
    assert.equal(restored.table.getAttribute('class'), 'table table-striped table-borderless')

    view.update(table('table table-striped'))
    assert.equal(view.table.getAttribute('class'), 'table table-striped')
})

test('preserves configured classes when document classes are added and removed', () => {
    const view = new CustomTableView(table('table-striped'), 25, undefined, { class: 'configured' })

    assert.equal(view.table.getAttribute('class'), 'configured table-striped')
    view.update(table())
    assert.equal(view.table.getAttribute('class'), 'configured')
})

test('keeps upstream column sizing and resizing behaviour', () => {
    const view = new CustomTableView(table('table-striped'), 25, undefined)

    assert.equal(view.table.style.width, '200px')
    assert.deepEqual(view.colgroup.children.map(col => col.style.width), ['80px', '120px'])

    assert.equal(view.update(table('table-striped', [100, 150, 50])), true)
    assert.equal(view.table.style.width, '300px')
    assert.deepEqual(view.colgroup.children.map(col => col.style.width), ['100px', '150px', '50px'])

    view.update(table('table-striped', [90]))
    assert.equal(view.table.style.width, '90px')
    assert.equal(view.colgroup.children.length, 1)
})

test('rejects a different node type without changing the table classes', () => {
    const view = new CustomTableView(table('table-striped'), 25, undefined)

    assert.equal(view.update(schema.node('paragraph')), false)
    assert.equal(view.table.getAttribute('class'), 'table-striped')
})
