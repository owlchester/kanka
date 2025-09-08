<template>
    <div v-if="loading" class="flex flex-col gap-4 w-full">
        <div class="flex gap-2 justify-between items-center">
            <h1 class="grow text-3xl category-title truncate" v-html="props.module"></h1>
            <div class="flex gap-2 items-center">
                <button class="btn2 btn-disabled" disabled="disabled">
                    <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
                </button>
            </div>
        </div>
        <div class="flex gap-2 items-start">
        <div class="rounded shadow-xs w-[47%] xs:w-[25%] sm:w-48 aspect-square flex items-center justify-center text-xl text-neutral-content">
            <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
        </div>
        </div>
    </div>
    <div class="flex flex-col gap-4 w-full" v-else>
        <div class="flex gap-2 justify-between items-center flex-wrap ">
            <div class="flex gap-1 items-center flex-wrap ">
                <h1 class="grow text-3xl category-title truncate" v-html="props.module"></h1>
                <div class="bg-base-200 flex items-stretch gap-1 rounded-xl" v-if="filters > 0">
                    <div class="flex items-center rounded-xl gap-2 hover:bg-base-300 px-2 py-2 cursor-pointer" v-bind:aria-label="i18n.filters" :title="i18n.filters" @click="openFilters">
                        <i class="fa-regular fa-filter hover:bg-base-300" aria-label="Filter"></i>
                        <span class="rounded bg-primary text-primary-content px-2 text-sm">1</span>
                    </div>

                    <div class="flex items-center justify-center rounded-xl gap-2 hover:bg-base-300 px-3 py-2 cursor-pointer hover:text-primary" :title="i18n.bookmark" v-if="bookmarkable" @click="bookmark">
                        <i class="fa-regular fa-bookmark" v-bind:aria-label="i18n.bookmark">
                        </i>
                    </div>
                    <div class="w-0 h-auto my-2 border-base-content border-l"></div>

                    <a class="flex items-center rounded-xl gap-2 hover:bg-base-300 px-2 py-2 text-base-content hover:text-primary" :href="filterUrls.clear">
                        <i class="fa-regular fa-eraser" aria-label="Clear">
                        </i>
                    </a>
                </div>
                <div v-else>
                    <i class="fa-regular fa-filter text-lg rounded hover:text-primary-content cursor-pointer px-2 py-1 hover:bg-primary" v-bind:aria-label="i18n.filters" :title="i18n.filters" @click="openFilters">

                    </i>
                </div>
                <button
                    v-if="hasPermissions() && !selecting"
                    @click="toggleSelecting()"
                    class="rounded rounded-full border-primary text-primary border px-3 py-1 text-xs uppercase hover:bg-primary hover:text-primary-content"
                    v-html="i18n.select"></button>
                <button
                    v-if="hasPermissions() && selecting"
                    @click="toggleSelecting()"
                    class="rounded rounded-full bg-primary text-primary-content px-3 py-1 text-xs uppercase"
                    v-html="i18n.done"></button>
                <button
                    v-if="hasPermissions() && selecting"
                    @click="toggleAll()"
                    class="rounded rounded-full border-primary text-primary border px-3 py-1 text-xs uppercase hover:bg-primary hover:text-primary-content"
                    v-html="i18n.selectAll"></button>
            </div>
            <div class="flex gap-2 items-center" v-if="!selecting">
                <button class="btn2" v-if="ordering">
                    <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
                </button>
                <div class="dropdown" v-else>
                    <button @click="orderDropdown = !orderDropdown" class="btn2" :title="i18n.order">
                        <i class="fa-regular fa-arrow-down-a-z" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu absolute mt-2 flex flex-col gap-1 bg-base-200 shadow p-2 rounded z-10" role="menu" id="templates-submenu" v-if="orderDropdown" v-click-outside="onClickOutside">
                        <button @click="orderBy('name')" :class="orderByClass('name')">
                            <i v-if="isOrdering('name')" :class="orderByIcon('name')"></i>
                            <span v-html="i18n.fields['name']"></span>
                        </button>
                        <button @click="orderBy('type')" :class="orderByClass('type')">
                            <i v-if="isOrdering('type')" :class="orderByIcon('type')"></i>
                            <span v-html="i18n.fields['type']"></span>
                        </button>
                        <button @click="orderBy('is_private')" :class="orderByClass('is_private')">
                            <i v-if="isOrdering('is_private')" :class="orderByIcon('is_private')"></i>
                            <span v-html="i18n.fields['is_private']"></span>
                        </button>
                    </div>
                </div>

                <div v-if="entityType.is_nested">
                    <button class="btn2" v-if="nesting">
                        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
                    </button>
                    <button @click="switchMode()" class="btn2" v-if="nested && !nesting" :title="i18n.flatten">
                        <i class="fa-regular fa-boxes-stacked" aria-hidden="true"></i>
                        <span class="sr-only" v-html="i18n.flatten"></span>
                    </button>
                    <button @click="switchMode()" class="btn2" v-else-if="!nesting" :title="i18n.nest">
                        <i class="fa-regular fa-layer-group" aria-hidden="true"></i>
                        <span class="sr-only" v-html="i18n.nest"></span>
                    </button>
                </div>
                <div v-if="entityType.has_table">
                    <button @click="switchLayout()" class="btn2" v-if="isGrid()" :title="i18n.layout_table">
                        <i class="fa-regular fa-list-ul" aria-hidden="true"></i>
                        <span class="sr-only" v-html="i18n.layout_table"></span>
                    </button>
                    <button @click="switchLayout()" class="btn2" v-else :title="i18n.layout_grid">
                        <i class="fa-regular fa-grid-2 " aria-hidden="true"></i>
                        <span class="sr-only" v-html="i18n.layout_grid"></span>
                    </button>
                </div>
                <div class="join"  v-if="hasPermissions() && permissions.create">
                    <a :href="urls.create" class="btn2 btn-primary join-item btn-new-entity">
                        <i class="fa-regular fa-plus" aria-hidden="true"></i>
                        <span class="hidden md:inline" v-html="entityType.singular"></span>
                    </a>

                    <div class="dropdown relative" v-if="permissions.template">
                        <button type="button" class="btn2 btn-primary join-item"  aria-expanded="false" aria-label="Create from template" aria-haspopup="menu" aria-controls="templates-submenu" @click="templating = !templating">
                            <i class="fa-regular fa-caret-down" aria-hidden="true"></i>
                            <span class="sr-only" v-html="i18n.actions"></span>
                        </button>
                        <div class="dropdown-menu absolute mt-2 flex flex-col gap-1 right-0 bg-base-200 shadow p-2 rounded z-10" role="menu" id="templates-submenu" v-if="templating" v-click-outside="onClickOutside">
                            <a
                                v-for="template in templates"
                                :href="template.url"
                                :key="template.id"
                                class="new-entity-from-template text-base-content flex items-center gap-2 px-2 py-1"
                            >
                                <i class="fa-regular fa-star" aria-hidden="true"></i>
                                <span v-html="template.name"></span>
                            </a>
                            <hr class="m-0" />
                            <a
                                href="https://docs.kanka.io/en/latest/guides/templates.html"
                                class="flex flex-no-wrap gap-2 px-2 py-1 items-center"
                            >
                                <i class="fa-regular fa-external-link" aria-hidden="true"></i>
                                <span class="text-nowrap" v-html="i18n.templates"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-2 items-center" v-else>
                <div class="join">
                    <button class="btn2 btn-primary join-item btn-bulk-batch" @click="bulkDialog(urls.batch)" v-if="permissions.admin">
                        <i class="fa-regular fa-pencil" aria-hidden="true"></i>
                        <span class="hidden md:inline" v-html="i18n.bulkEdit"></span>
                    </button>
                    <button v-else class="btn2 join-item btn-primary" @click="bulkPrint()">
                        <i class="fa-regular fa-print" aria-hidden="true"></i>
                        <span class="hidden md:inline" v-html="i18n.bulkPrint"></span>
                    </button>

                    <!-- If permissions isn't empty but an actual object !-->
                    <div class="dropdown relative" v-if="hasPermissions()">
                        <button type="button" class="btn2 btn-primary join-item"  aria-expanded="false" aria-label="Create from template" aria-haspopup="menu" aria-controls="templates-submenu" @click="templating = !templating">
                            <i class="fa-regular fa-caret-down" aria-hidden="true"></i>
                            <span class="sr-only" v-html="i18n.actions"></span>
                        </button>
                        <div class="dropdown-menu absolute mt-2 flex flex-col gap-1 right-0 bg-base-200 shadow p-2 rounded z-10" role="menu" id="templates-submenu" v-if="templating" v-click-outside="onClickOutside">
                            <button
                                v-if="permissions.admin"
                                @click="bulkDialog(urls.permissions)"
                                class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary"
                            >
                                <i class="fa-regular fa-lock" aria-hidden="true"></i>
                                <span v-html="i18n.bulkPermissions"></span>
                            </button>
                            <button
                                v-if="permissions.admin"
                                @click="bulkDialog(urls.transform)"
                                class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary"
                            >
                                <i class="fa-regular fa-exchange-alt" aria-hidden="true"></i>
                                <span v-html="i18n.bulkTransform"></span>
                            </button>
                            <button
                                @click="bulkDialog(urls.copy)"
                                class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary"
                            >
                                <i class="fa-regular fa-clone" aria-hidden="true"></i>
                                <span v-html="i18n.bulkCopy"></span>
                            </button>
                            <button
                                v-if="permissions.admin"
                                @click="bulkDialog(urls.template)"
                                class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary"
                            >
                                <i class="fa-regular fa-table" aria-hidden="true"></i>
                                <span v-html="i18n.bulkTemplate"></span>
                            </button>
                            <button
                                v-if="permissions.admin"
                                @click="bulkPrint()"
                                class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary"
                            >
                                <i class="fa-regular fa-print" aria-hidden="true"></i>
                                <span v-html="i18n.bulkPrint"></span>
                            </button>
                            <button
                                v-if="permissions.delete"
                                @click="bulkDelete()"
                                class="flex items-center gap-2 px-2 py-1 cursor-pointer text-error hover:bg-error hover:text-error-content rounded"
                            >
                                <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                                <span v-html="i18n.bulkDelete"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-1 items-start">
            <div :class="gridLayout()">
                <a v-if="parent && isGrid()" :href="parent.urls.parent" class="entity w-[47%] xs:w-[25%] sm:w-48 overflow-hidden rounded flex flex-col shadow-xs hover:shadow sm">
                    <div class="w-46 flex items-center justify-center grow  text-6xl">
                        <i class="fa-regular fa-arrow-left" aria-hidden="true"></i>
                    </div>
                    <div class="block text-center p-4 h-12 bg-box">
                        <span v-html="parent.links.back"></span>
                    </div>
                </a>
                <a v-else-if="parent && !isGrid()" :href="parent.urls.parent" class="rounded-xl flex bg-base-100 shadow-xs items-center gap-4 py-2 px-4 overflow-hidden">
                    <div class="">
                        <i class="fa-regular fa-arrow-left" aria-hidden="true"></i>
                    </div>
                    <div class="">
                        <span v-html="parent.links.back"></span>
                    </div>
                </a>
                <entities-entity
                    v-for="entity in entities"
                    :key="entity.id"
                    :entity="entity"
                    :is-parent="false"
                    :i18n="i18n"
                    :selecting="selecting"
                    :layout="layout"
                    :nesting="nested"
                >
                </entities-entity>


            </div>
        </div>

        <div v-if="true" class="flex items-center justify-end gap-1 h-12">
            <TailwindPagination
                v-if="!paginating"
                :data="entitiesData"
                :itemClasses="[
                    'bg-base-200',
                    'text-base-content',
                    'border-none',
                    'hover:bg-base-300',
                ]"
                :activeClasses="[
                    'bg-base-100',
                    'border-none',
                    'text-base-content',
                ]"
                @pagination-change-page="getEntities"
            />
            <div v-else class="flex items-center">
                <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
            </div>
        </div>
        <p v-if="entities.length === 0" class="help-text italic" v-html="i18n.noResults"></p>

        <form method="POST" :action="urls.print" ref="printForm">
            <input v-for="selected in selectedEntityIds()" type="hidden" name="model[]" :value="selected" />
            <input type="hidden" name="_token" :value="csrf" />
        </form>
    </div>
