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
                <div class="relative">
                    <button class="btn2 btn-default btn-sm" @click="toggleFilters">
                        <i class="fa-solid fa-filter" aria-hidden="true" />
                        <span v-html="trans('order_by_' + filter)" class="hidden md:inline"></span>
                    </button>
                    <div class="border shadow rounded bg-base-100 p-4 absolute right-0 flex flex-col gap-5 w-60" v-if="showFilters"  v-click-outside="onClickOutside">
                        <label @click="orderByNew" class="cursor-pointer" v-html="trans('newest')"></label>
                        <label @click="orderByOld" class="cursor-pointer" v-html="trans('oldest')"></label>
                        <label @click="orderByType" class="cursor-pointer" v-html="trans('type')"></label>
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
                        @recover="recoverElement(file)"
                    >
                    </element>
                </div>
            </div>
        </div>
    </div>

    <dialog ref="newDialog" class="dialog rounded-2xl text-center" v-if="initiated">
        <header class="bg-base-200 sm:rounded-t">
            <h4 v-html="trans('premium_title')"></h4>
            <button type="button" class="text-base-content" @click="closeModal(newDialog)" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl flex flex-col gap-2 text-left">
            <div class="flex flex-col gap-1 w-full">
                <label v-html="trans('premium')"></label>
            </div>
        </article>
        <footer class="bg-base-200 p-2">
            <menu class="">
                <a :href="upgradeLink" v-html="trans('upgrade')" class="btn2 btn-default"></a>
            </menu>
        </footer>
    </dialog>
</template>

<script setup lang="ts">

import {onMounted, ref} from "vue";
import Element from "./Element.vue";

const props = defineProps<{
    api: String
}>()

const initiated = ref(false)
const loading = ref(false)
const isBulking = ref(false)
const premium = ref(false)
const currentFile = ref()
const searchTerm = ref()
const lastTerm = ref()
const typingTimeout = ref(null)
const files = ref([])
const filter = ref('newest')
const i18n = ref()
const newDialog = ref()
const updateApi = ref()
const moving = ref(false)
const showFilters = ref(false)
const upgradeLink = ref()

onMounted(() => {
    axios.get(props.api)
        .then((res) => {
            initiated.value = true
            files.value = res.data.elements
            i18n.value = res.data.i18n
            updateApi.value = res.data.api.recovery
            premium.value = res.data.acl.premium
            upgradeLink.value = res.data.upgrade
        })

})

const trans = (key) => {
    if (!i18n.value[key]) {
        console.error('Missing trans', key, i18n)
        return 'MISSING'
    }
    return i18n.value[key]
}

const gridClass = () => {
    let css = "grid grid-cols-3 gap-2"
    if (currentFile.value) {
        css += ' basis-2/4 md:basis-3/4'
    }
    return css
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

    if (!premium.value) {
        openDialog(newDialog.value)
        return
    }

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

const hasSelection = () => {
    let count = files.value.filter(f => f.is_selected).length
    if (count === 0) {
        return false
    }
    return true
}

const bulkRecover = () => {

    if (!premium.value) {
        openDialog(newDialog.value)
        return
    }

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
    filter.value = 'newest'
}

const orderByOld = () => {
    loading.value = true
    files.value.sort(function(a, b){return b.position - a.position});
    loading.value = false
    showFilters.value = false
    filter.value = 'oldest'
}

const orderByType = () => {
    loading.value = true
    files.value.sort(function(a, b){return trans(a.type_id).localeCompare(trans(b.type_id))});
    loading.value = false
    showFilters.value = false
    filter.value = 'type'
}

const openDialog = (dialog) => {
    console.log(dialog)
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
    modal.removeEventListener('click', clickOutside)
    modal.close()
}
</script>
