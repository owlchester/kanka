<template>
    <div v-if="!initiated" class="text-center text-4xl p-4">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
    </div>
    <div v-else class="flex flex-col gap-4 md:gap-5">
        <div class="flex gap-4 items-end">
            <div class="flex flex-col gap-1 grow">
                <div class="flex gap-1 items-center">
                    <i class="fa-regular fa-cloud text-xl" aria-hidden="true"></i>
                    <span class="font-extrabold" v-html="trans('storage')"></span>
                </div>
                <div class="flex gap-1 items-center">
                    <span v-html="usedSpace()"></span>
                    <span v-html="trans('of')"></span>
                    <span v-html="totalSpace()"></span>
                </div>
                <div class="bg-base-300 rounded h-2 w-full overflow-hidden transition-all duration-300 ">
                    <div :class="usedClasses()" :style="{width: usedPercentage() + '%'}"></div>
                </div>
            </div>
            <div v-if="!premium || (usedPercentage() > 89) && (isWyvern || isElemental)">
                <a :href="upgradeLink" v-html="trans('upgrade')" class="btn2 btn-default"></a>
            </div>
        </div>

        <div class="flex gap-4 flex-wrap sticky top-14 z-50">
            <div class="flex gap-2 grow">
                <div class="flex gap-0.5">
                    <input type="text" placeholder="Search" @input="handleSearchInput" />
                </div>
                <div class="relative">
                    <button class="btn2 btn-default btn-sm" @click="toggleFilters">
                        <i class="fa-regular fa-filter" aria-hidden="true" />
                        <span v-html="trans('filters')" class="hidden md:inline"></span>
                        <span v-if="showUnused">(1)</span>
                    </button>
                    <div class="border shadow-sm rounded bg-base-100 p-4 absolute right-0 flex flex-col gap-5 w-60" v-if="showFilters"  v-click-outside="onClickOutside">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" v-model="showUnused" value="1" id="_show_unused" @change="toggleUnused" />
                            <label for="_show_unused" class="cursor-pointer" v-html="trans('filter_only_unused')">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button class="btn2 btn-default btn-sm" @click="toggleSort">
                        <i class="fa-regular fa-arrow-up-arrow-down" aria-hidden="true" />
                        <span v-html="trans('sort')" class="hidden md:inline"></span>
                        <span v-if="sortAsc || sortDesc">(1)</span>
                    </button>
                    <div
                        class="border shadow-sm rounded bg-base-100 p-4 absolute right-0 top-full mt-2 flex flex-col gap-1 w-60 z-50"
                        v-if="showSort"
                        v-click-outside="onClickOutside"
                    >
                        <ul class="flex flex-col gap-1 list-none m-0 p-0">
                            <li>
                            <span class="cursor-pointer flex items-center gap-2 px-2 py-2 rounded hover:bg-gray-100 transition" @click="sort('default')">
                                <i v-if="sortDefault" class="fa-regular fa-check" aria-hidden="true" />
                                <span v-html="trans('sort_default')" class="inline"></span>
                            </span>
                            </li>

                            <li>
                            <span class="cursor-pointer flex items-center gap-2 px-2 py-2 rounded hover:bg-gray-100 transition" @click="sort('asc')">
                                <i v-if="sortAsc" class="fa-regular fa-check" aria-hidden="true" />
                                <span v-html="trans('sort_asc')" class="inline"></span>
                            </span>
                            </li>

                            <li>
                            <span class="cursor-pointer flex items-center gap-2 px-2 py-2 rounded hover:bg-gray-100 transition" @click="sort('desc')">
                                <i v-if="sortDesc" class="fa-regular fa-check" aria-hidden="true" />
                                <span v-html="trans('sort_desc')" class="inline"></span>
                            </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 self-end flex-wrap">

                <button class="btn2 btn-default btn-sm" v-if="!isBulking && folder" @click="openFolderDetails">
                    <i class="fa-regular fa-clipboard" aria-hidden="true" />
                    <span v-html="trans('details')"></span>
                </button>
                <button class="btn2 btn-default btn-sm" v-if="!isBulking && canManage" @click="openNewFolder">
                    <i class="fa-regular fa-plus" aria-hidden="true" />
                    <span v-html="trans('new_folder')"></span>
                </button>
                <button class="btn2 btn-default btn-sm" v-if="!isBulking && canManage" @click="startBulking">
                    <i class="fa-regular fa-list-check" aria-hidden="true" />
                    <span v-html="trans('select')"></span>
                </button>
                <button class="btn2 btn-primary btn-sm" v-if="isBulking" @click="openUpdate">
                    <i class="fa-regular fa-pencil" aria-hidden="true" />
                    <span v-html="trans('update')"></span>
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
                <span class="flex gap-1 items-center" v-for="(breadcrumb, index) in breadcrumbs">
                    <i class="fa-solid fa-chevron-right text-base" aria-hidden="true" />
                    <a @click="openFolder(breadcrumb)" v-html="breadcrumb.name" class="text-base-content cursor-pointer"></a>
                </span>
            </div>
            <div class="flex gap-2 flex-row">
                <div :class="gridClass()">
                    <div v-if="canUpload && !showUnused" class="rounded-xl shadow bg-base-100 overflow-hidden col-span-2 sm:col-span-3 md:w-48 cursor-pointer flex justify-center items-center flex-col gap-4" @click="selectFiles">
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
                        <div v-else-if="hasPreview()" class="cover-background w-full h-full flex p-2" :style="{backgroundImage: 'url(\'' + imagePreview + '\')'}">
                            <div class="progress h-1 w-full self-end">
                                <div class="h-1 bg-accent shadow-xs" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" :style="{'width': progressPercentage()}">
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
                        :i18n="i18n"
                        @select="selectFile(file)"
                    >
                    </Preview>
                </div>

                <div class="fixed bottom-0 w-full left-0 right-0 shadow-md md:shadow-none md:relative md:basis-1/4 " v-if="currentFile">
                    <File
                        :file="currentFile"
                        :visibilities="visibilities"
                        :premium="premium"
                        :canManage="canManage"
                        :i18n="i18n"
                        @updated="updatedFile"
                        @deleted="deletedFile"
                        @closed="closeFile"
                    ></File>
                </div>
            </div>
        </div>
    </div>

    <div ref="infiniteScrollTrigger" class="h-4">
        <div v-if="loadingMore" class="text-center text-4xl p-4">
            <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
        </div>
    </div>

    <dialog ref="newDialog" class="dialog rounded-2xl text-center bg-base-100 text-base-content" v-if="initiated">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans('new_folder')" class="text-lg font-normal"></h4>
            <button type="button" class="text-base-content" @click="closeModal(newDialog)" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl flex flex-col gap-2 text-left p-4 md:px-6">
            <div class="flex flex-col gap-1 w-full">
                <label v-html="trans('name')"></label>
                <input type="text" class="w-full" v-model="folderName" ref="folderNameField" @keyup.enter="createFolder">
            </div>
            <div class="flex flex-col gap-1 w-full">
                <label v-html="trans('visibility')"></label>
                <select class="w-full" v-model="folderVisibility">
                    <option v-for="(name, id) in visibilities" :value="id" v-html="name"></option>
                </select>
            </div>
        </article>
        <footer class="bp-4 md:px-6">
            <menu class="">
                <button type="submit" class="btn2 btn-primary" @click="createFolder" v-html="trans('create')">
                </button>
            </menu>
        </footer>
    </dialog>

    <dialog ref="updateDialog" class="dialog rounded-2xl text-center bg-base-100 text-base-content" v-if="initiated">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans('update')" class="text-lg font-normal"></h4>
            <button type="button" class="text-base-content" @click="closeModal(updateDialog)" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl flex flex-col gap-2 text-left p-4 md:px-6">
            <div class="flex flex-col gap-1 w-full">
                <label v-html="trans('visibility')"></label>
                <select class="w-full" v-model="bulkVisibility">
                    <option v-for="(name, id) in bulkVisibilities" :value="id" v-html="name"></option>
                </select>
            </div>
            <div class="flex flex-col gap-1 w-full">
                <label v-html="trans('folder')"></label>
                <select class="w-full" v-model="bulkFolder">
                    <option v-for="(name, id) in folders" :value="id" v-html="name"></option>
                </select>
            </div>
        </article>
        <footer class="bg-base-200 p-2">
            <menu class="">
                <button type="submit" class="btn2 btn-primary" @click="updateFiles" v-html="trans('change')">
                </button>
            </menu>
        </footer>
    </dialog>
