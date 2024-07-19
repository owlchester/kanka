<template>
    <div v-if="loading">
        <i class="fa-solid fa-spin fa-spinner2" aria-label="Loading"></i>
    </div>

    <dialog class="dialog rounded-2xl text-center" id="gallery-dialog" ref="galleryDialog" aria-modal="true" aria-labelledby="modal-card-label">
        <header class="bg-base-200 sm:rounded-t">
            <h4>
                Gallery
            </h4>
            <button type="button" class="text-base-content" @click="closeBrowser()" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl">

            <div class="flex gap-1 w-full" v-if="!loading && !error">
                <div class="grow">
                    <input type="text" class="w-full" placeholder="Search for an image in the gallery" @input="handleInput" />
                </div>
                <div class="flex-none cursor-pointer btn2 btn-ghost btn-sm" v-if="mode !== 'large'" @click="toggle('large')">
                    <i class="fa-solid fa-grid-2" aria-label="Large images"></i>
                </div>
                <div class="flex-none cursor-pointer btn2 btn-ghost btn-sm" v-if="mode !== 'small'" @click="toggle('small')">
                    <i class="fa-solid fa-grid-4" aria-label="Small images"></i>
                </div>
            </div>

            <div class="md:h-36 md:w-80 text-center flex items-center justify-center w-full" v-if="loading || searching">
                <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
            </div>

            <div :class="gridClass()" v-else>
                <div v-for="image in images" class="cursor-pointer shadow rounded overflow-hidden hover:shadow-lg" @click="selectImage(image)">
                    <div :class="previewSize('cover-background')" :style="{'backgroundImage': 'url(' + image.thumbnail + ')'}" v-if="!image.folder" />
                    <div :class="previewSize('flex items-center align-middle justify-center text-4xl')" v-else>
                        <i :class="image.icon" aria-label="Folder" />
                    </div>
                    <div :class="widthSize('truncate p-2')" :title="image.name">
                        <span v-html="image.name"></span>
                    </div>
                </div>
                <div class="alert alert-error p-2 rounded" v-if="error" v-html="error"></div>
            </div>
        </article>
    </dialog>
</template>

<script setup lang="ts">
import {ref, onMounted, onBeforeUnmount, watch} from 'vue'

const props = defineProps<{
    api: string,
    opened: boolean
}>()

const emit = defineEmits(['selected', 'closed'])

const loading = ref(true)
const searching = ref(false)
const galleryDialog = ref()
const images = ref([])
const term = ref('')
const lastTerm = ref('')
const typingTimeout = ref(null)
const error = ref(null)
const debounceDelay = 300
const mode = ref('large')


const open = () => {
    loading.value = true
    galleryDialog.value.showModal()
    galleryDialog.value.addEventListener('click', function (event) {
        let rect = this.getBoundingClientRect()
        let isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
            rect.left <= event.clientX && event.clientX <= rect.left + rect.width)
        if (!isInDialog && event.target.tagName === 'DIALOG') {
            closeBrowser()
        }
    });

    axios.get(props.api)
        .then(res => {
            images.value = res.data.images
            loading.value = false
        })
        .catch(err => {
            loading.value = false
            if (err.response.status === 403) {
                error.value = err.response.data.message //'You aren\'t a member of any roles that have access to the gallery'
            }
        })
}

const closeBrowser = () => {
    galleryDialog.value.close()
    emit('closed')
}

const previewSize = (extra) => {
    extra = extra ?? ''
    if (mode.value === 'large') {
        return 'w-48 h-36 ' + extra
    }
    return 'w-20 h-16 ' + extra
}

const widthSize = (extra) => {
    extra = extra ?? ''
    if (mode.value === 'large') {
        return 'w-48 ' + extra
    }
    return 'w-20 ' + extra
}

const gridClass = () => {
    if (mode.value === 'small') {
        return 'flex flex-wrap gap-2'
    }
    return 'flex flex-wrap gap-2 md:gap-5'
}

const selectImage = (image) => {
    if (image.folder) {
        loading.value = true
        axios.get(image.url).then(res => {
            images.value = res.data.images
            loading.value = false
        })
        return;
    }

    emit('selected', image)
    closeBrowser()
}

watch(() => props.opened, (newVal, oldVal) => {
    if (newVal) {
        open()
    }
})

const handleInput = (event) => {
    term.value = event.target.value
    if (typingTimeout.value) {
        clearTimeout(typingTimeout.value)
    }

    typingTimeout.value = setTimeout(() => {
        search()
    }, debounceDelay)
}

const search = () => {
    if (lastTerm.value == term.value) {
        return
    }

    lastTerm.value = term.value
    searching.value= true

    axios.get(props.api + '?term=' + lastTerm.value).then(res => {
        images.value = res.data.images
        searching.value = false
    })
}

const toggle = (layout) => {
    mode.value = layout
}
</script>
