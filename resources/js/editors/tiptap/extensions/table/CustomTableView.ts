import { mergeAttributes } from '@tiptap/core'
import { TableView } from '@tiptap/extension-table'
import type { Node } from '@tiptap/pm/model'
import type { EditorView } from '@tiptap/pm/view'

export class CustomTableView extends TableView {
    private configuredAttributes: Record<string, any>

    constructor(node: Node, cellMinWidth: number, view: EditorView, HTMLAttributes: Record<string, any> = {}) {
        super(node, cellMinWidth, view, HTMLAttributes)
        this.configuredAttributes = HTMLAttributes
        this.syncClass(node)
    }

    update(node: Node) {
        if (!super.update(node)) {
            return false
        }

        this.syncClass(node)
        return true
    }

    private syncClass(node: Node) {
        // Resizable tables bypass renderHTML, so document classes must also be
        // applied to the live table (and removed when toolbar options change).
        const attributes = mergeAttributes(this.configuredAttributes, { class: node.attrs.class })

        if (attributes.class) {
            this.table.setAttribute('class', attributes.class)
        } else {
            this.table.removeAttribute('class')
        }
    }
}
