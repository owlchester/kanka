import { Extension } from '@tiptap/core'

export const PreserveStyle = Extension.create({
    name: 'preserveStyle',

    addGlobalAttributes() {
        return [
            {
                types: ['blockquote', 'paragraph', 'heading', 'bulletList', 'orderedList', 'listItem', 'codeBlock', 'image', 'table', 'tableRow', 'tableCell', 'tableHeader', 'iframe', 'div', 'p', 'details', 'summary'],
                attributes: {
                    style: {
                        default: null,
                        parseHTML: (el: HTMLElement) => el.getAttribute('style') || null,
                        renderHTML: (attrs: Record<string, any>) => attrs.style ? { style: attrs.style } : {},
                    },
                },
            },
        ]
    },
})
