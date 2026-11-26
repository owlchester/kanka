<template>
    <div v-if="!initiated" class="text-center text-4xl p-8">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
    </div>

    <div
        v-else
        class="flex flex-col gap-3 md:gap-4 relative"
        @dragenter.prevent="onGalleryDragEnter"
        @dragover.prevent
        @dragleave="onGalleryDragLeave"
        @drop.prevent="onGalleryDrop"
    >
        <!-- Full-area OS File Drop Overlay -->
        <Teleport to="body">
            <div
                v-if="osDragging && setup?.acl.upload"
                class="fixed inset-0 z-[1120] bg-primary/15 backdrop-blur-[2px] border-4 border-dashed border-primary rounded-2xl m-3 flex flex-col items-center justify-center gap-3 pointer-events-none"
            >
                <i class="fa-regular fa-cloud-arrow-up text-5xl text-primary" aria-hidden="true"></i>
                <p class="text-lg font-semibold text-base-content">
                    {{ trans('drop_to_upload') }}
                    <span v-if="currentFolder" class="text-primary">({{ currentFolder.name }})</span>
                </p>
            </div>
        </Teleport>

        <!-- Storage Bar -->
        <StorageBar
            v-if="setup"
            :used="usedSpace"
            :total="setup.space.total"
            :premium="setup.acl.premium"
            :isWyvern="setup.acl.wyvern"
            :isElemental="setup.acl.elemental"
            :upgradeLink="setup.upgrade"
            :trans="trans"
            @cleanup="applyCleanupPreset"
        />

        <!-- Sticky Toolbar -->
        <GalleryToolbar
            v-if="setup"
            ref="toolbarRef"
            :q="state.q"
            :scope="state.scope"
            :usage="state.usage"
            :type="state.type"
            :orientation="state.orientation"
            :visibilityId="state.visibilityId"
            :createdBy="state.createdBy"
            :sort="state.sort"
            :view="state.view"
            :currentFolderId="state.folderId"
            :sidebarOpen="state.sidebarOpen"
            :canManage="setup.acl.manage"
            :canUpload="setup.acl.upload"
            :mobileSelectMode="mobileSelectMode"
            :activeFilterCount="activeFilterCount"
            :visibilities="setup.visibilities"
            :uploaders="setup.uploaders"
            :trans="trans"
            @update:q="v => { state.q = v; state.page = 1; fetchItems() }"
            @update:scope="v => { state.scope = v; state.page = 1; persistPrefs(); fetchItems() }"
            @update:usage="v => { state.usage = v; state.page = 1; fetchItems() }"
            @update:type="v => { state.type = v; state.page = 1; fetchItems() }"
            @update:orientation="v => { state.orientation = v; state.page = 1; fetchItems() }"
            @update:visibilityId="v => { state.visibilityId = v; state.page = 1; fetchItems() }"
            @update:createdBy="v => { state.createdBy = v; state.page = 1; fetchItems() }"
            @update:sort="v => { state.sort = v; state.page = 1; persistPrefs(); fetchItems() }"
            @update:view="v => { state.view = v; persistPrefs() }"
            @reset-filters="resetFilters"
            @toggle-sidebar="state.sidebarOpen = !state.sidebarOpen; persistPrefs()"
            @toggle-mobile-select="mobileSelectMode = !mobileSelectMode"
            @open-folder-details="openFolderDetails"
            @new-folder="openNewFolderModal"
            @trigger-upload="fileInputRef?.click()"
            @open-url-upload="openUrlUploadModal"
        />

        <!-- Hidden Upload Input -->
        <input
            ref="fileInputRef"
            type="file"
            multiple
            accept="image/*, .svg, font/woff2, .woff2"
            class="hidden"
            @change="onFilesSelected"
        />

        <!-- Mobile Folder Jump + Breadcrumbs -->
        <div class="flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-1.5 flex-wrap text-sm md:text-base">
                <button
                    type="button"
                    class="px-2 py-1 rounded-lg hover:bg-base-100 cursor-pointer flex items-center gap-1.5 transition-colors"
                    :class="[
                        !state.folderId ? 'font-semibold text-base-content' : 'text-neutral-content',
                        breadcrumbDragOver === 'home' ? 'ring-2 ring-primary bg-primary/10' : ''
                    ]"
                    @click="navigateToFolder(null)"
                    @dragover.prevent="breadcrumbDragOver = 'home'"
                    @dragleave="breadcrumbDragOver === 'home' && (breadcrumbDragOver = null)"
                    @drop.prevent="onBreadcrumbDrop($event, null)"
                >
                    <i class="fa-regular fa-house text-xs" aria-hidden="true"></i>
                    <span>{{ trans('home') }}</span>
                </button>

                <template v-for="crumb in breadcrumbs" :key="crumb.id">
                    <i class="fa-solid fa-chevron-right text-xs text-neutral-content" aria-hidden="true"></i>
                    <button
                        type="button"
                        class="px-2 py-1 rounded-lg hover:bg-base-100 cursor-pointer text-neutral-content transition-colors"
                        :class="breadcrumbDragOver === crumb.id ? 'ring-2 ring-primary bg-primary/10' : ''"
                        @click="navigateToFolder(crumb.id)"
                        @dragover.prevent="breadcrumbDragOver = crumb.id"
                        @dragleave="breadcrumbDragOver === crumb.id && (breadcrumbDragOver = null)"
                        @drop.prevent="onBreadcrumbDrop($event, crumb.id)"
                    >
                        {{ crumb.name }}
                    </button>
                </template>

                <template v-if="currentFolder">
                    <i class="fa-solid fa-chevron-right text-xs text-neutral-content" aria-hidden="true"></i>
                    <span class="px-2 py-1 font-semibold">{{ currentFolder.name }}</span>
                </template>
            </div>

            <!-- Mobile folder jump -->
            <select
                v-if="setup && setup.folder_tree.length > 0"
                class="lg:hidden text-xs bg-base-100 rounded-lg px-2.5 py-1.5 shadow-xs max-w-[180px]"
                :value="state.folderId || ''"
                @change="navigateToFolder(($event.target as HTMLSelectElement).value || null)"
            >
                <option value="">{{ trans('home') }}</option>
                <option v-for="f in setup.folder_tree" :key="f.id" :value="f.id">{{ f.name }}</option>
            </select>
        </div>

        <!-- Main Layout: Folder Tree + Content -->
        <div class="flex gap-4 items-start">
            <FolderTree
                v-if="setup"
                :folders="setup.folder_tree"
                :currentFolderId="state.folderId"
                :open="state.sidebarOpen"
                :trans="trans"
                @select="navigateToFolder"
                @toggle="state.sidebarOpen = !state.sidebarOpen; persistPrefs()"
                @drop-items="moveDraggedToFolder"
                @drop-files="enqueueFiles"
            />

            <div class="flex-1 min-w-0 flex flex-col gap-3">
                <div v-if="loading" class="bg-base-100 rounded-xl p-12 text-center text-3xl shadow-sm">
                    <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
                </div>

                <template v-else-if="setup">
                    <GalleryTable
                        v-if="state.view === 'table'"
                        :files="files"
                        :sort="state.sort"
                        :canManage="setup.acl.manage"
                        :hasFilters="hasActiveFiltersOrSearch"
                        :trans="trans"
                        @open="openItem"
                        @toggle-select="toggleSelect"
                        @toggle-select-all="toggleSelectAll"
                        @update:sort="v => { state.sort = v; state.page = 1; persistPrefs(); fetchItems() }"
                        @copy-url="copyUrl"
                        @copy-admin-link="copyAdminLink"
                        @delete="requestDeleteSingle"
                        @drag-start="onItemDragStart"
                        @drop-items="moveDraggedToFolder"
                        @drop-files="enqueueFiles"
                    />

                    <GalleryGrid
                        v-else
                        :files="files"
                        :compact="state.view === 'grid-sm'"
                        :canManage="setup.acl.manage"
                        :canUpload="setup.acl.upload"
                        :mobileSelectMode="mobileSelectMode"
                        :hasFilters="hasActiveFiltersOrSearch"
                        :trans="trans"
                        @open="openItem"
                        @toggle-select="toggleSelect"
                        @lightbox="openLightbox"
                        @copy-url="copyUrl"
                        @copy-admin-link="copyAdminLink"
                        @delete="requestDeleteSingle"
                        @drag-start="onItemDragStart"
                        @drop-items="moveDraggedToFolder"
                        @drop-files="enqueueFiles"
                    />

                    <PaginationBar
                        :pagination="pagination"
                        :perPage="state.perPage"
                        :trans="trans"
                        @page="p => { state.page = p; fetchItems() }"
                        @per-page="pp => { state.perPage = pp; state.page = 1; persistPrefs(); fetchItems() }"
                    />
                </template>
            </div>
        </div>

        <!-- Slide-over Inspector -->
        <ImageInspector
            v-if="setup"
            :file="currentFile"
            :visibilities="setup.visibilities"
            :folderTree="setup.folder_tree"
            :trans="trans"
            @close="closeInspector"
            @updated="onFileUpdated"
            @replaced="onFileReplaced"
            @delete="requestDeleteSingle"
            @focus="focusTarget = $event"
            @lightbox="openLightbox"
            @copy-url="copyUrl"
            @copy-admin-link="copyAdminLink"
        />

        <!-- Lightbox -->
        <ImageLightbox
            :open="Boolean(lightboxFile)"
            :file="lightboxFile"
            :hasPrev="lightboxIndex > 0"
            :hasNext="lightboxIndex >= 0 && lightboxIndex < lightboxCandidates.length - 1"
            :trans="trans"
            @close="lightboxFile = null"
            @prev="stepLightbox(-1)"
            @next="stepLightbox(1)"
            @copy-url="copyUrl"
        />

        <!-- Focus Point Modal -->
        <FocusPointModal
            v-if="setup"
            :open="Boolean(focusTarget)"
            :file="focusTarget"
            :premium="setup.acl.premium"
            :trans="trans"
            @close="focusTarget = null"
            @updated="onFileUpdated($event, false)"
        />

        <!-- Bulk Action Bar -->
        <BulkActionBar
            :selectedFiles="selectedFiles"
            :trans="trans"
            @open-bulk-update="openBulkUpdateModal"
            @delete-selected="requestDeleteBulk"
            @clear="clearSelection"
        />

        <!-- Upload Queue Tray -->
        <UploadQueue
            :items="uploadQueue"
            :trans="trans"
            @cancel="cancelUploadItem"
            @retry="retryUploadItem"
            @clear-finished="clearFinishedUploads"
        />

        <!-- Delete Confirmation & Impact Modal -->
        <DeleteConfirmModal
            v-if="setup"
            :open="deleteModalOpen"
            :ids="deleteTargetIds"
            :previewApi="setup.api.deletePreview"
            :deleting="deleting"
            :trans="trans"
            @close="deleteModalOpen = false"
            @confirm="confirmDelete"
        />

        <!-- New Folder Modal -->
        <dialog ref="newFolderDialogRef" class="dialog rounded-2xl bg-base-100 text-base-content p-0 w-full! max-w-md!" @click.self="newFolderDialogRef?.close()">
            <header class="flex items-center justify-between p-4 md:p-5">
                <h4 class="text-lg font-medium">{{ trans('new_folder') }}</h4>
                <button type="button" class="text-base-content cursor-pointer" @click="newFolderDialogRef?.close()" aria-label="Close">
                    <i class="fa-regular fa-circle-xmark text-lg" aria-hidden="true"></i>
                </button>
            </header>
            <article class="px-4 md:px-6 pb-4 flex flex-col gap-3 text-sm">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('name') }}</label>
                    <input ref="newFolderInputRef" type="text" autofocus class="w-full bg-base-200 rounded-lg px-3 py-1.5" v-model="newFolderName" @keyup.enter="createFolder" />
                </div>
                <div v-if="setup" class="flex flex-col gap-1">
                    <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('visibility') }}</label>
                    <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5" v-model="newFolderVisibility">
                        <option v-for="(label, id) in setup.visibilities" :key="id" :value="Number(id)">{{ label }}</option>
                    </select>
                </div>
            </article>
            <footer class="px-4 md:px-6 py-3 flex justify-end gap-2">
                <button type="button" class="btn2 btn-default btn-sm" @click="newFolderDialogRef?.close()">{{ trans('cancel') }}</button>
                <button type="button" class="btn2 btn-primary btn-sm" :disabled="creatingFolder || !newFolderName.trim()" @click="createFolder">
                    <i v-if="creatingFolder" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                    <span>{{ trans('create') }}</span>
                </button>
            </footer>
        </dialog>

        <!-- Bulk Move / Visibility Modal -->
        <dialog ref="bulkUpdateDialogRef" class="dialog rounded-2xl bg-base-100 text-base-content p-0 w-full! max-w-md!" @click.self="bulkUpdateDialogRef?.close()">
            <header class="flex items-center justify-between p-4 md:p-5">
                <h4 class="text-lg font-medium">{{ trans('update') }} ({{ selectedFiles.length }})</h4>
                <button type="button" class="text-base-content cursor-pointer" @click="bulkUpdateDialogRef?.close()" aria-label="Close">
                    <i class="fa-regular fa-circle-xmark text-lg" aria-hidden="true"></i>
                </button>
            </header>
            <article class="px-4 md:px-6 pb-4 flex flex-col gap-3 text-sm" v-if="setup">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('visibility') }}</label>
                    <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5" v-model="bulkVisibility">
                        <option value="">—</option>
                        <option v-for="(label, id) in setup.visibilities" :key="id" :value="String(id)">{{ label }}</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('folder') }}</label>
                    <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5" v-model="bulkFolder">
                        <option value="">—</option>
                        <option value="0">{{ trans('home') }}</option>
                        <option v-for="f in setup.folder_tree" :key="f.id" :value="f.id">{{ f.name }}</option>
                    </select>
                </div>
            </article>
            <footer class="px-4 md:px-6 py-3 flex justify-end gap-2">
                <button type="button" class="btn2 btn-default btn-sm" @click="bulkUpdateDialogRef?.close()">{{ trans('cancel') }}</button>
                <button type="button" class="btn2 btn-primary btn-sm" :disabled="bulkUpdating" @click="submitBulkUpdate">
                    <i v-if="bulkUpdating" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                    <span>{{ trans('change') }}</span>
                </button>
            </footer>
        </dialog>

        <!-- Upload from URL Modal -->
        <dialog ref="urlDialogRef" class="dialog rounded-2xl bg-base-100 text-base-content p-0 w-full! max-w-md!" @click.self="urlDialogRef?.close()">
            <header class="flex items-center justify-between p-4 md:p-5">
                <h4 class="text-lg font-medium">{{ trans('upload_url_title') }}</h4>
                <button type="button" class="text-base-content cursor-pointer" @click="urlDialogRef?.close()" aria-label="Close">
                    <i class="fa-regular fa-circle-xmark text-lg" aria-hidden="true"></i>
                </button>
            </header>
            <article class="px-4 md:px-6 pb-4 flex flex-col gap-2 text-sm">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('upload_url_hint') }}</label>
                <input
                    ref="urlInputRef"
                    type="url"
                    autofocus
                    class="w-full bg-base-200 rounded-lg px-3 py-1.5"
                    placeholder="https://..."
                    v-model="urlUploadValue"
                    @keyup.enter="submitUrlUpload"
                />
            </article>
            <footer class="px-4 md:px-6 py-3 flex justify-end gap-2">
                <button type="button" class="btn2 btn-default btn-sm" @click="urlDialogRef?.close()">{{ trans('cancel') }}</button>
                <button type="button" class="btn2 btn-primary btn-sm" :disabled="uploadingUrl || !urlUploadValue.trim()" @click="submitUrlUpload">
                    <i v-if="uploadingUrl" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                    <span>{{ trans('upload_url') }}</span>
                </button>
            </footer>
        </dialog>
    </div>
