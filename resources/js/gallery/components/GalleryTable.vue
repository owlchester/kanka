<template>
    <div v-if="files.length === 0" class="bg-base-100 rounded-xl p-10 text-center flex flex-col items-center gap-2 text-neutral-content shadow-sm">
        <i class="fa-regular fa-images text-4xl opacity-60" aria-hidden="true"></i>
        <p class="text-base font-medium text-base-content">
            {{ hasFilters ? trans('empty_filtered') : trans('empty_title') }}
        </p>
    </div>

    <div v-else class="bg-base-100 rounded-xl shadow-sm overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase text-neutral-content bg-base-200/60">
                <tr>
                    <th class="p-3 w-10">
                        <input
                            v-if="canManage"
                            type="checkbox"
                            :checked="allSelected"
                            @change="$emit('toggle-select-all')"
                            aria-label="Select all"
                        />
                    </th>
                    <th class="p-3 w-14"></th>
                    <th class="p-3 cursor-pointer hover:text-base-content" @click="toggleNameSort">
                        <span class="inline-flex items-center gap-1">
                            {{ trans('name') }}
                            <i v-if="sort === 'name_asc'" class="fa-solid fa-sort-up" aria-hidden="true"></i>
                            <i v-else-if="sort === 'name_desc'" class="fa-solid fa-sort-down" aria-hidden="true"></i>
                        </span>
                    </th>
                    <th class="p-3 hidden sm:table-cell">{{ trans('file_type') }}</th>
                    <th class="p-3 hidden lg:table-cell">{{ trans('dimensions') }}</th>
                    <th class="p-3 cursor-pointer hover:text-base-content hidden sm:table-cell" @click="toggleSizeSort">
                        <span class="inline-flex items-center gap-1">
                            {{ trans('size') }}
                            <i v-if="sort === 'size_desc'" class="fa-solid fa-sort-down" aria-hidden="true"></i>
                            <i v-else-if="sort === 'size_asc'" class="fa-solid fa-sort-up" aria-hidden="true"></i>
                        </span>
                    </th>
                    <th class="p-3 hidden md:table-cell cursor-pointer hover:text-base-content" @click="toggleUsedSort">
                        <span class="inline-flex items-center gap-1">
                            {{ trans('used_in') }}
                            <i v-if="sort === 'used_desc'" class="fa-solid fa-sort-down" aria-hidden="true"></i>
                            <i v-else-if="sort === 'used_asc'" class="fa-solid fa-sort-up" aria-hidden="true"></i>
                        </span>
                    </th>
                    <th class="p-3 hidden xl:table-cell">{{ trans('uploaded_by') }}</th>
                    <th class="p-3 hidden lg:table-cell cursor-pointer hover:text-base-content" @click="toggleDateSort">
                        <span class="inline-flex items-center gap-1">
                            {{ trans('updated_at') }}
                            <i v-if="sort === 'recent'" class="fa-solid fa-sort-down" aria-hidden="true"></i>
                            <i v-else-if="sort === 'updated_asc'" class="fa-solid fa-sort-up" aria-hidden="true"></i>
                        </span>
                    </th>
                    <th class="p-3 text-right"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-base-200">
                <tr
                    v-for="file in files"
                    :key="file.id"
                    class="hover:bg-base-200/50 transition-colors cursor-pointer"
                    :class="[
                        file.is_selected ? 'bg-primary/10' : '',
                        dragOverId === file.id ? 'ring-2 ring-primary bg-primary/10' : '',
                    ]"
                    :draggable="canManage || file.can_edit"
                    @click="$emit('open', file)"
                    @dragstart="$emit('drag-start', file, $event)"
                    @dragover.prevent="file.is_folder && (dragOverId = file.id)"
                    @dragleave="dragOverId === file.id && (dragOverId = null)"
                    @drop.prevent="onRowDrop($event, file)"
                >
                    <td class="p-3" @click.stop>
                        <input
                            v-if="canManage || file.can_edit"
                            type="checkbox"
                            :checked="file.is_selected"
                            @click="$emit('toggle-select', file, $event)"
                        />
                    </td>
                    <td class="p-2">
                        <div class="w-10 h-10 rounded-lg bg-base-200 overflow-hidden flex items-center justify-center shrink-0">
                            <i v-if="file.is_folder" class="fa-regular fa-folder text-lg text-neutral-content" aria-hidden="true"></i>
                            <span v-else-if="file.is_font" class="text-sm font-serif">Aa</span>
                            <img v-else-if="file.thumbnail" :src="file.thumbnail" :alt="file.name" class="w-full h-full object-cover" loading="lazy" />
                            <i v-else class="fa-regular fa-file-image text-neutral-content" aria-hidden="true"></i>
                        </div>
                    </td>
                    <td class="p-3 max-w-xs">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="font-medium truncate">{{ file.name }}</span>
                            <i v-if="Number(file.visibility_id) > 1" class="fa-regular fa-lock text-xs text-neutral-content shrink-0" :title="trans(`visibility.${file.visibility_id}`)"></i>
                        </div>
                    </td>
                    <td class="p-3 hidden sm:table-cell uppercase text-xs text-neutral-content">
                        {{ file.is_folder ? trans('folders_title') : (file.ext || '—') }}
                    </td>
                    <td class="p-3 hidden lg:table-cell text-xs text-neutral-content tabular-nums">
                        <template v-if="file.width && file.height">{{ file.width }} × {{ file.height }}</template>
                        <template v-else>—</template>
                    </td>
                    <td class="p-3 hidden sm:table-cell text-xs text-neutral-content tabular-nums">
                        {{ file.is_folder ? (file.items_count !== null ? `${file.items_count}` : '—') : file.size }}
                    </td>
                    <td class="p-3 hidden md:table-cell text-xs tabular-nums">
                        <span v-if="!file.is_folder && file.usage_count !== null && file.usage_count > 0" class="text-primary font-medium">
                            {{ file.usage_count }}
                        </span>
                        <span v-else class="text-neutral-content">—</span>
                    </td>
                    <td class="p-3 hidden xl:table-cell text-xs text-neutral-content truncate max-w-[140px]">
                        {{ file.creator }}
                    </td>
                    <td class="p-3 hidden lg:table-cell text-xs text-neutral-content whitespace-nowrap">
                        {{ file.updated_at_human || '—' }}
                    </td>
                    <td class="p-3 text-right whitespace-nowrap" @click.stop>
                        <div class="inline-flex items-center gap-1">
                            <button
                                v-if="!file.is_folder"
                                type="button"
                                class="btn2 btn-ghost btn-xs"
                                @click="$emit('copy-url', file)"
                                :title="trans('copy_url')"
                            >
                                <i class="fa-regular fa-link" aria-hidden="true"></i>
                            </button>
                            <button
                                v-if="!file.is_folder"
                                type="button"
                                class="btn2 btn-ghost btn-xs"
                                @click="$emit('copy-admin-link', file)"
                                :title="trans('copy_admin_link')"
                            >
                                <i class="fa-regular fa-share-nodes" aria-hidden="true"></i>
                            </button>
                            <button
                                v-if="file.can_edit"
                                type="button"
                                class="btn2 btn-ghost btn-xs text-error-content"
                                @click="$emit('delete', file)"
                                :title="trans('delete')"
                            >
                                <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import type { GalleryFileItem, GallerySort } from '../types'

