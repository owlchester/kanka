import { Node, mergeAttributes } from '@tiptap/core'

export const Div = Node.create({
    name: 'div',

    group: 'block',

    content: 'block+',

    defining: true,

    addAttributes() {
        return {
            class: {
                default: null,
                parseHTML: element => element.getAttribute('class'),
            },
            style: {
                default: null,
                parseHTML: element => element.getAttribute('style'),
            },
        }
    },

    parseHTML() {
        return [
            {
                tag: 'div',
            },
        ]
    },

    renderHTML({ HTMLAttributes }) {
        return ['div', mergeAttributes(HTMLAttributes), 0]
    },
})