</template>

<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, onMounted, ref } from 'vue'
import axios from 'axios'
import { useGalleryState } from './composables/useGalleryState'
import { createUploadRequest } from './uploadRequest.js'
import StorageBar from './components/StorageBar.vue'
import GalleryToolbar from './components/GalleryToolbar.vue'
import FolderTree from './components/FolderTree.vue'
import GalleryGrid from './components/GalleryGrid.vue'
import GalleryTable from './components/GalleryTable.vue'
import PaginationBar from './components/PaginationBar.vue'
import ImageInspector from './components/ImageInspector.vue'
import ImageLightbox from './components/ImageLightbox.vue'
import FocusPointModal from './components/FocusPointModal.vue'
import UploadQueue from './components/UploadQueue.vue'
import BulkActionBar from './components/BulkActionBar.vue'
import DeleteConfirmModal from './components/DeleteConfirmModal.vue'
import type { GalleryFileItem, UploadQueueItem } from './types'

const props = defineProps<{
    api: string
}>()

const {
    state,
    initiated,
    loading,
    setup,
    files,
    currentFolder,
    breadcrumbs,
    currentFile,
    pagination,
    activeFilterCount,
    hasActiveFiltersOrSearch,
    trans,
    persistPrefs,
    syncUrl,
    fetchItems,
    loadSetup,
    resetFilters,
    applyPopstate,
} = useGalleryState()