</template>

<script setup lang="ts">
import {ref, onMounted, onBeforeUnmount, onUpdated} from 'vue'
import { TailwindPagination } from 'laravel-vue-pagination';


const props = defineProps<{
    api: string,
    module: string,
    mode: string,
}>()

const entities = ref([])
const parent = ref()
const csrf = ref()
const permissions = ref()
const printForm = ref()
const entityType = ref()
const entitiesData = ref()
const order = ref()
const urls = ref({})
const unfiltered = ref(0)
const filters = ref(0)
const filterUrls = ref()
const loading = ref(true)
const ordering = ref(false)
const orderDropdown = ref(false)
const paginating = ref(false)
const nesting = ref(false)
const nested = ref(true)
const templating = ref(false)
const templates = ref([])
const selecting = ref(false)
const i18n = ref({})
const bookmarkable = ref(false)
const layout = ref('grid');

onMounted(() => {
    layout.value = props.mode;
    fetch(props.api)
        .then(response => response.json())
        .then(response => {
            importEntities(response)
            unfiltered.value = response.filters.unfilteredCount
            filters.value = response.filters.count
            filterUrls.value = response.filters.urls
            i18n.value = response.i18n
            nested.value = response.nested
            parent.value = response.parent
            templates.value = response.templates
            permissions.value = response.permissions
            bookmarkable.value = response.bookmarkable
            urls.value = response.urls
            entityType.value = response.entityType
            finishLoading()
        });
    //window.addEventListener('keydown', handleKeyDown);
});

