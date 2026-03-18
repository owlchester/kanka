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
    <div class="flex flex-col gap-4 w-full" v-else ref="listingRef">
        <!-- Toolbar -->
        <div class="flex gap-2 justify-between items-center flex-wrap">
            <!-- Left: title + filters -->
            <div class="flex gap-2 items-center flex-wrap" v-if="!bulkActions.selecting.value">
                <h1 class="text-2xl category-title truncate" v-html="props.module"></h1>

                <!-- Filter button: no active filters -->
                <button
                    v-if="!bulkActions.selecting.value && filters === 0"
                    class="btn2"
                    :aria-label="i18n.filters"
                    :title="i18n.filters"
                    @click="openFilters"
                >
                    <i class="fa-regular fa-filter" aria-hidden="true"></i>
                    <span class="hidden sm:inline" v-html="i18n.filters"></span>
                </button>

                <!-- Filter pill: active filters -->
                <div
                    v-else-if="!bulkActions.selecting.value && filters > 0"
                    class="join"
                >
                    <button class="btn2 btn-sm join-item" @click="openFilters">
                        <i class="fa-regular fa-filter" aria-hidden="true"></i>
                        <span class="hidden sm:inline" v-html="i18n.filters"></span>
                        <span class="rounded-full bg-primary text-primary-content px-1.5 text-xs font-bold leading-5">{{ filters }}</span>
                    </button>
                    <button
                        v-if="bookmarkable"
                        class="btn2 btn-sm join-item"
                        :title="i18n.bookmark"
                        @click="bookmark"
                    >
                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                    </button>
                    <button
                        class="btn2 btn-sm join-item "
                        :title="i18n.clearFilters"
                        @click="clearFilters"
                    >
                        <i class="fa-regular fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <!-- Right: view controls + create (not in bulk mode) -->
            <div class="flex gap-2 items-center flex-wrap" v-if="!bulkActions.selecting.value">
                <!-- Loading spinner during ordering or per-page change -->
                <button class="btn2 btn-disabled" disabled v-if="orderingComposable.ordering.value || perPageComposable.loading.value">
                    <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
                </button>

                <!-- Nesting toggle (unchanged behaviour) -->
                <div
                    v-if="entityType.is_nested && !orderingComposable.ordering.value"
                    class="flex items-center rounded-xl bg-base-200 overflow-hidden p-0.5 gap-0.5"
                >
                    <button
                        @click="nestingComposable.switchMode()"
                        class="flex items-center justify-center rounded-lg px-2 py-2 text-sm transition-all"
                        :class="nestingComposable.nested.value ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content cursor-pointer hover:text-base-content'"
                        :title="i18n.flatten"
                    >
                        <i class="fa-regular fa-boxes-stacked" aria-hidden="true"></i>
                    </button>
                    <button
                        @click="nestingComposable.switchMode()"
                        class="flex items-center justify-center rounded-lg px-2 py-2 text-sm transition-all"
                        :class="!nestingComposable.nested.value ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content cursor-pointer hover:text-base-content'"
                        :title="i18n.nest"
                    >
                        <i class="fa-regular fa-layer-group" aria-hidden="true"></i>
                    </button>
                </div>

                <!-- Layout toggle (grid / table) — only when entity type has table -->
                <div
                    v-if="entityType.has_table && !orderingComposable.ordering.value"
                    class="flex items-center rounded-xl bg-base-200 overflow-hidden p-0.5 gap-0.5"
                >
                    <button
                        @click="!layoutComposable.isGrid() && layoutComposable.switchLayout()"
                        class="flex items-center justify-center rounded-lg px-2 py-2 text-sm transition-all"
                        :class="layoutComposable.isGrid() ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content cursor-pointer hover:text-base-content'"
                        :title="i18n.layout_grid"
                    >
                        <i class="fa-regular fa-grid-2" aria-hidden="true"></i>
                    </button>
                    <button
                        @click="layoutComposable.isGrid() && layoutComposable.switchLayout()"
                        class="flex items-center justify-center rounded-lg px-2 py-2 text-sm transition-all"
                        :class="!layoutComposable.isGrid() ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content cursor-pointer hover:text-base-content'"
                        :title="i18n.layout_table"
                    >
                        <i class="fa-regular fa-list-ul" aria-hidden="true"></i>
                    </button>
                </div>

                <!-- Display dropdown button -->
                <div>
                    <button ref="displayBtn" class="btn2 btn-sm" :title="i18n.display">
                        <i class="fa-regular fa-gear" aria-hidden="true"></i>
                        <span class="hidden sm:inline" v-html="i18n.display"></span>
                    </button>
                </div>

                <!-- Select button (hidden on mobile) -->
                <button
                    v-if="hasPermissions()"
                    @click="bulkActions.toggleSelecting()"
                    class="btn2 hidden btn-sm sm:flex"
                >
                    <i class="fa-regular fa-check-square" aria-hidden="true"></i>
                    <span class="hidden sm:inline" v-html="i18n.select"></span>
                </button>

                <!-- Create + template caret -->
                <div class="join" v-if="hasPermissions() && permissions.create">
                    <a :href="urls.create" class="btn2 btn-primary btn-sm join-item btn-new-entity">
                        <i class="fa-regular fa-plus" aria-hidden="true"></i>
                        <span class="hidden md:inline" v-html="entityType.singular"></span>
                    </a>
                    <div v-if="permissions.template">
                        <button ref="templateBtn" type="button" class="btn2 btn-primary btn-sm join-item" aria-expanded="false" aria-label="Create from template" aria-haspopup="menu">
                            <i class="fa-regular fa-caret-down" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bulk action bar (selecting mode) -->
            <div class="flex gap-2 items-center flex-wrap w-full" v-else>
                <span class="rounded-full bg-primary text-primary-content px-3 py-1 text-xs font-bold">
                    {{ bulkActions.selectedEntityIds().length }}
                    {{ i18n.selected }}
                </span>
                <button @click="bulkActions.toggleAll()" class="btn2 btn-sm" v-html="i18n.selectAll"></button>
                <div class="flex-1"></div>
                <!-- Admin primary action: batch edit -->
                <div class="join" v-if="permissions.admin">
                    <button class="btn2 btn-primary btn-sm join-item" @click="bulkActions.bulkDialog(urls.batch, actionsBtn)">
                        <i class="fa-regular fa-pencil" aria-hidden="true"></i>
                        <span class="hidden md:inline" v-html="i18n.bulkEdit"></span>
                    </button>
                    <div>
                        <button ref="actionsBtn" type="button" class="btn2 btn-primary btn-sm join-item" aria-expanded="false" aria-label="More bulk actions" aria-haspopup="menu">
                            <i class="fa-regular fa-caret-down" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <!-- Non-admin primary action: print -->
                <div class="join" v-else>
                    <button class="btn2 btn-primary join-item" @click="bulkActions.bulkPrint(printForm, actionsBtn)">
                        <i class="fa-regular fa-print" aria-hidden="true"></i>
                        <span class="hidden md:inline" v-html="i18n.bulkPrint"></span>
                    </button>
                    <div>
                        <button ref="actionsBtn" type="button" class="btn2 btn-primary join-item" aria-expanded="false" aria-label="More bulk actions" aria-haspopup="menu">
                            <i class="fa-regular fa-caret-down" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <button @click="bulkActions.toggleSelecting()" class="btn2 btn-ghost btn-sm">
                    <i class="fa-regular fa-times" aria-hidden="true"></i>
                    <span v-html="i18n.done"></span>
                </button>
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
                :all-selected="bulkActions.allSelected()"
                :nested="nestingComposable.nested.value"
                :i18n="i18n"
                :entity-type="entityType"
                :features="features"
                :ads="entityApi.ads.value"
                :is-ordering="orderingComposable.isOrdering"
                :order-by-icon="orderingComposable.orderByIcon"
                @order-by="handleOrderBy"
                @toggle-all="bulkActions.toggleAll()"
                @start-selecting="handleStartSelecting"
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
            <!-- Display menu: sort + per page + columns -->
            <div ref="displayMenu" class="flex flex-col gap-3 p-1 min-w-56">
                <!-- Sort by -->
                <div v-if="sortableColumns.length > 0">
                    <div class="text-xs uppercase tracking-wide text-neutral-content px-1 mb-1.5" v-html="i18n.sortBy"></div>
                    <div class="flex flex-wrap gap-1.5">
                        <button
                            v-for="col in sortableColumns"
                            :key="col.key"
                            @click="handleOrderBy(col.key, col.sortKey)"
                            class="px-2.5 py-1 rounded-full text-xs border transition-all cursor-pointer"
                            :class="orderingComposable.isOrdering(col.sortKey || col.key)
                                ? 'bg-primary text-primary-content border-primary font-semibold'
                                : 'bg-base-200 border-base-300 text-base-content hover:border-primary'"
                        >
                            <i v-if="orderingComposable.isOrdering(col.sortKey || col.key)" :class="orderingComposable.orderByIcon(col.sortKey || col.key)" class="mr-1"></i>
                            <span v-html="col.label"></span>
                        </button>
                    </div>
                </div>

                <!-- Results per page -->
                <div>
                    <div class="text-xs uppercase tracking-wide text-neutral-content px-1 mb-1.5" v-html="i18n.perPage"></div>
                    <div class="flex gap-1.5">
                        <button
                            v-for="n in [10, 25, 50, 100]"
                            :key="n"
                            @click="handleSelectPerPage(n)"
                            class="px-3 py-1 rounded-md text-xs border transition-all"
                            :class="[
                                perPageComposable.perPage.value === n
                                    ? 'bg-primary text-primary-content border-primary font-semibold'
                                    : 'bg-base-200 border-base-300 text-base-content hover:border-primary',
                                n === 100 && !perPageComposable.isSubscriber.value ? 'opacity-60' : ''
                            ]"
                        >
                            {{ n }}<i v-if="n === 100 && !perPageComposable.isSubscriber.value" class="fa-regular fa-star ml-1 text-warning" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <!-- Visible columns (table mode only) -->
                <div v-if="!layoutComposable.isGrid() && entityType.has_table && toggleableColumns.length > 0">
                    <hr class="border-base-300 -mx-1 mb-3" />
                    <div class="text-xs uppercase tracking-wide text-neutral-content px-1 mb-1.5" v-html="i18n.columns"></div>
                    <div class="flex flex-col gap-0.5">
                        <div
                            v-for="col in toggleableColumns"
                            :key="col.key"
                            class="px-2 py-1.5 hover:bg-base-200 rounded-lg flex items-center justify-between gap-2 text-xs cursor-pointer text-base-content"
                            :class="columnsComposable.isColumnVisible(col.key) ? 'text-primary' : ''"
                            @click="columnsComposable.toggleColumn(col.key)"
                        >
                            <span v-html="col.label"></span>
                            <i :class="columnsComposable.isColumnVisible(col.key) ? 'fa-regular fa-check text-primary' : 'fa-regular fa-circle text-neutral-content'"></i>
                        </div>
                    </div>
                    <button @click="columnsComposable.resetToDefaults()" class="mt-1.5 px-2 py-1.5 hover:bg-base-200 rounded-lg flex items-center gap-2 text-xs text-base-content w-full">
                        <i class="fa-regular fa-rotate-left" aria-hidden="true"></i>
                        <span v-html="i18n.resetDefaults"></span>
                    </button>
                </div>
            </div>

            <!-- Template/archetype menu (unchanged) -->
            <div ref="templateMenu" class="flex flex-col gap-1">
                <a v-for="template in templates" :href="template.url" :key="template.id"
                   class="px-2 py-2 hover:bg-base-200 rounded-xl flex items-center gap-1.5 text-xs transition-all duration-150 text-base-content">
                    <i class="fa-regular fa-star text-neutral-content w-5" aria-hidden="true"></i>
                    <span v-html="template.name"></span>
                </a>
                <hr class="m-0" v-if="templates.length > 0" />
                <a href="https://docs.kanka.io/en/latest/guides/templates.html"
                   class="px-2 py-2 hover:bg-base-200 rounded-xl flex items-center gap-1.5 transition-all duration-150 text-base-content text-xs">
                    <i class="fa-regular fa-external-link text-neutral-content w-5" aria-hidden="true"></i>
                    <span class="text-nowrap" v-html="i18n.templates"></span>
                </a>
            </div>

            <!-- Bulk actions menu (unchanged) -->
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
import { usePerPage } from './composables/usePerPage'

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
const features = ref<any>({})
const i18n = ref<any>({})
const loading = ref(true)

