<script setup lang="ts">
import { ref, computed } from 'vue'
import type { Editor } from '@tiptap/core'
import { buttonClass } from '../utils'
import ColorPicker from './ColorPicker.vue'
import { t } from '../i18n.js'

const props = defineProps<{
    editor: Editor
}>()

const emit = defineEmits<{
    openLink: []
}>()

const showHeadingDropdown = ref(false)
const showListDropdown = ref(false)

const currentTextColor = computed(() => {
    return props.editor.getAttributes('textStyle').color || null
})

const currentHighlightColor = computed(() => {
    return props.editor.getAttributes('highlight').color || null
})

const setTextColor = (color: string | null) => {
    if (color) {
        props.editor.chain().focus().setColor(color).run()
    } else {
        props.editor.chain().focus().unsetColor().run()
    }
}

const setHighlightColor = (color: string | null) => {
    if (color) {
        props.editor.chain().focus().setHighlight({ color }).run()
    } else {
        props.editor.chain().focus().unsetHighlight().run()
    }
}

const currentHeadingIcon = computed(() => {
    if (!props.editor) return 'fa-regular fa-paragraph'
    if (props.editor.isActive('paragraph')) return 'fa-regular fa-paragraph'
    return 'fa-regular fa-heading'
})

const currentHeadingLevel = () => {
    if (props.editor.isActive('heading', { level: 1 })) return '1'
    if (props.editor.isActive('heading', { level: 2 })) return '2'
    if (props.editor.isActive('heading', { level: 3 })) return '3'
    if (props.editor.isActive('heading', { level: 4 })) return '4'
    if (props.editor.isActive('heading', { level: 5 })) return '5'
    if (props.editor.isActive('heading', { level: 6 })) return '6'
    return 0
}

const setHeading = (level: 1 | 2 | 3 | 4 | 5 | 6 | null) => {
    if (level === null) {
        props.editor.chain().focus().setParagraph().run()
    } else {
        props.editor.chain().focus().toggleHeading({ level }).run()
    }
    showHeadingDropdown.value = false
}

const toggleDropdown = () => {
    showHeadingDropdown.value = !showHeadingDropdown.value
}

const closeDropdown = () => {
    showHeadingDropdown.value = false
}

const getCurrentListIcon = computed(() => {
    if (!props.editor) return 'fa-regular fa-list-ul'
    if (props.editor.isActive('bulletList')) return 'fa-regular fa-list-ul'
    if (props.editor.isActive('orderedList')) return 'fa-regular fa-list-ol'
    if (props.editor.isActive('taskList')) return 'fa-regular fa-square-check'
    return 'fa-regular fa-list-ul'
})

const toggleList = (type: 'bullet' | 'ordered' | 'task') => {
    if (type === 'bullet') {
        props.editor.chain().focus().toggleBulletList().run()
    } else if (type === 'ordered') {
        props.editor.chain().focus().toggleOrderedList().run()
    } else {
        props.editor.chain().focus().toggleTaskList().run()
    }
    showListDropdown.value = false
}

const toggleListDropdown = () => {
    showListDropdown.value = !showListDropdown.value
}

const closeListDropdown = () => {
    showListDropdown.value = false
}

const currentAlignIcon = computed(() => {
    if (props.editor.isActive({ textAlign: 'center' })) return 'fa-regular fa-align-center'
    if (props.editor.isActive({ textAlign: 'right' })) return 'fa-regular fa-align-right'
    if (props.editor.isActive({ textAlign: 'justify' })) return 'fa-regular fa-align-justify'
    return 'fa-regular fa-align-left'
})

const cycleAlignment = () => {
    if (props.editor.isActive({ textAlign: 'center' })) {
        props.editor.chain().focus().setTextAlign('right').run()
    } else if (props.editor.isActive({ textAlign: 'right' })) {
        props.editor.chain().focus().setTextAlign('justify').run()
    } else if (props.editor.isActive({ textAlign: 'justify' })) {
        props.editor.chain().focus().setTextAlign('left').run()
    } else {
        props.editor.chain().focus().setTextAlign('center').run()
    }
}

