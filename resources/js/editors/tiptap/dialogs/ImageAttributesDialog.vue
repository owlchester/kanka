<script setup lang="ts">
import { ref } from 'vue'
import type { Editor } from '@tiptap/core'
import { t } from '../i18n.js'

const dialogRef = ref<HTMLDialogElement | null>(null)
const editorRef = ref<Editor | null>(null)

const alt = ref('')
const title = ref('')
const width = ref<string>('')
const height = ref<string>('')
const unit = ref<'px' | '%'>('px')
const lockAspectRatio = ref(true)
const naturalWidth = ref<number>(0)
const naturalHeight = ref<number>(0)

const open = (editor: Editor) => {
    editorRef.value = editor
    const attrs = editor.getAttributes('image')

    alt.value = attrs.alt || ''
    title.value = attrs.title || ''
    lockAspectRatio.value = attrs.height == null

    if (attrs.widthStyle && String(attrs.widthStyle).endsWith('%')) {
        unit.value = '%'
        width.value = String(parseFloat(attrs.widthStyle))
        height.value = ''
    } else {
        unit.value = 'px'
        width.value = attrs.width != null ? String(Math.round(attrs.width)) : ''
        height.value = attrs.height != null ? String(Math.round(attrs.height)) : ''
    }

    naturalWidth.value = 0
    naturalHeight.value = 0

    if (attrs.src) {
        const probe = new Image()
        probe.onload = () => {
            naturalWidth.value = probe.naturalWidth
            naturalHeight.value = probe.naturalHeight
            if (lockAspectRatio.value && unit.value === 'px' && width.value && !height.value && probe.naturalWidth > 0) {
                height.value = String(Math.round(parseFloat(width.value) * (probe.naturalHeight / probe.naturalWidth)))
            }
        }
        probe.src = attrs.src
    }

    dialogRef.value?.showModal()
}

const close = () => {
    dialogRef.value?.close()
}

const onWidthInput = () => {
    if (!lockAspectRatio.value || unit.value !== 'px' || !naturalWidth.value || !naturalHeight.value) {
        return
    }
    const w = parseFloat(width.value)
    if (!Number.isNaN(w) && w > 0) {
        height.value = String(Math.round(w * (naturalHeight.value / naturalWidth.value)))
    } else {
        height.value = ''
    }
}

const onHeightInput = () => {
    if (!lockAspectRatio.value || unit.value !== 'px' || !naturalWidth.value || !naturalHeight.value) {
        return
    }
    const h = parseFloat(height.value)
    if (!Number.isNaN(h) && h > 0) {
        width.value = String(Math.round(h * (naturalWidth.value / naturalHeight.value)))
    } else {
        width.value = ''
    }
}

const onUnitChange = () => {
    if (unit.value === '%') {
        height.value = ''
        const w = parseFloat(width.value)
        if (!Number.isNaN(w) && w > 100) {
            width.value = '100'
        }
    } else {
        onWidthInput()
    }
}

const toggleLock = () => {
    lockAspectRatio.value = !lockAspectRatio.value
    if (lockAspectRatio.value) {
        onWidthInput()
    }
}

const resetSize = () => {
    width.value = ''
    height.value = ''
    unit.value = 'px'
    lockAspectRatio.value = true
}

