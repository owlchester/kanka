import { TableHeader } from '@tiptap/extension-table-header'

export const CustomTableHeader = TableHeader.extend({
    addAttributes() {
        return {
            ...this.parent?.(),
            colwidth: {
                default: null,
                parseHTML: (element: HTMLElement) => {
                    const colwidth = element.getAttribute('colwidth')
                    if (colwidth) {
                        return colwidth.split(',').map((w: string) => parseInt(w, 10))
                    }
                    const width = element.style.width
                    if (width && width.endsWith('px')) {
                        return [parseInt(width, 10)]
                    }
                    return null
                },
                renderHTML: (attributes: Record<string, any>) => {
                    if (!attributes.colwidth) {
                        return {}
                    }
                    return {
                        colwidth: attributes.colwidth.join(','),
                        style: `width: ${attributes.colwidth[0]}px`,
                    }
                },
            },
        }
    },
})
