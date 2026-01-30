<script setup lang="ts">
    import { useEditor, EditorContent } from '@tiptap/vue-3'
    import StarterKit from '@tiptap/starter-kit'
    import { Placeholder } from '@tiptap/extensions'
    import { BubbleMenu, FloatingMenu } from '@tiptap/vue-3/menus'
    import Link from '@tiptap/extension-link'
    import TableRow from '@tiptap/extension-table-row'
    import TableCell from '@tiptap/extension-table-cell'
    import TableHeader from '@tiptap/extension-table-header'
    import { TableWithControls } from './extensions/table/TableWithControls'
    import { ref, onMounted, onBeforeUnmount } from 'vue'
    import { Mention } from './extensions/mentions/Mention'
    import suggestion from './extensions/mentions/suggestion'
    import { MentionParser } from './extensions/mentions/MentionParser'
    import { SlashCommand } from './extensions/slashcommand/SlashCommand'
    import slashCommandSuggestion from './extensions/slashcommand/suggestion'
    import { Gallery } from './extensions/gallery/Gallery'
    import GalleryDialog from './extensions/gallery/GalleryDialog.vue'
    import { GalleryImage } from './extensions/gallery/GalleryImage'
    import { Iframe } from './extensions/Iframe'
    import { TextStyle } from '@tiptap/extension-text-style'
    import { Color } from '@tiptap/extension-color'
    import Highlight from '@tiptap/extension-highlight'

    // Bubble menus
    import MentionBubbleMenu from './bubblemenus/MentionBubbleMenu.vue'
    import LinkBubbleMenu from './bubblemenus/LinkBubbleMenu.vue'
    import TableBubbleMenu from './bubblemenus/TableBubbleMenu.vue'
    import ImageBubbleMenu from './bubblemenus/ImageBubbleMenu.vue'
    import TextBubbleMenu from './bubblemenus/TextBubbleMenu.vue'

    const props = withDefaults(defineProps<{
        modelValue?: string
        content?: string
        gallery?: string
        mentions?: string
        fieldName?: string
    }>(), {
        fieldName: 'entry'
    })

    const html = ref(props.content ?? props.modelValue ?? '')
    const mentions = ref([])
    const showLinkBubble = ref(false)

    // Refs for bubble menu components
    const mentionBubbleRef = ref<InstanceType<typeof MentionBubbleMenu> | null>(null)
    const linkBubbleRef = ref<InstanceType<typeof LinkBubbleMenu> | null>(null)

    const addEntityToMentions = (entity: any) => {
        const exists = mentions.value.find(e => e.id === entity.id)
        if (!exists) {
            mentions.value.push(entity)
        }
    }

    const extensions = [
        StarterKit.configure({
            link: false,
        }),
        Placeholder.configure({
            placeholder: 'Write something …',
        }),
        Link.configure({
            openOnClick: false,
            defaultProtocol: 'https',
            HTMLAttributes: {
                class: 'text-link',
            },
        }),
        TableWithControls.configure({
            resizable: true,
            HTMLAttributes: {
                class: '',
            },
        }),
        TableRow,
        TableCell.configure({
            HTMLAttributes: {
                class: '',
            },
        }),
        TableHeader.configure({
            HTMLAttributes: {
                class: '',
            },
        }),
        SlashCommand.configure({
            suggestion: slashCommandSuggestion(),
        }),
        GalleryImage.configure({
            inline: false,
            allowBase64: false,
        }),
        Iframe,
        TextStyle,
        Color,
        Highlight.configure({
            multicolor: true,
        }),
    ];

    if (props.gallery) {
        extensions.push(
            Gallery.configure({
                galleryUrl: props.gallery as string,
            })
        )
    }

    if (props.mentions) {
        extensions.push(
            Mention.configure({
                HTMLAttributes: {
                    class: 'mention',
                },
                suggestion: suggestion(props.mentions, addEntityToMentions),
                renderText({ node }) {
                    const mention = node.attrs.mention
                    const label = node.attrs.label
                    const id = node.attrs.id
                    const config = node.attrs.config

                    const mentionMatch = mention?.match(/\[([^:]+):(\d+)/)
                    const type = mentionMatch ? mentionMatch[1] : null

                    if (type && id) {
                        const entity = mentions.value.find(e => e.id === parseInt(id))
                        const entityName = entity ? entity.name : null
                        const parts = [`${type}:${id}`]

                        if (label && entityName && label !== entityName) {
                            parts.push(label)
                        }

                        if (config) {
                            parts.push(config)
                        }

                        return `[${parts.join('|')}]`
                    }

                    return mention || `[${label}]`
                },
            }),
            MentionParser.configure({
                entities: mentions
            })
        )
    }

    const editor = useEditor({
        content: html.value,
        extensions: extensions,
        onUpdate: ({ editor }) => {
            html.value = editor.getHTML()
        },
        onSelectionUpdate: ({ editor }) => {
            if (editor.isActive('mention')) {
                mentionBubbleRef.value?.syncLabel()
            }
            // Hide link bubble when selection changes away from link
            if (!editor.isActive('link')) {
                showLinkBubble.value = false
            }
        },
        editorProps: {
            clipboardTextSerializer: (slice) => {
                let text = ''
                slice.content.forEach(node => {
                    text += serializeNodeToText(node)
                })
                return text
            },
            handlePaste: (view, event, slice) => {
                const plainText = event.clipboardData?.getData('text/plain') || ''
                const htmlText = event.clipboardData?.getData('text/html') || ''

                const iframeMatch = (htmlText || plainText).match(/<iframe[^>]*src=["']([^"']+)["'][^>]*>/i)
                if (iframeMatch || plainText.includes('<iframe')) {
                    const content = htmlText || plainText
                    editor.value?.commands.insertContent(content, {
                        parseOptions: {
                            preserveWhitespace: false,
                        },
                    })
                    return true
                }

                const mentionPattern = /\[([a-zA-Z_]+):(\d+)(?:\|[^\]]+)?\]/
                if (mentionPattern.test(plainText)) {
                    editor.value?.commands.insertContent(plainText)
                    return true
                }

                return false
            },
        },
    })

    const serializeNodeToText = (node: any): string => {
        if (node.type.name === 'mention') {
            return serializeMentionToText(node)
        }

        if (node.isText) {
            return node.text || ''
        }

        let text = ''
        if (node.content) {
            node.content.forEach((child: any) => {
                text += serializeNodeToText(child)
            })
        }

        if (node.isBlock && text) {
            text += '\n'
        }

        return text
    }

    const serializeMentionToText = (node: any): string => {
        const config = node.attrs.config
        const id = node.attrs.id
        const type = node.attrs.type

        const parts = [`${type}:${id}`]

        if (config) {
            parts.push(config)
        }

        return `[${parts.join('|')}]`
    }

    const openLinkBubble = () => {
        showLinkBubble.value = true
        linkBubbleRef.value?.openLinkInput()
    }

    const parseMentionsFromContent = (content: string) => {
        const entityIds: number[] = []
        const postIds: number[] = []

        // Match patterns like [entity_type:123] or [entity_type:123|label] or [entity_type:123|label|config]
        const mentionPattern = /\[([a-zA-Z_]+):(\d+)(?:\|[^\]]+)?\]/g
        let match

        while ((match = mentionPattern.exec(content)) !== null) {
            const type = match[1]
            const id = parseInt(match[2], 10)

            if (type === 'post') {
                if (!postIds.includes(id)) {
                    postIds.push(id)
                }
            } else {
                // All other types are entities (character, location, item, etc.)
                if (!entityIds.includes(id)) {
                    entityIds.push(id)
                }
            }
        }

        return { entityIds, postIds }
    }

    onMounted(() => {
        // Parse content for mentions and load their data
        if (props.mentions && props.content) {
            const { entityIds, postIds } = parseMentionsFromContent(props.content)

            if (entityIds.length > 0 || postIds.length > 0) {
                axios.post(props.mentions, {
                    entities: entityIds,
                    posts: postIds,
                }).then(res => {
                    mentions.value = res.data
                    // Re-set content to trigger MentionParser with loaded mentions
                    editor.value?.commands.setContent(props.content)
                })
            }
        }
    })

    onBeforeUnmount(() => {
        editor?.value.destroy()
    })