const clearFormatting = () => {
    props.editor.chain().focus().unsetAllMarks().clearNodes().run()
}
</script>

<template>
    <div class="relative">
        <button
            type="button"
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
                type="button"
                @click.prevent="setHeading(null)"
                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                :class="{ 'text-semibold text-base-content': editor.isActive('paragraph') }"
            >
                {{ t('paragraph', 'Paragraph') }}
                <i class="fa-regular fa-check" v-if="editor.isActive('paragraph')"></i>
            </button>
            <button
                type="button"
                @click.prevent="setHeading(1)"
                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content flex items-center justify-between gap-1 text-[1.4rem]"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 1 }) }"
            >
                {{ t('heading_1', 'Heading 1') }}
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 1 })"></i>
            </button>
            <button
                type="button"
                @click.prevent="setHeading(2)"
                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content flex items-center justify-between gap-1 text-[1.3rem]"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 2 }) }"
            >
                {{ t('heading_2', 'Heading 2') }}
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 2 })"></i>
            </button>
            <button
                type="button"
                @click.prevent="setHeading(3)"
                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content flex items-center justify-between gap-1 text-[1.2rem]"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 3 }) }"
            >
                {{ t('heading_3', 'Heading 3') }}
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 3 })"></i>
            </button>
            <button
                type="button"
                @click.prevent="setHeading(4)"
                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1 text-[1.1rem]"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 4 }) }"
            >
                {{ t('heading_4', 'Heading 4') }}
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 4 })"></i>
            </button>
            <button
                type="button"
                @click.prevent="setHeading(5)"
                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 5 }) }"
            >
                {{ t('heading_5', 'Heading 5') }}
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 5 })"></i>
            </button>
            <button
                type="button"
                @click.prevent="setHeading(6)"
                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 6 }) }"
            >
                {{ t('heading_6', 'Heading 6') }}
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 6 })"></i>
            </button>
        </div>
    </div>

    <button
        type="button"
        @click.prevent="editor.chain().focus().toggleBold().run()"
        :class="buttonClass(editor.isActive('bold'))"
        :title="t('bold', 'Bold')"
    >
        <i class="fa-regular fa-bold" :aria-label="t('bold', 'Bold')" />
    </button>
    <button
        type="button"
        @click.prevent="editor.chain().focus().toggleItalic().run()"
        :class="buttonClass(editor.isActive('italic'))"
        :title="t('italic', 'Italic')"
    >
        <i class="fa-regular fa-italic" :aria-label="t('italic', 'Italic')" />
    </button>
    <button
        type="button"
        @click.prevent="editor.chain().focus().toggleStrike().run()"
        :class="buttonClass(editor.isActive('strike'))"
        :title="t('strikethrough', 'Strikethrough')"
    >
        <i class="fa-regular fa-strikethrough" :aria-label="t('strikethrough', 'Strikethrough')" />
    </button>
    <button
        type="button"
        @click.prevent="editor.chain().focus().toggleUnderline().run()"
        :class="buttonClass(editor.isActive('underline'))"
        :title="t('underline', 'Underline')"
    >
        <i class="fa-regular fa-underline" :aria-label="t('underline', 'Underline')" />
    </button>
    <button
        type="button"
        @click.prevent="editor.chain().focus().toggleCode().run()"
        :class="buttonClass(editor.isActive('code'))"
        :title="t('inline_code', 'Inline code')"
    >
        <i class="fa-regular fa-code" :aria-label="t('inline_code', 'Inline code')" />
    </button>

    <div class="flex items-center gap-0.5 border-r border-base-300 pr-2 mr-1">
        <ColorPicker
            :current-color="currentTextColor"
            icon="fa-regular fa-font"
            :title="t('text_color', 'Text color')"
            @select="setTextColor"
        />

        <ColorPicker
            :current-color="currentHighlightColor"
            icon="fa-regular fa-fill"
            :title="t('highlight_color', 'Highlight color')"
            @select="setHighlightColor"
        />
    </div>

    <div class="flex items-center gap-0.5 border-r border-base-300 pr-2 mr-1">
        <button
            type="button"
            @click.prevent="emit('openLink')"
            :class="buttonClass(editor.isActive('link'))"
            :title="t('link', 'Link')"
        >
            <i class="fa-regular fa-link" :aria-label="t('link', 'Link')" />
        </button>
        <button
            type="button"
            @click.prevent="editor.chain().focus().toggleBlockquote().run()"
            :class="buttonClass(editor.isActive('blockquote'))"
            :title="t('quote', 'Quote')"
        >
            <i class="fa-regular fa-quote-right" :aria-label="t('quote', 'Quote')" />
        </button>
        <button
            type="button"
            @click.prevent="cycleAlignment"
            :class="buttonClass(editor.isActive({ textAlign: 'center' }) || editor.isActive({ textAlign: 'right' }) || editor.isActive({ textAlign: 'justify' }))"
            :title="t('text_alignment', 'Text alignment')"
        >
            <i :class="currentAlignIcon" :aria-label="t('text_alignment', 'Text alignment')" />
        </button>

        <div class="relative">
            <button
                type="button"
                @click.prevent="toggleListDropdown"
                :class="buttonClass(editor.isActive('bulletList') || editor.isActive('orderedList') || editor.isActive('taskList'))"
                class="flex items-center gap-0.5"
                @blur="closeListDropdown"
            >
                <i :class="getCurrentListIcon"></i>
                <i class="fa-regular fa-chevron-down" aria-label="Toggle list styles"></i>
            </button>
            <div
                v-show="showListDropdown"
                class="absolute top-full left-0 mt-1 bg-base-100 shadow-lg rounded-lg py-1 z-50 min-w-[200px]"
                @mousedown.prevent
            >
                <button
                    type="button"
                    @click.prevent="toggleList('bullet')"
                    class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                    :class="{ 'text-semibold text-base-content': editor.isActive('bulletList') }"
                >
                    <div class="flex gap-1 items-center">
                        <i class="fa-regular fa-list-ul" aria-hidden="true"></i>
                        {{ t('bullet_list', 'List') }}
                    </div>
                    <i class="fa-regular fa-check" v-if="editor.isActive('bulletList')"></i>
                </button>
                <button
                    type="button"
                    @click.prevent="toggleList('ordered')"
                    class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                    :class="{ 'text-semibold text-base-content': editor.isActive('orderedList') }"
                >
                    <div class="flex gap-1 items-center">
                        <i class="fa-regular fa-list-ol" aria-hidden="true"></i>
                        {{ t('ordered_list', 'Numbered list') }}
                    </div>
                    <i class="fa-regular fa-check" v-if="editor.isActive('orderedList')"></i>
                </button>
                <button
                    type="button"
                    @click.prevent="toggleList('task')"
                    class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                    :class="{ 'text-semibold text-base-content': editor.isActive('taskList') }"
                >
                    <div class="flex gap-1 items-center">
                        <i class="fa-regular fa-square-check" aria-hidden="true"></i>
                        {{ t('task_list', 'Task list') }}
                    </div>
                    <i class="fa-regular fa-check" v-if="editor.isActive('taskList')"></i>
                </button>
            </div>
        </div>
    </div>

    <button
        type="button"
        @click.prevent="clearFormatting"
        :class="buttonClass(false)"
        :title="t('clear_formatting', 'Clear formatting')"
    >
        <i class="fa-regular fa-paint-roller" :aria-label="t('clear_formatting', 'Clear formatting')" />
    </button>
</template>
