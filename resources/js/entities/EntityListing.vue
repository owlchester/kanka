<template>
    <div v-if="loading" class="flex flex-col gap-4 w-full">
        <div class="flex gap-2 justify-between items-center">
            <h1 class="grow text-2xl category-title truncate" v-html="props.module"></h1>
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
        <!-- Toolbar -->
        <div class="flex gap-2 justify-between items-center flex-wrap">
            <div class="flex gap-1 items-center flex-wrap">
                <h1 class="grow text-2xl category-title truncate" v-html="props.module"></h1>
                <div class="bg-base-200 flex items-stretch gap-1 rounded-xl" v-if="filters > 0">
                    <div class="flex items-center rounded-xl gap-2 hover:bg-base-300 px-2 py-2 cursor-pointer" :aria-label="i18n.filters" :title="i18n.filters" @click="openFilters">
                        <i class="fa-regular fa-filter hover:bg-base-300" aria-label="Filter"></i>
                        <span class="rounded bg-primary text-primary-content px-2 text-sm">1</span>
                    </div>
                    <div class="flex items-center justify-center rounded-xl gap-2 hover:bg-base-300 px-3 py-2 cursor-pointer hover:text-primary" :title="i18n.bookmark" v-if="bookmarkable" @click="bookmark">
                        <i class="fa-regular fa-bookmark" :aria-label="i18n.bookmark"></i>
                    </div>
                    <div class="w-0 h-auto my-2 border-base-content border-l"></div>
                    <a class="flex items-center rounded-xl gap-2 hover:bg-base-300 px-2 py-2 text-base-content hover:text-primary" :href="filterUrls.clear">
                        <i class="fa-regular fa-eraser" aria-label="Clear"></i>
                    </a>
                </div>
                <div v-else>
                    <i class="fa-regular fa-filter text-lg rounded-lg hover:text-primary-content cursor-pointer px-2 py-1 hover:bg-primary" :aria-label="i18n.filters" :title="i18n.filters" @click="openFilters"></i>
                </div>
                <button v-if="hasPermissions() && !bulkActions.selecting.value" @click="bulkActions.toggleSelecting()" class="rounded-full border-primary text-primary border px-3 py-1 text-xs uppercase hover:bg-primary hover:text-primary-content" v-html="i18n.select"></button>
                <button v-if="hasPermissions() && bulkActions.selecting.value" @click="bulkActions.toggleSelecting()" class="rounded-full bg-primary text-primary-content px-3 py-1 text-xs uppercase" v-html="i18n.done"></button>
                <button v-if="hasPermissions() && bulkActions.selecting.value" @click="bulkActions.toggleAll()" class="rounded-full border-primary text-primary border px-3 py-1 text-xs uppercase hover:bg-primary hover:text-primary-content" v-html="i18n.selectAll"></button>
            </div>

            <!-- Action buttons (not selecting) -->
            <div class="flex gap-2 items-center" v-if="!bulkActions.selecting.value">
                <button class="btn2" v-if="orderingComposable.ordering.value">
                    <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
                </button>
                <div v-else>
                    <button ref="orderBtn" class="btn2" :title="i18n.order">
                        <i class="fa-regular fa-arrow-down-a-z" aria-hidden="true"></i>
                    </button>
                </div>

                <!-- Column visibility dropdown -->
                <div v-if="!layoutComposable.isGrid()">
                    <button ref="columnsBtn" class="btn2" title="Columns">
                        <i class="fa-regular fa-gear" aria-hidden="true"></i>
                    </button>
                </div>

                <div v-if="entityType.is_nested">
                    <button class="btn2" v-if="nestingComposable.nesting.value">
                        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
                    </button>
                    <button @click="nestingComposable.switchMode()" class="btn2" v-if="nestingComposable.nested.value && !nestingComposable.nesting.value" :title="i18n.flatten">
                        <i class="fa-regular fa-boxes-stacked" aria-hidden="true"></i>
                        <span class="sr-only" v-html="i18n.flatten"></span>
                    </button>
                    <button @click="nestingComposable.switchMode()" class="btn2" v-else-if="!nestingComposable.nesting.value" :title="i18n.nest">
                        <i class="fa-regular fa-layer-group" aria-hidden="true"></i>
                        <span class="sr-only" v-html="i18n.nest"></span>
                    </button>
                </div>
                <div v-if="entityType.has_table">
                    <button @click="layoutComposable.switchLayout()" class="btn2" v-if="layoutComposable.isGrid()" :title="i18n.layout_table">
                        <i class="fa-regular fa-list-ul" aria-hidden="true"></i>
                        <span class="sr-only" v-html="i18n.layout_table"></span>
                    </button>
                    <button @click="layoutComposable.switchLayout()" class="btn2" v-else :title="i18n.layout_grid">
                        <i class="fa-regular fa-grid-2" aria-hidden="true"></i>
                        <span class="sr-only" v-html="i18n.layout_grid"></span>
                    </button>
                </div>
                <div class="join" v-if="hasPermissions() && permissions.create">
                    <a :href="urls.create" class="btn2 btn-primary join-item btn-new-entity">
                        <i class="fa-regular fa-plus" aria-hidden="true"></i>
                        <span class="hidden md:inline" v-html="entityType.singular"></span>
                    </a>
                    <div v-if="permissions.template">
                        <button ref="templateBtn" type="button" class="btn2 btn-primary join-item" aria-expanded="false" aria-label="Create from template" aria-haspopup="menu">
                            <i class="fa-regular fa-caret-down" aria-hidden="true"></i>
                            <span class="sr-only" v-html="i18n.actions"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bulk action buttons (selecting) -->
            <div class="flex gap-2 items-center" v-else>
                <div class="join">
                    <button class="btn2 btn-primary join-item btn-bulk-batch" @click="bulkActions.bulkDialog(urls.batch, actionsBtn)" v-if="permissions.admin">
                        <i class="fa-regular fa-pencil" aria-hidden="true"></i>
                        <span class="hidden md:inline" v-html="i18n.bulkEdit"></span>
                    </button>
                    <button v-else class="btn2 join-item btn-primary" @click="bulkActions.bulkPrint(printForm, actionsBtn)">
                        <i class="fa-regular fa-print" aria-hidden="true"></i>
                        <span class="hidden md:inline" v-html="i18n.bulkPrint"></span>
                    </button>
                    <div v-if="hasPermissions()">
                        <button ref="actionsBtn" type="button" class="btn2 btn-primary join-item" aria-expanded="false" aria-label="Actions" aria-haspopup="menu">
                            <i class="fa-regular fa-caret-down" aria-hidden="true"></i>
                            <span class="sr-only" v-html="i18n.actions"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content area -->
        <div class="flex gap-1 items-start">
            <EntityGrid
                v-if="layoutComposable.isGrid()"
                :entities="entityApi.entities.value"
                :parent="entityApi.parent.value"
                :selecting="bulkActions.selecting.value"
                :nested="nestingComposable.nested.value"
                :i18n="i18n"
                :ads="entityApi.ads.value"
                @navigate="handleGridNavigate"
                @back="handleGridBack"
            />
            <EntityTable
                v-else
                :entities="entityApi.entities.value"
                :visible-columns="columnsComposable.visibleColumns.value"
                :selecting="bulkActions.selecting.value"
                :nested="nestingComposable.nested.value"
                :i18n="i18n"
                :entity-type="entityType"
                :ads="entityApi.ads.value"
                :is-ordering="orderingComposable.isOrdering"
                :order-by-icon="orderingComposable.orderByIcon"
                @order-by="handleOrderBy"
                @toggle-all="bulkActions.toggleAll()"
            />
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-end gap-1 h-12">
            <TailwindPagination
                v-if="!entityApi.paginating.value"
                :data="entityApi.entitiesData.value"
                :itemClasses="['bg-base-200', 'text-base-content', 'border-none', 'hover:bg-base-300']"
                :activeClasses="['bg-base-100', 'border-none', 'text-base-content']"
                @pagination-change-page="getEntities"
            />
            <div v-else class="flex items-center">
                <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
            </div>
        </div>
        <p v-if="entityApi.entities.value.length === 0" class="help-text italic" v-html="i18n.noResults"></p>

        <!-- Hidden tippy menus -->
        <div ref="hiddenMenus" style="display: none">
            <!-- Order menu - now dynamic based on sortable columns -->
            <div ref="orderMenu" class="flex flex-col gap-1">
                <button v-for="col in sortableColumns" :key="col.key"
                    @click="handleOrderBy(col.key, col.sortKey)"
                    :class="orderingComposable.orderByClass(col.sortKey || col.key)"
                    class="px-2 py-2 hover:bg-base-200 rounded-xl flex items-center gap-1.5 text-sm transition-all duration-150 text-base-content">
                    <i v-if="orderingComposable.isOrdering(col.sortKey || col.key)" :class="orderingComposable.orderByIcon(col.sortKey || col.key)"></i>
                    <span v-html="col.label"></span>
                </button>
            </div>
            <!-- Template menu -->
            <div ref="templateMenu" class="flex flex-col gap-1">
                <a v-for="template in templates" :href="template.url" :key="template.id"
                   class="px-2 py-2 hover:bg-base-200 rounded-xl flex items-center gap-1.5 text-sm transition-all duration-150 text-base-content">
                    <i class="fa-regular fa-star" aria-hidden="true"></i>
                    <span v-html="template.name"></span>
                </a>
                <hr class="m-0" v-if="templates.length > 0" />
                <a href="https://docs.kanka.io/en/latest/guides/templates.html"
                   class="px-2 py-2 hover:bg-base-200 rounded-xl flex items-center gap-1.5 transition-all duration-150 text-base-content text-sm">
                    <i class="fa-regular fa-external-link" aria-hidden="true"></i>
                    <span class="text-nowrap" v-html="i18n.templates"></span>
                </a>
            </div>
            <!-- Actions menu -->
            <div ref="actionsMenu" v-if="permissions" class="flex flex-col gap-1">
                <button v-if="permissions?.admin" @click="bulkActions.bulkDialog(urls.permissions, actionsBtn)" class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary">
                    <i class="fa-regular fa-lock" aria-hidden="true"></i>
                    <span v-html="i18n.bulkPermissions"></span>
                </button>
                <button v-if="permissions?.admin" @click="bulkActions.bulkDialog(urls.transform, actionsBtn)" class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary">
                    <i class="fa-regular fa-exchange-alt" aria-hidden="true"></i>
                    <span v-html="i18n.bulkTransform"></span>
                </button>
                <button @click="bulkActions.bulkDialog(urls.copy, actionsBtn)" class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary">
                    <i class="fa-regular fa-clone" aria-hidden="true"></i>
                    <span v-html="i18n.bulkCopy"></span>
                </button>
                <button v-if="permissions?.admin" @click="bulkActions.bulkDialog(urls.template, actionsBtn)" class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary">
                    <i class="fa-regular fa-table" aria-hidden="true"></i>
                    <span v-html="i18n.bulkTemplate"></span>
                </button>
                <button v-if="permissions?.admin" @click="bulkActions.bulkPrint(printForm, actionsBtn)" class="flex items-center gap-2 px-2 py-1 cursor-pointer text-nowrap hover:text-primary">
                    <i class="fa-regular fa-print" aria-hidden="true"></i>
                    <span v-html="i18n.bulkPrint"></span>
                </button>
                <button v-if="permissions?.delete" @click="bulkActions.bulkDialog(urls.delete, actionsBtn)" class="flex items-center gap-2 px-2 py-1 cursor-pointer text-error-content hover:bg-error rounded">
                    <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                    <span v-html="i18n.bulkDelete"></span>
                </button>
            </div>
            <!-- Column visibility menu -->
            <div ref="columnsMenu" class="flex flex-col gap-1 min-w-48">
                <div v-for="col in toggleableColumns" :key="col.key"
                     class="px-2 py-1.5 hover:bg-base-200 rounded-xl flex items-center gap-2 text-sm cursor-pointer text-base-content"
                     @click="columnsComposable.toggleColumn(col.key)">
                    <i :class="columnsComposable.isColumnVisible(col.key) ? 'fa-regular fa-square-check text-primary' : 'fa-regular fa-square text-neutral-content'"></i>
                    <span v-html="col.label"></span>
                </div>
                <hr class="m-0" />
                <button @click="columnsComposable.resetToDefaults()" class="px-2 py-1.5 hover:bg-base-200 rounded-xl flex items-center gap-2 text-sm text-base-content">
                    <i class="fa-regular fa-rotate-left" aria-hidden="true"></i>
                    <span>Reset to defaults</span>
                </button>
            </div>
        </div>

        <!-- Print form -->
        <form method="POST" :action="urls.print" ref="printForm">
            <input v-for="selected in bulkActions.selectedEntityIds()" type="hidden" name="model[]" :value="selected" :key="selected" />
            <input type="hidden" name="_token" :value="entityApi.csrf.value" />
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount, onUpdated, nextTick, watch } from 'vue'
import { TailwindPagination } from 'laravel-vue-pagination'
import tippy from 'tippy.js'
import EntityGrid from './EntityGrid.vue'
import EntityTable from './EntityTable.vue'
import { useEntityApi } from './composables/useEntityApi'
import { useBulkActions } from './composables/useBulkActions'
import { useOrdering } from './composables/useOrdering'
import { useLayout } from './composables/useLayout'
import { useNesting } from './composables/useNesting'
import { useColumns } from './composables/useColumns'