const toolbarRef = ref<InstanceType<typeof GalleryToolbar> | null>(null)
const fileInputRef = ref<HTMLInputElement | null>(null)
const usedSpace = ref(0)
const mobileSelectMode = ref(false)
const lastSelectedIndex = ref<number | null>(null)

// Lightbox & Focus
const lightboxFile = ref<GalleryFileItem | null>(null)
const focusTarget = ref<GalleryFileItem | null>(null)

// Drag & Drop
const osDragging = ref(false)
let osDragCounter = 0
const breadcrumbDragOver = ref<string | null>(null)
const draggingItemIds = ref<string[]>([])

// Upload Queue
const uploadQueue = ref<UploadQueueItem[]>([])
let activeUploads = 0
const MAX_CONCURRENT_UPLOADS = 3

// Delete Modal
const deleteModalOpen = ref(false)
const deleteTargetIds = ref<string[]>([])
const deleting = ref(false)

// New Folder Modal
const newFolderDialogRef = ref<HTMLDialogElement | null>(null)
const newFolderInputRef = ref<HTMLInputElement | null>(null)
const newFolderName = ref('')
const newFolderVisibility = ref(1)
const creatingFolder = ref(false)

// Bulk Update Modal
const bulkUpdateDialogRef = ref<HTMLDialogElement | null>(null)
const bulkVisibility = ref('')
const bulkFolder = ref('')
const bulkUpdating = ref(false)