</template>

<script setup lang="ts">

import {onMounted, onUnmounted, onBeforeUnmount, ref, nextTick} from "vue";
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
const premium = ref(false)
const isWyvern = ref(false)
const isElemental = ref(false)
const canManage = ref(false)
const breadcrumbs = ref()
const nextPage = ref()
const currentFile = ref()

// Search stuff
const searchTerm = ref()
const lastTerm = ref()
const searching = ref(false)
const typingTimeout = ref(null)
const searchApi = ref()
const apiParameters = ref([])

const files = ref([])
const homeFiles = ref([])
const folder = ref()
const i18n = ref()
const isHome = ref(true)
const homeUrl = ref()

// New folder
const creating = ref(false)
const createApi = ref()
const newDialog = ref()
const folderName = ref()
const folderNameField = ref()
const folderVisibility = ref(1)
const visibilities = ref()
const bulkVisibilities = ref()

// Visibility folder
const updateDialog = ref()
const bulkVisibility = ref()
const bulkFolder = ref()

// Move
const folders = ref()
const updateApi = ref()

// Upload
const moving = ref(false)
const uploadApi = ref()
const fileField = ref()
const uploading = ref(false)
const imagePreview = ref(null)
const cancelTokenSource = ref(null)
const progress = ref(0)

// Filters
const showFilters = ref(false)
const showUnused = ref(false)
const showSort = ref(false)
const sortAsc = ref(false)
const sortDesc = ref(false)
const sortDefault = ref(true)