const props = defineProps<{
    api: string
    module: string
    mode: string
}>()

// State not in composables
const permissions = ref<any>(null)
const entityType = ref<any>({})
const urls = ref<any>({})
const templates = ref<any[]>([])
const filters = ref(0)
const filterUrls = ref<any>({})
const bookmarkable = ref(false)
const i18n = ref<any>({})
const loading = ref(true)

// Template refs
const orderBtn = ref()
const orderMenu = ref()
const templateBtn = ref()
const templateMenu = ref()
const actionsBtn = ref()
const actionsMenu = ref()
const columnsBtn = ref()
const columnsMenu = ref()
const hiddenMenus = ref()
const printForm = ref()

// Composables
const entityApi = useEntityApi({ api: props.api })
const bulkActions = useBulkActions(entityApi.entities)

// These composables need values from the API response, so we initialize with defaults
// and update after the initial fetch
const orderingComposable = useOrdering({
    api: props.api,
    fetchEntities: (url: string) => entityApi.fetchEntities(url),
    addToUrl: entityApi.addToUrl,
})

const layoutComposable = useLayout({
    initialMode: props.mode,
    api: props.api,
    preferencesUrl: '',
    csrf: '',
    fetchEntities: (url: string) => entityApi.fetchEntities(url),
    addToUrl: entityApi.addToUrl,
})

