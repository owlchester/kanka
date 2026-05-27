<template>
    <div v-if="loading">
        <i class="fa-solid fa-spin fa-spinner" aria-label="Loading"></i>
    </div>
    <div v-else class="relative">
        <!-- Drop zone -->
        <div
            ref="zoneRef"
            :class="zoneClass()"
            :style="zoneStyle()"
            @click="toggleDropdown"
            @dragenter.prevent="onDragEnter"
            @dragover.prevent
            @dragleave="onDragLeave"
            @drop.prevent="onDrop"
        >
            <!-- Empty / drag state -->
            <template v-if="!hasImage() && !uploading">
                <i class="fa-regular fa-camera text-3xl opacity-30" aria-hidden="true"></i>
                <span class="text-xs text-base-content/40">
                    {{ dragging ? trans.drop_hint : trans.drag_hint }}
                </span>
            </template>

            <!-- Uploading dark overlay — must come before progress bar in DOM so z-10 on the bar renders above it -->
            <div v-if="uploading && imagePreview" class="absolute inset-0 bg-black/50 rounded-xl"></div>

            <!-- Upload progress -->
            <div v-if="uploading" class="relative z-10 w-full flex flex-col gap-2 p-3">
                <div class="h-1 w-full bg-base-300/80 rounded-full overflow-hidden">
                    <div
                        class="h-1 bg-accent rounded-full transition-all duration-300"
                        role="progressbar"
                        :aria-valuenow="progress"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        :style="{'width': progressPercentage()}"
                    >
                        <span class="sr-only">{{ progressPercentage() }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-white/70">{{ progressPercentage() }}</span>
                    <button type="button" class="text-red-300 flex items-center gap-1" @click.stop="cancelUpload">
                        <i class="fa-regular fa-xmark" aria-hidden="true"></i>
                        {{ trans.cancel }}
                    </button>
                </div>
            </div>

            <!-- Image change overlay -->
            <div
                v-if="hasImage() && !uploading"
                class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-sm px-3 py-1.5 text-white/70 text-xs flex justify-end items-center gap-1"
            >
                {{ trans.change }}
                <i class="fa-regular fa-chevron-down text-xs" aria-hidden="true"></i>
            </div>
        </div>

        <!-- Dropdown -->
        <div
            v-if="dropdownOpen"
            ref="dropdownRef"
            class="absolute left-0 right-0 top-full z-50 mt-1 bg-base-100 border border-base-300 rounded-xl shadow-lg overflow-hidden flex flex-col"
        >
            <!-- Upload from device -->
            <button
                v-if="canUploadProp"
                type="button"
                class="text-left px-3 py-2.5 hover:bg-base-200 transition-colors duration-150 flex gap-3 items-start border-b border-base-200"
                @click.stop="triggerFileInput"
            >
                <i class="fa-regular fa-upload mt-0.5 w-4 shrink-0 text-center" aria-hidden="true"></i>
                <div class="flex flex-col gap-0.5">
                    <span class="text-sm">{{ trans.upload }}</span>
                    <span class="text-xs text-base-content/40">{{ trans.formats }}</span>
                </div>
            </button>

            <!-- Add from URL -->
            <div v-if="canUploadProp" class="border-b border-base-200">
                <button
                    type="button"
                    class="w-full text-left px-3 py-2.5 hover:bg-base-200 transition-colors duration-150 flex gap-3 items-center"
                    @click.stop="toggleUrlExpanded"
                >
                    <i
                        class="w-4 shrink-0 text-center"
                        :class="downloading ? 'fa-solid fa-spin fa-spinner' : 'fa-regular fa-link'"
                        aria-hidden="true"
                    ></i>
                    <span class="text-sm grow">{{ trans.add_url }}</span>
                    <i
                        class="fa-regular fa-chevron-down text-xs transition-transform duration-150"
                        :class="urlExpanded ? 'rotate-180' : ''"
                        aria-hidden="true"
                    ></i>
                </button>
                <div v-if="urlExpanded" class="px-3 pb-3 flex flex-col gap-1">
                    <input
                        ref="urlField"
                        type="text"
                        class="w-full"
                        v-model="imageUrl"
                        @blur="download()"
                        @paste="pasteUrl"
                        @keydown.esc.stop="imageUrl = null; urlExpanded = false"
                        :placeholder="trans.url"
                    />
                    <span class="text-xs text-base-content/40">{{ trans.url_hint }}</span>
                </div>
            </div>

            <!-- Choose from gallery -->
            <button
                v-if="canBrowseProp"
                type="button"
                class="text-left px-3 py-2.5 hover:bg-base-200 transition-colors duration-150 flex gap-3 items-center"
                :class="hasImage() ? 'border-b border-base-200' : ''"
                @click.stop="openGallery(); dropdownOpen = false"
            >
                <i class="fa-regular fa-images w-4 shrink-0 text-center" aria-hidden="true"></i>
                <span class="text-sm">{{ trans.gallery }}</span>
            </button>

            <!-- Remove image -->
            <button
                v-if="hasImage()"
                type="button"
                class="text-left px-3 py-2.5 hover:bg-base-200 transition-colors duration-150 flex gap-3 items-center text-error"
                @click.stop="removeImage(); dropdownOpen = false"
            >
                <i class="fa-regular fa-trash w-4 shrink-0 text-center" aria-hidden="true"></i>
                <span class="text-sm">{{ trans.remove }}</span>
            </button>
        </div>

        <!-- Hidden file input (triggered programmatically) -->
        <input type="file" ref="fileField" :accept="props.accepts" @change="upload" class="hidden" />
    </div>

    <!-- Hidden form inputs -->
    <input type="hidden" :name="props.field" v-model="currentUuid" />
    <input type="hidden" :name="'remove-image'" value="1" v-if="removedOld" />

    <Browser
        :api="props.browse"
        :opened="galleryOpened"
        :i18n="props.i18n"
        @selected="selectImage"
        @closed="closedGallery"
    ></Browser>

    <dialog ref="cta" class="dialog rounded-2xl text-center" aria-modal="true" v-if="ctaOpen">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans.cta_title" class="text-lg font-normal"></h4>
            <button type="button" class="text-base-content" @click="closeDialog(cta)" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl flex flex-col gap-2 text-left p-4 md:px-6">
            <div class="flex flex-col gap-1 w-full">
                <p v-html="storageFull"></p>
                <p v-html="trans.cta_helper" v-if="!hasPremium"></p>
            </div>
        </article>
        <footer class="p-4 md:px-6" v-if="!hasPremium">
            <menu class="">
                <a v-bind:href="props.cta" class="btn2 btn-primary">
                    <i class="fa-regular fa-gem" aria-hidden="true" />
                    <span v-html="trans.cta_action"></span>
                </a>
            </menu>
        </footer>
    </dialog>
</template>

<script setup lang="ts">
import {ref, computed, onMounted, onBeforeUnmount, nextTick} from 'vue'
import Browser from "./Browser.vue"

const props = defineProps<{
    file: string,
    url: string,
    accepts: string,
    uuid: string,
    thumbnail: string,
    browse: string,
    field: string,
    old: string,
    i18n: undefined,
    cta: string,
    premium: string,
    canUpload: string,
    canBrowse: string,
}>()


const loading = ref(true)
const downloading = ref(false)
const uploading = ref(false)
const imageUrl = ref()
const urlField = ref()
const fileField = ref()
const currentThumbnail = ref()
const currentUuid = ref()
const galleryOpened = ref(false)
const progress = ref(0)
const imagePreview = ref(null)
let lastImageUrl
const cancelTokenSource = ref(null)
const hasOld = ref(false)
const hasPremium = ref(false)
const removedOld = ref(false)
const trans = ref(null)
const cta = ref()
const ctaOpen = ref(false)
const storageFull = ref()
const dragging = ref(false)
const dragCounter = ref(0)
const dropdownOpen = ref(false)
const urlExpanded = ref(false)
const zoneRef = ref<HTMLElement | null>(null)
const dropdownRef = ref<HTMLElement | null>(null)
const canUploadProp = computed(() => props.canUpload === 'true')
const canBrowseProp = computed(() => props.canBrowse === 'true')

onMounted(() => {
    loading.value = false
    currentThumbnail.value = props.thumbnail
    currentUuid.value = props.uuid
    if (props.old === 'true') {
        hasOld.value = true
    }
    if (props.premium === 'true') {
        hasPremium.value = true
    }
    trans.value = JSON.parse(props.i18n)
});

const zoneClass = () => {
    const isUploading = uploading.value
    const hasImg = hasImage()
    // justify-end pushes content (progress bar, image overlay) to the bottom;
    // justify-center vertically centers the empty/drag icon
    let css = 'relative w-full min-h-[90px] rounded-xl overflow-hidden cursor-pointer flex flex-col items-center transition-all duration-150 '
    css += (isUploading || hasImg) ? 'justify-end ' : 'justify-center '
    if (isUploading) {
        css += 'border-2 border-dashed border-base-300 '
    } else if (hasImg) {
        css += 'border border-base-300 '
    } else if (dragging.value) {
        css += 'border-2 border-dashed border-accent bg-accent/10 '
    } else {
        css += 'border-2 border-dashed border-base-300 bg-base-200/50 hover:bg-base-200 hover:border-base-content/30 '
    }
    return css
}

const zoneStyle = () => {
    if (uploading.value && imagePreview.value) {
        return { backgroundImage: backgroundImage(), backgroundSize: 'cover', backgroundPosition: 'center' }
    }
    if (hasImage() && !uploading.value) {
        return { backgroundImage: backgroundImage(), backgroundSize: 'cover', backgroundPosition: 'center' }
    }
    return {}
}

const hasImage = () => {
    return hasOld.value || currentUuid.value !== null && currentUuid.value !== ''
}

const hasPreview = () => {
    if (imagePreview.value || hasOld.value) {
        return true
    }
    return currentUuid.value !== null && currentUuid.value !== ''
}

const removeImage = () => {
    currentUuid.value = null
    currentThumbnail.value = null
    if (hasOld.value) {
        hasOld.value = false
        removedOld.value = true
    }
}

const backgroundImage = () => {
    if (imagePreview.value) {
        return 'url(\'' + imagePreview.value + '\')'
    }
    if (!currentThumbnail.value) {
        return ''
    }
    return 'url(\'' + currentThumbnail.value + '\')'
}

const progressPercentage = () => {
    return progress.value + '%'
}

const openGallery = () => {
    galleryOpened.value = true
}

const handleDropdownEscape = (e: KeyboardEvent) => {
    if (e.key === 'Escape') {
        dropdownOpen.value = false
        urlExpanded.value = false
        document.removeEventListener('keydown', handleDropdownEscape)
    }
}

const toggleDropdown = () => {
    if (uploading.value) {
        return
    }
    dropdownOpen.value = !dropdownOpen.value
    if (dropdownOpen.value) {
        nextTick(() => {
            document.addEventListener('click', closeDropdownOnOutside)
            document.addEventListener('keydown', handleDropdownEscape)
        })
    } else {
        document.removeEventListener('click', closeDropdownOnOutside)
        document.removeEventListener('keydown', handleDropdownEscape)
    }
}

const closeDropdownOnOutside = (e: MouseEvent) => {
    if (
        !zoneRef.value?.contains(e.target as Node) &&
        !dropdownRef.value?.contains(e.target as Node)
    ) {
        dropdownOpen.value = false
        urlExpanded.value = false
        document.removeEventListener('click', closeDropdownOnOutside)
        document.removeEventListener('keydown', handleDropdownEscape)
    }
}

const onDragEnter = () => {
    if (!canUploadProp.value) {
        return
    }
    dragCounter.value++
    dragging.value = true
}

const onDragLeave = () => {
    if (dragCounter.value > 0) {
        dragCounter.value--
    }
    if (dragCounter.value === 0) {
        dragging.value = false
    }
}

const onDrop = (e: DragEvent) => {
    dragCounter.value = 0
    dragging.value = false
    if (!canUploadProp.value) {
        return
    }
    const file = e.dataTransfer?.files[0]
    if (!file) {
        return
    }
    uploadFile(file)
}

const pasteUrl = (event) => {
    imageUrl.value = event.clipboardData.getData('text')
    download()
}

const download = () => {
    if (!imageUrl.value || imageUrl.value == lastImageUrl) {
        return
    }
    lastImageUrl = imageUrl.value
    downloading.value = true
    urlField.value.disabled = true

    axios.post(props.url, {url: imageUrl.value})
        .then(res => {
            urlField.value.disabled = false
            downloading.value = false
            imageUrl.value = null

            currentThumbnail.value = res.data.thumbnail
            currentUuid.value = res.data.uuid
        })
        .catch(err => {
            urlField.value.disabled = false
            downloading.value = false
            urlField.value.focus()

            showErrors(err)
        })
}

const uploadFile = async (file: File) => {
    const reader = new FileReader()
    reader.onload = (e) => {
        imagePreview.value = e.target?.result as string
    }
    reader.readAsDataURL(file)

    uploading.value = true
    document.addEventListener('keydown', handleEscape)
    cancelTokenSource.value = axios.CancelToken.source()

    const formData = new FormData()
    formData.append('file', file)

    axios.post(props.file, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
        cancelToken: cancelTokenSource.value.token,
        onUploadProgress: function (progressEvent) {
            progress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total)
        }
    })
        .then(res => {
            uploading.value = false
            currentThumbnail.value = res.data.thumbnail
            currentUuid.value = res.data.uuid
            imagePreview.value = null
            document.removeEventListener('keydown', handleEscape)
        })
        .catch(err => {
            uploading.value = false
            imagePreview.value = null
            if (axios.isCancel(err)) {
                // User cancelled
            } else {
                showErrors(err)
            }
            document.removeEventListener('keydown', handleEscape)
        })
}

