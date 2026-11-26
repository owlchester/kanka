<template>
    <aside
        v-if="open"
        class="hidden lg:flex flex-col w-60 shrink-0 bg-base-100 rounded-xl p-3 gap-1 self-start sticky top-28 max-h-[calc(100vh-8rem)] overflow-y-auto shadow-sm"
    >
        <div class="flex items-center justify-between px-2 py-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
            <span>{{ trans('folders_title') }}</span>
            <button
                type="button"
                class="text-neutral-content hover:text-base-content cursor-pointer"
                @click="$emit('toggle')"
                title="Collapse"
            >
                <i class="fa-regular fa-angles-left" aria-hidden="true"></i>
            </button>
        </div>

        <div
            class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg cursor-pointer text-sm transition-colors"
            :class="[
                currentFolderId === null ? 'bg-primary/15 text-primary font-medium' : 'hover:bg-base-200',
                dragOverId === 'home' ? 'ring-2 ring-primary bg-primary/10' : ''
            ]"
            @click="$emit('select', null)"
            @dragover.prevent="dragOverId = 'home'"
            @dragleave="dragOverId === 'home' && (dragOverId = null)"
            @drop.prevent="onDrop($event, null)"
        >
            <i class="fa-regular fa-house text-xs w-4 text-center" aria-hidden="true"></i>
            <span class="truncate grow">{{ trans('home') }}</span>
        </div>

        <template v-for="node in flattenedTree" :key="node.id">
            <div
                class="flex items-center gap-1.5 py-1.5 pr-2 rounded-lg cursor-pointer text-sm transition-colors"
                :style="{ paddingLeft: (node.depth * 14 + 10) + 'px' }"
                :class="[
                    currentFolderId === node.id ? 'bg-primary/15 text-primary font-medium' : 'hover:bg-base-200',
                    dragOverId === node.id ? 'ring-2 ring-primary bg-primary/10' : ''
                ]"
                @click="$emit('select', node.id)"
                @dragover.prevent="dragOverId = node.id"
                @dragleave="dragOverId === node.id && (dragOverId = null)"
                @drop.prevent="onDrop($event, node.id)"
            >
                <button
                    v-if="node.hasChildren"
                    type="button"
                    class="w-4 h-4 flex items-center justify-center text-[10px] text-neutral-content hover:text-base-content shrink-0"
                    @click.stop="toggleExpand(node.id)"
                >
                    <i :class="expanded[node.id] ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-right'" aria-hidden="true"></i>
                </button>
                <span v-else class="w-4 shrink-0"></span>

                <i class="fa-regular fa-folder text-xs text-neutral-content shrink-0" aria-hidden="true"></i>
                <span class="truncate grow">{{ node.name }}</span>
                <span class="text-[11px] text-neutral-content tabular-nums">{{ node.items_count }}</span>
            </div>
        </template>
    </aside>
</template>

<script setup lang="ts">
import { computed, reactive, ref } from 'vue'
import type { GalleryFolderNode } from '../types'

const props = defineProps<{
    folders: GalleryFolderNode[]
    currentFolderId: string | null
    open: boolean
    trans: (key: string) => string
}>()

const emit = defineEmits<{
    (e: 'select', folderId: string | null): void
    (e: 'toggle'): void
    (e: 'drop-items', targetFolderId: string | null): void
    (e: 'drop-files', files: FileList, targetFolderId: string | null): void
}>()

const expanded = reactive<Record<string, boolean>>({})
const dragOverId = ref<string | null>(null)

const childrenMap = computed(() => {
    const map = new Map<string, GalleryFolderNode[]>()
    for (const f of props.folders) {
        const key = f.folder_id || '__root__'
        if (!map.has(key)) map.set(key, [])
        map.get(key)!.push(f)
    }
    return map
})

interface FlatNode extends GalleryFolderNode {
    depth: number
    hasChildren: boolean
}

const flattenedTree = computed<FlatNode[]>(() => {
    const result: FlatNode[] = []
    const walk = (parentId: string, depth: number) => {
        const children = childrenMap.value.get(parentId) || []
        for (const child of children) {
            const grandChildren = childrenMap.value.get(child.id) || []
            const hasChildren = grandChildren.length > 0
            result.push({ ...child, depth, hasChildren })
            if (hasChildren && (expanded[child.id] ?? depth === 0)) {
                walk(child.id, depth + 1)
            }
        }
    }
    walk('__root__', 0)
    return result
})

const toggleExpand = (id: string) => {
    expanded[id] = !(expanded[id] ?? true)
}

const onDrop = (e: DragEvent, targetFolderId: string | null) => {
    dragOverId.value = null
    if (e.dataTransfer?.files && e.dataTransfer.files.length > 0) {
        emit('drop-files', e.dataTransfer.files, targetFolderId)
        return
    }
    if (e.dataTransfer?.types.includes('application/x-kanka-gallery')) {
        emit('drop-items', targetFolderId)
    }
}
</script>
