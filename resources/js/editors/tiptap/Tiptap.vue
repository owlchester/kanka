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
    import { ListKit } from '@tiptap/extension-list'
    import { TableKit } from "@tiptap/extension-table"
    import { CellSelection } from '@tiptap/pm/tables'
    import { ref, computed, onMounted, onBeforeUnmount, defineAsyncComponent, getCurrentInstance } from 'vue'
    import { Mention } from './extensions/mentions/Mention'
    import suggestion from './extensions/mentions/suggestion'
    import { MentionParser } from './extensions/mentions/MentionParser'
    import { SlashCommand } from './extensions/slashcommand/SlashCommand'
    import slashCommandSuggestion from './extensions/slashcommand/suggestion'
    import { Gallery } from './extensions/gallery/Gallery'
    const GalleryDialog = defineAsyncComponent(() => import('./extensions/gallery/GalleryDialog.vue'))
    import { CustomImage } from './extensions/CustomImage'
    import { Iframe } from './extensions/Iframe'
    import { Div } from './extensions/Div'
    import { Details, DetailsContent, DetailsSummary } from '@tiptap/extension-details'
    import { TextStyle } from '@tiptap/extension-text-style'
    import { Color } from '@tiptap/extension-color'
    import Highlight from '@tiptap/extension-highlight'

    // Bubble menus
    import MentionBubbleMenu from './bubblemenus/MentionBubbleMenu.vue'
    import LinkBubbleMenu from './bubblemenus/LinkBubbleMenu.vue'
    import TableBubbleMenu from './bubblemenus/TableBubbleMenu.vue'
    import ImageBubbleMenu from './bubblemenus/ImageBubbleMenu.vue'
    import TextBubbleMenu from './bubblemenus/TextBubbleMenu.vue'
    const SourceEditor = defineAsyncComponent(() => import('./SourceEditor.vue'))

    const props = withDefaults(defineProps<{
        modelValue?: string
        content?: string
        gallery?: string
        mentions?: string
        galleryUpload?: string
        fieldName?: string
    }>(), {
        fieldName: 'entry'
    })

    declare global {
        interface Window {
            showToast: (message: string, type?: string) => void
        }
    }

    const galleryId = getCurrentInstance()!.uid.toString()

    const html = ref(props.content ?? props.modelValue ?? '')
    const mentions = ref([])
    const isFocused = ref(false)
    const hasReceivedInput = ref(false)
    const sourceMode = ref(false)

    const showHelperText = computed(() => {
        return isFocused.value && !hasReceivedInput.value && editor.value?.isEmpty
    })

    const enterSourceMode = () => {
        sourceMode.value = true
    }

    const exitSourceMode = () => {
        // Sync HTML back to editor when exiting source mode
        editor.value?.commands.setContent(html.value)
        sourceMode.value = false
        // Focus the editor after a short delay to ensure it's mounted
        setTimeout(() => {
            editor.value?.commands.focus()
        }, 50)
    }

    // Refs for bubble menu components
    const mentionBubbleRef = ref<InstanceType<typeof MentionBubbleMenu> | null>(null)

    const addEntityToMentions = (entity: any) => {
        const exists = mentions.value.find(e => e.id === entity.id)
        if (!exists) {
            mentions.value.push(entity)
        }
    }

    const extensions = [
        StarterKit.configure({
            link: false,
            bulletList: false,
            orderedList: false,
            listItem: false,
            listKeymap: false,
        }),
        Placeholder.configure({
            placeholder: 'Start writing...',
        }),
        Link.configure({
            openOnClick: false,
            defaultProtocol: 'https',
            HTMLAttributes: {
                class: 'text-link',
            },
        }),
        ListKit.configure({
            taskItem: {
                nested: true,
            },
        }),
        TableWithControls.configure({
            resizable: true,
        }),
        TableRow,
        TableCell.configure({
        }),
        TableHeader.configure({
        }),
        // TableKit.configure({
        //     table: {
        //     },
        // }),
        SlashCommand.configure({
            suggestion: slashCommandSuggestion(),
        }),
        CustomImage.configure({
            inline: true,
            allowBase64: false,
            resize: {
                enabled: true,
                minWidth: 20,
                minHeight: 20,
                alwaysPreserveAspectRatio: true,
            }
        }),
        Iframe,
        Div,
        Details.configure({
            persist: true,
            HTMLAttributes: {
                class: 'details',
            },
        }),
        DetailsSummary,
        DetailsContent,
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
                galleryId,
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
        onFocus: () => {
            isFocused.value = true
        },
        onBlur: () => {
            isFocused.value = false
        },
        onUpdate: ({ editor }) => {
            // Convert data-table-class to class for new tables, preserve existing classes
            html.value = editor.getHTML().replace(
                /<table([^>]*) data-table-class="([^"]+)"([^>]*)>/g,
                '<table$1 class="$2"$3>'
            )
            if (!hasReceivedInput.value && !editor.isEmpty) {
                hasReceivedInput.value = true
            }
        },
        onSelectionUpdate: ({ editor }) => {
            if (editor.isActive('mention')) {
                mentionBubbleRef.value?.syncLabel()
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
                if (props.galleryUpload) {
                    const items = Array.from(event.clipboardData?.items || [])
                    const imageItem = items.find(item => item.type.startsWith('image/'))
                    if (imageItem) {
                        const file = imageItem.getAsFile()
                        if (file) {
                            const formData = new FormData()
                            formData.append('file[]', file)
                            axios.post(props.galleryUpload, formData).then(response => {
                                if (response.data?.url) {
                                    editor.value?.chain().focus().setImage({
                                        src: response.data.url,
                                        'data-gallery-id': String(response.data.id),
                                    }).run()
                                }
                            }).catch(() => {
                                window.showToast('Image upload failed', 'error')
                            })
                            return true
                        }
                    }
                }

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

                const trimmedText = plainText.trim()
                const isPlainUrl = /^https?:\/\/\S+$/i.test(trimmedText)
                if (isPlainUrl && !htmlText) {
                    try {
                        const url = new URL(trimmedText)
                        const imageExtensions = /\.(jpe?g|png|gif|webp|svg|bmp|avif|tiff?)$/i
                        if (imageExtensions.test(url.pathname)) {
                            editor.value?.chain().focus().setImage({ src: trimmedText }).run()
                            return true
                        }
                    } catch {
                        // Not a valid URL, fall through
                    }
                }

                const mentionPattern = /\[([a-zA-Z_]+):(\d+)(?:\|[^\]]+)?\]/
                if (mentionPattern.test(plainText)) {
                    editor.value?.commands.insertContent(plainText)
                    return true
                }

                return false
            },
            handleKeyDown: (view, event) => {
                if ((event.ctrlKey || event.metaKey) && event.key === 'k') {
                    if (!view.state.selection.empty) {
                        event.preventDefault()
                        openLinkBubble()
                        return true
                    }
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
        if (!editor.value) return
        const existingHref = editor.value.getAttributes('link').href || ''
        const { to } = editor.value.state.selection
        editor.value.chain()
            .focus()
            .setLink({ href: existingHref })
            .setTextSelection(to)
            .run()
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
        // Listen for source mode event
        window.addEventListener('tiptap:source-mode', enterSourceMode)

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
        window.removeEventListener('tiptap:source-mode', enterSourceMode)
        editor?.value.destroy()
    })
