<template>
    <div
        v-if="selectedFiles.length > 0"
        class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 bg-base-100 rounded-2xl shadow-2xl px-4 py-2.5 flex items-center gap-3 flex-wrap max-w-[95vw]"
    >
        <div class="text-sm font-medium tabular-nums flex items-center gap-2">
            <span class="badge badge-primary badge-sm">{{ selectedFiles.length }}</span>
            <span>{{ trans('selected_count', { count: selectedFiles.length }) }}</span>
            <span class="text-xs text-neutral-content hidden sm:inline">· {{ totalSizeReadable }}</span>
        </div>

        <div class="flex items-center gap-1.5 flex-wrap">
            <button type="button" class="btn2 btn-default btn-sm" @click="$emit('open-bulk-update')">
                <i class="fa-regular fa-folder-arrow-up" aria-hidden="true"></i>
                <span>{{ trans('move_to') }}</span>
            </button>
            <button type="button" class="btn2 btn-error btn-sm" @click="$emit('delete-selected')">
                <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                <span>{{ trans('remove') }}</span>
            </button>
            <button type="button" class="btn2 btn-ghost btn-sm" @click="$emit('clear')">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                <span class="hidden sm:inline">{{ trans('clear') }}</span>
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { GalleryFileItem } from '../types'

const props = defineProps<{
    selectedFiles: GalleryFileItem[]
    trans: (key: string, replacements?: Record<string, string | number>) => string
}>()

defineEmits<{
    (e: 'open-bulk-update'): void
    (e: 'delete-selected'): void
    (e: 'clear'): void
}>()

const totalSizeReadable = computed(() => {
    const kb = props.selectedFiles.reduce((acc, f) => acc + (f.size_kb || 0), 0)
    if (kb >= 1024 * 1024) return (kb / (1024 * 1024)).toFixed(2) + ' GiB'
    if (kb >= 1024) return (kb / 1024).toFixed(2) + ' MiB'
    return `${kb} KiB`
})
</script>
