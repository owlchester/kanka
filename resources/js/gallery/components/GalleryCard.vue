<template>
    <div
        class="group relative rounded-xl bg-base-100 shadow-sm hover:shadow-md transition-all overflow-hidden cursor-pointer select-none flex flex-col"
        :class="[
            file.is_selected ? 'ring-2 ring-primary bg-primary/5' : '',
            isDropTarget ? 'ring-2 ring-primary bg-primary/10 scale-[1.01]' : '',
        ]"
        :draggable="canDrag"
        @click="onClick"
        @dblclick="onDblClick"
        @dragstart="onDragStart"
        @dragover.prevent="onDragOver"
        @dragleave="onDragLeave"
        @drop.prevent="onDrop"
    >
        <!-- Selection checkbox -->
        <button
            v-if="canManage || file.can_edit"
            type="button"
            class="absolute top-2 left-2 z-10 w-6 h-6 rounded-md flex items-center justify-center transition-opacity cursor-pointer"
            :class="[
                file.is_selected || mobileSelectMode
                    ? 'opacity-100 bg-primary text-white shadow'
                    : 'opacity-0 group-hover:opacity-100 bg-base-100/90 text-base-content shadow hover:bg-base-100'
            ]"
            @click.stop="$emit('toggle-select', file, $event)"
            :aria-label="file.is_selected ? 'Deselect' : 'Select'"
        >
            <i :class="file.is_selected ? 'fa-solid fa-check text-xs' : 'fa-regular fa-square text-xs'" aria-hidden="true"></i>
        </button>

        <!-- Quick Menu button -->
        <div
            v-if="!file.is_folder"
            class="absolute top-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1"
        >
            <button
                v-if="file.original"
                type="button"
                class="w-6 h-6 rounded-md bg-base-100/90 hover:bg-base-100 text-base-content shadow flex items-center justify-center cursor-pointer"
                @click.stop="$emit('lightbox', file)"
                title="Preview"
            >
                <i class="fa-regular fa-magnifying-glass-plus text-xs" aria-hidden="true"></i>
            </button>
            <button
                type="button"
                class="w-6 h-6 rounded-md bg-base-100/90 hover:bg-base-100 text-base-content shadow flex items-center justify-center cursor-pointer"
                @click.stop="menuOpen = !menuOpen"
                title="Actions"
            >
                <i class="fa-solid fa-ellipsis-vertical text-xs" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Dropdown menu -->
        <div
            v-if="menuOpen"
            class="absolute top-9 right-2 z-30 w-44 bg-base-100 rounded-xl shadow-xl p-1 text-xs flex flex-col gap-0.5"
            @click.stop
        >
            <button type="button" class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-base-200 text-left cursor-pointer" @click="menuOpen = false; $emit('open', file)">
                <i class="fa-regular fa-circle-info w-3.5 text-center" aria-hidden="true"></i>
                <span>{{ trans('details') }}</span>
            </button>
            <button type="button" class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-base-200 text-left cursor-pointer" @click="menuOpen = false; $emit('copy-url', file)">
                <i class="fa-regular fa-link w-3.5 text-center" aria-hidden="true"></i>
                <span>{{ trans('copy_url') }}</span>
            </button>
            <button type="button" class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-base-200 text-left cursor-pointer" @click="menuOpen = false; $emit('copy-admin-link', file)">
                <i class="fa-regular fa-share-nodes w-3.5 text-center" aria-hidden="true"></i>
                <span>{{ trans('copy_admin_link') }}</span>
            </button>
            <a :href="file.link" :download="file.name" class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-base-200 text-left">
                <i class="fa-regular fa-download w-3.5 text-center" aria-hidden="true"></i>
                <span>{{ trans('download') }}</span>
            </a>
            <button v-if="file.can_edit" type="button" class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-base-200 text-error-content text-left cursor-pointer" @click="menuOpen = false; $emit('delete', file)">
                <i class="fa-regular fa-trash-can w-3.5 text-center" aria-hidden="true"></i>
                <span>{{ trans('delete') }}</span>
            </button>
        </div>

        <!-- Thumbnail / Preview Area -->
        <div :class="compact ? 'h-24' : 'h-36'" class="w-full bg-base-200 relative overflow-hidden">
            <!-- Folder preview -->
            <template v-if="file.is_folder">
                <div v-if="file.thumbnails && file.thumbnails.length === 1" class="w-full h-full bg-cover bg-center" :style="{ backgroundImage: `url('${file.thumbnails[0]}')` }"></div>
                <div v-else-if="file.thumbnails && file.thumbnails.length === 2" class="w-full h-full flex gap-0.5">
                    <div class="w-1/2 h-full bg-cover bg-center" :style="{ backgroundImage: `url('${file.thumbnails[0]}')` }"></div>
                    <div class="w-1/2 h-full bg-cover bg-center" :style="{ backgroundImage: `url('${file.thumbnails[1]}')` }"></div>
                </div>
                <div v-else-if="file.thumbnails && file.thumbnails.length >= 3" class="w-full h-full flex gap-0.5">
                    <div class="w-1/2 h-full bg-cover bg-center" :style="{ backgroundImage: `url('${file.thumbnails[0]}')` }"></div>
                    <div class="w-1/2 h-full flex flex-col gap-0.5">
                        <div class="w-full h-1/2 bg-cover bg-center" :style="{ backgroundImage: `url('${file.thumbnails[1]}')` }"></div>
                        <div class="w-full h-1/2 bg-cover bg-center" :style="{ backgroundImage: `url('${file.thumbnails[2]}')` }"></div>
                    </div>
                </div>
                <div v-else class="w-full h-full flex items-center justify-center text-neutral-content">
                    <i class="fa-regular fa-folder" :class="compact ? 'text-3xl' : 'text-5xl'" aria-hidden="true"></i>
                </div>
                <span v-if="file.items_count !== null" class="absolute bottom-1.5 right-1.5 px-1.5 py-0.5 rounded bg-black/60 text-white text-[10px] tabular-nums">
                    {{ file.items_count }}
                </span>
            </template>

            <!-- Font preview -->
            <template v-else-if="file.is_font">
                <div class="w-full h-full flex flex-col items-center justify-center gap-1 text-base-content/70">
                    <span class="text-3xl font-serif tracking-tight">Aa</span>
                    <span class="text-[10px] uppercase tracking-wider px-1.5 py-0.5 rounded bg-base-300">{{ file.ext }}</span>
                </div>
            </template>

            <!-- Raster / SVG image -->
            <template v-else-if="file.thumbnail">
                <img
                    :src="file.thumbnail"
                    :alt="file.name"
                    loading="lazy"
                    decoding="async"
                    class="w-full h-full"
                    :class="file.is_svg ? 'object-contain p-2' : 'object-cover'"
                />
                <span v-if="file.is_svg" class="absolute bottom-1.5 right-1.5 px-1.5 py-0.5 rounded bg-black/60 text-white text-[10px] uppercase">SVG</span>
            </template>

            <!-- Fallback -->
            <template v-else>
                <div class="w-full h-full flex items-center justify-center text-neutral-content">
                    <i class="fa-regular fa-file-image text-3xl" aria-hidden="true"></i>
                </div>
            </template>
        </div>

        <!-- Card Footer -->
        <div :class="compact ? 'p-2' : 'p-2.5 md:p-3'" class="flex flex-col gap-1 min-w-0">
            <div class="flex items-center gap-1.5 min-w-0">
                <i v-if="file.is_folder" class="fa-regular fa-folder text-xs text-neutral-content shrink-0" aria-hidden="true"></i>
                <span class="text-sm font-medium truncate grow" :title="file.name">{{ file.name }}</span>
                <i v-if="Number(file.visibility_id) > 1" :class="visibilityIcon" class="text-xs text-neutral-content shrink-0" :title="visibilityTitle" aria-hidden="true"></i>
            </div>

            <div v-if="!compact && !file.is_folder" class="flex items-center justify-between gap-2 text-[11px] text-neutral-content tabular-nums">
                <span>{{ file.size }}<template v-if="file.ext"> · {{ file.ext.toUpperCase() }}</template></span>
                <span v-if="file.usage_count !== null && file.usage_count > 0" class="inline-flex items-center gap-1 text-primary font-medium">
                    <i class="fa-regular fa-cubes text-[10px]" aria-hidden="true"></i>
                    {{ file.usage_count }}
                </span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import type { GalleryFileItem } from '../types'

