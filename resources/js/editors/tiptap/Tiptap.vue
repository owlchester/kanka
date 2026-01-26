<script setup lang="ts">
    import { useEditor, EditorContent } from '@tiptap/vue-3'
    import StarterKit from '@tiptap/starter-kit'
    import { BubbleMenu, FloatingMenu } from '@tiptap/vue-3/menus'
    import {ref, onMounted, onBeforeUnmount, onUnmounted, computed} from 'vue'


    const props = defineProps<{
        modelValue?: string
        api?: String
    }>()
    const html = ref(props.modelValue ?? '<p>Loading...</p>')
    const showHeadingDropdown = ref(false)
    const showListDropdown = ref(false)


    const editor = useEditor({
        content: html.value,
        extensions: [
            StarterKit,
        ],
        onUpdate: ({ editor }) => {
            html.value = editor.getHTML()
        },

    })



    onMounted(() => {
        if (props.api) {
            axios.get(props.api)
                .then(res => {
                    html.value = res.data.document
                    editor?.value.commands.setContent(html.value)
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

        return 'fa-regular fa-list-ol'
    })

    onBeforeUnmount(() => {
        editor?.value.destroy()
    })
</script>

<template>

    <div v-if="editor">
        <bubble-menu :editor="editor">
            <div class="bubble-menu bg-base-100 shadow rounded-2xl flex gap-0.5 items-center px-2 py-2">
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
                        class="absolute top-full left-0 mt-1 bg-base-100 shadow-lg rounded-lg py-1 z-50 min-w-[120px]"
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
                            class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1 text[1.1rem]"
                            :class="{ 'font-semibold text-base-content': editor.isActive('heading', { level: 4 }) }"
                        >
                            Heading 4
                            <i class="fa-regular fa-check" v-if="editor.isActive('heading', {level: 4})"></i>
                        </button>
                        <button
                            @click.prevent="setHeading(5)"
                            class="block w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center justify-between gap-1 "
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
                        class="absolute top-full left-0 mt-1 bg-base-100 shadow-lg rounded-lg py-1 z-50 min-w-[120px]"
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
