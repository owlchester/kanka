import { Image } from '@tiptap/extension-image'
import { mergeAttributes, ResizableNodeView } from '@tiptap/core'

declare module '@tiptap/core' {
    interface Commands<ReturnType> {
        customImage: {
            setImageWidth: (width: string | null) => ReturnType
            setImageFloat: (float: 'left' | 'right' | null) => ReturnType
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
            'data-gallery-uuid': { default: null },
            class: {
                default: null,
                parseHTML: (element: HTMLElement) => {
                    const classes = element.getAttribute('class') || ''
                    const filtered = classes
                        .split(/\s+/)
                        .filter(c => !['note-float-left', 'note-float-right', 'float-left', 'float-right'].includes(c))
                        .join(' ')
                        .trim()
                    return filtered || null
                },
            },
            width: {
                default: null,
                parseHTML: (element: HTMLElement) => {
                    const style = element.getAttribute('style') || ''
                    const match = style.match(/width:\s*(\d+(?:\.\d+)?)px/)
                    if (match) return parseFloat(match[1])

                    const attr = element.getAttribute('width')
                    if (attr) return parseFloat(attr)

                    return null
                },
                renderHTML: () => ({}),
            },
            height: {
                default: null,
                parseHTML: (element: HTMLElement) => {
                    const style = element.getAttribute('style') || ''
                    const match = style.match(/height:\s*(\d+(?:\.\d+)?)px/)
                    if (match) return parseFloat(match[1])

                    const attr = element.getAttribute('height')
                    if (attr) return parseFloat(attr)

                    return null
                },
                renderHTML: () => ({}),
            },
            widthStyle: {
                default: null,
                parseHTML: (element: HTMLElement) => {
                    const style = element.getAttribute('style') || ''
                    const match = style.match(/width:\s*(\d+%)/)
                    return match ? match[1] : null
                },
                renderHTML: () => ({}),
            },
            floatStyle: {
                default: null,
                parseHTML: (element: HTMLElement) => {
                    const style = element.getAttribute('style') || ''
                    const match = style.match(/float:\s*(left|right)/)
                    if (match) return match[1]

                    const classes = element.getAttribute('class') || ''
                    if (classes.includes('note-float-left') || classes.includes('float-left')) return 'left'
                    if (classes.includes('note-float-right') || classes.includes('float-right')) return 'right'

                    return null
                },
                renderHTML: () => ({}),
            },
        }
    },

    renderHTML({ node, HTMLAttributes }) {
        const { width, height, widthStyle, floatStyle } = node.attrs
        const styleParts: string[] = []

        if (widthStyle) {
            styleParts.push(`width: ${widthStyle}`)
        } else if (width != null) {
            styleParts.push(`width: ${typeof width === 'number' ? `${width}px` : width}`)
        }

        if (!widthStyle && height != null) {
            styleParts.push(`height: ${typeof height === 'number' ? `${height}px` : height}`)
        }

        if (floatStyle) {
            styleParts.push(`float: ${floatStyle}`)
            if (floatStyle === 'left') styleParts.push('margin-right: 0.5rem')
            if (floatStyle === 'right') styleParts.push('margin-left: 0.5rem')
        }

        const styleAttr = styleParts.length > 0 ? { style: styleParts.join('; ') } : {}

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

            const applyCustomStyles = (attrs: any, container: HTMLElement) => {
                const { widthStyle, floatStyle } = attrs

                if (widthStyle) {
                    container.style.width = widthStyle
                    el.style.width = '100%'
                    el.style.height = 'auto'
                } else {
                    container.style.width = ''
                }

                container.style.float = floatStyle || ''
                container.style.marginRight = floatStyle === 'left' ? '0.5rem' : ''
                container.style.marginLeft = floatStyle === 'right' ? '0.5rem' : ''
            }

            const nodeView = new ResizableNodeView({
                element: el,
                editor,
                node,
                getPos,
                onResize: (width: number, height: number) => {
                    el.style.width = `${width}px`
                    el.style.height = `${height}px`
                },
                onCommit: (width: number, height: number) => {
                    const pos = getPos()
                    if (pos === undefined) return

                    this.editor.chain().setNodeSelection(pos).updateAttributes(this.name, {
                        width,
                        height,
                        widthStyle: null,
                    }).run()
                },
                onUpdate: (updatedNode: any) => {
                    if (updatedNode.type !== node.type) return false

                    applyCustomStyles(updatedNode.attrs, nodeView.dom as HTMLElement)
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

            applyCustomStyles(node.attrs, dom)

            return nodeView
        }
    },
})