// URL Upload Modal
const urlDialogRef = ref<HTMLDialogElement | null>(null)
const urlInputRef = ref<HTMLInputElement | null>(null)
const urlUploadValue = ref('')
const uploadingUrl = ref(false)

const selectedFiles = computed(() => files.value.filter(f => f.is_selected))

const lightboxCandidates = computed(() => files.value.filter(f => !f.is_folder && Boolean(f.original)))
const lightboxIndex = computed(() => {
    if (!lightboxFile.value) return -1
    return lightboxCandidates.value.findIndex(f => f.id === lightboxFile.value!.id)
})

const navigateToFolder = (folderId: string | null) => {
    state.folderId = folderId
    state.page = 1
    currentFile.value = null
    state.imageId = null
    mobileSelectMode.value = false
    lastSelectedIndex.value = null
    fetchItems()
}

const openItem = (file: GalleryFileItem) => {
    if (file.is_folder) {
        navigateToFolder(file.id)
        return
    }
    if (currentFile.value?.id === file.id) {
        closeInspector()
    } else {
        currentFile.value = file
        state.imageId = file.id
        syncUrl(false)
    }
}

const closeInspector = () => {
    currentFile.value = null
    state.imageId = null
    syncUrl(false)
}

const openFolderDetails = () => {
    if (!currentFolder.value) return
    if (currentFile.value?.id === currentFolder.value.id) {
        closeInspector()
    } else {
        currentFile.value = currentFolder.value
    }
}