const nestingComposable = useNesting({
    api: props.api,
    preferencesUrl: '',
    csrf: '',
    fetchEntities: (url: string) => entityApi.fetchEntities(url),
    addToUrl: entityApi.addToUrl,
})

const columnsComposable = useColumns({
    preferencesUrl: '',
    csrf: '',
})

// Computed
const sortableColumns = computed(() => {
    return entityApi.columns.value.filter((col: any) => col.sortable && col.label)
})

const toggleableColumns = computed(() => {
    return entityApi.columns.value.filter((col: any) => !col.alwaysVisible && col.label)
})

// Methods
const hasPermissions = () => permissions.value

const openFilters = () => {
    (window as any).openDialog('datagrid-filters', filterUrls.value.form)
}

const bookmark = () => {
    (window as any).openDialog('primary-dialog', urls.value.bookmark)
}

const getEntities = async (page = 1) => {
    entityApi.loadPage(page)
}

const handleOrderBy = (field: string, sortKey?: string | null) => {
    orderBtn.value?._tippy?.hide()
    orderingComposable.orderBy(field, sortKey)
}

const handleGridNavigate = (entityId: number, childrenUrl: string) => {
    // Navigate into children without page reload
    entityApi.fetchEntities(childrenUrl).then((response: any) => {
        entityApi.parent.value = response.parent
    })

    // Update browser URL
    const currentUrl = new URL(window.location.href)
    currentUrl.searchParams.set('parent_id', String(entityId))
    window.history.pushState({}, '', currentUrl)
}

