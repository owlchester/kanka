import { Extension } from '@tiptap/core'

export const PreserveClass = Extension.create({
    name: 'preserveClass',

    addGlobalAttributes() {
        return [
            {
                types: ['blockquote', 'paragraph', 'heading', 'bulletList', 'orderedList', 'listItem', 'codeBlock', 'image', 'table', 'tableRow', 'tableCell', 'tableHeader', 'iframe', 'div', 'p', 'details', 'summary'],
                attributes: {
                    class: {
                        default: null,
                        parseHTML: (el: HTMLElement) => el.getAttribute('class') || null,
                        renderHTML: (attrs: Record<string, any>) => attrs.class ? { class: attrs.class } : {},
                    },
                },
            },
        ]
    },
})
