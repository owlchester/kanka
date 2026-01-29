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
    import {ref, onMounted, onBeforeUnmount, watch, computed} from 'vue'
    import { Mention } from './extensions/mentions/Mention'
    import suggestion from './extensions/mentions/suggestion'
    import { MentionParser } from './extensions/mentions/MentionParser'
    import { SlashCommand } from './extensions/slashcommand/SlashCommand'
    import slashCommandSuggestion from './extensions/slashcommand/suggestion'
    import { Gallery } from './extensions/gallery/Gallery'
    import GalleryDialog from './extensions/gallery/GalleryDialog.vue'
    import { GalleryImage } from './extensions/gallery/GalleryImage'
    import { Iframe } from './extensions/Iframe'


    const props = defineProps<{
        modelValue?: string
        api?: String,
        gallery?: String,
        mentions?: String,
    }>()
    const html = ref(props.modelValue ?? '<p>Loading...</p>')
    const showHeadingDropdown = ref(false)
    const showListDropdown = ref(false)
    const showLinkInput = ref(false)
    const linkUrl = ref('')
    const linkInputRef = ref<HTMLInputElement | null>(null)

    /** Mentions **/
    const mentions = ref([]);
    const mentionLabelInput = ref<HTMLInputElement | null>(null)
    const editingMentionLabel = ref('')
    const mentionConfigInput = ref<HTMLInputElement | null>(null)
    const editingMentionConfig = ref('')
    const showMentionConfig = ref(false)

    const addEntityToMentions = (entity: any) => {
        // Check if entity already exists in the mentions array
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
    ];
    // Add gallery extension if gallery URL is provided
    if (props.gallery) {
        extensions.push(
            Gallery.configure({
                galleryUrl: props.gallery as string,
            })
        )
    }
    // Add mention extension if mentions URL is provided
    if (props.mentions) {
        extensions.push(
            Mention.configure({
                HTMLAttributes: {
                    class: 'mention',
                },
                suggestion: suggestion(props.mentions, addEntityToMentions),

                renderText({ node }) {
                    // Get attributes
                    const mention = node.attrs.mention
                    const label = node.attrs.label
                    const id = node.attrs.id
                    const config = node.attrs.config

                    // Extract type from mention (e.g., [character:123] -> "character")
                    const mentionMatch = mention?.match(/\[([^:]+):(\d+)/)
                    const type = mentionMatch ? mentionMatch[1] : null

                    if (type && id) {
                        // Find the entity to compare label with original name
                        const entity = mentions.value.find(e => e.id === parseInt(id))
                        const entityName = entity ? entity.name : null

                        // Build the mention parts
                        const parts = [`${type}:${id}`]

                        // Add label if it differs from entity name (must come last to detect custom names)
                        if (label && entityName && label !== entityName) {
                            parts.push(label)
                        }

                        // Add config if present
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
            // Pre-fill mention label when a mention is selected (only if entity exists)
            if (editor.isActive('mention')) {
                const mentionAttrs = editor.getAttributes('mention')
                if (mentionAttrs?.entity) {
                    editingMentionLabel.value = mentionAttrs?.label || ''
                }
            } else {
                // Clear when leaving mention
                editingMentionLabel.value = ''
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

                // Check if pasted content contains an iframe
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

                // Check if plain text contains mention patterns
                const mentionPattern = /\[([a-zA-Z_]+):(\d+)(?:\|[^\]]+)?\]/

                if (mentionPattern.test(plainText)) {
                    // Insert as plain text so MentionParser can convert the patterns
                    editor.value?.commands.insertContent(plainText)
                    return true
                }

                // Let TipTap handle paste normally
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

        // Add newlines for block nodes
        if (node.isBlock && text) {
            text += '\n'
        }

        return text
    }

    const serializeMentionToText = (node: any): string => {
        const config = node.attrs.config
        const id = node.attrs.id
        const type = node.attrs.type

        // Build the mention parts
        const parts = [`${type}:${id}`]

        // Add config if present
        if (config) {
            parts.push(config)
        }

        return `[${parts.join('|')}]`
    }

    // Watch for selection changes to reset mention editing state
    // watch(() => editor?.value?.state.selection, (newSelection, oldSelection) => {
    //     if (newSelection && oldSelection) {
    //         // Reset editing states when selection changes
    //         editingMentionLabel.value = ''
    //         showMentionConfig.value = false
    //         editingMentionConfig.value = ''
    //     }
    // }, { deep: true })


    onMounted(() => {
        if (props.api) {
            axios.get(props.api)
                .then(res => {
                    html.value = res.data.document
                    mentions.value = res.data.mentions

                    editor?.value?.commands.setContent(html.value)
                })
        } else {
            html.value = ""
            editor?.value?.commands.setContent(html.value)
        }
    });

    const buttonClass = (active: boolean) => {
        const base = 'px-2 py-1 rounded-lg hover:bg-base-200 block hover:text-base-content ';
        const state = active ? 'bg-base-300 border-primary text-base-content' : 'text-neutral-content '
        return base + ' ' + state
    }

    const currentHeadingIcon = computed(() => {
        if (!editor?.value) return 'fa-regular fa-paragraph'

        if (editor.value.isActive('paragraph')) return 'fa-regular fa-paragraph'

        return 'fa-regular fa-heading'
    })

    const currentHeadingLevel = () => {

        if (editor.value.isActive('heading', {level: 1})) return '1'
        if (editor.value.isActive('heading', {level: 2})) return '2'
        if (editor.value.isActive('heading', {level: 3})) return '3'
        if (editor.value.isActive('heading', {level: 4})) return '4'
        if (editor.value.isActive('heading', {level: 5})) return '5'
        return 0;
    }

    const setHeading = (level: number | null) => {
        if (level === null) {
            editor?.value.chain().focus().setParagraph().run()
        } else {
            editor?.value.chain().focus().toggleHeading({ level }).run()
        }
        showHeadingDropdown.value = false
    }

    const toggleDropdown = () => {
        showHeadingDropdown.value = !showHeadingDropdown.value
    }

    const closeDropdown = () => {
        showHeadingDropdown.value = false
    }

    const toggleList = (type: 'bullet' | 'ordered') => {
        if (type === 'bullet') {
            editor?.value.chain().focus().toggleBulletList().run()
        } else {
            editor?.value.chain().focus().toggleOrderedList().run()
        }
        showListDropdown.value = false
    }
    const toggleListDropdown = () => {
        showListDropdown.value = !showListDropdown.value
    }

    const closeListDropdown = () => {
        showListDropdown.value = false
    }


    const getCurrentListIcon = computed(() => {
        if (!editor?.value) return 'fa-regular fa-list-ol'

        if (editor.value.isActive('bulletList')) return 'fa-regular fa-list-ul'
        if (editor.value.isActive('orderedList')) return 'fa-regular fa-list-ol'

        return 'fa-regular fa-list-ul'
    })
    const openLinkInput = () => {
        // Get existing link URL if there is one
        const previousUrl = editor?.value.getAttributes('link').href || ''
        linkUrl.value = previousUrl
        showLinkInput.value = true

        // Focus the input after Vue updates the DOM
        setTimeout(() => {
            linkInputRef.value?.focus()
        }, 10)
    }

    const setLink = () => {
        if (!linkUrl.value) {
            closeLinkInput()
            return
        }

        // Add https:// if no protocol is specified
        let url = linkUrl.value
        if (!/^https?:\/\//i.test(url)) {
            url = 'https://' + url
        }

        editor?.value
            .chain()
            .focus()
            .extendMarkRange('link')
            .setLink({ href: url })
            .run()

        closeLinkInput()
    }

    const removeLink = () => {
        editor?.value
            .chain()
            .focus()
            .extendMarkRange('link')
            .unsetLink()
            .run()

        closeLinkInput()
    }

    const closeLinkInput = () => {
        showLinkInput.value = false
        linkUrl.value = ''
        editor?.value.commands.focus()
    }

    const handleLinkKeydown = (event: KeyboardEvent) => {
        if (event.key === 'Enter') {
            event.preventDefault()
            setLink()
        } else if (event.key === 'Escape') {
            event.preventDefault()
            closeLinkInput()
        }
    }


    const deleteMention = () => {
        editor?.value.chain().focus().deleteSelection().run()
    }

    const startEditingMentionLabel = () => {
        // Value is pre-filled by onSelectionUpdate, nothing to do here
    }

    const updateMentionLabel = () => {
        let trimmedLabel = editingMentionLabel.value.trim()
        const mentionAttrs = editor?.value.getAttributes('mention')
        const entityId = mentionAttrs?.id

        // If the new name matches the entity's default name, clear the label
        const entity = mentions.value.find(e => e.id === parseInt(entityId))
        if (trimmedLabel === entity?.name) {
            trimmedLabel = ''
        }

        // Update the label (empty string will cause renderLabel to fall back to name)
        editor?.value
            .chain()
            .focus()
            .updateAttributes('mention', {
                label: trimmedLabel
            })
            .run()

        editingMentionLabel.value = ''
    }

    const handleMentionLabelBlur = (event: FocusEvent) => {
        // Check if the new focus target is within the bubble menu
        const relatedTarget = event.relatedTarget as HTMLElement
        if (relatedTarget && relatedTarget.closest('.bubble-menu')) {
            // Don't update if clicking within bubble menu
            return
        }
        updateMentionLabel()
    }

    const handleMentionLabelKeydown = (event: KeyboardEvent) => {
        if (event.key === 'Enter') {
            event.preventDefault()
            updateMentionLabel()
        } else if (event.key === 'Escape') {
            event.preventDefault()
            editingMentionLabel.value = ''
            editor?.value.commands.focus()
        }
    }
    const openMentionConfig = () => {
        const mentionAttrs = editor?.value.getAttributes('mention')
        editingMentionConfig.value = mentionAttrs?.config || ''
        showMentionConfig.value = true

        // Focus the input after Vue updates the DOM
        setTimeout(() => {
            mentionConfigInput.value?.focus()
            mentionConfigInput.value?.select()
        }, 10)
    }

    const updateMentionConfig = () => {
        const trimmedConfig = editingMentionConfig.value.trim()

        editor?.value
            .chain()
            .focus()
            .updateAttributes('mention', {
                config: trimmedConfig || null
            })
            .run()

        showMentionConfig.value = false
        editingMentionConfig.value = ''
    }

    const handleMentionConfigBlur = (event: FocusEvent) => {
        // Check if the new focus target is within the bubble menu
        const relatedTarget = event.relatedTarget as HTMLElement
        if (relatedTarget && relatedTarget.closest('.bubble-menu')) {
            // Don't update if clicking within bubble menu
            return
        }
        updateMentionConfig()
    }

    const clearMentionConfig = () => {
        editor?.value
            .chain()
            .focus()
            .updateAttributes('mention', {
                config: null
            })
            .run()

        showMentionConfig.value = false
        editingMentionConfig.value = ''
    }

    const handleMentionConfigKeydown = (event: KeyboardEvent) => {
        if (event.key === 'Enter') {
            event.preventDefault()
            updateMentionConfig()
        } else if (event.key === 'Escape') {
            event.preventDefault()
            showMentionConfig.value = false
            editingMentionConfig.value = ''
            editor?.value.commands.focus()
        }
    }

    /** Table controls **/
    const addColumnAfter = () => {
        editor?.value.chain().focus().addColumnAfter().run()
    }

    const addRowAfter = () => {
        editor?.value.chain().focus().addRowAfter().run()
    }

    const deleteTable = () => {
        editor?.value.chain().focus().deleteTable().run()
    }

    const deleteRow = () => {
        editor?.value.chain().focus().deleteRow().run()
    }

    const deleteColumn = () => {
        editor?.value.chain().focus().deleteColumn().run()
    }

    const toggleHeaderRow = () => {
        editor?.value.chain().focus().toggleHeaderRow().run()
    }

    /** Image controls **/
    const setImageWidth = (width: string | null) => {
        editor?.value.commands.setImageWidth(width)
    }

    const setImageFloat = (float: 'left' | 'right' | null) => {
        editor?.value.commands.setImageFloat(float)
    }

    const deleteImage = () => {
        editor?.value.chain().focus().deleteSelection().run()
    }

    const getImageWidth = () => {
        return editor?.value.getAttributes('image').width || null
    }

    const getImageFloat = () => {
        return editor?.value.getAttributes('image').float || null
    }

    onBeforeUnmount(() => {
        editor?.value.destroy()
    })
</script>

<template>

    <div v-if="editor">
        <bubble-menu :editor="editor">
            <div class="bubble-menu bg-base-100 shadow rounded-2xl flex gap-0.5 items-center px-2 py-2 ">
                <template v-if="editor.isActive('mention')">
                    <div class="flex items-center gap-2 text-xs text-neutral-content px-2">
                        <template v-if="showMentionConfig">
                            <input
                                ref="mentionConfigInput"
                                v-model="editingMentionConfig"
                                type="text"
                                placeholder="page:abilities|anchor:#ability-1"
                                class="p-0 px-1 rounded text-xs outline-none focus:ring-1 focus:ring-primary min-w-[250px]"
                                @blur="handleMentionConfigBlur"
                                @keydown="handleMentionConfigKeydown"
                            />
                            <button
                                v-if="editor.getAttributes('mention').config"
                                @click.prevent="clearMentionConfig"
                                class="hover:text-warning"
                                title="Clear config"
                            >
                                <i class="fa-regular fa-times" />
                            </button>
                        </template>
                        <template v-else>
                            <!-- Valid entity: show editable label and link -->
                            <template v-if="editor.getAttributes('mention').entity">
                                <input
                                    ref="mentionLabelInput"
                                    v-model="editingMentionLabel"
                                    type="text"
                                    :placeholder="editor.getAttributes('mention').entity.name"
                                    class="p-0 px-1 rounded text-xs outline-none focus:ring-1 focus:ring-primary min-w-[150px]"
                                    @focus="startEditingMentionLabel"
                                    @blur="handleMentionLabelBlur"
                                    @keydown="handleMentionLabelKeydown"
                                />
                                <a
                                    v-if="editor.getAttributes('mention').url"
                                    class="text-link"
                                    :href="editor.getAttributes('mention').url"
                                    title="Go to entity"
                                >
                                    <i class="fa-regular fa-external-link-alt" aria-hidden="true" />
                                </a>
                            </template>
                            <!-- Unknown entity: show warning -->
                            <template v-else>
                                <span class="text-neutral-content flex items-center gap-1">
                                    <i class="fa-regular fa-exclamation-triangle" aria-hidden="true" />
                                    Unknown entity
                                </span>
                            </template>
                            <button
                                @click.prevent="openMentionConfig"
                                class="hover:text-primary"
                                :class="{ 'text-primary': editor.getAttributes('mention').config }"
                                title="Customize mention"
                            >
                                <i class="fa-regular fa-cog" aria-hidden="true" />
                            </button>
                            <button
                                @click.prevent="deleteMention"
                                class="hover:text-error"
                                title="Remove mention"
                            >
                                <i class="fa-regular fa-trash" aria-hidden="true"  />
                            </button>
                        </template>
                    </div>
                </template>
                <template v-else-if="showLinkInput || editor.isActive('link')">
                    <div class="flex gap-2 items-center text-xs text-neutral-content px-2">
                        <input
                            ref="linkInputRef"
                            v-model="editor.getAttributes('link').href"
                            type="text"
                            placeholder="Enter URL..."
                            class="p-0 px-1 rounded text-xs outline-none focus:ring-1 focus:ring-primary min-w-[200px]"
                            @keydown="handleLinkKeydown"
                        />
                        <a
                            v-if="editor.isActive('link')"
                            :href="editor.getAttributes('link').href"
                            target="_blank"
                            class="hover:text-base-content"
                            title="Open in a new window"
                        >
                            <i class="fa-regular fa-external-link-alt" />
                        </a>
                        <button
                            v-if="editor.isActive('link')"
                            @click.prevent="removeLink"
                            class="hover:text-error"
                            title="Remove link"
                        >
                            <i class="fa-regular fa-unlink" aria-label="Removal icon" />
                        </button>
                    </div>
                </template>
                <template v-else-if="editor.isActive('table')">
                    <div class="flex gap-1 items-center text-xs text-neutral-content px-2">
                        <button
                            @click.prevent="addColumnAfter"
                            :class="buttonClass(false)"
                            title="Add column"
                        >
                            <i class="fa-solid fa-table-columns" aria-hidden="true" />
                            <i class="fa-solid fa-plus text-[8px]" aria-hidden="true" />
                        </button>
                        <button
                            @click.prevent="addRowAfter"
                            :class="buttonClass(false)"
                            title="Add row"
                        >
                            <i class="fa-solid fa-table-rows" aria-hidden="true" />
                            <i class="fa-solid fa-plus text-[8px]" aria-hidden="true" />
                        </button>
                        <button
                            @click.prevent="deleteColumn"
                            :class="buttonClass(false)"
                            title="Delete column"
                        >
                            <i class="fa-solid fa-table-columns" aria-hidden="true" />
                            <i class="fa-solid fa-minus text-[8px]" aria-hidden="true" />
                        </button>
                        <button
                            @click.prevent="deleteRow"
                            :class="buttonClass(false)"
                            title="Delete row"
                        >
                            <i class="fa-solid fa-table-rows" aria-hidden="true" />
                            <i class="fa-solid fa-minus text-[8px]" aria-hidden="true" />
                        </button>
                        <button
                            @click.prevent="toggleHeaderRow"
                            :class="buttonClass(false)"
                            title="Toggle header row"
                        >
                            <i class="fa-solid fa-heading" aria-hidden="true" />
                        </button>
                        <button
                            @click.prevent="deleteTable"
                            class="hover:text-error px-2 py-1"
                            title="Delete table"
                        >
                            <i class="fa-solid fa-trash" aria-hidden="true" />
                        </button>
                    </div>
                </template>
                <template v-else-if="editor.isActive('image')">
                    <div class="flex gap-1 items-center text-xs text-neutral-content px-2">
                        <!-- Width controls -->
                        <div class="flex items-center gap-0.5 border-r border-base-300 pr-2 mr-1">
                            <button
                                @click.prevent="setImageWidth('25%')"
                                :class="buttonClass(getImageWidth() === '25%')"
                                title="25% width"
                            >
                                25%
                            </button>
                            <button
                                @click.prevent="setImageWidth('50%')"
                                :class="buttonClass(getImageWidth() === '50%')"
                                title="50% width"
                            >
                                50%
                            </button>
                            <button
                                @click.prevent="setImageWidth('100%')"
                                :class="buttonClass(getImageWidth() === '100%')"
                                title="100% width"
                            >
                                100%
                            </button>
                            <button
                                @click.prevent="setImageWidth(null)"
                                :class="buttonClass(getImageWidth() === null)"
                                title="Reset width"
                            >
                                <i class="fa-regular fa-undo" aria-hidden="true" />
                            </button>
                        </div>
                        <!-- Float controls -->
                        <div class="flex items-center gap-0.5 border-r border-base-300 pr-2 mr-1">
                            <button
                                @click.prevent="setImageFloat('left')"
                                :class="buttonClass(getImageFloat() === 'left')"
                                title="Float left"
                            >
                                <i class="fa-regular fa-align-left" aria-hidden="true" />
                            </button>
                            <button
                                @click.prevent="setImageFloat('right')"
                                :class="buttonClass(getImageFloat() === 'right')"
                                title="Float right"
                            >
                                <i class="fa-regular fa-align-right" aria-hidden="true" />
                            </button>
                            <button
                                @click.prevent="setImageFloat(null)"
                                :class="buttonClass(getImageFloat() === null)"
                                title="No float"
                            >
                                <i class="fa-regular fa-align-justify" aria-hidden="true" />
                            </button>
                        </div>
                        <!-- Delete -->
                        <button
                            @click.prevent="deleteImage"
                            class="hover:text-error px-2 py-1"
                            title="Delete image"
                        >
                            <i class="fa-regular fa-trash" aria-hidden="true" />
                        </button>
                    </div>
                </template>
                <template v-else>
                    <div class="relative">
                        <button
                            @click.prevent="toggleDropdown"
                            :class="buttonClass(false)"
                            class="flex items-center gap-0.5"
                            @blur="closeDropdown"
                        >
                            <i :class="currentHeadingIcon"></i>
                            <sub v-if="editor.isActive('heading')" class="text-xs">
                                <span v-html="currentHeadingLevel()"></span>
                            </sub>
                            <i class="fa-regular fa-chevron-down" aria-label="Toggle paragraph styles"></i>
                        </button>
                        <div
                            v-show="showHeadingDropdown"
                            class="absolute top-full left-0 mt-1 bg-base-100 shadow-lg rounded-lg py-1 z-50 min-w-[200px]"
                            @mousedown.prevent
                        >
                            <button
                                @click.prevent="setHeading(null)"
                                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                                :class="{ 'text-semibold text-base-content': editor.isActive('paragraph') }"
                            >
                                Paragraph
                                <i class="fa-regular fa-check" v-if="editor.isActive('paragraph')"></i>
                            </button>
                            <button
                                @click.prevent="setHeading(1)"
                                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content flex items-center justify-between gap-1 text-[1.4rem]"
                                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 1 }) }"
                            >
                                Heading 1
                                <i class="fa-regular fa-check" v-if="editor.isActive('heading', {level: 1})"></i>
                            </button>
                            <button
                                @click.prevent="setHeading(2)"
                                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content flex items-center justify-between gap-1 text-[1.3rem]"
                                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 2 }) }"
                            >
                                Heading 2
                                <i class="fa-regular fa-check" v-if="editor.isActive('heading', {level: 2})"></i>
                            </button>
                            <button
                                @click.prevent="setHeading(3)"
                                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content flex items-center justify-between gap-1 text-[1.2rem]"
                                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 3 }) }"
                            >
                                Heading 3
                                <i class="fa-regular fa-check" v-if="editor.isActive('heading', {level: 3})"></i>
                            </button>
                            <button
                                @click.prevent="setHeading(4)"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1 text[1.1rem]"
                                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 4 }) }"
                            >
                                Heading 4
                                <i class="fa-regular fa-check" v-if="editor.isActive('heading', {level: 4})"></i>
                            </button>
                            <button
                                @click.prevent="setHeading(5)"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1 "
                                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 5 }) }"
                            >
                                Heading 5
                                <i class="fa-regular fa-check" v-if="editor.isActive('heading', {level: 5})"></i>
                            </button>
                        </div>
                    </div>

                    <button
                        @click.prevent="editor.chain().focus().toggleBold().run()"
                        :class="buttonClass(editor.isActive('bold'))"
                        >
                        <i class="fa-solid fa-bold" aria-label="Bold" />
                    </button>
                    <button
                        @click.prevent="editor.chain().focus().toggleItalic().run()"
                        :class="buttonClass(editor.isActive('italic'))"
                    >
                        <i class="fa-solid fa-italic" aria-label="Bold" />
                    </button>
                    <button
                        @click.prevent="editor.chain().focus().toggleStrike().run()"
                        :class="buttonClass(editor.isActive('strike'))"
                    >
                        <i class="fa-solid fa-strikethrough" aria-label="Strikethrough" />
                    </button>
                    <button
                        @click.prevent="editor.chain().focus().toggleUnderline().run()"
                        :class="buttonClass(editor.isActive('underline'))"
                    >
                        <i class="fa-solid fa-underline" aria-label="Underline" />
                    </button>
                    <button
                        @click.prevent="openLinkInput"
                        :class="buttonClass(editor.isActive('link'))"
                    >
                        <i class="fa-regular fa-link" aria-label="Link" />
                    </button>
                    <button
                        @click.prevent="editor.chain().focus().toggleBlockquote().run()"
                        :class="buttonClass(editor.isActive('quote'))"
                    >
                        <i class="fa-solid fa-quote-right" aria-label="Quote" />
                    </button>

                    <div class="relative">
                        <button
                            @click.prevent="toggleListDropdown"
                            :class="buttonClass(false)"
                            class="flex items-center gap-0.5"
                            @blur="closeListDropdown"
                        >
                            <i :class="getCurrentListIcon"></i>
                            <i class="fa-regular fa-chevron-down" aria-label="Toggle paragraph styles"></i>
                        </button>
                        <div
                            v-show="showListDropdown"
                            class="absolute top-full left-0 mt-1 bg-base-100 shadow-lg rounded-lg py-1 z-50 min-w-[200px]"
                            @mousedown.prevent
                        >
                            <button
                                @click.prevent="toggleList('bullet')"
                                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                                :class="{ 'text-semibold text-base-content': editor.isActive('bulletList') }"
                            >
                                <div class="flex gap-1 items-center">
                                    <i class="fa-regular fa-list-ul" aria-hidden="true"></i>
                                    List
                                </div>
                                <i class="fa-regular fa-check" v-if="editor.isActive('bulletList')"></i>
                            </button>
                            <button
                                @click.prevent="toggleList('ordered')"
                                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                                :class="{ 'text-semibold text-base-content': editor.isActive('orderedList') }"
                            >
                                <div class="flex gap-1 items-center">
                                <i class="fa-regular fa-list-ol" aria-hidden="true"></i>
                                Numbered list
                                </div>
                                <i class="fa-regular fa-check" v-if="editor.isActive('orderedList')"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </bubble-menu>

    </div>
    <editor-content :editor="editor" />

    <input type="hidden" name="entry" :value="html" />

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
}

:deep(.iframe-wrapper) {
    margin: 1rem 0;
}

:deep(.iframe-wrapper iframe) {
    max-width: 100%;
    border: 0;
}
</style>
