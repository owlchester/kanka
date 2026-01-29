
import { Plugin, PluginKey } from '@tiptap/pm/state'
import { Extension } from '@tiptap/core'
import type { Ref } from 'vue'

/**
 * Parse mentions from text in the format [moduleName:id] or [moduleName:id|page:inventory|alias:456]
 * and convert them to mention nodes
 */
export const MentionParserPluginKey = new PluginKey('mentionParser')

export interface MentionParserOptions {
    entities?: Array<{ id: number; name: string; type: string; image?: string, url?: string, alias?: any }> | Ref<Array<{ id: number; name: string; type: string; image?: string, url?: string, alias?: any }>>
}

export const MentionParser = Extension.create<MentionParserOptions>({
    name: 'mentionParser',

    addOptions() {
        return {
            entities: [],
        }
    },

    addProseMirrorPlugins() {
        return [
            new Plugin({
                key: MentionParserPluginKey,

                appendTransaction: (transactions, oldState, newState) => {
                    // Check if document has changed
                    const docChanged = transactions.some(transaction => transaction.docChanged)
                    if (!docChanged) {
                        return null
                    }

                    // Support both plain arrays and Vue refs
                    const entities = 'value' in this.options.entities
                        ? this.options.entities.value
                        : this.options.entities || []

                    const tr = newState.tr
                    let modified = false

                    // Regular expression to match mentions like [moduleName:id] or [moduleName:id|page:inventory|alias:456]
                    const mentionRegex = /\[([a-zA-Z_]+):(\d+)(?:\|[^\]]+)?\]/g

                    newState.doc.descendants((node, pos) => {
                        if (node.isText && node.text) {
                            const text = node.text
                            let match: RegExpExecArray | null
                            const matches: Array<{ start: number; end: number; mention: string; module: string; id: string; customLabel?: string; config?: string }> = []

                            // Collect all matches first to avoid position issues
                            while ((match = mentionRegex.exec(text)) !== null) {
                                const fullMention = match[0]
                                const module = match[1]
                                const id = match[2]

                                const baseMention = `${module}:${id}`

                                // Parse the parts after the pipe separator
                                // Format: [type:id|CustomName|page:abilities|anchor:#post-1]
                                let customLabel: string | undefined
                                let config: string | undefined

                                // Extract everything after the first pipe if it exists
                                const pipeIndex = fullMention.indexOf('|')
                                if (pipeIndex !== -1) {
                                    // Get all parts after type:id
                                    const parts = fullMention.substring(pipeIndex + 1, fullMention.length - 1).split('|')

                                    const configParts: string[] = []

                                    for (const part of parts) {
                                        // Check if this part is a config (contains a colon)
                                        if (part.includes(':')) {
                                            configParts.push(part)
                                        } else if (!customLabel) {
                                            // First non-config part is the custom label
                                            customLabel = part
                                        }
                                    }

                                    if (configParts.length > 0) {
                                        config = configParts.join('|')
                                    }
                                }

                                matches.push({
                                    start: pos + match.index,
                                    end: pos + match.index + match[0].length,
                                    mention: baseMention,
                                    module: module,
                                    id: id,
                                    customLabel: customLabel,
                                    config: config
                                })
                            }

                            // Process matches in reverse order to maintain correct positions
                            for (let i = matches.length - 1; i >= 0; i--) {
                                const { start, end, mention, module, id, customLabel, config } = matches[i]

                                // Map positions through the transaction to account for previous changes
                                const mappedStart = tr.mapping.map(start)
                                const mappedEnd = tr.mapping.map(end)

                                // Check if this position isn't already a mention node
                                const $pos = tr.doc.resolve(mappedStart)
                                const nodeAtPos = tr.doc.nodeAt(mappedStart)

                                if (nodeAtPos?.type.name !== 'mention') {
                                    // Check if mention node type exists
                                    const mentionType = newState.schema.nodes.mention
                                    if (mentionType) {
                                        // Find entity by id to get the name and image
                                        const entity = entities.find(e => e.id === parseInt(id))
                                        const defaultLabel = entity ? entity.name : `${module}:${id}`
                                        const label = customLabel || defaultLabel
                                        const image = entity?.image || null
                                        const url = entity?.url || null

                                        // Replace text with mention node
                                        const mentionNode = mentionType.create({
                                            id: id,
                                            name: entity ? entity.name : `${module}:${id}`,
                                            label: label,
                                            mention: mention,
                                            image: image,
                                            url: url,
                                            config: config || null,
                                            entity: entity
                                        })

                                        tr.replaceWith(mappedStart, mappedEnd, mentionNode)
                                        modified = true
                                    }
                                }
                            }
                        }
                    })

                    return modified ? tr : null
                },
            }),
        ]
    },
})
