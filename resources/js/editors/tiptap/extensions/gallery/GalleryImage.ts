import { Image } from '@tiptap/extension-image'
import { VueNodeViewRenderer } from '@tiptap/vue-3'
import ImageWrapper from './ImageWrapper.vue'

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

const floatClasses = ['note-float-left', 'note-float-right']

const updateClassWithFloat = (currentClass: string | null, float: 'left' | 'right' | null): string | null => {
    const classes = (currentClass || '').split(' ').filter(c => c && !floatClasses.includes(c))
    if (float) {
        classes.push(`note-float-${float}`)
    }
    return classes.length > 0 ? classes.join(' ') : null
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
            'data-gallery-id': {
                default: null,
                parseHTML: element => element.getAttribute('data-gallery-id'),
                renderHTML: attributes => {
                    if (!attributes['data-gallery-id']) {
                        return {}
                    }
                    return { 'data-gallery-id': attributes['data-gallery-id'] }
                },
            },
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
            width: {
                default: null,
                parseHTML: element => element.getAttribute('width'),
                renderHTML: attributes => {
                    if (!attributes.width) {
                        return {}
                    }
                    return { width: attributes.width }
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
            setImageFloat: (float: 'left' | 'right' | null) => ({ tr, state, dispatch }) => {
                const { selection } = state
                const node = state.doc.nodeAt(selection.from)

                if (node?.type.name !== 'image') {
                    return false
                }

                const currentClass = node.attrs.class
                const newClass = updateClassWithFloat(currentClass, float)

                if (dispatch) {
                    tr.setNodeMarkup(selection.from, undefined, {
                        ...node.attrs,
                        class: newClass,
                    })
                    dispatch(tr)
                }

                return true
            },
        }
    },

    addNodeView() {
        return VueNodeViewRenderer(ImageWrapper)
    },
})