const props = defineProps<{
    file: GalleryFileItem
    compact: boolean
    canManage: boolean
    mobileSelectMode: boolean
    trans: (key: string) => string
}>()

const emit = defineEmits<{
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

const menuOpen = ref(false)
const isDropTarget = ref(false)

const canDrag = computed(() => props.canManage || props.file.can_edit)

const visibilityIcon = computed(() => {
    switch (Number(props.file.visibility_id)) {
        case 2: return 'fa-regular fa-lock'
        case 3: return 'fa-regular fa-user-lock'
        case 4: return 'fa-regular fa-user-secret'
        case 5: return 'fa-regular fa-users'
        default: return 'fa-regular fa-eye'
    }
})

const visibilityTitle = computed(() => props.trans(`visibility.${props.file.visibility_id}`))

const onClick = (e: MouseEvent) => {
    if (menuOpen.value) {
        menuOpen.value = false
        return
    }
    if (props.mobileSelectMode || e.shiftKey) {
        emit('toggle-select', props.file, e)
        return
    }
    emit('open', props.file)
}

const onDblClick = () => {
    if (!props.file.is_folder && props.file.original) {
        emit('lightbox', props.file)
    }
}

const onDragStart = (e: DragEvent) => {
    emit('drag-start', props.file, e)
}

const onDragOver = (e: DragEvent) => {
    if (!props.file.is_folder) return
    if (e.dataTransfer?.files?.length || e.dataTransfer?.types.includes('application/x-kanka-gallery')) {
        isDropTarget.value = true
    }
}

const onDragLeave = () => {
    isDropTarget.value = false
}

const onDrop = (e: DragEvent) => {
    isDropTarget.value = false
    if (!props.file.is_folder) return
    if (e.dataTransfer?.files && e.dataTransfer.files.length > 0) {
        emit('drop-files', e.dataTransfer.files, props.file.id)
        return
    }
    if (e.dataTransfer?.types.includes('application/x-kanka-gallery')) {
        emit('drop-items', props.file.id)
    }
}
</script>
