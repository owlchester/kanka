<template>
    <div v-if="files.length === 0" class="bg-base-100 rounded-xl p-10 text-center flex flex-col items-center gap-2 text-neutral-content shadow-sm">
        <i class="fa-regular fa-images text-4xl opacity-60" aria-hidden="true"></i>
        <p class="text-base font-medium text-base-content">
            {{ hasFilters ? trans('empty_filtered') : trans('empty_title') }}
        </p>
        <p v-if="canUpload && !hasFilters" class="text-xs">{{ trans('upload_hint') }}</p>
    </div>

    <div
        v-else
        class="grid gap-3 md:gap-4"
        :class="compact
            ? 'grid-cols-2 sm:grid-cols-4 md:grid-cols-5 xl:grid-cols-6'
            : 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5'"
    >
        <GalleryCard
            v-for="file in files"
            :key="file.id"
            :file="file"
            :compact="compact"
            :canManage="canManage"
            :mobileSelectMode="mobileSelectMode"
            :trans="trans"
            @open="$emit('open', $event)"
            @toggle-select="(f, ev) => $emit('toggle-select', f, ev)"
            @lightbox="$emit('lightbox', $event)"
            @copy-url="$emit('copy-url', $event)"
            @copy-admin-link="$emit('copy-admin-link', $event)"
            @delete="$emit('delete', $event)"
            @drag-start="(f, ev) => $emit('drag-start', f, ev)"
            @drop-items="$emit('drop-items', $event)"
            @drop-files="(fl, id) => $emit('drop-files', fl, id)"
        />
    </div>
</template>

<script setup lang="ts">
import type { GalleryFileItem } from '../types'
import GalleryCard from './GalleryCard.vue'

defineProps<{
    files: GalleryFileItem[]
    compact: boolean
    canManage: boolean
    canUpload: boolean
    mobileSelectMode: boolean
    hasFilters: boolean
    trans: (key: string) => string
}>()

defineEmits<{
    (e: 'open', file: GalleryFileItem): void
    (e: 'toggle-select', file: GalleryFileItem, event: MouseEvent): void
    (e: 'lightbox', file: GalleryFileItem): void
    (e: 'copy-url', file: GalleryFileItem): void
    (e: 'copy-admin-link', file: GalleryFileItem): void
    (e: 'delete', file: GalleryFileItem): void
    (e: 'drag-start', file: GalleryFileItem, event: DragEvent): void
    (e: 'drop-items', targetFolderId: string): void
    (e: 'drop-files', files: FileList, targetFolderId: string): void
}>()
</script>