</script>

<template>
    <SourceEditor
        v-if="sourceMode"
        v-model="html"
        @exit="exitSourceMode"
    />

    <template v-else>
        <template v-if="editor">
            <bubble-menu
                :editor="editor"
                plugin-key="mentionBubbleMenu"
                :should-show="({ editor }) => editor.isActive('mention')"
            >
                <div class="bubble-menu bg-base-100 shadow rounded-2xl flex gap-0.5 items-center px-2 py-2">
                    <MentionBubbleMenu
                        ref="mentionBubbleRef"
                        :editor="editor"
                        :mentions="mentions"
                    />
                </div>
            </bubble-menu>

            <bubble-menu
                :editor="editor"
                plugin-key="linkBubbleMenu"
                :should-show="({ editor }) => editor.isActive('link') && editor.state.selection.empty"
            >
                <div class="bubble-menu bg-base-100 shadow rounded-2xl flex gap-0.5 items-center px-2 py-2">
                    <LinkBubbleMenu :editor="editor" />
                </div>
            </bubble-menu>

            <bubble-menu
                :editor="editor"
                plugin-key="tableBubbleMenu"
                :should-show="({ editor }) => editor.state.selection instanceof CellSelection"
            >
                <div class="bubble-menu bg-base-100 shadow rounded-2xl flex gap-0.5 items-center px-2 py-2">
                    <TableBubbleMenu :editor="editor" />
                </div>
            </bubble-menu>

            <bubble-menu
                :editor="editor"
                plugin-key="imageBubbleMenu"
                :should-show="({ editor }) => editor.isActive('image')"
            >
                <div class="bubble-menu bg-base-100 shadow rounded-2xl flex gap-0.5 items-center px-2 py-2">
                    <ImageBubbleMenu :editor="editor" />
                </div>
            </bubble-menu>

            <bubble-menu
                :editor="editor"
                plugin-key="textBubbleMenu"
                :should-show="({ editor }) => {
                    if (editor.state.selection.empty) return false
                    if (editor.isActive('mention')) return false
                    if (editor.state.selection instanceof CellSelection) return false
                    if (editor.isActive('image')) return false
                    return true
                }"
            >
                <div class="bubble-menu bg-base-100 shadow rounded-2xl flex gap-0.5 items-center px-2 py-2">
                    <TextBubbleMenu
                        :editor="editor"
                        @open-link="openLinkBubble"
                    />
                </div>
            </bubble-menu>
        </template>

        <editor-content :editor="editor" />

        <p v-if="showHelperText" class="text-neutral-content text-xs mt-2 flex items-center gap-5">
            <span>
                Use <kbd>@</kbd> to reference entities
            </span>
            <span>
                <kbd>/</kbd> for commands
            </span>
        </p>
    </template>

    <input type="hidden" :name="props.fieldName" :value="html" />

    <GalleryDialog v-if="gallery" :gallery-id="galleryId" />
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
    margin-bottom: 1rem;
    &:focus {
        outline-style: solid;
        outline-width: 2px;
        outline-offset: 2px;
        outline-color: hsl(var(--p)/0.3);
        border-color: transparent;
    }

    p.is-editor-empty:first-child::before {
        content: attr(data-placeholder);
        --tw-text-opacity: .4;
        color: hsl(var(--bc)/var(--tw-text-opacity));
        pointer-events: none;
        float: left;
        height: 0;
    }
}


