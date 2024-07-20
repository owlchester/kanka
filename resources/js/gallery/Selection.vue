<template>
    <div v-if="loading">
        <i class="fa-solid fa-spin fa-spinner2" aria-label="Loading"></i>
    </div>
    <div v-else :class="backgroundClass()" :style="{'backgroundImage': backgroundImage()}">
        <div :class="buttonsClass()">
            <div class="rounded p-2 cursor-pointer backdrop-blur backdrop-opacity-30 bg-red-700/50 text-white hover:backdrop-opacity-100 transition" v-if="hasPreview()" @click="removeImage()" v-html="trans.remove">
            </div>
            <div class="flex items-center gap-1" v-if="!hasImage()">
                <input type="file" v-bind:accept="props.accepts" class="w-full" @change="upload" ref="fileField" />
            </div>
            <div class="flex items-center gap-1" v-if="!hasImage()">
                <input ref="urlField" type="text" class="w-full" v-model="imageUrl" @blur="download()" :placeholder="trans.url" />
                <i class="fa-solid fa-spin fa-spinner" v-if="downloading" aria-label="Downloading" />
            </div>
            <div class="flex items-center gap-1" v-if="!hasImage()">
                <span role="button" class="btn2 btn-default btn-sm" @click="openGallery()" v-html="trans.gallery"></span>
            </div>
        </div>
        <div v-if="uploading" class="flex gap-2 flex-col w-full">
            <div class="progress h-1 w-full">
                <div class="h-1 bg-accent shadow-sm" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" :style="{'width': progressPercentage()}">
                    <span class="sr-only"></span>
                </div>
            </div>
            <div class="rounded p-2 cursor-pointer backdrop-blur backdrop-opacity-30 bg-red-700/50 text-white hover:backdrop-opacity-100 transition flex items-center gap-2" @click="cancelUpload()">
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
</template>

<script setup lang="ts">
import {ref, onMounted, onBeforeUnmount} from 'vue'
import Browser from "./Browser.vue"

const props = defineProps<{
    file: string,
    url: string,
    accepts: string,
    uuid: string,
    thumbnail: string,
    browse: string,
    field: string,
    old: string, // Using the old system
    i18n: undefined,
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
const removedOld = ref(false)
const trans = ref(null)

onMounted(() => {
    loading.value = false
    currentThumbnail.value = props.thumbnail
    currentUuid.value = props.uuid
    if (props.old === 'true') {
        hasOld.value = true
    }

    console.log('props', props.i18n)
    trans.value = JSON.parse(props.i18n)
    console.log('parse', trans.value)
});


const backgroundClass = () => {
    let css = 'relative flex items-end align-middle rounded overflow-hidden'

    if (!hasPreview()) {
        css += 'w-full'
    } else {
        css += ' cover-background preview-bg w-48 h-36 p-2 '
    }
    return css
}

const buttonsClass = () => {
    return uploading.value ? 'hidden' : 'flex gap-2 flex-col w-full'
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


const download = () => {
    if (!imageUrl.value || imageUrl.value == lastImageUrl) {
        return
    }

    downloading.value = true
    urlField.value.disabled = true
    lastImageUrl = imageUrl.value

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

const upload = async (event) => {
    const file = event.target.files[0]
    if (!file) {
        uploading.value = false
        return
    }
    const reader = new FileReader()
    reader.onload = (e) => {
        imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)

    uploading.value = true
    document.addEventListener('keydown', handleEscape)
    cancelTokenSource.value = axios.CancelToken.source()
    fileField.value.disabled = true

    const formData = new FormData()
    formData.append('file', file)

    axios.post(props.file, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
        cancelToken: cancelTokenSource.value.token,
        onUploadProgress: function (progressEvent) {
            progress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total);
        }
    })
        .then(res => {
            uploading.value = false
            fileField.value.disabled = false
            fileField.value = null
            currentThumbnail.value = res.data.thumbnail
            currentUuid.value = res.data.uuid
            imagePreview.value = null
            document.removeEventListener('keydown', handleEscape)
        })
        .catch (err => {
            uploading.value = false
            fileField.value.disabled = false
            imagePreview.value = null
            if (axios.isCancel(err)) {
                // User cancelled
                fileField.value = null
            } else {
                showErrors(err)
            }
            document.removeEventListener('keydown', handleEscape)
        })
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
        window.showToast(err.response.data.message, 'error')
        return
    }

    const errorKeys = Object.keys(err.response.data.errors);
    errorKeys.forEach(i => {
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

</script>
