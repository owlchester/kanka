import { Node } from '@tiptap/core'

export interface IframeOptions {
    allowFullscreen: boolean
    HTMLAttributes: Record<string, any>
}

declare module '@tiptap/core' {
    interface Commands<ReturnType> {
        iframe: {
            setIframe: (options: { src: string }) => ReturnType
        }
    }
}

export const Iframe = Node.create<IframeOptions>({
    name: 'iframe',

    group: 'block',

    atom: true,

    addOptions() {
        return {
            allowFullscreen: true,
            HTMLAttributes: {
                class: 'iframe-wrapper relative overflow-hidden max-w-full h-fit',
            },
        }
    },

    addAttributes() {
        return {
            src: {
                default: null,
                parseHTML: element => element.getAttribute('src'),
            },
            frameborder: {
                default: 0,
                parseHTML: element => element.getAttribute('frameborder') || 0,
            },
            allowfullscreen: {
                default: this.options.allowFullscreen,
                parseHTML: element => element.hasAttribute('allowfullscreen'),
            },
            width: {
                default: '100%',
                parseHTML: element => element.getAttribute('width') || '100%',
            },
            height: {
                default: 315,
                parseHTML: element => element.getAttribute('height') || 315,
            },
            allow: {
                default: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share',
                parseHTML: element => element.getAttribute('allow'),
            },
            title: {
                default: null,
                parseHTML: element => element.getAttribute('title'),
            },
            style: {
                default: null,
                parseHTML: element => element.getAttribute('style'),
            },
        }
    },

    parseHTML() {
        return [
            {
                tag: 'iframe',
            },
        ]
    },

    renderHTML({ HTMLAttributes }) {
        return ['div', this.options.HTMLAttributes, ['iframe', HTMLAttributes]]
    },

    addCommands() {
        return {
            setIframe:
                (options: { src: string }) =>
                ({ tr, dispatch }) => {
                    const { selection } = tr
                    const node = this.type.create(options)

                    if (dispatch) {
                        tr.replaceRangeWith(selection.from, selection.to, node)
                    }

                    return true
                },
        }
    },
})
