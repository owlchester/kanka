<template>
    <Teleport to="body">
        <div
            v-if="open && file"
            class="fixed inset-0 z-[1150] bg-black/90 text-white flex flex-col"
            @click.self="$emit('close')"
        >
        <!-- Top bar -->
        <div class="flex items-center justify-between gap-4 px-4 py-3 bg-black/40">
            <div class="min-w-0 flex items-center gap-3">
                <span class="font-medium truncate">{{ file.name }}</span>
                <span v-if="file.width && file.height" class="text-xs text-white/60 tabular-nums hidden sm:inline">
                    {{ file.width }} × {{ file.height }}
                </span>
                <span class="text-xs text-white/60 tabular-nums hidden sm:inline">{{ file.size }}</span>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <button type="button" class="btn2 btn-ghost btn-sm text-white" @click="zoomed = !zoomed" :title="zoomed ? 'Fit' : 'Zoom'">
                    <i :class="zoomed ? 'fa-regular fa-magnifying-glass-minus' : 'fa-regular fa-magnifying-glass-plus'" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn2 btn-ghost btn-sm text-white" @click="$emit('copy-url', file)" :title="trans('copy_url')">
                    <i class="fa-regular fa-link" aria-hidden="true"></i>
                </button>
                <a :href="file.link" :download="file.name" class="btn2 btn-ghost btn-sm text-white" :title="trans('download')">
                    <i class="fa-regular fa-download" aria-hidden="true"></i>
                </a>
                <button type="button" class="btn2 btn-ghost btn-sm text-white" @click="$emit('close')" aria-label="Close">
                    <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Image stage -->
        <div class="relative flex-1 min-h-0 flex items-center justify-center p-4 overflow-auto" @click.self="$emit('close')">
            <button
                v-if="hasPrev"
                type="button"
                class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/60 hover:bg-black/80 flex items-center justify-center cursor-pointer z-10"
                @click.stop="$emit('prev')"
                aria-label="Previous"
            >
                <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
            </button>

            <img
                :src="file.original || file.link"
                :alt="file.name"
                class="transition-transform duration-150 select-none"
                :class="zoomed ? 'max-w-none cursor-zoom-out' : 'max-w-full max-h-full object-contain cursor-zoom-in'"
                @click.stop="zoomed = !zoomed"
            />

            <button
                v-if="hasNext"
                type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/60 hover:bg-black/80 flex items-center justify-center cursor-pointer z-10"
                @click.stop="$emit('next')"
                aria-label="Next"
            >
                <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Bottom caption -->
        <div v-if="file.description || file.author" class="px-4 py-2.5 bg-black/40 text-xs text-white/80 flex flex-wrap items-center justify-center gap-4">
            <span v-if="file.description">{{ file.description }}</span>
            <span v-if="file.author" class="text-white/60">{{ file.author }}</span>
        </div>
        </div>
    </Teleport>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import type { GalleryFileItem } from '../types'

const props = defineProps<{
    open: boolean
    file: GalleryFileItem | null
    hasPrev: boolean
    hasNext: boolean
    trans: (key: string) => string
}>()

defineEmits<{
    (e: 'close'): void
    (e: 'prev'): void
    (e: 'next'): void
    (e: 'copy-url', file: GalleryFileItem): void
}>()

const zoomed = ref(false)

watch(() => props.file?.id, () => {
    zoomed.value = false
})
</script>