const toggleSelecting = () => {
    selecting.value = !selecting.value;

    entities.value.forEach(e => {
        e.selected = false
    })
}

const toggleAll = () => {
    if (!entities.value.length) {
        return;
    }

    const shouldSelect = !entities.value[0].selected;

    entities.value.forEach(e => {
        e.selected = shouldSelect
    })
}

const openFilters = () => {
    window.openDialog('datagrid-filters', filterUrls.value.form)
}

const bulkDialog = (url) => {
    // Add each selected entity to the url as a id[] param
    let ids = selectedEntityIds();
    if (ids.length === 0) {
        return;
    }

    let parsedUrl = new URL(url, window.location.origin);
    let params = parsedUrl.searchParams;
    ids.forEach(id => {
        params.append('entities[]', id);
    });

    window.openDialog('primary-dialog', parsedUrl.toString());
}

const switchMode = () => {
    nesting.value = true;
    let url = props.api;
    nested.value = !nested.value;
    loadEntities(addToUrl(url, 'n', (nested.value ? '1' : '0')));

    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('n', nested.value ? 1 : 0);
    window.history.pushState({}, '', currentUrl);
}

const switchLayout = () => {
    let url = props.api;
    if (isGrid()) {
        layout.value = 'table';
    } else {
        layout.value = 'grid';
    }
    loadEntities(addToUrl(url, 'm', layout.value));

    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('m', layout.value);
    window.history.pushState({}, '', currentUrl);
}

