<template>
    <div v-if="!initiated" class="text-center text-4xl p-4">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
    </div>
    <div v-else class="flex flex-col gap-4 md:gap-5">
        <div class="flex gap-4 flex-wrap sticky top-14 z-50">
            <div class="flex gap-2 grow">
                <div class="flex gap-0.5">
                    <input type="text" placeholder="Search" @input="handleSearchInput" />
                </div>
                <button class="btn2 btn-default btn-sm">
                    <i class="fa-solid fa-filter" aria-hidden="true" />
                    <span v-html="trans('filters')"></span>
                </button>
            </div>
            <div class="flex gap-2 flex-none self-end">

                <button class="btn2 btn-default btn-sm" v-if="!isBulking && folder" @click="openFolderDetails">
                    <i class="fa-regular fa-clipboard" aria-hidden="true" />
                    <span v-html="trans('details')"></span>
                </button>
                <button class="btn2 btn-default btn-sm" v-if="!isBulking" @click="openNewFolder">
                    <i class="fa-solid fa-plus" aria-hidden="true" />
                    <span v-html="trans('new_folder')"></span>
                </button>
                <button class="btn2 btn-default btn-sm" v-if="!isBulking" @click="startBulking">
                    <i class="fa-solid fa-list-check" aria-hidden="true" />
                    <span v-html="trans('select')"></span>
                </button>
                <button class="btn2 btn-primary btn-sm" v-if="isBulking" @click="openMove">
                    <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true" />
                    <span v-html="trans('move')"></span>
                    <span v-html="countSelected()"></span>
                </button>
                <button class="btn2 btn-error btn-sm" v-if="isBulking" @click="deleteBulk">
                    <i class="fa-regular fa-trash-can" aria-hidden="true" />
                    <span v-html="trans('remove')"></span>
                    <span v-html="countSelected()"></span>
                </button>
                <button class="btn2 btn-default btn-sm" v-if="isBulking" @click="stopBulking" >
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                    <span v-html="trans('cancel')"></span>
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

                <div class="basis-1/2 md:basis-1/4 " v-if="currentFile">
                    <File
                        :file="currentFile"
                        :visibilities="visibilities"
                        :i18n="i18n"
                        @updated="updatedFile"
                        @deleted="deletedFile"
                        @closed="closeFile"
                    ></File>

                </div>
            </div>
        </div>
    </div>

    <dialog ref="newDialog" class="dialog rounded-2xl text-center" v-if="initiated">
        <header class="bg-base-200 sm:rounded-t">
            <h4 v-html="trans('new_folder')"></h4>
            <button type="button" class="text-base-content" @click="closeModal(newDialog)" title="Close">
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


    <dialog ref="moveDialog" class="dialog rounded-2xl text-center" v-if="initiated">
        <header class="bg-base-200 sm:rounded-t">
            <h4 v-html="trans('move')"></h4>
            <button type="button" class="text-base-content" @click="closeModal(moveDialog)" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl flex flex-col gap-2 text-left">
            <div class="flex flex-col gap-1 w-full">
                <label>Folder</label>
                <select class="w-full" v-model="targetFolder">
                    <option v-for="(name, id) in folders" :value="id" v-html="name"></option>
                </select>
            </div>
        </article>
        <footer class="bg-base-200 p-2">
            <menu class="">
                <button type="submit" class="btn2 btn-primary" @click="moveFiles">
                    Move
                </button>
            </menu>
        </footer>
    </dialog>
</template>

<script setup lang="ts">

import {onMounted, onUnmounted, ref} from "vue";
import Preview from "./Preview.vue";
import File from "./File.vue";

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
const newDialog = ref()
const moveDialog = ref()
const folderName = ref()
const folderVisibility = ref(1)
const visibilities = ref()

// Move
const targetFolder = ref()
const folders = ref()
const moveApi = ref()

// Upload
const moving = ref(false)
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
            moveApi.value = res.data.move
            nextPage.value = res.data.next
            visibilities.value = res.data.visibilities
            canUpload.value = res.data.acl.upload
            folders.value = res.data.folders
        })

    window.addEventListener('keydown', handleEscapeKey)
})

onUnmounted(() => {
    window.removeEventListener('keydown', handleEscapeKey);
})

const handleEscapeKey = (event) => {
    if (event.key === 'Escape' || event.key === 'Esc') {
        if (uploading.value) {
            cancelUpload()
        }
        if (currentFile.value) {
            currentFile.value = null
        }
        if (isBulking.value) {
            isBulking.value = null
        }
    }
}


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

const openMove = () => {
    openDialog(moveDialog.value)
}

const gridClass = () => {
    let css = 'flex gap-4 flex-wrap'
    if (currentFile.value) {
        css += ' basis-2/4 md:basis-3/4'
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
            folder.value = file
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
    currentFile.value = null
    folder.value = null
    loading.value = false
    isHome.value = true
    isBulking.value = false
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
    openDialog(newDialog.value)
}

const openDialog = (dialog) => {
    dialog.showModal()
    dialog.addEventListener('click', clickOutside);
}

const clickOutside = (event) => {
    let rect = event.target.getBoundingClientRect()
    let isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
        rect.left <= event.clientX && event.clientX <= rect.left + rect.width)
    if (!isInDialog && event.target.tagName === 'DIALOG') {
        closeModal(event.target)
    }
}

const closeModal = (modal) => {
    // DOn't close the modal while it's thinking
    if (creating.value) {
        return
    }
    modal.removeEventListener('click', clickOutside)
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
    if (folder.value) {
        data.folder_id = folder.value.id
    }
    axios.post(createApi.value, data).then(res => {
        folderName.value = null
        folderVisibility.value = 1
        creating.value = false

        files.value.unshift(res.data.folder)
        folders.value[res.data.folder.id] = res.data.folder.name
        closeModal(newDialog.value)
    })
}

const moveFiles = () => {
    if (moving.value) {
        return
    }
    let ids = files.value.filter(f => f.is_selected).map(f => f.id)
    if (ids.length === 0) {
        alert('select at least one image')
    }

    moving.value = true
    let data = {}
    data.folder_id = targetFolder.value
    data.images = ids

    axios.post(moveApi.value, data).then(res => {
        targetFolder.value = null
        moving.value = false

        // Remove selected files from current folder
        files.value = files.value.filter(i => !i.is_selected)

        // If the files were moved to the homepage... do something?

        window.showToast(res.data.toast)
        closeModal(moveDialog.value)
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
        })
}

const countSelected = () => {
    let count = files.value.filter(f => f.is_selected).length
    if (count === 0) {
        return
    }
    return '(' + count + ')'
}

const progressPercentage = () => {
    return progress.value + '%'
}


const cancelUpload = () => {
    cancelTokenSource.value.cancel('Upload canceled by user.')
}

// A file has been updated in the side panel, update our main reference?
const updatedFile = (file) => {

}
const deletedFile = (file) => {
    files.value = files.value.filter(f => f.id !== file.id)
    currentFile.value = null

    if (file.is_folder) {
        if (file.folder_id) {

        } else {
            home()
        }
    }
}

const closeFile = () => {
    currentFile.value = null
}

const openFolderDetails = () => {
    if (currentFile.value === folder.value) {
        currentFile.value = null
        return
    }
    currentFile.value = folder.value;
}

</script>
