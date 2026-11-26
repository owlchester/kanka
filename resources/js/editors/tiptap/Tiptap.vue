<script setup lang="ts">
    import { useEditor, EditorContent } from '@tiptap/vue-3'
    import StarterKit from '@tiptap/starter-kit'
    import { Placeholder } from '@tiptap/extensions'
    import { BubbleMenu, FloatingMenu } from '@tiptap/vue-3/menus'
    import Link from '@tiptap/extension-link'
    import TableRow from '@tiptap/extension-table-row'
    import { CustomTableCell } from './extensions/table/CustomTableCell'
    import { CustomTableHeader } from './extensions/table/CustomTableHeader'
    import { TableWithControls } from './extensions/table/TableWithControls'
    import { ListKit } from '@tiptap/extension-list'
    import { TableKit } from "@tiptap/extension-table"
    import { CellSelection } from '@tiptap/pm/tables'
    import { ref, computed, nextTick, onMounted, onBeforeUnmount, defineAsyncComponent, getCurrentInstance } from 'vue'
    import { Mention } from './extensions/mentions/Mention'
    import suggestion from './extensions/mentions/suggestion'
    import { MentionParser } from './extensions/mentions/MentionParser'
    import { createMentionEntityLoader } from './extensions/mentions/entityLoader.js'
    import { SlashCommand } from './extensions/slashcommand/SlashCommand'
    import slashCommandSuggestion from './extensions/slashcommand/suggestion'
    import { Gallery } from './extensions/gallery/Gallery'
    const GalleryDialog = defineAsyncComponent(() => import('./extensions/gallery/GalleryDialog.vue'))
    import { CustomImage } from './extensions/CustomImage'
    import { Iframe } from './extensions/Iframe'
    import { Div } from './extensions/Div'
    import { PreserveClass } from './extensions/PreserveClass'
    import { PreserveStyle } from './extensions/PreserveStyle'
    import { Details, DetailsContent, DetailsSummary } from '@tiptap/extension-details'
    import { TextStyle } from '@tiptap/extension-text-style'
    import { Color } from '@tiptap/extension-color'
    import Highlight from '@tiptap/extension-highlight'
    import TextAlign from '@tiptap/extension-text-align'

    // Bubble menus & toolbar
    import MentionBubbleMenu from './bubblemenus/MentionBubbleMenu.vue'
    import LinkBubbleMenu from './bubblemenus/LinkBubbleMenu.vue'
    import TableBubbleMenu from './bubblemenus/TableBubbleMenu.vue'
    import ImageBubbleMenu from './bubblemenus/ImageBubbleMenu.vue'
    import TextBubbleMenu from './bubblemenus/TextBubbleMenu.vue'
    import EditorToolbar from './EditorToolbar.vue'
    import { buttonClass } from './utils'
    import { t } from './i18n.js'
    const SourceEditor = defineAsyncComponent(() => import('./SourceEditor.vue'))
    const ImageAttributesDialog = defineAsyncComponent(() => import('./dialogs/ImageAttributesDialog.vue'))
    const EmbedDialog = defineAsyncComponent(() => import('./dialogs/EmbedDialog.vue'))
    const ImageUrlDialog = defineAsyncComponent(() => import('./dialogs/ImageUrlDialog.vue'))

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

    const emit = defineEmits<{
        'update:modelValue': [value: string]
    }>()

    declare global {
        interface Window {
            showToast: (message: string, type?: string) => void
            entityFormHasUnsavedChanges?: boolean
        }
    }

    const TOOLBAR_STORAGE_KEY = 'tiptap_toolbar_visible'

    const getInitialToolbarState = (): boolean => {
        if (typeof window === 'undefined') return false
        const stored = window.localStorage?.getItem(TOOLBAR_STORAGE_KEY)
        if (stored === '1') return true
        if (stored === '0') return false
        return window.matchMedia?.('(pointer: coarse)')?.matches || window.innerWidth < 768
    }

    const galleryId = getCurrentInstance()!.uid.toString()

    const html = ref(props.content ?? props.modelValue ?? '')
    const mentions = ref([])
    const isFocused = ref(false)
    const hasReceivedInput = ref(false)
    const sourceMode = ref(false)
    const sourceModeCursorBlock = ref(0)
    const isFullscreen = ref(false)
    const showToolbar = ref<boolean>(getInitialToolbarState())

    const toggleToolbar = () => {
        showToolbar.value = !showToolbar.value
        if (typeof window !== 'undefined') {
            window.localStorage?.setItem(TOOLBAR_STORAGE_KEY, showToolbar.value ? '1' : '0')
        }
    }

    const setFullscreen = (next: boolean) => {
        isFullscreen.value = next
        if (typeof document !== 'undefined') {
            document.body.style.overflow = next ? 'hidden' : ''
        }
    }

    const toggleFullscreen = () => {
        setFullscreen(!isFullscreen.value)
    }

    const handleGlobalKeydown = (event: KeyboardEvent) => {
        if (!isFullscreen.value || event.key !== 'Escape' || event.defaultPrevented) return
        if (document.querySelector('dialog[open], .slash-command-list, .mention-list')) return
        event.preventDefault()
        setFullscreen(false)
    }

    const showHelperText = computed(() => {
        return isFocused.value && !hasReceivedInput.value && editor.value?.isEmpty
    })

    const enterSourceMode = () => {
        // Remember which top-level block the cursor is in so source mode can scroll there
        sourceModeCursorBlock.value = editor.value?.state.selection.$from.index(0) ?? 0
        sourceMode.value = true
    }

    // Converts a top-level block index back into a ProseMirror position, landing
    // just inside that block's content (rather than always at the very start/end).
    const positionOfBlock = (blockIndex: number): number => {
        const doc = editor.value?.state.doc
        if (!doc) {
            return 0
        }
        const clampedIndex = Math.min(Math.max(blockIndex, 0), Math.max(doc.childCount - 1, 0))
        let pos = 0
        for (let i = 0; i < clampedIndex; i++) {
            pos += doc.child(i).nodeSize
        }
        return pos + 1
    }

    const exitSourceMode = (cursorBlockIndex = 0) => {
        // Sync HTML back to editor when exiting source mode
        editor.value?.commands.setContent(html.value)
        sourceMode.value = false
        // Focus the editor after a short delay to ensure it's mounted, landing
        // back on the block the user was editing in source mode
        setTimeout(() => {
            editor.value?.commands.focus(positionOfBlock(cursorBlockIndex))
        }, 50)
    }

    // Refs for bubble menu & dialog components
    const mentionBubbleRef = ref<InstanceType<typeof MentionBubbleMenu> | null>(null)
    const toolbarRef = ref<InstanceType<typeof EditorToolbar> | null>(null)
    const imageAttributesDialogRef = ref<InstanceType<typeof ImageAttributesDialog> | null>(null)
    const embedDialogRef = ref<InstanceType<typeof EmbedDialog> | null>(null)
    const imageUrlDialogRef = ref<InstanceType<typeof ImageUrlDialog> | null>(null)

    const openImageAttributesDialog = () => {
        if (editor.value) {
            imageAttributesDialogRef.value?.open(editor.value)
        }
    }

    const openEmbedDialog = () => {
        if (editor.value) {
            embedDialogRef.value?.open(editor.value)
        }
    }

    const openImageUrlDialog = () => {
        if (editor.value) {
            imageUrlDialogRef.value?.open(editor.value)
        }
    }

    const onSourceUpdate = (value: string) => {
        html.value = value
        emit('update:modelValue', value)
        window.entityFormHasUnsavedChanges = true
    }

    const addEntityToMentions = (entity: any) => {
        const exists = mentions.value.find(e => e.id === entity.id)
        if (!exists) {
            mentions.value.push(entity)
        }
    }

    const mentionEntityLoader = createMentionEntityLoader({
        getEditor: () => editor.value,
        getEntities: () => mentions.value,
        addEntity: addEntityToMentions,
        fetchEntities: async (ids) => {
            const response = await axios.post(props.mentions, { entities: ids, posts: [] })
            return response.data
        },
    })

    const extensions = [
        StarterKit.configure({
            link: false,
            bulletList: false,
            orderedList: false,
            listItem: false,
            listKeymap: false,
        }),
        PreserveClass,
        PreserveStyle,
        Placeholder.configure({
            placeholder: t('placeholder', 'Start writing...'),
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
            allowTableNodeSelection: true,
        }),
        TableRow,
        CustomTableCell.configure({
        }),
        CustomTableHeader.configure({
        }),
        SlashCommand.configure({
            suggestion: slashCommandSuggestion({
                onSourceMode: enterSourceMode,
                onFullscreen: toggleFullscreen,
                onOpenEmbed: openEmbedDialog,
                onOpenImageUrl: openImageUrlDialog,
                hasGallery: Boolean(props.gallery),
            }),
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
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
        window.tiptapCustomExtensions ?? [],
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
                resolveEntity: id => id === null ? null : mentions.value.find(e => e.id === Number(id)) || null,
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
            if (props.mentions) {
                void mentionEntityLoader.load()
            }
            // Convert data-table-class to class for new tables, preserve existing classes
            html.value = editor.getHTML().replace(
                /<table([^>]*) data-table-class="([^"]+)"([^>]*)>/g,
                '<table$1 class="$2"$3>'
            )
            emit('update:modelValue', html.value)
            window.entityFormHasUnsavedChanges = true
            if (!hasReceivedInput.value && !editor.isEmpty) {
                hasReceivedInput.value = true
            }
        },
        onSelectionUpdate: ({ editor }) => {
            if (editor.isActive('mention')) {
                mentionBubbleRef.value?.syncLabel()
                toolbarRef.value?.syncMentionLabel()
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
                // Keep rich-text pastes on Tiptap's default path, even when they contain mentions.
                if (!htmlText && mentionPattern.test(plainText)) {
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
        const identity = node.attrs.mention?.match(/^\[?([a-zA-Z_-]+:\d+)(?=[|\]]|$)/)?.[1]
        if (!identity) return node.attrs.label || node.attrs.name || id || ''

        const parts = [identity]

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
        window.addEventListener('keydown', handleGlobalKeydown)

        // Parse content for mentions and load their data
        if (props.mentions && props.content) {
            const { entityIds, postIds } = parseMentionsFromContent(props.content)

            if (entityIds.length > 0 || postIds.length > 0) {
                axios.post(props.mentions, {
                    entities: entityIds,
                    posts: postIds,
                }).then(res => {
                    res.data.forEach(addEntityToMentions)
                    // Re-set content to trigger MentionParser with loaded mentions
                    editor.value?.commands.setContent(props.content)
                })
            }
        }
    })

    onBeforeUnmount(() => {
        mentionEntityLoader.destroy()
        window.removeEventListener('keydown', handleGlobalKeydown)
        if (typeof document !== 'undefined') {
            document.body.style.overflow = ''
        }
        editor?.value.destroy()
    })

    defineExpose({
        // EditorContent only attaches editor.view.dom to the visible DOM inside its own
        // nextTick callback (queued once the editor is created in this component's own
        // onMounted), so a caller focusing right after mount needs one more tick or the
        // view isn't connected to the document yet and focus() is a silent no-op.
        focus: async () => {
            await nextTick()
            editor.value?.commands.focus()
        },
    })
</script>

<template>
    <div class="tiptap-shell" :class="isFullscreen ? 'fixed inset-0 z-[900] flex flex-col bg-base-100 p-4' : ''">
        <SourceEditor
            v-if="sourceMode"
            :model-value="html"
            :cursor-block-index="sourceModeCursorBlock"
            :is-fullscreen="isFullscreen"
            @update:model-value="onSourceUpdate"
            @toggle-fullscreen="toggleFullscreen"
            @exit="exitSourceMode"
        />

        <template v-else>
            <template v-if="editor">
                <EditorToolbar
                    v-if="showToolbar"
                    ref="toolbarRef"
                    :editor="editor"
                    :mentions="mentions"
                    :has-gallery="Boolean(gallery)"
                    :has-mentions="Boolean(props.mentions)"
                    :is-fullscreen="isFullscreen"
                    @open-link="openLinkBubble"
                    @edit-image="openImageAttributesDialog"
                    @open-embed="openEmbedDialog"
                    @open-image-url="openImageUrlDialog"
                    @enter-source="enterSourceMode"
                    @toggle-fullscreen="toggleFullscreen"
                    @hide-toolbar="toggleToolbar"
                />

                <div v-else class="tiptap-minimal-bar flex items-center justify-end gap-0.5 mb-1 px-2 pt-1">
                    <button
                        type="button"
                        @click.prevent="toggleToolbar"
                        :class="buttonClass(false)"
                        :title="t('show_toolbar', 'Show toolbar')"
                    >
                        <i class="fa-regular fa-toolbox text-xs" :aria-label="t('show_toolbar', 'Show toolbar')" />
                    </button>
                    <button
                        type="button"
                        @click.prevent="enterSourceMode"
                        :class="buttonClass(false)"
                        :title="t('source_mode', 'Source Mode')"
                    >
                        <i class="fa-regular fa-code text-xs" :aria-label="t('source_mode', 'Source Mode')" />
                    </button>
                    <button
                        type="button"
                        @click.prevent="toggleFullscreen"
                        :class="buttonClass(isFullscreen)"
                        :title="isFullscreen ? t('exit_fullscreen', 'Exit fullscreen') : t('fullscreen', 'Fullscreen')"
                    >
                        <i
                            class="fa-regular text-xs"
                            :class="isFullscreen ? 'fa-compress' : 'fa-expand'"
                            :aria-label="isFullscreen ? t('exit_fullscreen', 'Exit fullscreen') : t('fullscreen', 'Fullscreen')"
                        />
                    </button>
                </div>

                <template v-if="!showToolbar">
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
                            <ImageBubbleMenu
                                :editor="editor"
                                @edit-image="openImageAttributesDialog"
                            />
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
            </template>

            <editor-content
                :editor="editor"
                class="tiptap-content"
                :class="{ 'flex-1 min-h-0 flex flex-col': isFullscreen }"
            />

            <p v-if="showHelperText" class="tiptap-helper text-neutral-content text-xs mt-2 pb-2 flex items-center gap-5">
                <span>
                    {{ t('helper_mentions', 'Use @ to reference entities') }}
                </span>
                <span>
                    <kbd>/</kbd> {{ t('helper_commands', 'for commands') }}
                </span>
                <span>
                    <kbd>/help</kbd> {{ t('helper_help', 'for help') }}
                </span>
            </p>
        </template>
    </div>

    <input type="hidden" :name="props.fieldName" :value="html" />

    <GalleryDialog v-if="gallery" :gallery-id="galleryId" />
    <ImageAttributesDialog ref="imageAttributesDialogRef" />
    <EmbedDialog ref="embedDialogRef" />
    <ImageUrlDialog ref="imageUrlDialogRef" />
</template>

<style scoped>
.bubble-menu {
    z-index: 845;
    position: relative;
}

.tiptap-content.flex-1 :deep(.ProseMirror) {
    flex: 1 1 0%;
    max-height: none;
    height: 100%;
    margin-bottom: 0;
}

:deep(.ProseMirror) {
    min-height: 200px;
    max-height: 70vh;
    overflow-y: auto;
    border: 1px solid hsl(var(--bc)/.1);
    border-radius: var(--rounded-btn);
    background-color: hsl(var(--b1)/1);
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
.tiptap-editor {
    table {

        td, th {
            box-sizing: border-box;
        }

        .selectedCell {
            background: hsl(var(--p)/1);
            color: hsl(var(--pc)/1);
        }
        .selectedCell:after {
            content: '';
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            pointer-events: none;
            position: absolute;
            z-index: 2;
        }

        .column-resize-handle {
            background: hsl(var(--p)/1);
            bottom: -2px;
            margin: 0;
            pointer-events: none;
            position: absolute;
            right: -2px;
            top: 0;
            width: 4px;
        }
    }

    .tableWrapper {
        margin: 1.5rem 0;
        overflow-x: auto;
    }

    &.resize-cursor {
        cursor: ew-resize;
        cursor: col-resize;
    }

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
