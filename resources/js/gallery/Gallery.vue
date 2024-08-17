<template>
    <div v-if="!initiated" class="text-center text-4xl p-4">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
    </div>
    <div v-else class="flex flex-col gap-4 md:gap-5">
        <div class="flex gap-4 flex-wrap sticky top-14">
            <div class="flex gap-2 grow">
                <div class="flex gap-0.5">
                    <input type="text" placeholder="Search" @input="handleSearchInput" />
                </div>
                <button class="btn2 btn-default">
                    <i class="fa-solid fa-filter" aria-hidden="true" />
                    <span v-html="trans('filters')"></span>
                </button>
            </div>
            <div class="flex gap-2 flex-none self-end">
                <button class="btn2 btn-default" v-if="!isBulking" @click="openNewFolder">
                    <i class="fa-solid fa-plus" aria-hidden="true" />
                    <span v-html="trans('new_folder')"></span>
                </button>
                <button class="btn2 btn-default" v-if="!isBulking" @click="startBulking">
                    <i class="fa-solid fa-plus" aria-hidden="true" />
                    <span v-html="trans('select')"></span>
                </button>
                <button class="btn2 btn-default" v-if="isBulking" @click="stopBulking" >
                    <span v-html="trans('cancel')"></span>
                </button>
                <button class="btn2 btn-primary" v-if="isBulking" @click="editBulk">
                    <span v-html="trans('move')"></span>
                </button>
                <button class="btn2 btn-error" v-if="isBulking" @click="deleteBulk">
                    <span v-html="trans('remove')"></span>
                </button>

            </div>
        </div>

        <div class="text-center text-4xl p-4" v-if="loading">
            <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
        </div>
        <div class="flex flex-col gap-4" v-else>
            <div v-if="folder" class="flex gap-1 flex-wrap text-xl">
                <a @click="home" v-html="trans('home')" class="text-base-content cursor-pointer"></a>
                <a v-for="breadcrumb in breadcrumbs" @click="open(breadcrumb)" v-html="breadcrumb.name" class="text-base-content cursor-pointer"></a>
            </div>
            <div class="flex gap-2 flex-row">
                <div :class="gridClass()">
                    <div v-if="canUpload" class="rounded-xl shadow bg-base-100 overflow-hidden w-[12rem] cursor-pointer flex justify-center items-center flex-col gap-4" @click="selectFiles">
                        <div class="flex flex-col gap-4 p-2" v-if="!uploading">
                            <div class="flex flex-col gap-2 items-center">
                                <i class="fa-regular fa-image text-4xl text-neutral-content" aria-hidden="true"></i>
                                <span>Upload files</span>
                            </div>
                            <div class="text-center text-xs">
                                <i class="fa-regular fa-info-circle mr-1 text-base" aria-hidden="true" />
                                <span v-html="trans('upload_hint')" class="text-neutral-content"></span>
                            </div>
                        </div>
                        <div v-else class="cover-background w-full h-full flex p-2" :style="{backgroundImage: 'url(\'' + imagePreview + '\')'}">
                            <div class="progress h-1 w-full self-end">
                                <div class="h-1 bg-accent shadow-sm" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" :style="{'width': progressPercentage()}">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <input type="file" multiple accept="image/*, .gif, .webp, .woff2" class="hidden" @change="filesSelected" ref="fileField" />
                    </div>

                    <Preview
                        v-for="file in files"
                        :file="file"
                        :isBulking="isBulking"
                        @select="selectFile(file)"
                    >
                    </Preview>

                    <div class="flex items-center justify-center grow" v-if="nextPage">
                        <button :class="loadMoreClass()" @click="openNextPage()" v-html="trans('load_more')"></button>
                    </div>
                </div>

                <div class="basis-1/4 bg-base-100 p-4 rounded flex flex-col gap-4" v-if="currentFile">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-clipboard" aria-hidden="true"></i>
                        <span class="font-extrabold">Details</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="font-extrabold">Name</label>
                        <input type="text" class="" maxlength="191" v-model="currentFile.name" />
                    </div>


                    <div class="flex flex-col gap-1">
                        <label class="font-extrabold">Visibility</label>
                        <select class="w-full" v-model="currentFile.visibility_id">
                            <option v-for="(name, id) in visibilities" :value="id" v-html="name"></option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label>Used in</label>

                        <div class="flex flex-wrap gap-2">
                            <a href="#" class="rounded-xl bg-base-200 px-4 py-1">Privite</a>
                        </div>
                    </div>



                    <div class="grid grid-cols-2 gap-2">
                        <div class="text-neutral-content">Size</div>
                        <div class="text-right" v-html="currentFile.size"></div>

                        <div class="text-neutral-content">Uploaded by</div>
                        <div class="text-right" v-html="currentFile.creator"></div>

                        <div class="text-neutral-content">File type</div>
                        <div class="text-right uppercase" v-html="currentFile.ext"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <dialog ref="newFolder" class="dialog rounded-2xl text-center" v-if="initiated">
        <header class="bg-base-200 sm:rounded-t">
            <h4 v-html="trans('new_folder')"></h4>
            <button type="button" class="text-base-content" @click="closeModal(newFolder)" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl flex flex-col gap-2 text-left">
            <div class="flex flex-col gap-1 w-full">
                <label>Name</label>
                <input type="text" class="w-full" v-model="folderName">
            </div>
            <div class="flex flex-col gap-1 w-full">
                <label>Visibility</label>
                <select class="w-full" v-model="folderVisibility">
                    <option v-for="(name, id) in visibilities" :value="id" v-html="name"></option>
                </select>
            </div>
        </article>
        <footer class="bg-base-200 p-2">
            <menu class="">
                <button type="submit" class="btn2 btn-primary" @click="createFolder">
                    Create
                </button>
            </menu>
        </footer>
    </dialog>
</template>

<script setup lang="ts">

import {onMounted, ref} from "vue";
import Preview from "./Preview.vue";

const props = defineProps<{
    api: String
}>()

const initiated = ref(false)
const loading = ref(false)
const deleteApi = ref()
const deleting = ref(false)
const loadingMore = ref(false)
const canUpload = ref(false)
const isBulking = ref(false)
const breadcrumbs = ref()
const nextPage = ref()
const currentFile = ref()

// Search stuff
const searchTerm = ref()
const lastTerm = ref()
const searching = ref(false)
const typingTimeout = ref(null)
const searchApi = ref()

const files = ref([])
const homeFiles = ref([])
const folder = ref()
const i18n = ref()
const isHome = ref(true)

// New folder
const creating = ref(false)
const createApi = ref()
const newFolder = ref()
const folderName = ref()
const folderVisibility = ref(1)
const visibilities = ref()

// Upload
const uploadApi = ref()
const fileField = ref()
const uploading = ref(false)
const imagePreview = ref()
const cancelTokenSource = ref(null)
const progress = ref(0)

onMounted(() => {
    axios.get(props.api)
        .then((res) => {
            initiated.value = true
            files.value = res.data.files
            homeFiles.value = res.data.files
            i18n.value = res.data.i18n
            searchApi.value = res.data.search
            deleteApi.value = res.data.delete
            createApi.value = res.data.create
            uploadApi.value = res.data.upload
            nextPage.value = res.data.next
            visibilities.value = res.data.visibilities
            canUpload.value = res.data.acl.upload
        })
})

const trans = (key) => {
    if (!i18n.value[key]) {
        console.error('Missing trans', i18n)
        return 'MISSING'
    }
    return i18n.value[key]
}

const startBulking = () => {
    isBulking.value = true;
}

const stopBulking = () => {
    isBulking.value = false;
}

const editBulk = () => {

}

const gridClass = () => {
    let css = 'flex gap-4 flex-wrap'
    if (currentFile.value) {
        css += ' basis-3/4'
    }
    return css
}

const deleteBulk = () => {
    let ids = files.value.filter(f => f.is_selected).map(f => f.id)
    if (ids.length === 0) {
        return
    }

    deleting.value = true
    axios
        .post(deleteApi.value, {images: ids})
        .then(res => {
            files.value = files.value.filter(i => !i.is_selected)
            // If we are on the home page, reset the home files
            if (isHome) {
                homeFiles.value = files.value
            }

            window.showToast(res.data.toast)
        })


}

const selectFile = (file) => {
    // Bulking? Do nothing
    if (isBulking.value) {
        let f = files.value.find(f => f.id === file.id)
        f.is_selected = !f.is_selected
        return;
    }
    // Open a folder
    if (file.is_folder) {
        openFolder(file);
        return;
    }

    // Open a file
    if (currentFile.value && currentFile.value.id === file.id) {
        currentFile.value = null
    } else {
        currentFile.value = file;
    }
}

const openFolder = (file) => {
    loading.value = true
    axios.get(file.open)
        .then(res => {
            folder.value = res.data.folder
            breadcrumbs.value = res.data.breadcrumbs
            files.value = res.data.files
            nextPage.value = res.data.next
            loading.value = false
            isHome.value = false
        })
}

const home = () => {
    loading.value = true
    files.value = homeFiles.value
    folder.value = null
    loading.value = false
    isHome.value = true
}

const handleSearchInput = (event) => {
    searchTerm.value = event.target.value
    if (typingTimeout.value) {
        clearTimeout(typingTimeout.value)
    }

    typingTimeout.value = setTimeout(() => {
        search()
    }, 300)
}

const search = () => {
    if (lastTerm.value == searchTerm.value) {
        return
    }
    lastTerm.value = searchTerm.value

    // Nothing? Go back home
    if (!searchTerm.value) {
        home()
        return;
    }

    loading.value = true
    axios.get(searchApi.value + '/' + searchTerm.value).then(res => {
        files.value = res.data.files
        nextPage.value = res.data.next
        folder.value = null
        loading.value = false
    })
}

const openNextPage = () => {
    loadingMore.value = true
    axios.get(nextPage.value).then(res => {
        res.data.files.forEach(file => {
            files.value.push(file)
        })
        nextPage.value = res.data.next
        loadingMore.value = false
    })
}

const loadMoreClass = () => {
    let css = 'btn2 btn-secondary'
    if (loadingMore.value) {
        css += ' loading btn-disabled'
    }
    return css
}


const openNewFolder = () => {
    newFolder.value.showModal()
    newFolder.value.addEventListener('click', function (event) {
        let rect = this.getBoundingClientRect()
        let isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
            rect.left <= event.clientX && event.clientX <= rect.left + rect.width)
        if (!isInDialog && event.target.tagName === 'DIALOG') {
            closeModal(newFolder.value)
        }
    });
}
const closeModal = (modal) => {
    // DOn't close the modal while it's thinking
    if (creating.value) {
        return
    }
    modal.close()
}

const createFolder = () => {
    if (creating.value) {
        return
    }
    let data = {}
    creating.value = true
    data.name = folderName.value
    data.visibility_id = folderVisibility.value
    axios.post(createApi.value, data).then(res => {
        folderName.value = null
        folderVisibility.value = 1
        creating.value = false

        files.value.unshift(res.data.folder)
        closeModal(newFolder.value)
    })
}

const selectFiles = () => {
    fileField.value.click()
}

const filesSelected = async (event) => {
    const file = event.target.files[0]
    const files = event.target.files
    if (!files) {
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
    formData.append('files[]', files)

    axios.post(uploadApi.value, formData, {
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
            fileField.value.disabled = false
            fileField.value = null
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
                //showErrors(err)
            }
            document.removeEventListener('keydown', handleEscape)
        })
}

const progressPercentage = () => {
    return progress.value + '%'
}

const handleEscape = (event) => {
    if (event.key === 'Escape' && uploading.value) {
        cancelUpload()
    }
}

const cancelUpload = () => {
    cancelTokenSource.value.cancel('Upload canceled by user.')
}

</script>