const applyCleanupPreset = () => {
    state.usage = 'unused'
    state.sort = 'size_desc'
    state.scope = 'all'
    state.page = 1
    persistPrefs()
    fetchItems()
}

const toggleSelect = (file: GalleryFileItem, event: MouseEvent) => {
    const idx = files.value.findIndex(f => f.id === file.id)
    if (event.shiftKey && lastSelectedIndex.value !== null && idx !== -1) {
        const start = Math.min(lastSelectedIndex.value, idx)
        const end = Math.max(lastSelectedIndex.value, idx)
        const targetState = !file.is_selected
        for (let i = start; i <= end; i++) {
            files.value[i].is_selected = targetState
        }
    } else {
        file.is_selected = !file.is_selected
    }
    lastSelectedIndex.value = idx !== -1 ? idx : null
}

const toggleSelectAll = () => {
    const all = files.value.length > 0 && files.value.every(f => f.is_selected)
    files.value.forEach(f => {
        f.is_selected = !all
    })
}

const clearSelection = () => {
    files.value.forEach(f => {
        f.is_selected = false
    })
    mobileSelectMode.value = false
    lastSelectedIndex.value = null
}

const onFileUpdated = (updated: GalleryFileItem, movedFolderChanged: boolean) => {
    if (movedFolderChanged) {
        closeInspector()
        refreshSetupFolders()
        fetchItems({ pushUrl: false })
        return
    }
    const idx = files.value.findIndex(f => f.id === updated.id)
    if (idx !== -1) {
        files.value[idx] = { ...updated, is_selected: files.value[idx].is_selected }
    }
    if (currentFile.value?.id === updated.id) {
        currentFile.value = updated
    }
    if (updated.is_folder) {
        refreshSetupFolders()
    }
}

