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
    <input type="hidden" name="image_uuid" v-model="currentUuid" />

    <dialog class="dialog rounded-2xl text-center" id="gallery-dialog" ref="galleryDialog" aria-modal="true" aria-labelledby="modal-card-label">
        <header class="bg-base-200 sm:rounded-t">
            <h4>
                Gallery
            </h4>
            <button type="button" class="text-base-content" @click="closeGallery()" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="">
            <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" v-if="loadingGallery"></i>
            <div class="flex flex-wrap gap-5" v-else>
                <div v-for="image in galleryImages" class="cursor-pointer shadow rounded overflow-hidden hover:shadow-lg" @click="selectImage(image)">
                    <img class="w-48 h-36" :src="image.thumbnail" v-if="!image.folder" />
                    <div class="w-48 h-36 flex items-center align-middle justify-center text-4xl" v-else>
                        <i :class="image.icon" aria-label="Folder" />
                    </div>
                    <div class="truncate p-2 w-48" :title="image.name">
                        <span v-html="image.name"></span>
                    </div>
                </div>
            </div>
        </article>
    </dialog>
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
}>()

const loading = ref(true)
const downloading = ref(false)
const uploading = ref(false)
const loadingGallery = ref(false)
const imageUrl = ref()
const urlField = ref()
const fileField = ref()
const currentThumbnail = ref()
const currentUuid = ref()
const galleryDialog = ref()
const galleryImages = ref([])

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
    return 'url(' + currentThumbnail.value + ')'
}
const imageBackground = (image) => {
    return 'url(' + image.thumbnail + ')'
}

const openGallery = () => {
    console.log('I hate my life')
    loadingGallery.value = true
    galleryDialog.value.showModal()
    galleryDialog.value.addEventListener('click', function (event) {
        let rect = this.getBoundingClientRect()
        let isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
            rect.left <= event.clientX && event.clientX <= rect.left + rect.width)
        if (!isInDialog && event.target.tagName === 'DIALOG') {
            this.close()
        }
    });

    axios.get(props.browse).then(res => {
        galleryImages.value = res.data.images
        loadingGallery.value = false
    })

}

const closeGallery = () => {
    galleryDialog.value.close();
}

const download = () => {
    if (!imageUrl.value || !imageUrl.value.startsWith('https://')) {
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
    if (!err.response || !err.response.data.errors) {
        return
    }
    const errorKeys = Object.keys(err.response.data.errors);
    errorKeys.forEach(i => {
        window.showToast(err.response.data.errors[i][0], 'error')
    })
}

const selectImage = (image) => {
    if (image.folder) {
        loadingGallery.value = true
        axios.get(image.url).then(res => {
            galleryImages.value = res.data.images
            loadingGallery.value = false
        })
        return;
    }

    currentUuid.value = image.id
    currentThumbnail.value = image.thumbnail
    closeGallery()
}

</script>
