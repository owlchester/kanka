<script setup lang="ts">
import { computed, ref } from 'vue'
import type { Editor } from '@tiptap/core'
import { t } from '../i18n.js'

const dialogRef = ref<HTMLDialogElement | null>(null)
const editorRef = ref<Editor | null>(null)
const inputRef = ref<HTMLInputElement | null>(null)
const embedInput = ref('')

const toEmbedSrc = (raw: string): string | null => {
    const trimmed = raw.trim()
    if (!trimmed) return null

    if (/^<iframe[\s>]/i.test(trimmed)) {
        return trimmed
    }

    try {
        const url = new URL(trimmed)
        if (url.protocol !== 'https:' && url.protocol !== 'http:') {
            return null
        }
        if ((url.hostname === 'www.youtube.com' || url.hostname === 'youtube.com') && url.pathname === '/watch') {
            const videoId = url.searchParams.get('v')
            if (videoId) {
                return `https://www.youtube.com/embed/${videoId}`
            }
        }
        if (url.hostname === 'youtu.be') {
            const videoId = url.pathname.replace(/^\//, '')
            if (videoId) {
                return `https://www.youtube.com/embed/${videoId}`
            }
        }
        return url.toString()
    } catch {
        return null
    }
}

const parsedEmbed = computed(() => toEmbedSrc(embedInput.value))
const isValid = computed(() => parsedEmbed.value !== null)

const open = (editor: Editor) => {
    editorRef.value = editor
    embedInput.value = ''
    dialogRef.value?.showModal()
    setTimeout(() => inputRef.value?.focus(), 10)
}

const close = () => {
    dialogRef.value?.close()
}

const insert = () => {
    if (!editorRef.value || !parsedEmbed.value) return

    if (/^<iframe[\s>]/i.test(parsedEmbed.value)) {
        editorRef.value.chain().focus().insertContent(parsedEmbed.value, {
            parseOptions: { preserveWhitespace: false },
        }).run()
    } else {
        editorRef.value.chain().focus().setIframe({ src: parsedEmbed.value }).run()
    }

    close()
}

defineExpose({ open, close })
</script>

<template>
    <dialog
        ref="dialogRef"
        class="rounded-2xl bg-base-100 text-base-content p-0 backdrop:bg-black/50 w-[480px] max-w-[92vw]"
        @click.self="close"
    >
        <form @submit.prevent="insert" class="flex flex-col">
            <div class="flex items-center justify-between p-4">
                <h2 class="text-base font-semibold">{{ t('insert_embed', 'Insert Embed') }}</h2>
                <button type="button" @click="close" class="btn2 btn-ghost btn-sm" :aria-label="t('cancel', 'Cancel')">
                    <i class="fa-regular fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <div class="px-4 pb-4 space-y-2 text-sm">
                <label class="block text-xs font-medium text-neutral-content">
                    {{ t('embed_label', 'Embed code or URL') }}
                </label>
                <input
                    ref="inputRef"
                    v-model="embedInput"
                    type="text"
                    :placeholder="t('embed_placeholder', '<iframe src=&quot;...&quot;></iframe> or https://...')"
                    class="input input-bordered input-sm w-full"
                />
                <p class="text-xs text-neutral-content">
                    {{ t('embed_help', 'Paste an <iframe> embed code or a YouTube, Spotify, or Google Docs URL.') }}
                </p>
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