// Template refs
const listingRef = ref<HTMLElement | null>(null)
const displayBtn = ref()
const displayMenu = ref()
const templateBtn = ref()
const templateMenu = ref()
const actionsBtn = ref()
const actionsMenu = ref()
const hiddenMenus = ref()
const printForm = ref()

// Composables
const entityApi = useEntityApi({ api: props.api })
const bulkActions = useBulkActions(entityApi.entities)

// Options objects are kept as references so their properties can be mutated
// after the API response provides the preferences URL and CSRF token
const layoutOptions = {
    initialMode: props.mode,
    api: props.api,
    preferencesUrl: '',
    csrf: '',
    fetchEntities: (url: string) => entityApi.fetchEntities(url),
    addToUrl: entityApi.addToUrl,
}

const nestingOptions = {
    api: props.api,
    preferencesUrl: '',
    csrf: '',
    fetchEntities: (url: string) => entityApi.fetchEntities(url),
    addToUrl: entityApi.addToUrl,
}

const columnsOptions = {
    preferencesUrl: '',
    csrf: '',
}

const perPageOptions = {
    api: props.api,
    preferencesUrl: '',
    csrf: '',
    fetchEntities: (url: string) => entityApi.fetchEntities(url),
    addToUrl: entityApi.addToUrl,
    subscribeUrl: '',
    isSubscriber: false,
}