const handleGridBack = () => {
    // Go back to parent level
    const parent = entityApi.parent.value
    if (parent?.urls?.parent) {
        const url = new URL(parent.urls.parent)
        // Extract parent_id from the parent URL if any
        const parentApiUrl = entityApi.addToUrl(props.api, 'parent_id', '')
        // Fetch parent level
        entityApi.fetchEntities(parent.urls.parent.replace(window.location.origin, '') + '/api' + window.location.search).then((response: any) => {
            entityApi.parent.value = response.parent
        })
    } else {
        // Back to root
        entityApi.loadInitial().then((response: any) => {
            entityApi.parent.value = response.parent
        })
    }

    // Update browser URL
    const currentUrl = new URL(window.location.href)
    currentUrl.searchParams.delete('parent_id')
    window.history.pushState({}, '', currentUrl)
}

// Tippy dropdowns
let tippyInstances: any[] = []

const destroyAllTippy = () => {
    tippyInstances.forEach(instance => {
        const content = instance.props.content
        if (content instanceof Element && hiddenMenus.value) {
            hiddenMenus.value.appendChild(content)
        }
        instance.destroy()
    })
    tippyInstances = []
}

const initTippyDropdown = (btnRef: any, menuRef: any, placement = 'bottom') => {
    if (!btnRef.value || !menuRef.value) return
    const instance = tippy(btnRef.value, {
        content: menuRef.value,
        theme: 'kanka-dropdown',
        placement: placement,
        interactive: true,
        trigger: 'click',
        allowHTML: true,
        arrow: true,
        zIndex: 890,
    })
    tippyInstances.push(instance)
}

