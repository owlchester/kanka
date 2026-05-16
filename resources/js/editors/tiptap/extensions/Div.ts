import { Node, mergeAttributes } from '@tiptap/core'

export const Div = Node.create({
    name: 'div',

    group: 'block',

    content: 'block+',

    defining: true,

    parseHTML() {
        return [
            {
                tag: 'div',
                getAttrs: (node) => {
                    const el = node as HTMLElement
                    // Skip the content-wrapper div inside task items to avoid
                    // it being parsed as a block that drifts outside the list
                    if (el.parentElement?.getAttribute('data-type') === 'taskItem') {
                        return false
                    }
                    return {}
                },
            },
        ]
    },

    renderHTML({ HTMLAttributes }) {
        return ['div', mergeAttributes(HTMLAttributes), 0]
    },
})
