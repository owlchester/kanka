
import { Image } from '@tiptap/extension-image'

export interface GalleryImageOptions {
    inline: boolean
    allowBase64: boolean
    HTMLAttributes: Record<string, any>
}

declare module '@tiptap/core' {
    interface Commands<ReturnType> {
        galleryImage: {
            setImageWidth: (width: string | null) => ReturnType
            setImageFloat: (float: 'left' | 'right' | null) => ReturnType
        }
    }
}

export const GalleryImage = Image.extend<GalleryImageOptions>({
    name: 'image',

    addAttributes() {
        return {
            ...this.parent?.(),
            'data-uuid': {
                default: null,
                parseHTML: element => element.getAttribute('data-uuid'),
                renderHTML: attributes => {
                    if (!attributes['data-uuid']) {
                        return {}
                    }
                    return { 'data-uuid': attributes['data-uuid'] }
                },
            },
            width: {
                default: null,
                parseHTML: element => element.getAttribute('width') || element.style.width || null,
                renderHTML: attributes => {
                    if (!attributes.width) {
                        return {}
                    }
                    return { width: attributes.width }
                },
            },
            float: {
                default: null,
                parseHTML: element => {
                    if (element.classList.contains('float-left')) return 'left'
                    if (element.classList.contains('float-right')) return 'right'
                    return null
                },
                renderHTML: attributes => {
                    if (!attributes.float) {
                        return {}
                    }
                    return { class: `float-${attributes.float}` }
                },
            },
        }
    },

    addCommands() {
        return {
            ...this.parent?.(),
            setImageWidth: (width: string | null) => ({ commands }) => {
                return commands.updateAttributes('image', { width })
            },
            setImageFloat: (float: 'left' | 'right' | null) => ({ commands }) => {
                return commands.updateAttributes('image', { float })
            },
        }
    },
})
