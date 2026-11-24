import { Image } from '@tiptap/extension-image'
import { mergeAttributes, ResizableNodeView } from '@tiptap/core'
import {
    applyImageNodeViewStyles,
    buildImageStyle,
    filterImageClasses,
    parseFloatStyle,
    parsePercentWidth,
    parsePixelDimension,
} from './imageStyles.js'

export interface ImageAttributesPayload {
    alt?: string | null
    title?: string | null
    width?: number | null
    height?: number | null
    widthStyle?: string | null
}

declare module '@tiptap/core' {
    interface Commands<ReturnType> {
        customImage: {
            setImageWidth: (width: string | null) => ReturnType
            setImageFloat: (float: 'left' | 'right' | null) => ReturnType
            setImageAttributes: (attrs: ImageAttributesPayload) => ReturnType
        }
    }
}

export const CustomImage = Image.extend({
    name: 'image',

    addAttributes() {
        return {
            src: { default: null },
            alt: { default: null },
            title: { default: null },
            'data-gallery-id': { default: null },
            class: {
                default: null,
                parseHTML: (element: HTMLElement) => filterImageClasses(element),
            },
            width: {
                default: null,
                parseHTML: (element: HTMLElement) => parsePixelDimension(element, 'width'),
                renderHTML: () => ({}),
            },
            height: {
                default: null,
                parseHTML: (element: HTMLElement) => parsePixelDimension(element, 'height'),
                renderHTML: () => ({}),
            },
            widthStyle: {
                default: null,
                parseHTML: (element: HTMLElement) => parsePercentWidth(element),
                renderHTML: () => ({}),
            },
            floatStyle: {
                default: null,
                parseHTML: (element: HTMLElement) => parseFloatStyle(element),
                renderHTML: () => ({}),
            },
        }
    },

    renderHTML({ node, HTMLAttributes }) {
        const style = buildImageStyle(node.attrs)
        const styleAttr = style ? { style } : {}

        return ['img', mergeAttributes(this.options.HTMLAttributes, HTMLAttributes, styleAttr)]
    },

    addCommands() {
        return {
            ...this.parent?.(),
            setImageWidth: (width: string | null) => ({ commands }) => {
                return commands.updateAttributes('image', {
                    widthStyle: width,
                    width: null,
                    height: null,
                })
            },
            setImageFloat: (float: 'left' | 'right' | null) => ({ commands }) => {
                return commands.updateAttributes('image', { floatStyle: float })
            },
            setImageAttributes: (attrs: ImageAttributesPayload) => ({ commands }) => {
                return commands.updateAttributes('image', attrs)
            },
        }
    },

    addNodeView() {
        if (!this.options.resize?.enabled || typeof document === 'undefined') {
            return null
        }

        const { directions, minWidth, minHeight, alwaysPreserveAspectRatio } = this.options.resize

        return ({ node, getPos, HTMLAttributes, editor }: any) => {
            const el = document.createElement('img')

            Object.entries(HTMLAttributes).forEach(([key, value]) => {
                if (value != null) {
                    switch (key) {
                        case 'width':
                        case 'height':
                            break
                        default:
                            el.setAttribute(key, value as string)
                            break
                    }
                }
            })

            el.src = HTMLAttributes.src

            const nodeView = new ResizableNodeView({
                element: el,
                editor,
                node,
                getPos,
                onResize: (width: number, height: number) => {
                    el.style.width = `${width}px`
                    el.style.height = `${height}px`
                },
                onCommit: (width: number) => {
                    const pos = getPos()
                    if (pos === undefined) return

                    this.editor.chain().setNodeSelection(pos).updateAttributes(this.name, {
                        width: Math.round(width),
                        height: null,
                        widthStyle: null,
                    }).run()
                },
                onUpdate: (updatedNode: any) => {
                    if (updatedNode.type !== node.type) return false

                    applyImageNodeViewStyles(updatedNode.attrs, el, nodeView.dom as HTMLElement)
                    return true
                },
                options: {
                    directions,
                    min: { width: minWidth, height: minHeight },
                    preserveAspectRatio: alwaysPreserveAspectRatio === true,
                },
            })

            const dom = nodeView.dom as HTMLElement
            dom.style.visibility = 'hidden'
            dom.style.pointerEvents = 'none'

            el.onload = () => {
                dom.style.visibility = ''
                dom.style.pointerEvents = ''
            }
            if (el.complete) {
                dom.style.visibility = ''
                dom.style.pointerEvents = ''
            }

            applyImageNodeViewStyles(node.attrs, el, dom)

            return nodeView
        }
    },
})