const onFileReplaced = (updated: GalleryFileItem, newUsed: number) => {
    usedSpace.value = newUsed
    onFileUpdated(updated, false)
}

const copyUrl = async (file: GalleryFileItem) => {
    await navigator.clipboard.writeText(file.link)
    window.showToast?.(trans('copied'))
}

const copyAdminLink = async (file: GalleryFileItem) => {
    await navigator.clipboard.writeText(file.admin_url)
    window.showToast?.(trans('copied'))
}

const openLightbox = (file: GalleryFileItem) => {
    lightboxFile.value = file
}

const stepLightbox = (delta: number) => {
    const nextIdx = lightboxIndex.value + delta
    if (nextIdx >= 0 && nextIdx < lightboxCandidates.value.length) {
        lightboxFile.value = lightboxCandidates.value[nextIdx]
    }
}

// Drag & Drop (Internal Move + OS Upload)
const onItemDragStart = (file: GalleryFileItem, e: DragEvent) => {
    const ids = file.is_selected && selectedFiles.value.length > 0
        ? selectedFiles.value.map(f => f.id)
        : [file.id]
    draggingItemIds.value = ids
    if (e.dataTransfer) {
        e.dataTransfer.effectAllowed = 'move'
        e.dataTransfer.setData('application/x-kanka-gallery', JSON.stringify(ids))
    }
}

const moveDraggedToFolder = async (targetFolderId: string | null) => {
    if (!setup.value || draggingItemIds.value.length === 0) return
    const ids = draggingItemIds.value.filter(id => id !== targetFolderId)
    draggingItemIds.value = []
    if (ids.length === 0) return

    try {
        const payload: Record<string, any> = { files: ids }
        if (targetFolderId === null) {
            payload.folder_home = 1
        } else {
            payload.folder_id = targetFolderId
        }
        const res = await axios.post(setup.value.api.update, payload)
        window.showToast?.(res.data.toast)
        refreshSetupFolders()
        fetchItems({ pushUrl: false })
    } catch (err: any) {
        const msg = err.response?.data?.errors?.folder_id?.[0] ?? err.response?.data?.message ?? 'Move failed'
        window.showToast?.(msg, 'error')
    }
}

const onGalleryDragEnter = (e: DragEvent) => {
    if (!setup.value?.acl.upload) return
    if (e.dataTransfer?.types.includes('Files')) {
        osDragCounter++
        osDragging.value = true
    }
}

const onGalleryDragLeave = () => {
    if (osDragCounter > 0) osDragCounter--
    if (osDragCounter === 0) osDragging.value = false
}

const onGalleryDrop = (e: DragEvent) => {
    osDragCounter = 0
    osDragging.value = false
    if (!setup.value?.acl.upload) return
    if (e.dataTransfer?.files && e.dataTransfer.files.length > 0) {
        enqueueFiles(e.dataTransfer.files, state.folderId)
    }
}

const onBreadcrumbDrop = (e: DragEvent, targetFolderId: string | null) => {
    breadcrumbDragOver.value = null
    if (e.dataTransfer?.files && e.dataTransfer.files.length > 0) {
        enqueueFiles(e.dataTransfer.files, targetFolderId)
        return
    }
    if (e.dataTransfer?.types.includes('application/x-kanka-gallery')) {
        moveDraggedToFolder(targetFolderId)
    }
}

// Upload Queue
const onFilesSelected = (e: Event) => {
    const input = e.target as HTMLInputElement
    if (input.files && input.files.length > 0) {
        enqueueFiles(input.files, state.folderId)
    }
    input.value = ''
}

const enqueueFiles = (fileList: FileList | File[], targetFolderId: string | null) => {
    if (!setup.value?.acl.upload) return
    Array.from(fileList).forEach(file => {
        uploadQueue.value.push({
            uid: `${Date.now()}-${Math.random().toString(36).slice(2)}`,
            file,
            name: file.name,
            folderId: targetFolderId,
            progress: 0,
            status: 'queued',
            error: null,
            preview: null,
            controller: null,
        })
    })
    processUploadQueue()
}