const orderingComposable = useOrdering({
    api: props.api,
    fetchEntities: (url: string) => entityApi.fetchEntities(url),
    addToUrl: entityApi.addToUrl,
})

const layoutComposable = useLayout(layoutOptions)
const nestingComposable = useNesting(nestingOptions)
const columnsComposable = useColumns(columnsOptions)
const perPageComposable = usePerPage(perPageOptions)

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

// Full page navigation: filterUrls.clear is a page URL, not a JSON API endpoint
const clearFilters = () => {
    window.location.href = filterUrls.value.clear
}

const getEntities = async (page = 1) => {
    entityApi.loadPage(page)
    listingRef.value?.scrollIntoView({ behavior: 'smooth', block: 'start' })
}

const handleOrderBy = (field: string, sortKey?: string | null) => {
    orderingComposable.orderBy(field, sortKey)
}

const handleSelectPerPage = (n: number) => {
    perPageComposable.selectPerPage(n)
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

const handleStartSelecting = (entityId: number) => {
    bulkActions.toggleSelecting()
    const entity = entityApi.entities.value.find((e: any) => e.id === entityId)
    if (entity) {
        entity.selected = true
    }
}

const handleGridBack = () => {
    const parent = entityApi.parent.value
    if (parent?.urls?.parent_api) {
        entityApi.fetchEntities(parent.urls.parent_api).then((response: any) => {
            entityApi.parent.value = response.parent
        })

        const currentUrl = new URL(window.location.href)
        if (parent.parent_id) {
            currentUrl.searchParams.set('parent_id', String(parent.parent_id))
        } else {
            currentUrl.searchParams.delete('parent_id')
        }
        window.history.pushState({}, '', currentUrl)
    } else {
        entityApi.loadInitial().then((response: any) => {
            entityApi.parent.value = response.parent
        })

        const currentUrl = new URL(window.location.href)
        currentUrl.searchParams.delete('parent_id')
        window.history.pushState({}, '', currentUrl)
    }
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
    initTippyDropdown(displayBtn, displayMenu, 'bottom-end')
    initTippyDropdown(templateBtn, templateMenu, 'bottom-end')
    initTippyDropdown(actionsBtn, actionsMenu, 'bottom-end')
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
        features.value = response.features ?? {}
        urls.value = response.urls
        entityType.value = response.entityType

        // Initialize composables with API data
        nestingComposable.setNested(response.nested)
        orderingComposable.setOrder(response.order)
        columnsComposable.setColumns(response.columns ?? [], response.columnPreferences ?? [])

        // Update composable options with preference URLs from API response
        if (response.urls?.preferences) {
            layoutOptions.preferencesUrl = response.urls.preferences
            layoutOptions.csrf = response.csrf
            nestingOptions.preferencesUrl = response.urls.preferences
            nestingOptions.csrf = response.csrf
            columnsOptions.preferencesUrl = response.urls.preferences
            columnsOptions.csrf = response.csrf
        }

        // Wire per-page composable
        perPageComposable.setPerPage(response.preferences?.per_page ?? 25)
        perPageComposable.setSubscriber(response.subscription?.isSubscriber ?? false)
        if (response.urls?.preferences) {
            perPageOptions.preferencesUrl = response.urls.preferences
            perPageOptions.csrf = response.csrf
            perPageOptions.subscribeUrl = response.subscription?.url ?? ''
        }

        loading.value = false
    })
    window.addEventListener('keydown', handleKeydown)
})

watch(loading, (val) => {
    if (!val) nextTick(() => {
        initAllDropdowns()
    })
})


watch(() => bulkActions.selecting.value, () => {
    nextTick(initAllDropdowns)
})

watch(() => layoutComposable.layout.value, () => {
    nextTick(initAllDropdowns)
})

const handleKeydown = (e: KeyboardEvent) => {
    if (e.key === 'Escape' && bulkActions.selecting.value) {
        bulkActions.toggleSelecting()
    }
}

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeydown)
    destroyAllTippy()
})

onUpdated(() => {
    (window as any).ajaxTooltip?.()
})
</script>