</script>

<template>
    <div v-if="editor">
        <bubble-menu :editor="editor">
            <div class="bubble-menu bg-base-100 shadow rounded-2xl flex gap-0.5 items-center px-2 py-2">
                <MentionBubbleMenu
                    v-if="editor.isActive('mention')"
                    ref="mentionBubbleRef"
                    :editor="editor"
                    :mentions="mentions"
                />
                <LinkBubbleMenu
                    v-else-if="showLinkBubble || editor.isActive('link')"
                    ref="linkBubbleRef"
                    :editor="editor"
                />
                <TableBubbleMenu
                    v-else-if="editor.isActive('table')"
                    :editor="editor"
                />
                <ImageBubbleMenu
                    v-else-if="editor.isActive('image')"
                    :editor="editor"
                />
                <TextBubbleMenu
                    v-else
                    :editor="editor"
                    @open-link="openLinkBubble"
                />
            </div>
        </bubble-menu>
    </div>

    <editor-content :editor="editor" />

    <input type="hidden" :name="props.fieldName" :value="html" />

    <GalleryDialog v-if="gallery" />
</template>

<style scoped>
.bubble-menu {
    z-index: 845;
    position: relative;
}

:deep(.ProseMirror) {
    min-height: 200px;
    max-height: 70vh;
    overflow-y: auto;
    border: 1px solid hsl(var(--bc)/.1);
    border-radius: var(--rounded-btn);
    padding: 0.6rem 0.8rem;
    &:focus {
        outline-style: solid;
        outline-width: 2px;
        outline-offset: 2px;
        outline-color: hsl(var(--p)/0.3);
        border-color: transparent;
    }
}

:deep(.iframe-wrapper) {
    margin: 1rem 0;
}

:deep(.iframe-wrapper iframe) {
    max-width: 100%;
    border: 0;
}
</style>
