<script setup lang="ts">
import { ref } from 'vue'
import type { Editor } from '@tiptap/core'
import { buttonClass } from './utils'
import { t } from './i18n.js'
import TextBubbleMenu from './bubblemenus/TextBubbleMenu.vue'
import ImageBubbleMenu from './bubblemenus/ImageBubbleMenu.vue'
import TableBubbleMenu from './bubblemenus/TableBubbleMenu.vue'
import LinkBubbleMenu from './bubblemenus/LinkBubbleMenu.vue'
import MentionBubbleMenu from './bubblemenus/MentionBubbleMenu.vue'

const props = defineProps<{
    editor: Editor
    mentions: any[]
    hasGallery: boolean
    hasMentions: boolean
    isFullscreen: boolean
}>()

const emit = defineEmits<{
    'open-link': []
    'edit-image': []
    'open-embed': []
    'open-image-url': []
    'enter-source': []
    'toggle-fullscreen': []
    'hide-toolbar': []
}>()

const mentionRef = ref<InstanceType<typeof MentionBubbleMenu> | null>(null)
const showInsertDropdown = ref(false)

const syncMentionLabel = () => {
    mentionRef.value?.syncLabel()
}

defineExpose({ syncMentionLabel })

const tableHTML = `
  <table class="table table-striped table-bordered" style="width: 200px;">
    <thead>
        <tr>
            <th><p></p></th>
            <th><p></p></th>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td><p></p></td>
          <td><p></p></td>
        </tr>
        <tr>
          <td><p></p></td>
          <td><p></p></td>
        </tr>
    </tbody>
  </table>`

const toggleInsertDropdown = () => {
    showInsertDropdown.value = !showInsertDropdown.value
}

const closeInsertDropdown = () => {
    showInsertDropdown.value = false
}

const insertAction = (action: () => void) => {
    showInsertDropdown.value = false
    action()
}

const insertTable = () => {
    props.editor.chain().focus().insertContent(tableHTML, { parseOptions: { preserveWhitespace: true } }).run()
}

const insertHorizontalRule = () => {
    props.editor.chain().focus().setHorizontalRule().run()
}

const insertToc = () => {
    props.editor.chain().focus().insertContent('<p>{table-of-contents}</p>').run()
}

const insertCodeBlock = () => {
    props.editor.chain().focus().toggleCodeBlock().run()
}

const insertMentionTrigger = () => {
    props.editor.chain().focus().insertContent('@').run()
}
</script>