:deep(.iframe-wrapper) {
    margin: 1rem 0;
}

:deep(.iframe-wrapper iframe) {
    max-width: 100%;
    border: 0;
}

:deep(.details) {
    flex-direction: row;
    summary {
        display: inline;
    }
}
</style>
<style>
.tiptap-editor .ProseMirror {
    table {
        td, th {
            > p {
                margin-bottom: 0 !important;
            }
        }

        .selectedCell {
            background-color: hsl(var(--p) / .2) !important;
        }

        .column-resize-handle {
            background-color: hsl(var(--p) / 1);
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            width: 4px;
            transform: translateX(50%);
            pointer-events: none;
            z-index: 10;
        }
    }

    &.resize-cursor {
        cursor: col-resize;
    }
}

.tiptap-editor {
    .ProseMirror-selectednode img {
        outline: 2px solid hsl(var(--p)/1);
    }

    [data-resize-handle] {
        position: absolute;
        background: hsl(var(--pc)/1);
        border: 1px solid hsl(var(--pc)/1);
        border-radius: 2px;
        z-index: 10;

        &:hover {
            background: hsl(var(--p)/1);
        }

        /* Corner handles */
        &[data-resize-handle='top-left'],
        &[data-resize-handle='top-right'],
        &[data-resize-handle='bottom-left'],
        &[data-resize-handle='bottom-right'] {
            width: 8px;
            height: 8px;
        }

        &[data-resize-handle='top-left'] {
            top: -4px;
            left: -4px;
            cursor: nwse-resize;
        }

        &[data-resize-handle='top-right'] {
            top: -4px;
            right: -4px;
            cursor: nesw-resize;
        }

        &[data-resize-handle='bottom-left'] {
            bottom: -4px;
            left: -4px;
            cursor: nesw-resize;
        }

        &[data-resize-handle='bottom-right'] {
            bottom: -4px;
            right: -4px;
            cursor: nwse-resize;
        }

        /* Edge handles */
        &[data-resize-handle='top'],
        &[data-resize-handle='bottom'] {
            height: 6px;
            left: 8px;
            right: 8px;
        }

        &[data-resize-handle='top'] {
            top: -3px;
            cursor: ns-resize;
        }

        &[data-resize-handle='bottom'] {
            bottom: -3px;
            cursor: ns-resize;
        }

        &[data-resize-handle='left'],
        &[data-resize-handle='right'] {
            width: 6px;
            top: 8px;
            bottom: 8px;
        }

        &[data-resize-handle='left'] {
            left: -3px;
            cursor: ew-resize;
        }

        &[data-resize-handle='right'] {
            right: -3px;
            cursor: ew-resize;
        }
    }

    [data-resize-state='true'] [data-resize-wrapper] {
        outline: 2px solid hsl(var(--p)/1);
        border-radius: 0.125rem;
    }

}
</style>
