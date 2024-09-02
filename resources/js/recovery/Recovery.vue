<template>
    <div v-if="!initiated" class="text-center text-4xl p-4">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
    </div>
    <div v-else class="flex flex-col gap-4 md:gap-5">
        <div class="flex gap-4 items-end">
            <div v-if="!premium">
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
                        <i class="fa-solid fa-filter" aria-hidden="true" />
                        <span v-html="trans('filters')" class="hidden md:inline"></span>
                        <span v-if="showUnused">(1)</span>
                    </button>
                    <div class="border shadow rounded bg-base-100 p-4 absolute right-0 flex flex-col gap-5 w-60" v-if="showFilters"  v-click-outside="onClickOutside">
                        <div class="flex gap-2 items-center">
                            <label @click="orderByNew" class="cursor-pointer"  v-html="trans('newest')"></label>
                            <label @click="orderByOld" class="cursor-pointer"  v-html="trans('oldest')"></label>
                            <label @click="orderByType" class="cursor-pointer"  v-html="trans('type')"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 self-end flex-wrap">

                <button class="btn2 btn-default btn-sm" v-if="!hasSelection()" @click="selectAll">
                    <i class="fa-solid fa-list-check" aria-hidden="true" />
                    <span v-html="trans('select_all')"></span>
                </button>
                <button class="btn2 btn-default btn-sm" v-if="hasSelection()" @click="deselectAll">
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                    <span v-html="trans('deselect_all')"></span>
                </button>
                <button class="btn2 btn-primary btn-sm" v-if="hasSelection()" @click="bulkRecover">
                    <i class="fa-solid fa-plus" aria-hidden="true" />
                    <span v-html="trans('restore_selected')"></span>
                    <span v-html="countSelected()"></span>
                </button>

            </div>
        </div>

        <div class="text-center text-4xl p-4" v-if="loading">
            <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
        </div>
        <div class="flex flex-col gap-4" v-else>
            <div class="flex gap-2 flex-row">
                <div :class="gridClass()">
                    <Element
                        v-for="file in files"
                        :file="file"
                        :isBulking="isBulking"
                        :i18n="i18n"
                        @select="selectFile(file)"
                        @recover="recoverElement(file)"
                    >
                    </element>
                    <div class="flex items-center justify-center grow" v-if="nextPage">
                        <button :class="loadMoreClass()" @click="openNextPage()" v-html="trans('load_more')"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <dialog ref="updateDialog" class="dialog rounded-2xl text-center" v-if="initiated">
        <header class="bg-base-200 sm:rounded-t">
            <h4 v-html="trans('update')"></h4>
            <button type="button" class="text-base-content" @click="closeModal(updateDialog)" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl flex flex-col gap-2 text-left">
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
                <button type="submit" class="btn2 btn-primary" @click="bulkRecover" v-html="trans('change')">
                </button>
            </menu>
        </footer>
    </dialog>
</template>

<script setup lang="ts">

import {onMounted, onUnmounted, ref} from "vue";
import Preview from "./Preview.vue";
import Element from "./Element.vue";

const props = defineProps<{
    api: String
}>()

const initiated = ref(false)
const loading = ref(false)
const loadingMore = ref(false)
const canUpload = ref(false)
const isBulking = ref(false)
const premium = ref(false)
const canManage = ref(false)
const breadcrumbs = ref()
const nextPage = ref()
const currentFile = ref()

// Search stuff
const searchTerm = ref()
const lastTerm = ref()
const searching = ref(false)
const typingTimeout = ref(null)

const files = ref([])
const homeFiles = ref([])
const folder = ref()
const i18n = ref()
const isHome = ref(true)

// New folder
const creating = ref(false)
const newDialog = ref()
const folderNameField = ref()
const visibilities = ref()
const bulkVisibilities = ref()

// Visibility folder
const updateDialog = ref()
const bulkVisibility = ref()
const bulkFolder = ref()
const orderBy = ref()

// Move
const folders = ref()
const updateApi = ref()

// Upload
const moving = ref(false)
const uploading = ref(false)


// Filters
const showFilters = ref(false)
const showUnused = ref(false)

// Space
const upgradeLink = ref()

