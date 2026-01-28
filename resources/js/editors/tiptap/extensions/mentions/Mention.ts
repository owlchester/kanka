
import { Node, mergeAttributes } from '@tiptap/core'
import { PluginKey } from '@tiptap/pm/state'
import { Suggestion } from '@tiptap/suggestion'

export interface MentionOptions {
    HTMLAttributes: Record<string, any>
    renderLabel: (props: { options: MentionOptions; node: any }) => string
    suggestion: any
}

export const MentionPluginKey = new PluginKey('mention')

export const Mention = Node.create<MentionOptions>({
    name: 'mention',

    addOptions() {
        return {
            HTMLAttributes: {},
            renderLabel({ options, node }) {
                return node.attrs.label ?? node.attrs.id
            },
            suggestion: {
                char: '@',
                pluginKey: MentionPluginKey,
                command: ({ editor, range, props }) => {
                    // increase range.to by one when the next node is of type "text"
                    // and starts with a space character
                    const nodeAfter = editor.view.state.selection.$to.nodeAfter
                    const overrideSpace = nodeAfter?.text?.startsWith(' ')

                    if (overrideSpace) {
                        range.to += 1
                    }

                    editor
                        .chain()
                        .focus()
                        .insertContentAt(range, [
                            {
                                type: 'text',
                                text: props.mention,
                            },
                            {
                                type: 'text',
                                text: ' ',
                            },
                        ])
                        .run()

                    window.getSelection()?.collapseToEnd()
                },
                allow: ({ state, range }) => {
                    const $from = state.doc.resolve(range.from)
                    const type = state.schema.nodes[this.name]
                    const allow = !!$from.parent.type.contentMatch.matchType(type)

                    return allow
                },
            },
        }
    },

    group: 'inline',

    inline: true,

    selectable: true,

    atom: true,

    addAttributes() {
        return {
            id: {
                default: null,
                parseHTML: element => element.getAttribute('data-id'),
                renderHTML: attributes => {
                    if (!attributes.id) {
                        return {}
                    }

                    return {
                        'data-id': attributes.id,
                    }
                },
            },

            label: {
                default: null,
                parseHTML: element => element.getAttribute('data-label'),
                renderHTML: attributes => {
                    if (!attributes.label) {
                        return {}
                    }

                    return {
                        'data-label': attributes.label,
                    }
                },
            },

            name: {
                default: null,
                parseHTML: element => element.getAttribute('data-name'),
                renderHTML: attributes => {
                    if (!attributes.name) {
                        return {}
                    }

                    return {
                        'data-name': attributes.name,
                    }
                },
            },

            mention: {
                default: null,
                parseHTML: element => element.getAttribute('data-mention'),
                renderHTML: attributes => {
                    if (!attributes.mention) {
                        return {}
                    }

                    return {
                        'data-mention': attributes.mention,
                    }
                },
            },

            image: {
                default: null,
                parseHTML: element => element.getAttribute('data-image'),
                renderHTML: attributes => {
                    if (!attributes.image) {
                        return {}
                    }

                    return {
                        'data-image': attributes.image,
                    }
                },
            },

            url: {
                default: null,
                parseHTML: element => element.getAttribute('data-url'),
                renderHTML: attributes => {
                    if (!attributes.url) {
                        return {}
                    }

                    return {
                        'data-url': attributes.url,
                    }
                },
            },
            config: {
                default: null,
                parseHTML: element => element.getAttribute('data-config'),
                renderHTML: attributes => {
                    if (!attributes.config) {
                        return {}
                    }

                    return {
                        'data-config': attributes.config,
                    }
                },
            },
        }
    },

    parseHTML() {
        return [
            {
                tag: `span[data-mention]`,
            },
        ]
    },

    renderHTML({ node, HTMLAttributes }) {
        const label = this.options.renderLabel({
            options: this.options,
            node,
        })

        // Build inner content wrapper with styling
        const innerContent: any[] = []

        if (node.attrs.image) {
            innerContent.push([
                'img',
                {
                    src: node.attrs.image,
                    class: 'inline-block w-4 h-4 rounded-full object-cover mr-1 align-middle',
                    alt: label,
                },
            ])
        }

        innerContent.push(label)

        // If the node has a config, and in that config we have an "alias:id" property, we need to load that and show the ID inside a span element



        console.log('node', node.attrs);
        if (node.attrs.config) {
            innerContent.push([
                'span',
                {
                    class: 'rounded-2xl bg-primary text-primary-content',
                    html: 'config'
                }
            ])
        }

        return [
            'a',
            mergeAttributes(
                { 'data-type': 'mention' },
                this.options.HTMLAttributes,
                HTMLAttributes
            ),
            [
                'span',
                {
                    class: 'rounded-xl bg-base-200 hover:bg-base-300 text-base-content px-2 py-0.5 inline-flex items-center gap-1 cursor-pointer'
                },
                ...innerContent
            ]
        ]
    },

    renderText({ node }) {
        return node.attrs.mention || `[${node.attrs.label}]`
    },

    addKeyboardShortcuts() {
        return {
            Backspace: () =>
                this.editor.commands.command(({ tr, state }) => {
                    let isMention = false
                    const { selection } = state
                    const { empty, anchor } = selection

                    if (!empty) {
                        return false
                    }

                    state.doc.nodesBetween(anchor - 1, anchor, (node, pos) => {
                        if (node.type.name === this.name) {
                            isMention = true
                            tr.insertText(
                                this.options.suggestion.char || '',
                                pos,
                                pos + node.nodeSize
                            )

                            return false
                        }
                    })

                    return isMention
                }),
        }
    },

    addProseMirrorPlugins() {
        return [
            Suggestion({
                editor: this.editor,
                ...this.options.suggestion,
            }),
        ]
    },
})
