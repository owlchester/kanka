<template>
    <div class="flex flex-col gap-2 sticky top-12 z-40">
        <div class="bg-base-100 rounded-xl p-2.5 md:p-3 shadow-sm flex flex-wrap items-center gap-2">
            <!-- Sidebar toggle (desktop) -->
            <button
                v-if="!sidebarOpen"
                type="button"
                class="hidden lg:inline-flex btn2 btn-default btn-sm"
                @click="$emit('toggle-sidebar')"
                :title="trans('folders_title')"
            >
                <i class="fa-regular fa-sidebar" aria-hidden="true"></i>
            </button>

            <!-- Search + Scope -->
            <div class="flex items-center gap-1 grow min-w-[200px]">
                <div class="relative flex items-center grow">
                    <i class="fa-regular fa-magnifying-glass absolute left-3 text-neutral-content text-xs pointer-events-none" aria-hidden="true"></i>
                    <input
                        ref="searchInputRef"
                        type="text"
                        class="w-full pl-9! pr-8! py-1.5 text-sm rounded-lg bg-base-200 focus:outline-none focus:ring-2 focus:ring-primary/40"
                        :value="q"
                        :placeholder="trans('search_placeholder')"
                        @input="onSearchInput"
                    />
                    <button
                        v-if="q"
                        type="button"
                        class="absolute right-2.5 text-neutral-content hover:text-base-content text-xs cursor-pointer"
                        @click="$emit('update:q', '')"
                        aria-label="Clear search"
                    >
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>

                <select
                    v-if="currentFolderId && q"
                    class="text-xs bg-base-200 rounded-lg px-2 py-1.5 shrink-0"
                    :value="scope"
                    @change="$emit('update:scope', ($event.target as HTMLSelectElement).value as any)"
                >
                    <option value="all">{{ trans('scope_all') }}</option>
                    <option value="folder">{{ trans('scope_folder') }}</option>
                </select>
            </div>

            <!-- Filter Popover -->
            <div class="relative" ref="filterWrapRef">
                <button
                    type="button"
                    class="btn2 btn-default btn-sm whitespace-nowrap"
                    :class="activeFilterCount > 0 ? 'ring-1 ring-primary text-primary' : ''"
                    @click="showFilters = !showFilters; showSort = false; showUploadMenu = false"
                >
                    <i class="fa-regular fa-filter" aria-hidden="true"></i>
                    <span class="hidden md:inline">{{ trans('filters') }}</span>
                    <span v-if="activeFilterCount > 0" class="badge badge-xs badge-primary">{{ activeFilterCount }}</span>
                </button>

                <div
                    v-if="showFilters"
                    class="absolute right-0 top-full mt-1.5 w-72 bg-base-100 rounded-xl shadow-xl p-4 z-50 flex flex-col gap-3 text-sm"
                >
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('usage_label') }}</label>
                        <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5 text-sm" :value="usage" @change="$emit('update:usage', ($event.target as HTMLSelectElement).value as any)">
                            <option value="all">{{ trans('usage_all') }}</option>
                            <option value="unused">{{ trans('usage_unused') }}</option>
                            <option value="used">{{ trans('usage_used') }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('type_label') }}</label>
                        <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5 text-sm" :value="type" @change="$emit('update:type', ($event.target as HTMLSelectElement).value as any)">
                            <option value="all">{{ trans('type_all') }}</option>
                            <option value="image">{{ trans('type_image') }}</option>
                            <option value="svg">{{ trans('type_svg') }}</option>
                            <option value="font">{{ trans('type_font') }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('orientation_label') }}</label>
                        <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5 text-sm" :value="orientation" @change="$emit('update:orientation', ($event.target as HTMLSelectElement).value as any)">
                            <option value="all">{{ trans('orientation_all') }}</option>
                            <option value="landscape">{{ trans('orientation_landscape') }}</option>
                            <option value="portrait">{{ trans('orientation_portrait') }}</option>
                            <option value="square">{{ trans('orientation_square') }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('visibility') }}</label>
                        <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5 text-sm" :value="visibilityId" @change="$emit('update:visibilityId', ($event.target as HTMLSelectElement).value)">
                            <option value="all">{{ trans('all') }}</option>
                            <option v-for="(label, id) in visibilities" :key="id" :value="String(id)">{{ label }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1" v-if="uploaders.length > 0">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('uploader_label') }}</label>
                        <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5 text-sm" :value="createdBy" @change="$emit('update:createdBy', ($event.target as HTMLSelectElement).value)">
                            <option value="all">{{ trans('all') }}</option>
                            <option v-for="u in uploaders" :key="u.id" :value="String(u.id)">{{ u.name }}</option>
                        </select>
                    </div>

                    <div class="flex justify-end pt-1" v-if="activeFilterCount > 0">
                        <button type="button" class="btn2 btn-ghost btn-xs" @click="$emit('reset-filters'); showFilters = false">
                            {{ trans('reset_filters') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sort Dropdown -->
            <div class="relative" ref="sortWrapRef">
                <button
                    type="button"
                    class="btn2 btn-default btn-sm whitespace-nowrap"
                    @click="showSort = !showSort; showFilters = false; showUploadMenu = false"
                >
                    <i class="fa-regular fa-arrow-up-arrow-down" aria-hidden="true"></i>
                    <span class="hidden md:inline">{{ currentSortLabel }}</span>
                </button>

                <div
                    v-if="showSort"
                    class="absolute right-0 top-full mt-1.5 w-52 bg-base-100 rounded-xl shadow-xl p-1.5 z-50 flex flex-col gap-0.5 text-sm"
                >
                    <button
                        v-for="opt in sortOptions"
                        :key="opt.value"
                        type="button"
                        class="flex items-center gap-2 px-2.5 py-2 rounded-lg text-left hover:bg-base-200 transition-colors cursor-pointer"
                        :class="sort === opt.value ? 'bg-base-200 font-medium' : ''"
                        @click="$emit('update:sort', opt.value); showSort = false"
                    >
                        <i class="fa-regular fa-check w-4 text-xs" :class="sort === opt.value ? 'opacity-100 text-primary' : 'opacity-0'" aria-hidden="true"></i>
                        <span>{{ opt.label }}</span>
                    </button>
                </div>
            </div>

            <!-- View Switcher -->
            <div class="flex rounded-lg bg-base-200 p-0.5 text-xs gap-0.5 shrink-0">
                <button
                    type="button"
                    class="rounded-md px-2 py-1.5 transition-colors cursor-pointer flex gap-1 items-center"
                    :class="view === 'grid-md' ? 'bg-base-100 shadow-xs font-medium' : 'text-neutral-content hover:text-base-content'"
                    @click="$emit('update:view', 'grid-md')"
                    :title="trans('views_grid')"
                >
                    <i class="fa-regular fa-grid-2" aria-hidden="true"></i>
                    <span class="hidden xl:inline">{{ trans('views_grid') }}</span>
                </button>
                <button
                    type="button"
                    class="rounded-md px-2 py-1.5 transition-colors cursor-pointer flex gap-1 items-center"
                    :class="view === 'grid-sm' ? 'bg-base-100 shadow-xs font-medium' : 'text-neutral-content hover:text-base-content'"
                    @click="$emit('update:view', 'grid-sm')"
                    :title="trans('views_compact')"
                >
                    <i class="fa-regular fa-grid-4" aria-hidden="true"></i>
                    <span class="hidden xl:inline">{{ trans('views_compact') }}</span>
                </button>
                <button
                    type="button"
                    class="rounded-md px-2 py-1.5 transition-colors cursor-pointer flex gap-1 items-center"
                    :class="view === 'table' ? 'bg-base-100 shadow-xs font-medium' : 'text-neutral-content hover:text-base-content'"
                    @click="$emit('update:view', 'table')"
                    :title="trans('views_table')"
                >
                    <i class="fa-regular fa-table-list" aria-hidden="true"></i>
                    <span class="hidden xl:inline">{{ trans('views_table') }}</span>
                </button>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center gap-1.5 shrink-0">
                <button
                    v-if="currentFolderId"
                    type="button"
                    class="btn2 btn-default btn-sm whitespace-nowrap"
                    @click="$emit('open-folder-details')"
                    :title="trans('details')"
                >
                    <i class="fa-regular fa-clipboard" aria-hidden="true"></i>
                    <span class="hidden sm:inline">{{ trans('details') }}</span>
                </button>

                <button
                    v-if="canManage"
                    type="button"
                    class="btn2 btn-default btn-sm whitespace-nowrap"
                    @click="$emit('new-folder')"
                    :title="trans('new_folder')"
                >
                    <i class="fa-regular fa-folder-plus" aria-hidden="true"></i>
                    <span class="hidden sm:inline">{{ trans('new_folder') }}</span>
                </button>

                <button
                    v-if="canManage"
                    type="button"
                    class="md:hidden btn2 btn-sm"
                    :class="mobileSelectMode ? 'btn-primary' : 'btn-default'"
                    @click="$emit('toggle-mobile-select')"
                >
                    <i class="fa-regular fa-list-check" aria-hidden="true"></i>
                </button>

                <div v-if="canUpload" class="relative" ref="uploadWrapRef">
                    <div class="inline-flex items-stretch">
                        <button
                            type="button"
                            class="btn2 btn-primary btn-sm whitespace-nowrap rounded-r-none!"
                            @click="$emit('trigger-upload')"
                        >
                            <i class="fa-regular fa-upload" aria-hidden="true"></i>
                            <span class="hidden sm:inline">{{ trans('upload_files') }}</span>
                        </button>
                        <button
                            type="button"
                            class="btn2 btn-primary btn-sm rounded-l-none! px-2! border-l border-white/20"
                            @click="showUploadMenu = !showUploadMenu; showFilters = false; showSort = false"
                            aria-label="More upload options"
                        >
                            <i class="fa-solid fa-chevron-down text-[10px]" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div
                        v-if="showUploadMenu"
                        class="absolute right-0 top-full mt-1.5 w-48 bg-base-100 rounded-xl shadow-xl p-1.5 z-50 flex flex-col gap-0.5 text-sm"
                    >
                        <button
                            type="button"
                            class="flex items-center gap-2 px-2.5 py-2 rounded-lg text-left hover:bg-base-200 cursor-pointer"
                            @click="showUploadMenu = false; $emit('trigger-upload')"
                        >
                            <i class="fa-regular fa-upload w-4 text-center" aria-hidden="true"></i>
                            <span>{{ trans('upload_files') }}</span>
                        </button>
                        <button
                            type="button"
                            class="flex items-center gap-2 px-2.5 py-2 rounded-lg text-left hover:bg-base-200 cursor-pointer"
                            @click="showUploadMenu = false; $emit('open-url-upload')"
                        >
                            <i class="fa-regular fa-link w-4 text-center" aria-hidden="true"></i>
                            <span>{{ trans('upload_url') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Filter Chips -->
        <div v-if="activeChips.length > 0" class="flex flex-wrap items-center gap-1.5 px-1">
            <span
                v-for="chip in activeChips"
                :key="chip.key"
                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-base-100 text-xs shadow-xs"
            >
                <span class="text-neutral-content">{{ chip.label }}:</span>
                <span class="font-medium">{{ chip.value }}</span>
                <button
                    type="button"
                    class="text-neutral-content hover:text-base-content cursor-pointer"
                    @click="chip.clear()"
                    aria-label="Remove filter"
                >
                    <i class="fa-solid fa-xmark text-[10px]" aria-hidden="true"></i>
                </button>
            </span>
            <button
                type="button"
                class="text-xs text-primary hover:underline px-1 cursor-pointer"
                @click="$emit('reset-filters')"
            >
                {{ trans('reset_filters') }}
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'
import type {
    GalleryFileType,
    GalleryOrientation,
    GalleryScope,
    GallerySort,
    GalleryUploader,
    GalleryUsage,
    GalleryViewMode,
} from '../types'

const props = defineProps<{
    q: string
    scope: GalleryScope
    usage: GalleryUsage
    type: GalleryFileType
    orientation: GalleryOrientation
    visibilityId: string
    createdBy: string
    sort: GallerySort
    view: GalleryViewMode
    currentFolderId: string | null
    sidebarOpen: boolean
    canManage: boolean
    canUpload: boolean
    mobileSelectMode: boolean
    activeFilterCount: number
    visibilities: Record<string, string>
    uploaders: GalleryUploader[]
    trans: (key: string) => string
}>()

const emit = defineEmits<{
    (e: 'update:q', v: string): void
    (e: 'update:scope', v: GalleryScope): void
    (e: 'update:usage', v: GalleryUsage): void
    (e: 'update:type', v: GalleryFileType): void
    (e: 'update:orientation', v: GalleryOrientation): void
    (e: 'update:visibilityId', v: string): void
    (e: 'update:createdBy', v: string): void
    (e: 'update:sort', v: GallerySort): void
    (e: 'update:view', v: GalleryViewMode): void
    (e: 'reset-filters'): void
    (e: 'toggle-sidebar'): void
    (e: 'toggle-mobile-select'): void
    (e: 'open-folder-details'): void
    (e: 'new-folder'): void
    (e: 'trigger-upload'): void
    (e: 'open-url-upload'): void
}>()

const showFilters = ref(false)
const showSort = ref(false)
const showUploadMenu = ref(false)
const searchInputRef = ref<HTMLInputElement | null>(null)
const filterWrapRef = ref<HTMLElement | null>(null)
const sortWrapRef = ref<HTMLElement | null>(null)
const uploadWrapRef = ref<HTMLElement | null>(null)

let debounceTimer: ReturnType<typeof setTimeout> | null = null

const onSearchInput = (e: Event) => {
    const val = (e.target as HTMLInputElement).value
    if (debounceTimer) clearTimeout(debounceTimer)
    debounceTimer = setTimeout(() => {
        emit('update:q', val)
    }, 280)
}

const sortOptions = computed<{ value: GallerySort; label: string }[]>(() => [
    { value: 'recent', label: props.trans('sort_default') },
    { value: 'updated_asc', label: props.trans('sort_updated_asc') },
    { value: 'oldest', label: props.trans('sort_oldest') },
    { value: 'name_asc', label: props.trans('sort_asc') },
    { value: 'name_desc', label: props.trans('sort_desc') },
    { value: 'size_desc', label: props.trans('sort_size_desc') },
    { value: 'size_asc', label: props.trans('sort_size_asc') },
    { value: 'used_desc', label: props.trans('sort_used_desc') },
    { value: 'used_asc', label: props.trans('sort_used_asc') },
])

const currentSortLabel = computed(() => {
    return sortOptions.value.find(o => o.value === props.sort)?.label ?? props.trans('sort')
})

const activeChips = computed(() => {
    const chips: Array<{ key: string; label: string; value: string; clear: () => void }> = []
    if (props.usage !== 'all') {
        chips.push({
            key: 'usage',
            label: props.trans('usage_label'),
            value: props.trans(props.usage === 'unused' ? 'usage_unused' : 'usage_used'),
            clear: () => emit('update:usage', 'all'),
        })
    }
    if (props.type !== 'all') {
        chips.push({
            key: 'type',
            label: props.trans('type_label'),
            value: props.trans(`type_${props.type}`),
            clear: () => emit('update:type', 'all'),
        })
    }
    if (props.orientation !== 'all') {
        chips.push({
            key: 'orientation',
            label: props.trans('orientation_label'),
            value: props.trans(`orientation_${props.orientation}`),
            clear: () => emit('update:orientation', 'all'),
        })
    }
    if (props.visibilityId !== 'all') {
        chips.push({
            key: 'visibility',
            label: props.trans('visibility'),
            value: props.visibilities[props.visibilityId] ?? props.visibilityId,
            clear: () => emit('update:visibilityId', 'all'),
        })
    }
    if (props.createdBy !== 'all') {
        const u = props.uploaders.find(x => String(x.id) === props.createdBy)
        chips.push({
            key: 'uploader',
            label: props.trans('uploader_label'),
            value: u?.name ?? props.createdBy,
            clear: () => emit('update:createdBy', 'all'),
        })
    }
    return chips
})

const handleOutsideClick = (e: MouseEvent) => {
    const target = e.target as Node
    if (showFilters.value && !filterWrapRef.value?.contains(target)) showFilters.value = false
    if (showSort.value && !sortWrapRef.value?.contains(target)) showSort.value = false
    if (showUploadMenu.value && !uploadWrapRef.value?.contains(target)) showUploadMenu.value = false
}

const focusSearch = () => {
    searchInputRef.value?.focus()
    searchInputRef.value?.select()
}

defineExpose({ focusSearch })

onMounted(() => document.addEventListener('click', handleOutsideClick))
onBeforeUnmount(() => document.removeEventListener('click', handleOutsideClick))
</script>