const save = () => {
    if (!editorRef.value) return

    const trimmedAlt = alt.value.trim()
    const trimmedTitle = title.value.trim()
    const parsedWidth = parseFloat(width.value)
    const parsedHeight = parseFloat(height.value)

    let payloadWidth: number | null = null
    let payloadHeight: number | null = null
    let payloadWidthStyle: string | null = null

    if (!Number.isNaN(parsedWidth) && parsedWidth > 0) {
        if (unit.value === '%') {
            payloadWidthStyle = `${Math.min(Math.round(parsedWidth), 100)}%`
        } else {
            payloadWidth = Math.round(parsedWidth)
            if (!lockAspectRatio.value && !Number.isNaN(parsedHeight) && parsedHeight > 0) {
                payloadHeight = Math.round(parsedHeight)
            }
        }
    } else if (unit.value === 'px' && !lockAspectRatio.value && !Number.isNaN(parsedHeight) && parsedHeight > 0) {
        payloadHeight = Math.round(parsedHeight)
    }

    editorRef.value
        .chain()
        .focus()
        .setImageAttributes({
            alt: trimmedAlt || null,
            title: trimmedTitle || null,
            width: payloadWidth,
            height: payloadHeight,
            widthStyle: payloadWidthStyle,
        })
        .run()

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
        <form @submit.prevent="save" class="flex flex-col">
            <div class="flex items-center justify-between p-4">
                <h2 class="text-base font-semibold">{{ t('image_attributes_title', 'Image Attributes') }}</h2>
                <button type="button" @click="close" class="btn2 btn-ghost btn-sm" :aria-label="t('cancel', 'Cancel')">
                    <i class="fa-regular fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <div class="px-4 pb-4 space-y-3 text-sm">
                <div>
                    <label class="block text-xs font-medium text-neutral-content mb-1">
                        {{ t('alt_text', 'Alternative text') }}
                    </label>
                    <input
                        v-model="alt"
                        type="text"
                        :placeholder="t('alt_placeholder', 'Describe this image...')"
                        class="input input-bordered input-sm w-full"
                    />
                </div>

                <div>
                    <label class="block text-xs font-medium text-neutral-content mb-1">
                        {{ t('image_title', 'Title') }}
                    </label>
                    <input
                        v-model="title"
                        type="text"
                        :placeholder="t('title_placeholder', 'Optional tooltip text...')"
                        class="input input-bordered input-sm w-full"
                    />
                </div>

                <div class="grid grid-cols-12 gap-2 items-end">
                    <div :class="unit === 'px' ? 'col-span-5' : 'col-span-9'">
                        <label class="block text-xs font-medium text-neutral-content mb-1">
                            {{ t('width', 'Width') }}
                        </label>
                        <div class="flex gap-1">
                            <input
                                v-model="width"
                                type="number"
                                min="1"
                                :max="unit === '%' ? 100 : undefined"
                                class="input input-bordered input-sm w-full"
                                @input="onWidthInput"
                            />
                            <select
                                v-model="unit"
                                class="select select-bordered select-sm"
                                @change="onUnitChange"
                            >
                                <option value="px">px</option>
                                <option value="%">%</option>
                            </select>
                        </div>
                    </div>

                    <div v-if="unit === 'px'" class="col-span-4">
                        <label class="block text-xs font-medium text-neutral-content mb-1">
                            {{ t('height', 'Height') }}
                        </label>
                        <input
                            v-model="height"
                            type="number"
                            min="1"
                            class="input input-bordered input-sm w-full"
                            @input="onHeightInput"
                        />
                    </div>

                    <div class="col-span-3 flex gap-1 justify-end">
                        <button
                            v-if="unit === 'px'"
                            type="button"
                            @click="toggleLock"
                            class="btn2 btn-sm"
                            :class="lockAspectRatio ? 'btn-primary' : 'btn-default'"
                            :title="t('keep_aspect_ratio', 'Keep aspect ratio')"
                            :aria-pressed="lockAspectRatio"
                        >
                            <i class="fa-regular" :class="lockAspectRatio ? 'fa-lock' : 'fa-lock-open'" aria-hidden="true"></i>
                        </button>
                        <button
                            type="button"
                            @click="resetSize"
                            class="btn2 btn-default btn-sm"
                            :title="t('reset_width', 'Reset size')"
                        >
                            <i class="fa-regular fa-undo" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2 p-4 pt-2">
                <button type="button" @click="close" class="btn2 btn-default btn-sm">
                    {{ t('cancel', 'Cancel') }}
                </button>
                <button type="submit" class="btn2 btn-primary btn-sm">
                    {{ t('save', 'Save') }}
                </button>
            </div>
        </form>
    </dialog>
</template>