<template>
    <div class="editor-toolbar bg-base-100 border border-base-content/10 rounded-lg mt-2 mb-2 px-3 py-2 flex flex-col gap-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <!-- Context-aware left/main zone -->
            <div class="flex items-center gap-0.5 flex-wrap">
                <ImageBubbleMenu
                    v-if="editor.isActive('image')"
                    :editor="editor"
                    @edit-image="emit('edit-image')"
                />

                <MentionBubbleMenu
                    v-else-if="editor.isActive('mention')"
                    ref="mentionRef"
                    :editor="editor"
                    :mentions="mentions"
                />

                <LinkBubbleMenu
                    v-else-if="editor.isActive('link') && editor.state.selection.empty"
                    :editor="editor"
                />

                <template v-else>
                    <TextBubbleMenu
                        :editor="editor"
                        @open-link="emit('open-link')"
                    />

                    <!-- + Insert menu -->
                    <div class="relative ml-1 pl-1 border-l border-base-300">
                        <button
                            type="button"
                            @click.prevent="toggleInsertDropdown"
                            @blur="closeInsertDropdown"
                            :class="buttonClass(showInsertDropdown)"
                            class="flex items-center gap-1 text-xs"
                            :title="t('insert', 'Insert')"
                        >
                            <i class="fa-regular fa-plus" aria-hidden="true" />
                            <span class="hidden sm:inline">{{ t('insert', 'Insert') }}</span>
                            <i class="fa-regular fa-chevron-down text-[10px]" aria-hidden="true" />
                        </button>
                        <div
                            v-show="showInsertDropdown"
                            class="absolute top-full left-0 mt-1 bg-base-100 shadow-lg rounded-lg py-1 z-50 min-w-[200px]"
                            @mousedown.prevent
                        >
                            <button
                                v-if="hasGallery"
                                type="button"
                                @click.prevent="insertAction(() => editor.commands.openGallery())"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center gap-2"
                            >
                                <i class="fa-regular fa-images w-4 text-center" aria-hidden="true" />
                                {{ t('gallery', 'Gallery') }}
                            </button>
                            <button
                                v-if="hasGallery"
                                type="button"
                                @click.prevent="insertAction(() => editor.commands.uploadMedia())"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center gap-2"
                            >
                                <i class="fa-regular fa-upload w-4 text-center" aria-hidden="true" />
                                {{ t('slash_upload_title', 'Insert Media') }}
                            </button>
                            <button
                                type="button"
                                @click.prevent="insertAction(() => emit('open-image-url'))"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center gap-2"
                            >
                                <i class="fa-regular fa-image w-4 text-center" aria-hidden="true" />
                                {{ t('slash_image_url_title', 'Image from URL') }}
                            </button>
                            <button
                                type="button"
                                @click.prevent="insertAction(insertTable)"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center gap-2"
                            >
                                <i class="fa-regular fa-table w-4 text-center" aria-hidden="true" />
                                {{ t('slash_table_title', 'Table') }}
                            </button>
                            <button
                                type="button"
                                @click.prevent="insertAction(insertHorizontalRule)"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center gap-2"
                            >
                                <i class="fa-regular fa-minus w-4 text-center" aria-hidden="true" />
                                {{ t('horizontal_rule', 'Horizontal Rule') }}
                            </button>
                            <button
                                type="button"
                                @click.prevent="insertAction(insertToc)"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center gap-2"
                            >
                                <i class="fa-regular fa-list-tree w-4 text-center" aria-hidden="true" />
                                {{ t('table_of_contents', 'Table of Contents') }}
                            </button>
                            <button
                                type="button"
                                @click.prevent="insertAction(() => emit('open-embed'))"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center gap-2"
                            >
                                <i class="fa-regular fa-photo-film w-4 text-center" aria-hidden="true" />
                                {{ t('slash_embed_title', 'Embed') }}
                            </button>
                            <button
                                type="button"
                                @click.prevent="insertAction(insertCodeBlock)"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center gap-2"
                            >
                                <i class="fa-regular fa-code w-4 text-center" aria-hidden="true" />
                                {{ t('code_block', 'Code Block') }}
                            </button>
                            <button
                                v-if="hasMentions"
                                type="button"
                                @click.prevent="insertAction(insertMentionTrigger)"
                                class="w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs flex items-center gap-2"
                            >
                                <i class="fa-regular fa-at w-4 text-center" aria-hidden="true" />
                                {{ t('mention', 'Mention (@)') }}
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Utility zone (right) -->
            <div class="flex items-center gap-0.5 ml-auto">
                <button
                    type="button"
                    @click.prevent="editor.chain().focus().undo().run()"
                    :disabled="!editor.can().undo()"
                    :class="[buttonClass(false), !editor.can().undo() ? 'opacity-40 pointer-events-none' : '']"
                    :title="t('undo', 'Undo')"
                >
                    <i class="fa-regular fa-rotate-left" :aria-label="t('undo', 'Undo')" />
                </button>
                <button
                    type="button"
                    @click.prevent="editor.chain().focus().redo().run()"
                    :disabled="!editor.can().redo()"
                    :class="[buttonClass(false), !editor.can().redo() ? 'opacity-40 pointer-events-none' : '']"
                    :title="t('redo', 'Redo')"
                >
                    <i class="fa-regular fa-rotate-right" :aria-label="t('redo', 'Redo')" />
                </button>

                <span class="w-px h-4 bg-base-content/20 mx-1" />

                <button
                    type="button"
                    @click.prevent="emit('enter-source')"
                    :class="buttonClass(false)"
                    :title="t('source_mode', 'Source Mode')"
                >
                    <i class="fa-regular fa-code" :aria-label="t('source_mode', 'Source Mode')" />
                </button>
                <button
                    type="button"
                    @click.prevent="emit('toggle-fullscreen')"
                    :class="buttonClass(isFullscreen)"
                    :title="isFullscreen ? t('exit_fullscreen', 'Exit fullscreen') : t('fullscreen', 'Fullscreen')"
                >
                    <i
                        class="fa-regular"
                        :class="isFullscreen ? 'fa-compress' : 'fa-expand'"
                        :aria-label="isFullscreen ? t('exit_fullscreen', 'Exit fullscreen') : t('fullscreen', 'Fullscreen')"
                    />
                </button>
                <button
                    type="button"
                    @click.prevent="emit('hide-toolbar')"
                    :class="buttonClass(false)"
                    :title="t('hide_toolbar', 'Hide toolbar')"
                >
                    <i class="fa-regular fa-chevron-up" :aria-label="t('hide_toolbar', 'Hide toolbar')" />
                </button>
            </div>
        </div>

        <!-- Contextual Table sub-row when cursor is inside a table -->
        <div
            v-if="editor.isActive('table') && !editor.isActive('image') && !editor.isActive('mention') && !(editor.isActive('link') && editor.state.selection.empty)"
            class="pt-1 border-t border-base-content/10"
        >
            <TableBubbleMenu :editor="editor" />
        </div>
    </div>
</template>