// Space
const total = ref()
const used = ref()
const upgradeLink = ref()

//Infinite Scrolling
const infiniteScrollTrigger = ref(null)
let observer: IntersectionObserver | null = null

onMounted(() => {
    axios.get(props.api)
        .then((res) => {
            initiated.value = true
            files.value = res.data.files
            homeFiles.value = res.data.files
            homeUrl.value = res.data.url
            i18n.value = res.data.i18n
            searchApi.value = res.data.api.search
            deleteApi.value = res.data.api.delete
            updateApi.value = res.data.api.update
            createApi.value = res.data.api.create
            uploadApi.value = res.data.api.upload
            nextPage.value = res.data.next
            visibilities.value = res.data.visibilities
            bulkVisibilities.value = res.data.bulkVisibilities
            canUpload.value = res.data.acl.upload
            premium.value = res.data.acl.premium
            isWyvern.value = res.data.acl.wyvern
            isElemental.value = res.data.acl.elemental
            canManage.value = res.data.acl.manage
            folders.value = res.data.folders

            total.value = res.data.space.total
            used.value = res.data.space.used
            upgradeLink.value = res.data.upgrade

            // Set up infinite scroll observer after data is loaded
            nextTick(() => {
                observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            openNextPage()
                        }
                    })
                })

                if (infiniteScrollTrigger.value) {
                    observer.observe(infiniteScrollTrigger.value)
                }
            })
        })

    window.addEventListener('keydown', handleEscapeKey)
})

onBeforeUnmount(() => {
  if (observer && infiniteScrollTrigger.value) {
    observer.unobserve(infiniteScrollTrigger.value)
  }
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
        else if (showFilters.value) {
            showFilters.value = false
        }
    }
}


