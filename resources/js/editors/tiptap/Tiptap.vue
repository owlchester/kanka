<script setup lang="ts">
    import { useEditor, EditorContent } from '@tiptap/vue-3'
    import StarterKit from '@tiptap/starter-kit'
    import { BubbleMenu, FloatingMenu } from '@tiptap/vue-3/menus'
    import Link from '@tiptap/extension-link'
    import {ref, onMounted, onBeforeUnmount, onUnmounted, computed} from 'vue'
    import { Mention } from './extensions/mentions/Mention'
    import suggestion from './extensions/mentions/suggestion'
    import { MentionParser } from './extensions/mentions/MentionParser'


    const props = defineProps<{
        modelValue?: string
        api?: String,
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
        Link.configure({
            openOnClick: false,
            defaultProtocol: 'https',
            HTMLAttributes: {
                class: 'text-link',
            },
        }),
    ];
    // Add mention extension if mentions URL is provided
    if (props.mentions) {
        extensions.push(
            Mention.configure({
                HTMLAttributes: {
                    class: 'mention text-link',
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

                        // Add config if present
                        if (config) {
                            parts.push(config)
                        }

                        // Add label if it differs from entity name (must come last to detect custom names)
                        if (label && entityName && label !== entityName) {
                            parts.push(label)
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
    })



    onMounted(() => {
        if (props.api) {
            axios.get(props.api)
                .then(res => {
                    html.value = res.data.document
                    mentions.value = res.data.mentions

                    editor?.value?.commands.setContent(html.value)
                })
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
        editingMentionLabel.value = editor?.value.getAttributes('mention').label || ''

        // Focus the input after Vue updates the DOM
        setTimeout(() => {
            mentionLabelInput.value?.focus()
            mentionLabelInput.value?.select()
        }, 10)
    }

    const updateMentionLabel = () => {
        const trimmedLabel = editingMentionLabel.value.trim()
        const mentionAttrs = editor?.value.getAttributes('mention')
        const entityId = mentionAttrs?.id

        // If input is empty, revert to the entity's original name
        if (!trimmedLabel) {
            const entity = mentions.value.find(e => e.id === parseInt(entityId))
            if (entity) {
                editor?.value
                    .chain()
                    .focus()
                    .updateAttributes('mention', {
                        label: entity.name
                    })
                    .run()
            }
        } else {
            // Update with the new label
            editor?.value
                .chain()
                .focus()
                .updateAttributes('mention', {
                    label: trimmedLabel
                })
                .run()
        }

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
                            <input
                                ref="mentionLabelInput"
                                v-model="editingMentionLabel"
                                type="text"
                                :placeholder="editor.getAttributes('mention').label"
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

</template>

<style scoped>
.bubble-menu {
}
</style>
