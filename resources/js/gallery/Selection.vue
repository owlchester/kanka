<template>
    <div v-if="loading">
        <i class="fa-solid fa-spin fa-spinner2" aria-label="Loading"></i>
    </div>
    <div v-else v-bind:class="backgroundClass()" :style="{'backgroundImage': backgroundImage()}">
        <div class="flex gap-2 flex-col w-full">
            <div class="rounded p-2 cursor-pointer backdrop-blur backdrop-opacity-30 bg-red-700/50 text-white hover:backdrop-opacity-100 transition" v-if="hasImage()" @click="removeImage()">
                Remove
            </div>
            <div class="flex items-center gap-1" v-if="!hasImage()">
                <input type="file" v-bind:accept="props.accepts" class="w-full" @change="upload" ref="fileField" />
                <i class="fa-solid fa-spin fa-spinner" v-if="uploading" aria-label="Uploading" />
            </div>
            <div class="flex items-center gap-1" v-if="!hasImage()">
                <input ref="urlField" type="text" class="w-full" v-model="imageUrl" @blur="download()" placeholder="Upload an image from a URL" />
                <i class="fa-solid fa-spin fa-spinner" v-if="downloading" aria-label="Downloading" />
            </div>
            <div class="flex items-center gap-1" v-if="!hasImage()">
                <span role="button" class="btn2 btn-default btn-sm" @click="openGallery()">From gallery</span>
            </div>
        </div>
    </div>
    <input type="hidden" name="entity_image_uuid" v-model="currentUuid" />

    <gallery-browser
        :api="props.browse"
        :opened="galleryOpened"
        @selected="selectImage"
        @closed="closedGallery"
    ></gallery-browser>
</template>

<script setup lang="ts">
import {ref, onMounted, onBeforeUnmount} from 'vue'

const props = defineProps<{
    file: string,
    url: string,
    accepts: string,
    uuid: string,
    thumbnail: string,
    browse: string,
    // i18n: Object,
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

onMounted(() => {
    loading.value = false;
    currentThumbnail.value = props.thumbnail;
    currentUuid.value = props.uuid;
});


const backgroundClass = () => {
    let css = 'relative flex items-end align-middle rounded overflow-hidden';

    if (!hasImage()) {
        css += 'w-full'
    } else {
        css += ' cover-background preview-bg w-48 h-36 p-2 '
    }
    return css;
}

const hasImage = () => {
    return currentUuid.value !== null && currentUuid.value !== ''
}

const removeImage = () => {
    currentUuid.value = null
    currentThumbnail.value = null
}

const backgroundImage = () => {
    if (!currentThumbnail.value) {
        return ''
    }
    return 'url(' + currentThumbnail.value + ')'
}

const openGallery = () => {
    galleryOpened.value = true
}


const download = () => {
    if (!imageUrl.value) {
        return
    }

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

const upload = async (event) => {
    const file = event.target.files[0]
    if (!file) {
        uploading.value = false
        return
    }
    uploading.value = true
    fileField.value.disabled = true

    const formData = new FormData()
    formData.append('file', file)

    axios.post(props.file, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
        .then(res => {
            uploading.value = false
            fileField.value.disabled = false
            fileField.value = null
            currentThumbnail.value = res.data.thumbnail
            currentUuid.value = res.data.uuid
        })
        .catch (err => {
            uploading.value = false
            fileField.value.disabled = false
            showErrors(err)
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

</script>