const upload = async (event: Event) => {
    const target = event.target as HTMLInputElement
    const file = target.files?.[0]
    if (!file) {
        uploading.value = false
        return
    }
    await uploadFile(file)
}

const triggerFileInput = () => {
    dropdownOpen.value = false
    fileField.value?.click()
}

const toggleUrlExpanded = () => {
    urlExpanded.value = !urlExpanded.value
    if (urlExpanded.value) {
        nextTick(() => urlField.value?.focus())
    }
}

const showErrors = (err) => {
    if (!err.response) {
        return
    }
    if (err.response.data.error) {
        window.showToast(err.response.data.error, 'error')
        return
    }

    if (err.response && err.response.status === 403 && err.response.data.message) {
        window.showToast(trans.value.unauthorized, 'error')
        return
    }

    const errorKeys = Object.keys(err.response.data.errors)
    errorKeys.forEach(i => {
        if (err.response.data.errors[i][0].includes('(storage_full)')) {
            storageFull.value = err.response.data.errors[i][0].replace('(storage_full)', '')
            openDialog(cta.value);
            return;
        }
        window.showToast(err.response.data.errors[i][0], 'error')
    })
}

const selectImage = (image) => {
    currentUuid.value = image.uuid
    currentThumbnail.value = image.thumbnail
}

const closedGallery = () => {
    galleryOpened.value = false
}

const handleEscape = (event) => {
    if (event.key === 'Escape' && uploading.value) {
        cancelUpload()
    }
}

const cancelUpload = (event) => {
    cancelTokenSource.value.cancel('Upload canceled by user.')
}

const openDialog = async (dialog) => {
    ctaOpen.value = true
    await nextTick()
    cta.value.showModal()
    cta.value.addEventListener('click', clickOutside)
}

const closeDialog = (modal) => {
    modal.removeEventListener('click', clickOutside)
    modal.close()
    ctaOpen.value = false
}

const clickOutside = (event) => {
    let rect = event.target.getBoundingClientRect()
    let isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
        rect.left <= event.clientX && event.clientX <= rect.left + rect.width)
    if (!isInDialog && event.target.tagName === 'DIALOG') {
        closeDialog(event.target)
    }
}

onBeforeUnmount(() => {
    document.removeEventListener('click', closeDropdownOnOutside)
    document.removeEventListener('keydown', handleDropdownEscape)
    document.removeEventListener('keydown', handleEscape)
})

</script>