onMounted(() => {
    axios.get(props.api)
        .then((res) => {
            //console.log(res.data.elements)
            initiated.value = true
            files.value = res.data.elements
            homeFiles.value = res.data.files
            i18n.value = res.data.i18n
            updateApi.value = res.data.api.recovery
            nextPage.value = res.data.next
            visibilities.value = res.data.visibilities
            bulkVisibilities.value = res.data.bulkVisibilities
            canUpload.value = res.data.acl.upload
            premium.value = res.data.acl.premium
            canManage.value = res.data.acl.manage

            upgradeLink.value = res.data.upgrade
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

const selectFile = (file) => {
        let f = files.value.find(f => f.id === file.id)
        f.is_selected = !f.is_selected
        return;
}

const selectElements = (file) => {
        let f = files.value.find(f => f.id === file.id)
        if (!f.url && !f.is_hidden) {
            f.is_selected = true
        }
        return;
}

const deselectElements = (file) => {
        let f = files.value.find(f => f.id === file.id)
        f.is_selected = false
        return;
}

const recoverElement = (file) => {
        let f = files.value.find(f => f.id === file.id)
        f.is_recovering = true

    if (moving.value) {
        return
    }
    
    moving.value = true
    let data = {}

    if (f.type === 'post') {
        data.posts = [f.id]
        data.entities = []
    } else {
        data.entities = [f.id]
        data.posts = []
    }
        axios.post(updateApi.value, data).then(res => {
        moving.value = false
        
        const entities = Object.keys(res.data.entities).map(
            key => res.data.entities[key]
        );

        //console.log(res.data.entities, entities)
        let ids = files.value.filter(f => f.is_recovering && f.type == 'entity')
        let postIds = files.value.filter(f => f.is_recovering && f.type == 'post')
        
        ids.forEach(f => {
            f.is_selected = false
            f.is_recovering = false
            if (res.data.entities[f.id]) {
                f.url = res.data.entities[f.id]
            }
        })
        postIds.forEach(f => {
            f.is_selected = false
            f.is_recovering = false
            if (res.data.posts[f.id]) {
                f.url = res.data.posts[f.id]
            }
        })


        window.showToast(res.data.toast)
        })


        return;
}

const selectAll = () => {
    files.value.forEach(selectElements)
    return
}

const deselectAll = () => {
    files.value.forEach(deselectElements)
    return
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
    searchTerm.value = event.target.value.toLowerCase()
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
        files.value.forEach(f => {
            f.is_hidden = false
        })
        return;
    }

    loading.value = true
    showSearchResults()

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

const hasSelection = () => {
    let count = files.value.filter(f => f.is_selected).length
    if (count === 0) {
        return false
    }
    return true
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

const bulkRecover = () => {
    if (moving.value) {
        return
    }
    let ids = files.value.filter(f => f.is_selected && f.type == 'entity').map(f => f.id)
    let postIds = files.value.filter(f => f.is_selected && f.type == 'post').map(f => f.id)
    if (ids.length === 0 && postIds.length === 0) {
        return
    }

    moving.value = true
    let data = {}

    data.entities = ids
    data.posts = postIds

    axios.post(updateApi.value, data).then(res => {
        moving.value = false

        // Remove old selected files from the home folder
        //let selectedFiles = homeFiles.value.filter(i => i.is_selected)

        //let selectedFiles = files.value.find(f => f.id === file.id)

        
        const entities = Object.keys(res.data.entities).map(
            key => res.data.entities[key]
        );

        //console.log(res.data.entities, entities)
        let ids = files.value.filter(f => f.is_selected && f.type == 'entity')
        let postIds = files.value.filter(f => f.is_selected && f.type == 'post')
        
        ids.forEach(f => {
            f.is_selected = false
            if (res.data.entities[f.id]) {
                f.url = res.data.entities[f.id]
            }
        })
        postIds.forEach(f => {
            f.is_selected = false
            if (res.data.posts[f.id]) {
                f.url = res.data.posts[f.id]
            }
        })


        window.showToast(res.data.toast)
        //closeModal(updateDialog.value)
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



const toggleFilters = () => {
    showFilters.value = !showFilters.value;
}

const onClickOutside = () => {
    showFilters.value = false
}

const showSearchResults = () => {
    files.value.forEach(f => {
        const slug = f.name.toLowerCase()
        if (slug.includes(searchTerm.value)) {
            f.is_hidden = false
        } else {
            f.is_hidden = true
        }
    })
    loading.value = false
}

const orderByNew = () => {
    loading.value = true
    files.value.sort(function(a, b){return a.position - b.position});
    loading.value = false
    showFilters.value = false

}

const orderByOld = () => {
    loading.value = true
    files.value.sort(function(a, b){return b.position - a.position});
    loading.value = false
    showFilters.value = false

}

const orderByType = () => {
    loading.value = true
    files.value.sort(function(a, b){return trans(a.type_id).localeCompare(trans(b.type_id))});
    loading.value = false
    showFilters.value = false

}

</script>