const trans = (key) => {
    if (!i18n.value[key]) {
        console.error('Missing trans', key, i18n)
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

const openUpdate = () => {
    openDialog(updateDialog.value)
    bulkVisibility.value = null
    bulkFolder.value = null
}

const gridClass = () => {
    let css = 'grid grid-cols-2 sm:grid-cols-3 md:flex gap-2 sm:gap-3 md:gap-4 md:flex-wrap'
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
            if (isHome.value) {
                homeFiles.value = files.value
            }
            used.value = res.data.used;

            isBulking.value = false
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

            //window.history.pushState({}, "", res.data.url);
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

    //window.history.pushState({}, "", homeUrl.value);
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
        apiParameters.value['searchParam'] = '';
        home()
        return;
    }

    loading.value = true

    apiParameters.value['searchParam'] = 'term=' + searchTerm.value;

    var params = '';

    if (apiParameters.value['searchParam']) {
        params += apiParameters.value['searchParam'] + '&';
    }

    if (apiParameters.value['sortParam']) {
        params += apiParameters.value['sortParam'] + '&';
    }

    if (apiParameters.value['toggleParam']) {
        params += apiParameters.value['toggleParam'] + '&';
    }

    axios.get(searchApi.value + '/?' + params).then(res => {
        showSearchResults(res.data)
    })
}

const openNextPage = () => {
    if (nextPage.value == null || loadingMore.value == true) {
        return
    }
    loadingMore.value = true

    var params = '';

    if (apiParameters.value['searchParam']) {
        params += apiParameters.value['searchParam'] + '&';
    }

    if (apiParameters.value['sortParam']) {
        params += apiParameters.value['sortParam'] + '&';
    }

    if (apiParameters.value['toggleParam']) {
        params += apiParameters.value['toggleParam'] + '&';
    }

    axios.get(nextPage.value + '&' + params).then(res => {
        res.data.files.forEach(file => {
            files.value.push(file)
        })
        nextPage.value = res.data.next
        loadingMore.value = false
    })
}

const openNewFolder = () => {
    openDialog(newDialog.value)
    folderNameField.value.focus()
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

// const moveFiles = () => {
//     if (moving.value) {
//         return
//     }
//     let ids = files.value.filter(f => f.is_selected).map(f => f.id)
//     if (ids.length === 0) {
//         alert('select at least one image')
//     }
//
//     moving.value = true
//     let data = {}
//     data.folder_id = targetFolder.value
//     data.images = ids
//
//     axios.post(moveApi.value, data).then(res => {
//         targetFolder.value = null
//         moving.value = false
//
//         // Remove selected files from current folder
//         files.value = files.value.filter(i => !i.is_selected)
//
//         // If the files were moved to the homepage... do something?
//         isBulking.value = false
//
//         window.showToast(res.data.toast)
//         closeModal(moveDialog.value)
//     })
// }
const updateFiles = () => {
    if (moving.value) {
        return
    }
    let ids = files.value.filter(f => f.is_selected).map(f => f.id)
    if (ids.length === 0) {
        return
    }

    moving.value = true
    let data = {}
    if (bulkFolder.value) {
        if (bulkFolder.value === '0') {
            data.folder_home = 1
        } else {
            data.folder_id = bulkFolder.value
        }
    }
    if (bulkVisibility.value) {
        data.visibility_id = bulkVisibility.value
    }
    data.files = ids

    axios.post(updateApi.value, data).then(res => {
        moving.value = false


        // If the files were moved to the homepage... do something?
        if (data.folder_home) {
            console.log(
                'move home'
            )
            let selectedFiles = files.value.filter(i => i.is_selected)
            selectedFiles.forEach(f => {
                homeFiles.value.unshift(f)
            })
        }

        // Remove selected files from current folder
        if (bulkFolder.value) {
            files.value = files.value.filter(i => !i.is_selected)
            // If we're currently on the home folder, remove if
            if (isHome.value) {
                homeFiles.value = homeFiles.value.filter(i => !i.is_selected)
            }
        }
        if (bulkVisibility.value) {
            files.value.forEach(f => {
                if (ids.includes(f.id)) {
                    f.visibility_id = bulkVisibility.value
                }
            })
        }

        bulkFolder.value = null
        bulkVisibility.value = null
        isBulking.value = false

        // Remove old selected files from the home folder
        let selectedFiles = homeFiles.value.filter(i => i.is_selected)
        selectedFiles.forEach(f => {
            f.is_selected = false
        })

        window.showToast(res.data.toast)
        closeModal(updateDialog.value)
    })
}

const selectFiles = () => {
    fileField.value.click()
}

const filesSelected = async (event) => {
    const file = event.target.files[0]
    const selectedFiles = event.target.files
    if (!selectedFiles) {
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
    if (folder.value) {
        formData.append('folder_id', folder.value.id)
    }
    Array.from(selectedFiles).forEach(f => {
        formData.append('files[]', f)
    })

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
            // Find the index of the last folder
            const matchCriterion = f => f.is_folder;
            const lastIndex = files.value.map((file, index) => matchCriterion(file) ? index : -1)
                .filter(index => index !== -1)
                .pop();

            res.data.files.forEach(f => {
                if (lastIndex !== undefined) {
                    files.value.splice(lastIndex + 1, 0, f);
                } else {
                    // If no match is found, you can push the item to the end or handle accordingly
                    files.value.push(f);
                }
            })

            used.value = res.data.used
            //console.log(used.value, res.data.used)
        })
        .catch (err => {
            console.error(err)
            uploading.value = false
            fileField.value.disabled = false
            imagePreview.value = null
            if (axios.isCancel(err)) {
                // User cancelled
                fileField.value = null
            } else {
                showErrors(err)
            }
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
        window.showToast(trans.value.unauthorized, 'error')
        return
    }

    const errorKeys = Object.keys(err.response.data.errors)
    errorKeys.forEach(i => {
        window.showToast(err.response.data.errors[i][0], 'error')
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
    // No need as it's editing the reactive component, apparently
}

const deletedFile = (file, newSpace) => {
    files.value = files.value.filter(f => f.id !== file.id)
    currentFile.value = null

    if (file.is_folder) {
        if (file.folder_id) {

        } else {
            home()
        }
    }

    used.value = newSpace
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

const toggleFilters = () => {
    showFilters.value = !showFilters.value;
}

const toggleSort = () => {
    showSort.value = !showSort.value;
}

const onClickOutside = () => {
    showFilters.value = false;
    showSort.value = false;
}

const toggleUnused = () => {
    if (!showUnused.value) {
        apiParameters.value['toggleParam'] = '';
        home()
        return
    }
    console.log('filter')
    loading.value = true

    apiParameters.value['toggleParam'] = 'unused=1';

    var params = '';

    if (apiParameters.value['searchParam']) {
        params += apiParameters.value['searchParam'] + '&';
    }

    if (apiParameters.value['sortParam']) {
        params += apiParameters.value['sortParam'] + '&';
    }

    if (apiParameters.value['toggleParam']) {
        params += apiParameters.value['toggleParam'] + '&';
    }

    axios.get(searchApi.value + '/?' + params).then(res => {
        showSearchResults(res.data)
    })
}

const sort = (order = 'default') => {

    if (order == 'asc') {
        sortDesc.value = false;
        sortDefault.value = false;
        sortAsc.value = true;
    } else if (order == 'desc') {
        sortAsc.value = false;
        sortDefault.value = false;
        sortDesc.value = true;
    } else if (order == 'default') {
        sortAsc.value = false;
        sortDesc.value = false;
        sortDefault.value = true;
    }

    loading.value = true

    apiParameters.value['sortParam'] = 'sort=' + order;

    var params = '';

    if (apiParameters.value['searchParam']) {
        params += apiParameters.value['searchParam'] + '&';
    }

    if (apiParameters.value['sortParam']) {
        params += apiParameters.value['sortParam'] + '&';
    }

    if (apiParameters.value['toggleParam']) {
        params += apiParameters.value['toggleParam'] + '&';
    }

    let api = searchApi.value

    if (folder.value?.open) {
        api = folder.value.open
    }

    axios.get(api + '/?' + params).then(res => {
        showFilterResults(res.data)
    })
}

const showFilterResults = (data) => {
    files.value = data.files
    nextPage.value = data.next
    loading.value = false
}

const showSearchResults = (data) => {
    files.value = data.files
    nextPage.value = data.next
    folder.value = null
    loading.value = false
}

const usedSpace = () => {
    return human(used.value)
}
const totalSpace = () => {
    return human(total.value)
}

const human = (kb) => {
    if (kb == 0) {
        return '0';
    }
    else if (kb > 1000000) {
        return (kb / (1024 * 1024)).toFixed(2) + ' GiB'
    }
    else if (kb > 1000) {
        return (kb / (1024)).toFixed(2) + ' MiB'
    }
    return (kb * 1).toFixed(2) + ' KiB'
}

const usedClasses = () => {
    let css = 'rounded h-2 transition-all duration-300'
    let per = usedPercentage()
    if (per < 60) {
        return css + ' bg-primary'
    } else if (per < 90) {
        return css + ' bg-orange-400'
    }
    return css + ' bg-red-500';
}
const usedPercentage = () => {
    return Math.round((used.value / total.value) * 100)
}

const hasPreview = () => {
    return imagePreview.value !== null
}
</script>
