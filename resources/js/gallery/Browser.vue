<template>
    <dialog class="dialog rounded-2xl bg-base-100 text-base-content" id="gallery-dialog" ref="galleryDialog" aria-modal="true" aria-labelledby="modal-card-label">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 class="text-lg font-normal">{{ trans.browse.title }}</h4>
            <button type="button" class="text-base-content cursor-pointer" @click="closeBrowser()" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>

        <article class="max-w-4xl p-4 flex flex-col gap-4 md:min-w-2xl max-h-[75vh] overflow-y-auto">
            <div class="flex flex-wrap gap-2 justify-between items-center" v-if="!error">
                <div class="grow min-w-[180px]">
                    <input
                        type="text"
                        class="w-full"
                        v-model="term"
                        :placeholder="trans.browse.search.placeholder"
                        @input="handleInput"
                    />
                </div>

                <select
                    class="text-xs bg-base-200 rounded-lg px-2 py-1.5"
                    v-model="sort"
                    @change="reloadCurrent"
                >
                    <option value="recent">Recent</option>
                    <option value="name_asc">Name (A-Z)</option>
                    <option value="name_desc">Name (Z-A)</option>
                </select>

                <div class="flex rounded-lg bg-base-200 p-0.5 text-xs gap-0.5 shrink-0">
                    <button
                        type="button"
                        class="rounded px-2 py-1 transition-colors cursor-pointer flex gap-1 items-center"
                        :class="mode === 'large' ? 'bg-base-100' : 'bg-transparent text-neutral-content'"
                        @click="toggle('large')"
                    >
                        <i class="fa-regular fa-grid-2" aria-hidden="true"></i>
                        {{ trans.browse.layouts.large }}
                    </button>
                    <button
                        type="button"
                        class="rounded px-2 py-1 transition-colors cursor-pointer flex gap-1 items-center"
                        :class="mode === 'small' ? 'bg-base-100' : 'bg-transparent text-neutral-content'"
                        @click="toggle('small')"
                    >
                        <i class="fa-regular fa-grid-4" aria-hidden="true"></i>
                        {{ trans.browse.layouts.small }}
                    </button>
                </div>
            </div>

            <!-- Breadcrumbs -->
            <div v-if="!error && breadcrumbs.length > 0" class="flex items-center gap-1.5 flex-wrap text-xs">
                <button type="button" class="hover:underline cursor-pointer text-neutral-content" @click="loadUrl(props.api)">
                    <i class="fa-regular fa-house" aria-hidden="true"></i>
                </button>
                <template v-for="(crumb, idx) in breadcrumbs" :key="crumb.id">
                    <span class="text-neutral-content">/</span>
                    <button
                        type="button"
                        class="cursor-pointer"
                        :class="idx === breadcrumbs.length - 1 ? 'font-semibold' : 'text-neutral-content hover:underline'"
                        @click="loadUrl(crumb.url)"
                    >
                        {{ crumb.name }}
                    </button>
                </template>
            </div>

            <div class="md:h-36 text-center flex items-center justify-center w-full" v-if="loading || searching">
                <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
            </div>

            <template v-else>
                <div class="alert alert-error p-2 rounded-lg" v-if="error">{{ error }}</div>

                <p class="text-sm text-left uppercase font-medium text-neutral-content" v-if="!error && term">
                    {{ trans.browse.search.results?.replace(':term', term) }}
                </p>

                <div class="text-center py-4" v-if="!error && term && !images.length">
                    <i class="fa-regular fa-search text-neutral-content text-2xl mb-4" aria-hidden="true"></i>
                    <p>{{ trans.browse.search.no_results?.replace(':term', term) }}</p>
                    <p class="text-base-content/60 text-sm mt-1">{{ trans.browse.search.try_again }}</p>
                </div>

                <div v-if="!error && folders.length" class="flex flex-wrap gap-2 md:gap-4">
                    <div
                        v-for="folder in folders"
                        :key="folder.uuid || folder.url"
                        class="border border-base-200 rounded-lg flex gap-3 p-3 cursor-pointer hover:shadow-lg w-40 md:w-48 items-center group hover:bg-base-200 justify-between"
                        :title="folder.name"
                        @click="selectImage(folder)"
                    >
                        <div class="rounded-lg flex items-center justify-center w-10 h-10 bg-base-200 group-hover:bg-base-300 flex-none">
                            <i :class="folder.icon" aria-label="Folder" />
                        </div>
                        <div class="flex flex-col grow overflow-hidden">
                            <div class="truncate w-full font-medium" :class="mode === 'large' ? 'text-sm' : 'text-xs'">{{ folder.name }}</div>
                            <div class="text-xs text-neutral-content" v-if="folder.image_count !== null && folder.image_count !== undefined">
                                {{ Number(folder.image_count) === 1 ? trans.browse.folder_count_one : trans.browse.folder_count?.replace(':count', String(folder.image_count)) }}
                            </div>
                        </div>
                        <i class="fa-regular fa-chevron-right text-neutral-content" aria-label="Open folder" v-if="folder.image_count !== undefined && folder.image_count !== null" />
                    </div>
                </div>

                <div :class="gridClass()" v-if="!error && imageItems.length">
                    <div
                        v-for="image in imageItems"
                        :key="image.uuid"
                        class="cursor-pointer shadow-sm rounded-lg hover:shadow-lg overflow-hidden relative group"
                        @click="selectImage(image)"
                    >
                        <img :class="previewSize('object-cover')" :src="image.thumbnail" :alt="image.name" loading="lazy" decoding="async" />
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white px-2 py-1 transition-opacity opacity-100 md:opacity-0 md:group-hover:opacity-100" :title="image.name">
                            <div class="truncate text-sm">{{ image.name }}</div>
                            <div class="truncate text-xs opacity-80" v-if="mode === 'large'">{{ image.ext }} · {{ image.size }}</div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="!error && pagination && pagination.last_page > 1" class="flex items-center justify-between pt-2 text-xs">
                    <button
                        type="button"
                        class="btn2 btn-ghost btn-xs"
                        :disabled="!pagination.prev"
                        @click="loadUrl(pagination.prev)"
                    >
                        <i class="fa-regular fa-chevron-left" aria-hidden="true"></i>
                        Previous
                    </button>
                    <span class="text-neutral-content tabular-nums">
                        Page {{ pagination.current_page }} / {{ pagination.last_page }}
                    </span>
                    <button
                        type="button"
                        class="btn2 btn-ghost btn-xs"
                        :disabled="!pagination.next"
                        @click="loadUrl(pagination.next)"
                    >
                        Next
                        <i class="fa-regular fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            </template>
        </article>
    </dialog>