const processUploadQueue = () => {
    while (activeUploads < MAX_CONCURRENT_UPLOADS) {
        const next = uploadQueue.value.find(i => i.status === 'queued')
        if (!next) break
        startSingleUpload(next)
    }
}

const startSingleUpload = async (item: UploadQueueItem) => {
    if (!setup.value) return
    activeUploads++
    item.status = 'uploading'
    item.error = null
    item.progress = 0

    const formData = new FormData()
    formData.append('files[]', item.file)
    if (item.folderId) {
        formData.append('folder_id', item.folderId)
    }

    const req = createUploadRequest((ev: ProgressEvent) => {
        if (ev.total > 0) {
            item.progress = Math.round((ev.loaded * 100) / ev.total)
        }
    })
    item.controller = req.controller

    try {
        const res = await axios.post(setup.value.api.upload, formData, req.config)
        if (res.data.used !== undefined) {
            usedSpace.value = res.data.used
        }
        const uploadedFiles = res.data.files || []
        if (uploadedFiles.length === 0) {
            item.status = 'error'
            item.error = 'Insufficient storage space'
        } else {
            item.status = 'done'
            item.progress = 100
            if (item.folderId === state.folderId) {
                fetchItems({ pushUrl: false })
            }
            refreshSetupFolders()
        }
    } catch (err: any) {
        if (req.controller.signal.aborted) {
            item.status = 'cancelled'
        } else {
            item.status = 'error'
            item.error = err.response?.data?.error
                ?? err.response?.data?.errors?.['files.0']?.[0]
                ?? err.response?.data?.message
                ?? 'Upload failed'
        }
    } finally {
        activeUploads--
        processUploadQueue()
    }
}

const cancelUploadItem = (uid: string) => {
    const item = uploadQueue.value.find(i => i.uid === uid)
    if (!item) return
    if (item.status === 'queued') {
        item.status = 'cancelled'
    } else if (item.status === 'uploading') {
        item.controller?.abort()
    }
}

const retryUploadItem = (uid: string) => {
    const item = uploadQueue.value.find(i => i.uid === uid)
    if (!item) return
    item.status = 'queued'
    item.error = null
    processUploadQueue()
}

const clearFinishedUploads = () => {
    uploadQueue.value = uploadQueue.value.filter(i => i.status === 'uploading' || i.status === 'queued')
}

// Delete Flow
const requestDeleteSingle = (file: GalleryFileItem) => {
    deleteTargetIds.value = [file.id]
    deleteModalOpen.value = true
}

const requestDeleteBulk = () => {
    if (selectedFiles.value.length === 0) return
    deleteTargetIds.value = selectedFiles.value.map(f => f.id)
    deleteModalOpen.value = true
}

const confirmDelete = async () => {
    if (!setup.value || deleting.value || deleteTargetIds.value.length === 0) return
    deleting.value = true
    try {
        const res = await axios.post(setup.value.api.delete, { images: deleteTargetIds.value })
        usedSpace.value = res.data.used
        window.showToast?.(res.data.toast)
        if (currentFile.value && deleteTargetIds.value.includes(currentFile.value.id)) {
            closeInspector()
        }
        deleteModalOpen.value = false
        clearSelection()
        refreshSetupFolders()
        fetchItems({ pushUrl: false })
    } catch (err: any) {
        window.showToast?.(err.response?.data?.message ?? 'Delete failed', 'error')
    } finally {
        deleting.value = false
    }
}

// New Folder
const openNewFolderModal = () => {
    newFolderName.value = ''
    newFolderVisibility.value = 1
    newFolderDialogRef.value?.showModal()
    requestAnimationFrame(() => newFolderInputRef.value?.focus())
}

const createFolder = async () => {
    if (!setup.value || creatingFolder.value || !newFolderName.value.trim()) return
    creatingFolder.value = true
    try {
        await axios.post(setup.value.api.create, {
            name: newFolderName.value.trim(),
            visibility_id: newFolderVisibility.value,
            folder_id: state.folderId,
        })
        newFolderDialogRef.value?.close()
        refreshSetupFolders()
        fetchItems({ pushUrl: false })
    } catch (err: any) {
        window.showToast?.(err.response?.data?.message ?? 'Failed to create folder', 'error')
    } finally {
        creatingFolder.value = false
    }
}

// Bulk Update
const openBulkUpdateModal = () => {
    bulkVisibility.value = ''
    bulkFolder.value = ''
    bulkUpdateDialogRef.value?.showModal()
}

