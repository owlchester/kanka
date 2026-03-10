
<script setup lang="ts">
import { ref, watch, onMounted, onBeforeUnmount } from 'vue'
import axios from 'axios'

interface GalleryImage {
    src: string
    name: string
    folder: boolean
    uuid: string
    icon: string
    url: string | null
    thumbnail: string
}

interface PaginationLinks {
    first: string | null
    last: string | null
    prev: string | null
    next: string | null
}

const props = defineProps<{ galleryId: string }>()

const dialogRef = ref<HTMLDialogElement | null>(null)
const images = ref<GalleryImage[]>([])
const loading = ref(false)
const searchTerm = ref('')
const currentUrl = ref('')
const baseUrl = ref('')
const pagination = ref<PaginationLinks>({
    first: null,
    last: null,
    prev: null,
    next: null,
})
const folderStack = ref<{ url: string; name: string }[]>([])
const editorRef = ref<any>(null)
let abortController: AbortController | null = null
let searchTimeout: ReturnType<typeof setTimeout> | null = null

const openGallery = (event: CustomEvent) => {
    if (event.detail.galleryId !== props.galleryId) return

    editorRef.value = event.detail.editor
    baseUrl.value = event.detail.galleryUrl
    currentUrl.value = `${event.detail.galleryUrl}?setup`
    folderStack.value = []
    searchTerm.value = ''
    loadImages(currentUrl.value)
    dialogRef.value?.showModal()
}

const closeGallery = () => {
    // Clean up pending requests and timeouts
    if (searchTimeout) {
        clearTimeout(searchTimeout)
        searchTimeout = null
    }
    if (abortController) {
        abortController.abort()
        abortController = null
    }
    dialogRef.value?.close()
}

const loadImages = async (url: string) => {
    // Cancel any pending request
    if (abortController) {
        abortController.abort()
    }
    abortController = new AbortController()

    loading.value = true
    try {
        const response = await axios.get(url, {
            signal: abortController.signal
        })
        images.value = response.data.data || []
        pagination.value = {
            first: response.data.links?.first || null,
            last: response.data.links?.last || null,
            prev: response.data.links?.prev || null,
            next: response.data.links?.next || null,
        }
    } catch (error) {
        // Ignore aborted requests
        if (axios.isCancel(error)) {
            return
        }
        console.error('Failed to load gallery images:', error)
        images.value = []
    } finally {
        loading.value = false
    }
}

const search = () => {
    // Clear any pending debounced search
    if (searchTimeout) {
        clearTimeout(searchTimeout)
        searchTimeout = null
    }

    folderStack.value = []
    const url = new URL(baseUrl.value)
    url.searchParams.set('setup', '')
    if (searchTerm.value) {
        url.searchParams.set('term', searchTerm.value)
    }
    currentUrl.value = url.toString()
    loadImages(currentUrl.value)
}

const debouncedSearch = () => {
    // Clear any pending debounced search
    if (searchTimeout) {
        clearTimeout(searchTimeout)
    }

    searchTimeout = setTimeout(() => {
        search()
    }, 500)
}

const handleSearchKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Enter') {
        event.preventDefault()
        search()
    }
}

const clearSearch = () => {
    searchTerm.value = ''
    search()
}

// Watch searchTerm for debounced auto-search
watch(searchTerm, (newValue, oldValue) => {
    // Only trigger debounced search if user is typing (not on clear or programmatic changes)
    if (newValue !== oldValue) {
        debouncedSearch()
    }
})

const openFolder = (image: GalleryImage) => {
    if (!image.folder || !image.url) return

    folderStack.value.push({
        url: currentUrl.value,
        name: image.name,
    })
    currentUrl.value = image.url
    loadImages(image.url)
}

const goBack = () => {
    if (folderStack.value.length === 0) return

    const previous = folderStack.value.pop()
    if (previous) {
        currentUrl.value = previous.url
        loadImages(previous.url)
    }
}

const goToRoot = () => {
    folderStack.value = []
    const url = new URL(baseUrl.value)
    currentUrl.value = url.toString()
    loadImages(currentUrl.value)
}

const loadPage = (url: string | null) => {
    if (!url) return
    currentUrl.value = url
    loadImages(url)
}

const selectImage = (image: GalleryImage) => {
    if (image.folder) {
        openFolder(image)
        return
    }

    // Insert image into editor with uuid
    editorRef.value?.chain().focus().setImage({
        src: image.src,
        alt: image.name,
        'data-gallery-id': image.uuid,
    }).run()
    closeGallery()
}

