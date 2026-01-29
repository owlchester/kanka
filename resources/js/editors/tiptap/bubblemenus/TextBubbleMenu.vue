<script setup lang="ts">
import { ref, computed } from 'vue'
import type { Editor } from '@tiptap/core'
import { buttonClass } from '../utils'
import ColorPicker from './ColorPicker.vue'

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
    return 0
}

const setHeading = (level: number | null) => {
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
    if (!props.editor) return 'fa-regular fa-list-ol'
    if (props.editor.isActive('bulletList')) return 'fa-regular fa-list-ul'
    if (props.editor.isActive('orderedList')) return 'fa-regular fa-list-ol'
    return 'fa-regular fa-list-ul'
})

const toggleList = (type: 'bullet' | 'ordered') => {
    if (type === 'bullet') {
        props.editor.chain().focus().toggleBulletList().run()
    } else {
        props.editor.chain().focus().toggleOrderedList().run()
    }
    showListDropdown.value = false
}

const toggleListDropdown = () => {
    showListDropdown.value = !showListDropdown.value
}

const closeListDropdown = () => {
    showListDropdown.value = false
}
</script>

<template>
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
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 1 })"></i>
            </button>
            <button
                @click.prevent="setHeading(2)"
                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content flex items-center justify-between gap-1 text-[1.3rem]"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 2 }) }"
            >
                Heading 2
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 2 })"></i>
            </button>
            <button
                @click.prevent="setHeading(3)"
                class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content flex items-center justify-between gap-1 text-[1.2rem]"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 3 }) }"
            >
                Heading 3
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 3 })"></i>
            </button>
            <button
                @click.prevent="setHeading(4)"
                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1 text[1.1rem]"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 4 }) }"
            >
                Heading 4
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 4 })"></i>
            </button>
            <button
                @click.prevent="setHeading(5)"
                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1"
                :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 5 }) }"
            >
                Heading 5
                <i class="fa-regular fa-check" v-if="editor.isActive('heading', { level: 5 })"></i>
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
        <i class="fa-solid fa-italic" aria-label="Italic" />
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
        @click.prevent="emit('openLink')"
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

    <ColorPicker
        :current-color="currentTextColor"
        icon="fa-solid fa-font"
        title="Text color"
        @select="setTextColor"
    />

    <ColorPicker
        :current-color="currentHighlightColor"
        icon="fa-solid fa-highlighter"
        title="Highlight color"
        @select="setHighlightColor"
    />

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
