<script setup lang="ts">
import { computed, ref } from 'vue'
import type { Editor } from '@tiptap/core'
import { t } from '../i18n.js'

const dialogRef = ref<HTMLDialogElement | null>(null)
const editorRef = ref<Editor | null>(null)
const urlInputRef = ref<HTMLInputElement | null>(null)
const imageUrl = ref('')
const altText = ref('')

const isValid = computed(() => {
    const trimmed = imageUrl.value.trim()
    if (!trimmed) return false
    try {
        const url = new URL(trimmed)
        return url.protocol === 'https:' || url.protocol === 'http:'
    } catch {
        return false
    }
})

const open = (editor: Editor) => {
    editorRef.value = editor
    imageUrl.value = ''
    altText.value = ''
    dialogRef.value?.showModal()
    setTimeout(() => urlInputRef.value?.focus(), 10)
}

const close = () => {
    dialogRef.value?.close()
}

const insert = () => {
    if (!editorRef.value || !isValid.value) return

    editorRef.value.chain().focus().setImage({
        src: imageUrl.value.trim(),
        alt: altText.value.trim() || null,
    }).run()

    close()
}

defineExpose({ open, close })
</script>

<template>
    <dialog
        ref="dialogRef"
        class="rounded-2xl bg-base-100 text-base-content p-0 backdrop:bg-black/50 w-[440px] max-w-[92vw]"
        @click.self="close"
    >
        <form @submit.prevent="insert" class="flex flex-col">
            <div class="flex items-center justify-between p-4">
                <h2 class="text-base font-semibold">{{ t('insert_image_url', 'Insert Image from URL') }}</h2>
                <button type="button" @click="close" class="btn2 btn-ghost btn-sm" :aria-label="t('cancel', 'Cancel')">
                    <i class="fa-regular fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <div class="px-4 pb-4 space-y-3 text-sm">
                <div>
                    <label class="block text-xs font-medium text-neutral-content mb-1">
                        {{ t('image_url_label', 'Image URL') }}
                    </label>
                    <input
                        ref="urlInputRef"
                        v-model="imageUrl"
                        type="url"
                        :placeholder="t('image_url_placeholder', 'https://example.com/image.png')"
                        class="input input-bordered input-sm w-full"
                    />
                </div>

                <div>
                    <label class="block text-xs font-medium text-neutral-content mb-1">
                        {{ t('alt_text', 'Alternative text') }}
                    </label>
                    <input
                        v-model="altText"
                        type="text"
                        :placeholder="t('alt_placeholder', 'Describe this image...')"
                        class="input input-bordered input-sm w-full"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-2 p-4 pt-2">
                <button type="button" @click="close" class="btn2 btn-default btn-sm">
                    {{ t('cancel', 'Cancel') }}
                </button>
                <button type="submit" class="btn2 btn-primary btn-sm" :disabled="!isValid">
                    {{ t('insert', 'Insert') }}
                </button>
            </div>
        </form>
    </dialog>
</template>
