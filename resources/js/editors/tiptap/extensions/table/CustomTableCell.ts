import { TableCell } from '@tiptap/extension-table-cell'

export const CustomTableCell = TableCell.extend({
    addAttributes() {
        return {
            ...this.parent?.(),
            colwidth: {
                default: null,
                parseHTML: (element: HTMLElement) => {
                    // First try the colwidth attribute (editor's native format)
                    const colwidth = element.getAttribute('colwidth')
                    if (colwidth) {
                        return colwidth.split(',').map((w: string) => parseInt(w, 10))
                    }
                    // Fall back to inline width style
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