const getEntities = async (page = 1) => {
    paginating.value = true

    loadEntities(addToUrl(props.api, 'page', page));
}

const loadEntities = (url) => {
    fetch(url)
        .then(response => response.json())
        .then(response => {
            importEntities(response)
            finishLoading()
        });
}

const importEntities = (response) => {
    entities.value = [];
    entitiesData.value = response.entities;
    response.entities.data.forEach(a => {
        entities.value.push(a)
    })
    csrf.value = response.csrf
    order.value = response.order
}

const finishLoading = () => {
    loading.value = false
    paginating.value = false
    nesting.value = false
    ordering.value = false
}

const orderBy = (field: string) => {
    ordering.value = true

    let url = new URL(props.api, window.location.origin);
    let params = url.searchParams;

    params.set('order', field);
    if (isOrderingAscending(field)) {
        params.set('desc', '1');
    } else {
        params.delete('desc');
    }
    url = url.toString();
    loadEntities(url);

    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('order', field);
    if (isOrderingAscending(field)) {
        currentUrl.searchParams.set('desc', "1");
    } else {
        currentUrl.searchParams.delete('desc');
    }

    window.history.pushState({}, '', currentUrl);
}
const orderByClass = (field: string) => {
    let css = 'flex items-center gap-2 px-2'
    // If order.value has a property named the same as field, return "font-extrabold"
    if (!isOrdering(field)) {
        return css
    }
    return css + ' font-extrabold'
}

const orderByIcon = (field: string) => {
    if (isOrderingAscending(field)) {
        return 'fa-regular fa-arrow-down-z-a';
    }
    return 'fa-fa-regular fa-arrow-down-a-z';
}

const isOrdering = (field: string) => {
    return order.value[field];
}

const isOrderingAscending = (field: string) => {
    return order.value[field] === 'ASC'
}

onUpdated(() => {
    // Add the ajax tooltip listener when the dom is updated (for example when displaying
    // children abilities)
    window.ajaxTooltip();
})

const onClickOutside = () => {
    templating.value = false
    orderDropdown.value = false
}

const bulkPrint = () => {
    let ids = selectedEntityIds();
    if (ids.length === 0) {
        return;
    }
    printForm.value.submit();
}

const bookmark = () => {
    window.openDialog('primary-dialog', urls.value.bookmark);
}

const bulkDelete = () => {
    bulkDialog(urls.value.delete);
}

const selectedEntityIds = () => {
    let ids = [];
    entities.value.filter(e => e.selected).forEach(e => {
        ids.push(e.id);
    })
    return ids;
}

const hasPermissions = () => {
    return permissions.value;
}

const gridLayout = () => {
    if (isGrid()) {
        return "entities-grid flex flex-wrap gap-3 lg:gap-5 w-full"
    }
    return "entities-grid flex flex-col gap-1 w-full"
}

const isGrid = () => {
    return layout.value === 'grid';
}

const addToUrl = (url, param, value) => {
    let urlObject = new URL(url, window.location.origin);
    let params = urlObject.searchParams;
    params.set(param, value);
    return urlObject.toString();
}

</script>