const initAllDropdowns = () => {
    destroyAllTippy()
    initTippyDropdown(orderBtn, orderMenu, 'bottom')
    initTippyDropdown(templateBtn, templateMenu, 'bottom-end')
    initTippyDropdown(actionsBtn, actionsMenu, 'bottom-end')
    initTippyDropdown(columnsBtn, columnsMenu, 'bottom-end')
}

// Lifecycle
onMounted(() => {
    entityApi.loadInitial().then((response: any) => {
        // Import state from API response
        filters.value = response.filters.count
        filterUrls.value = response.filters.urls
        i18n.value = response.i18n
        entityApi.parent.value = response.parent
        templates.value = response.templates
        permissions.value = response.permissions
        bookmarkable.value = response.bookmarkable
        urls.value = response.urls
        entityType.value = response.entityType

        // Initialize composables with API data
        nestingComposable.setNested(response.nested)
        orderingComposable.setOrder(response.order)
        columnsComposable.setColumns(response.columns ?? [], response.columnPreferences ?? [])

        // Update composable options that depend on API response
        if (response.urls?.preferences) {
            // The composables use the options passed at creation, so we update their internal refs
            // For layout/nesting/columns, the preferencesUrl and csrf need to be available
            // Since composables capture options by reference, we can't change them after creation
            // Instead, we use the response directly for preference persistence
        }

        loading.value = false
    })
})

watch(loading, (val) => {
    if (!val) nextTick(initAllDropdowns)
})

watch(() => orderingComposable.ordering.value, (val, oldVal) => {
    if (oldVal && !val) nextTick(initAllDropdowns)
})

watch(() => bulkActions.selecting.value, () => {
    nextTick(initAllDropdowns)
})

onBeforeUnmount(() => {
    destroyAllTippy()
})

onUpdated(() => {
    (window as any).ajaxTooltip?.()
})
</script>