onMounted(() => {
    window.addEventListener('tiptap:open-gallery', openGallery as EventListener)
})

onBeforeUnmount(() => {
    window.removeEventListener('tiptap:open-gallery', openGallery as EventListener)
    // Clean up pending requests and timeouts
    if (searchTimeout) {
        clearTimeout(searchTimeout)
    }
    if (abortController) {
        abortController.abort()
    }
})
</script>

<template>
    <dialog
        ref="dialogRef"
        class="gallery-dialog rounded-2xl bg-base-100 p-0 backdrop:bg-black/50"
        @click.self="closeGallery"
    >
        <div class="gallery-container w-[800px] max-w-[90vw] max-h-[80vh] flex flex-col">
            <!-- Header -->
            <div class="gallery-header flex items-center justify-between p-4">
                <h2 class="">Gallery</h2>
                <button @click.prevent="closeGallery" class="btn2 btn-ghost">
                    <i class="fa-regular fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <!-- Search & Navigation -->
            <div class="p-4 space-y-3">
                <!-- Search -->
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input
                            v-model="searchTerm"
                            type="text"
                            placeholder="Search images..."
                            class="input input-bordered w-full pr-10"
                            @keydown="handleSearchKeydown"
                        />
                        <button
                            v-if="searchTerm"
                            @click.prevent="clearSearch"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-base-content/50 hover:text-base-content"
                        >
                            <i class="fa-regular fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <button @click.prevent="search" class="btn2 btn-primary">
                        <i class="fa-regular fa-search" aria-hidden="true"></i>
                        Search
                    </button>
                </div>

                <!-- Breadcrumb / Back navigation -->
                <div v-if="folderStack.length > 0" class="flex items-center gap-2 text-sm">
                    <button @click.prevent="goToRoot" class="btn2 btn-ghost btn-xs">
                        <i class="fa-regular fa-home" aria-hidden="true"></i>
                    </button>
                    <span class="text-base-content/50">/</span>
                    <template v-for="(folder, index) in folderStack" :key="index">
                        <span class="text-base-content/70">{{ folder.name }}</span>
                        <span class="text-base-content/50">/</span>
                    </template>
                    <button @click.prevent="goBack" class="btn2 btn-ghost btn-xs">
                        <i class="fa-regular fa-arrow-left" aria-hidden="true"></i>
                        Back
                    </button>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="gallery-content flex-1 min-h-0 overflow-y-auto p-4">
                <div v-if="loading" class="flex items-center justify-center py-12">
                    <i class="fa-solid fa-spinner fa-spin text-2xl" aria-hidden="true"></i>
                </div>

                <div v-else-if="images.length === 0" class="flex items-center justify-center py-12 text-base-content/50">
                    No images found
                </div>

                <div v-else class="grid grid-cols-4 gap-4">
                    <button
                        v-for="image in images"
                        :key="image.uuid"
                        @click.prevent="selectImage(image)"
                        class="gallery-item group relative aspect-square rounded-lg overflow-hidden border border-base-300 hover:border-primary transition-colors cursor-pointer bg-base-200"
                    >
                        <template v-if="image.folder">
                            <div class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                                <i :class="image.icon" class="text-4xl text-neutral-content" aria-hidden="true"></i>
                                <span class="text-sm text-neutral-content truncate max-w-full px-2">{{ image.name }}</span>
                            </div>
                        </template>
                        <template v-else>
                            <img
                                :src="image.thumbnail"
                                :alt="image.name"
                                class="absolute inset-0 w-full h-full object-cover"
                                loading="lazy"
                            />
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-white text-xs truncate block">{{ image.name }}</span>
                            </div>
                        </template>
                    </button>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="pagination.prev || pagination.next" class="gallery-footer flex items-center justify-center gap-2 p-4 border-t border-base-300">
                <button
                    @click.prevent="loadPage(pagination.prev)"
                    :disabled="!pagination.prev"
                    class="btn2 btn-ghost btn-xs"
                >
                    <i class="fa-regular fa-chevron-left" aria-hidden="true"></i>
                    Previous
                </button>
                <button
                    @click.prevent="loadPage(pagination.next)"
                    :disabled="!pagination.next"
                    class="btn2 btn-ghost btn-xs"
                >
                    Next
                    <i class="fa-regular fa-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </dialog>
</template>

<style scoped>
.gallery-dialog::backdrop {
    background: rgba(0, 0, 0, 0.5);
}

.gallery-dialog[open] {
    display: flex;
}

.gallery-item:focus {
    outline: 2px solid oklch(var(--p));
    outline-offset: 2px;
}
</style>
