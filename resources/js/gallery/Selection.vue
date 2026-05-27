<template>
    <div v-if="loading">
        <i class="fa-solid fa-spin fa-spinner" aria-label="Loading"></i>
    </div>
    <div v-else :class="backgroundClass()" :style="{'backgroundImage': backgroundImage()}">
        <div :class="buttonsClass()">
            <div class="rounded p-2 cursor-pointer backdrop-blur-sm backdrop-opacity-30 bg-red-700/50 text-white hover:backdrop-opacity-100 transition" v-if="hasPreview()" @click="removeImage()" v-html="trans.remove">
            </div>
            <div class="flex items-center gap-1" v-if="!hasImage()">
                <input type="file" v-bind:accept="props.accepts" class="w-full" @change="upload" ref="fileField" />
            </div>
            <div class="flex items-center gap-1" v-if="!hasImage()">
                <input ref="urlField" type="text" class="w-full" v-model="imageUrl" @blur="download()" @paste="pasteUrl" :placeholder="trans.url" />
                <i class="fa-solid fa-spin fa-spinner" v-if="downloading" aria-label="Downloading" />
            </div>
            <div class="flex items-center gap-1" v-if="!hasImage()">
                <span role="button" class="btn2 btn-outline btn-sm" @click="openGallery()" v-html="trans.gallery"></span>
            </div>
        </div>
        <div v-if="uploading" class="flex gap-2 flex-col w-full">
            <div class="progress h-1 w-full">
                <div class="h-1 bg-accent shadow-xs" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" :style="{'width': progressPercentage()}">
                    <span class="sr-only"></span>
                </div>
            </div>
            <div class="rounded p-2 cursor-pointer backdrop-blur-sm backdrop-opacity-30 bg-red-700/50 text-white hover:backdrop-opacity-100 transition flex items-center gap-2" @click="cancelUpload()">
                <span class="grow" v-html="trans.cancel"></span>
                <span class="text-xs flex-none" v-html="progressPercentage()"></span>
            </div>
        </div>
    </div>
    <input type="hidden" :name="props.field" v-model="currentUuid" />
    <input type="hidden" :name="'remove-image'" value="1" v-if="removedOld" />

    <Browser
        :api="props.browse"
        :opened="galleryOpened"
        :i18n="i18n"
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

const toggleDropdown = () => {
    if (uploading.value) {
        return
    }
    dropdownOpen.value = !dropdownOpen.value
    if (dropdownOpen.value) {
        nextTick(() => {
            document.addEventListener('click', closeDropdownOnOutside)
        })
    } else {
        document.removeEventListener('click', closeDropdownOnOutside)
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
    document.removeEventListener('keydown', handleEscape)
})

</script>