</template>

<script setup lang="ts">
import { ref, computed, watch, onBeforeMount, onBeforeUnmount } from 'vue'
import axios from 'axios'

const props = defineProps<{
    api: string,
    opened: boolean,
    i18n: unknown,
}>()

const trans = ref<any>(null)

onBeforeMount(() => {
    if (props.i18n && typeof props.i18n === 'string') {
        trans.value = JSON.parse(props.i18n)
    } else {
        trans.value = props.i18n
    }
})

const emit = defineEmits(['selected', 'closed'])

const loading = ref(true)
const searching = ref(false)
const galleryDialog = ref<HTMLDialogElement | null>(null)
const images = ref<any[]>([])
const breadcrumbs = ref<any[]>([])
const pagination = ref<any>(null)
const folders = computed(() => images.value.filter(i => i.folder))
const imageItems = computed(() => images.value.filter(i => !i.folder))
const term = ref('')
const currentBaseUrl = ref(props.api)
const sort = ref(localStorage.getItem('gallery-browser-sort') || 'recent')
const typingTimeout = ref<ReturnType<typeof setTimeout> | null>(null)
const error = ref<string | null>(null)
const debounceDelay = 300
const savedMode = localStorage.getItem('gallery-mode')
const mode = ref(savedMode === 'small' || savedMode === 'large' ? savedMode : 'large')
let abortController: AbortController | null = null

const buildUrl = (baseUrl: string): string => {
    const url = new URL(baseUrl, window.location.origin)
    if (term.value.trim()) {
        url.searchParams.set('term', term.value.trim())
    }
    if (sort.value && sort.value !== 'recent') {
        url.searchParams.set('sort', sort.value)
    }
    return url.toString()
}

const loadUrl = async (rawUrl: string | null) => {
    if (!rawUrl) return
    currentBaseUrl.value = rawUrl
    if (abortController) abortController.abort()
    abortController = new AbortController()
    loading.value = true
    error.value = null

    try {
        const res = await axios.get(buildUrl(rawUrl), { signal: abortController.signal })
        images.value = res.data.images || []
        breadcrumbs.value = res.data.breadcrumbs || []
        pagination.value = res.data.pagination || null
    } catch (err: any) {
        if (axios.isCancel(err)) return
        if (err.response?.status === 403) {
            error.value = `${err.response.data.message} ${trans.value?.browse?.unauthorized ?? ''}`
        } else {
            error.value = 'Failed to load gallery'
        }
    } finally {
        loading.value = false
        searching.value = false
    }
}

const reloadCurrent = () => {
    localStorage.setItem('gallery-browser-sort', sort.value)
    loadUrl(currentBaseUrl.value)
}

const open = () => {
    term.value = ''
    error.value = null
    galleryDialog.value?.showModal()
    loadUrl(props.api)
}

const closeBrowser = () => {
    galleryDialog.value?.close()
    emit('closed')
}

const previewSize = (extra: string) => {
    extra = extra ?? ''
    if (mode.value === 'large') {
        return 'w-40 h-28 md:w-48 md:h-36 ' + extra
    }
    return 'w-24 h-18 ' + extra
}

const gridClass = () => {
    if (mode.value === 'small') {
        return 'flex flex-wrap gap-2 md:gap-2'
    }
    return 'flex flex-wrap gap-2 md:gap-4'
}

const selectImage = (image: any) => {
    if (image.folder) {
        loadUrl(image.url)
        return
    }
    emit('selected', image)
    closeBrowser()
}

watch(() => props.opened, (newVal) => {
    if (newVal) {
        open()
    }
})

const handleInput = () => {
    if (typingTimeout.value) clearTimeout(typingTimeout.value)
    typingTimeout.value = setTimeout(() => {
        searching.value = true
        loadUrl(props.api)
    }, debounceDelay)
}

const toggle = (layout: string) => {
    mode.value = layout
    localStorage.setItem('gallery-mode', layout)
}

onBeforeUnmount(() => {
    abortController?.abort()
    if (typingTimeout.value) clearTimeout(typingTimeout.value)
})
</script>
