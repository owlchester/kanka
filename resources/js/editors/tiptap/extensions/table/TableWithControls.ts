
import { Table } from '@tiptap/extension-table'
import { mergeAttributes } from '@tiptap/core'
import { Plugin, PluginKey } from '@tiptap/pm/state'

export const TableWithControls = Table.extend({
    addAttributes() {
        return {
            ...this.parent?.(),
            class: {
                default: null,
                parseHTML: element => element.getAttribute('class'),
                renderHTML: attributes => {
                    if (!attributes.class) {
                        return {}
                    }
                    return { class: attributes.class }
                },
            },
            style: {
                default: null,
                parseHTML: element => element.getAttribute('style'),
                renderHTML: attributes => {
                    if (!attributes.style) {
                        return {}
                    }
                    return { style: attributes.style }
                },
            },
        }
    },

    renderHTML({ HTMLAttributes }) {
        return [
            'table',
            mergeAttributes(this.options.HTMLAttributes, HTMLAttributes),
            ['tbody', 0],
        ]
    },
})