const submitBulkUpdate = async () => {
    if (!setup.value || bulkUpdating.value || selectedFiles.value.length === 0) return
    bulkUpdating.value = true
    try {
        const payload: Record<string, any> = {
            files: selectedFiles.value.map(f => f.id),
        }
        if (bulkVisibility.value) payload.visibility_id = Number(bulkVisibility.value)
        if (bulkFolder.value === '0') {
            payload.folder_home = 1
        } else if (bulkFolder.value) {
            payload.folder_id = bulkFolder.value
        }

        const res = await axios.post(setup.value.api.update, payload)
        window.showToast?.(res.data.toast)
        bulkUpdateDialogRef.value?.close()
        clearSelection()
        refreshSetupFolders()
        fetchItems({ pushUrl: false })
    } catch (err: any) {
        const msg = err.response?.data?.errors?.folder_id?.[0] ?? err.response?.data?.message ?? 'Update failed'
        window.showToast?.(msg, 'error')
    } finally {
        bulkUpdating.value = false
    }
}

// URL Upload
const openUrlUploadModal = () => {
    urlUploadValue.value = ''
    urlDialogRef.value?.showModal()
    requestAnimationFrame(() => urlInputRef.value?.focus())
}

const submitUrlUpload = async () => {
    if (!setup.value || uploadingUrl.value || !urlUploadValue.value.trim()) return
    uploadingUrl.value = true
    try {
        const res = await axios.post(setup.value.api.uploadUrl, {
            url: urlUploadValue.value.trim(),
            folder_id: state.folderId,
        })
        if (res.data.used !== undefined) {
            usedSpace.value = res.data.used
        }
        urlDialogRef.value?.close()
        fetchItems({ pushUrl: false })
    } catch (err: any) {
        const msg = err.response?.data?.error ?? err.response?.data?.message ?? 'Failed to download URL'
        window.showToast?.(msg, 'error')
    } finally {
        uploadingUrl.value = false
    }
}

const refreshSetupFolders = async () => {
    try {
        const res = await axios.get(props.api)
        if (setup.value) {
            setup.value.folder_tree = res.data.folder_tree
            setup.value.folders = res.data.folders
        }
    } catch {
        // Non-fatal
    }
}

// Keyboard Shortcuts & Clipboard Paste
const handleKeydown = (e: KeyboardEvent) => {
    const tag = (e.target as HTMLElement)?.tagName
    const isInput = tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT'

    if (e.key === 'Escape') {
        if (lightboxFile.value) {
            lightboxFile.value = null
            return
        }
        if (focusTarget.value) {
            focusTarget.value = null
            return
        }
        if (currentFile.value) {
            closeInspector()
            return
        }
        if (selectedFiles.value.length > 0) {
            clearSelection()
        }
        return
    }

    if (lightboxFile.value) {
        if (e.key === 'ArrowLeft') stepLightbox(-1)
        if (e.key === 'ArrowRight') stepLightbox(1)
        return
    }

    if (isInput) return

    if (e.key === '/') {
        e.preventDefault()
        toolbarRef.value?.focusSearch()
    } else if ((e.key === 'Delete' || e.key === 'Backspace') && selectedFiles.value.length > 0) {
        e.preventDefault()
        requestDeleteBulk()
    }
}

const handlePaste = (e: ClipboardEvent) => {
    const tag = (e.target as HTMLElement)?.tagName
    if (tag === 'INPUT' || tag === 'TEXTAREA' || !setup.value?.acl.upload) return
    const items = e.clipboardData?.items
    if (!items) return

    const pastedFiles: File[] = []
    for (const item of Array.from(items)) {
        if (item.kind === 'file' && item.type.startsWith('image/')) {
            const f = item.getAsFile()
            if (f) pastedFiles.push(f)
        }
    }
    if (pastedFiles.length > 0) {
        enqueueFiles(pastedFiles, state.folderId)
    }
}

onMounted(async () => {
    await loadSetup(props.api)
    if (setup.value) {
        usedSpace.value = setup.value.space.used
    }
    window.addEventListener('popstate', applyPopstate)
    window.addEventListener('keydown', handleKeydown)
    window.addEventListener('paste', handlePaste)
})

onBeforeUnmount(() => {
    window.removeEventListener('popstate', applyPopstate)
    window.removeEventListener('keydown', handleKeydown)
    window.removeEventListener('paste', handlePaste)
})
</script>
