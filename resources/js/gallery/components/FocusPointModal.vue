<template>
    <dialog
        ref="dialogRef"
        class="dialog rounded-2xl bg-base-100 text-base-content p-0 w-full! max-w-3xl!"
        @click.self="close"
    >
        <header class="flex items-center justify-between p-4 md:p-5">
            <div class="flex items-center gap-2">
                <i class="fa-regular fa-bullseye text-primary" aria-hidden="true"></i>
                <h4 class="text-lg font-medium">{{ trans('focus_point') }}</h4>
            </div>
            <button type="button" class="text-base-content cursor-pointer" @click="close" :aria-label="trans('cancel')">
                <i class="fa-regular fa-circle-xmark text-lg" aria-hidden="true"></i>
            </button>
        </header>

        <article class="px-4 md:px-6 pb-4 flex flex-col gap-4 max-h-[75vh] overflow-y-auto">
            <div v-if="!premium" class="alert alert-warning p-4 rounded-xl flex flex-col gap-2">
                <p>{{ trans('focus_locked') }}</p>
                <a href="https://kanka.io/premium" target="_blank" class="text-link font-medium">Learn more</a>
            </div>

            <template v-else-if="file">
                <p class="text-xs md:text-sm text-neutral-content">
                    {{ trans('focus_description') }}
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                    <!-- Interactive Canvas -->
                    <div class="md:col-span-2 bg-base-200 rounded-xl p-3 flex items-center justify-center min-h-[240px]">
                        <div
                            class="relative inline-block cursor-crosshair select-none overflow-hidden rounded-lg"
                            @pointerdown="startDrag"
                            @pointermove="onDrag"
                            @pointerup="endDrag"
                            @pointercancel="endDrag"
                        >
                            <img
                                ref="imgRef"
                                :src="file.original || file.link"
                                :alt="file.name"
                                draggable="false"
                                class="max-h-[45vh] max-w-full object-contain block"
                                @load="syncPointFromCoordinates"
                            />
                            <span
                                v-if="pointPercent"
                                class="pointer-events-none absolute -translate-x-1/2 -translate-y-1/2 text-2xl text-accent drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]"
                                :style="{ left: pointPercent.x + '%', top: pointPercent.y + '%' }"
                                aria-hidden="true"
                            >
                                <i class="fa-duotone fa-arrow-up-left-from-circle"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Live Crop Previews -->
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-medium text-neutral-content">{{ trans('focus_preview_avatar') }}</span>
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-base-200">
                                <img :src="file.original || file.link" :alt="file.name" class="w-full h-full object-cover" :style="previewPositionStyle" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-medium text-neutral-content">{{ trans('focus_preview_card') }}</span>
                            <div class="w-full aspect-[4/3] rounded-lg overflow-hidden bg-base-200">
                                <img :src="file.original || file.link" :alt="file.name" class="w-full h-full object-cover" :style="previewPositionStyle" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-medium text-neutral-content">{{ trans('focus_preview_header') }}</span>
                            <div class="w-full aspect-[16/9] rounded-lg overflow-hidden bg-base-200">
                                <img :src="file.original || file.link" :alt="file.name" class="w-full h-full object-cover" :style="previewPositionStyle" />
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </article>

        <footer v-if="premium" class="px-4 md:px-6 py-3 flex items-center justify-between gap-2">
            <button
                v-if="pointPercent"
                type="button"
                class="btn2 btn-ghost btn-sm text-error-content"
                :disabled="saving"
                @click="resetFocus"
            >
                {{ trans('focus_reset') }}
            </button>
            <span v-else></span>

            <div class="flex items-center gap-2">
                <button type="button" class="btn2 btn-default btn-sm" @click="close">{{ trans('cancel') }}</button>
                <button type="button" class="btn2 btn-primary btn-sm" :disabled="saving" @click="save">
                    <i v-if="saving" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                    <span>{{ trans('save') }}</span>
                </button>
            </div>
        </footer>
    </dialog>
</template>

<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import axios from 'axios'
import type { GalleryFileItem } from '../types'

const props = defineProps<{
    open: boolean
    file: GalleryFileItem | null
    premium: boolean
    trans: (key: string) => string
}>()

const emit = defineEmits<{
    (e: 'close'): void
    (e: 'updated', file: GalleryFileItem): void
}>()

const dialogRef = ref<HTMLDialogElement | null>(null)
const imgRef = ref<HTMLImageElement | null>(null)
const saving = ref(false)
const dragging = ref(false)

const coords = ref<{ x: number; y: number } | null>(null)
const pointPercent = ref<{ x: number; y: number } | null>(null)

const syncPointFromCoordinates = () => {
    const img = imgRef.value
    if (!img || !img.naturalWidth || !coords.value) {
        pointPercent.value = null
        return
    }
    pointPercent.value = {
        x: (coords.value.x / img.naturalWidth) * 100,
        y: (coords.value.y / img.naturalHeight) * 100,
    }
}

watch(() => props.open, (isOpen) => {
    if (isOpen && props.file) {
        coords.value = props.file.focus_x !== null && props.file.focus_y !== null
            ? { x: Number(props.file.focus_x), y: Number(props.file.focus_y) }
            : null
        dialogRef.value?.showModal()
        syncPointFromCoordinates()
    } else {
        dialogRef.value?.close()
    }
})

const previewPositionStyle = computed(() => {
    if (!pointPercent.value) return { objectPosition: '50% 50%' }
    return {
        objectPosition: `${pointPercent.value.x.toFixed(1)}% ${pointPercent.value.y.toFixed(1)}%`,
    }
})

const updateFromEvent = (e: PointerEvent) => {
    const img = imgRef.value
    if (!img || !img.naturalWidth) return
    const rect = img.getBoundingClientRect()
    const x = Math.max(0, Math.min(rect.width, e.clientX - rect.left))
    const y = Math.max(0, Math.min(rect.height, e.clientY - rect.top))
    const px = x / rect.width
    const py = y / rect.height
    pointPercent.value = { x: px * 100, y: py * 100 }
    coords.value = {
        x: Math.round(px * img.naturalWidth),
        y: Math.round(py * img.naturalHeight),
    }
}

const startDrag = (e: PointerEvent) => {
    dragging.value = true
    ;(e.currentTarget as HTMLElement).setPointerCapture(e.pointerId)
    updateFromEvent(e)
}

const onDrag = (e: PointerEvent) => {
    if (dragging.value) updateFromEvent(e)
}

const endDrag = () => {
    dragging.value = false
}

const resetFocus = () => {
    coords.value = null
    pointPercent.value = null
    save()
}

const save = async () => {
    if (!props.file || saving.value) return
    saving.value = true
    try {
        const res = await axios.post(props.file.api.focus, {
            focus_x: coords.value?.x ?? null,
            focus_y: coords.value?.y ?? null,
        })
        const updated = res.data.data as GalleryFileItem
        emit('updated', updated)
        close()
    } catch (err: any) {
        window.showToast?.(err.response?.data?.message ?? 'Failed to save focus point', 'error')
    } finally {
        saving.value = false
    }
}

const close = () => {
    dialogRef.value?.close()
    emit('close')
}
</script>