const props = defineProps<{
    files: GalleryFileItem[]
    sort: GallerySort
    canManage: boolean
    hasFilters: boolean
    trans: (key: string) => string
}>()

const emit = defineEmits<{
    (e: 'open', file: GalleryFileItem): void
    (e: 'toggle-select', file: GalleryFileItem, event: MouseEvent): void
    (e: 'toggle-select-all'): void
    (e: 'update:sort', sort: GallerySort): void
    (e: 'copy-url', file: GalleryFileItem): void
    (e: 'copy-admin-link', file: GalleryFileItem): void
    (e: 'delete', file: GalleryFileItem): void
    (e: 'drag-start', file: GalleryFileItem, event: DragEvent): void
    (e: 'drop-items', targetFolderId: string): void
    (e: 'drop-files', files: FileList, targetFolderId: string): void
}>()

const dragOverId = ref<string | null>(null)

const allSelected = computed(() => {
    return props.files.length > 0 && props.files.every(f => f.is_selected)
})

const toggleNameSort = () => {
    emit('update:sort', props.sort === 'name_asc' ? 'name_desc' : 'name_asc')
}

const toggleSizeSort = () => {
    emit('update:sort', props.sort === 'size_desc' ? 'size_asc' : 'size_desc')
}

const toggleDateSort = () => {
    emit('update:sort', props.sort === 'recent' ? 'updated_asc' : 'recent')
}

const toggleUsedSort = () => {
    emit('update:sort', props.sort === 'used_desc' ? 'used_asc' : 'used_desc')
}

const onRowDrop = (e: DragEvent, file: GalleryFileItem) => {
    dragOverId.value = null
    if (!file.is_folder) return
    if (e.dataTransfer?.files && e.dataTransfer.files.length > 0) {
        emit('drop-files', e.dataTransfer.files, file.id)
        return
    }
    if (e.dataTransfer?.types.includes('application/x-kanka-gallery')) {
        emit('drop-items', file.id)
    }
}
</script>
