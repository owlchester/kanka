import Heading from '@tiptap/extension-heading'

export const CustomHeading = Heading.extend({
    addAttributes() {
        return {
            ...this.parent?.(),
            style: {
                default: null,
                parseHTML: (element: HTMLElement) => element.getAttribute('style') || null,
                renderHTML: (attributes: Record<string, any>) => {
                    if (!attributes.style) {
                        return {}
                    }

                    return { style: attributes.style }
                },
            },
        }
    },
})
