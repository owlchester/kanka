import { reactive, ref, computed } from 'vue'
import axios from 'axios'
import type {
    GalleryBreadcrumb,
    GalleryFileItem,
    GalleryFileType,
    GalleryOrientation,
    GalleryPagination,
    GalleryScope,
    GallerySetupData,
    GallerySort,
    GalleryUsage,
    GalleryViewMode,
} from '../types'

const PREFS_KEY = 'kanka.gallery.prefs.v1'

interface StoredPrefs {
    view?: GalleryViewMode
    perPage?: number
    sort?: GallerySort
    sidebarOpen?: boolean
    scope?: GalleryScope
}

function loadPrefs(): StoredPrefs {
    try {
        const raw = localStorage.getItem(PREFS_KEY)
        if (!raw) return {}
        return JSON.parse(raw) as StoredPrefs
    } catch {
        return {}
    }
}

function savePrefs(prefs: StoredPrefs): void {
    try {
        localStorage.setItem(PREFS_KEY, JSON.stringify(prefs))
    } catch {
        // Ignore storage quota errors
    }
}

export function useGalleryState() {
    const prefs = loadPrefs()
    const urlParams = new URLSearchParams(window.location.search)

    const viewParam = urlParams.get('view') as GalleryViewMode | null
    const perPageParam = Number(urlParams.get('per_page'))
    const sortParam = urlParams.get('sort') as GallerySort | null
    const scopeParam = urlParams.get('scope') as GalleryScope | null

    const state = reactive({
        folderId: urlParams.get('folder') || urlParams.get('folder_id') || null as string | null,
        imageId: urlParams.get('image') || null as string | null,
        q: urlParams.get('q') || '',
        scope: (scopeParam === 'folder' || scopeParam === 'all' ? scopeParam : (prefs.scope ?? 'all')) as GalleryScope,
        usage: (urlParams.get('usage') || 'all') as GalleryUsage,
        type: (urlParams.get('type') || 'all') as GalleryFileType,
        visibilityId: urlParams.get('visibility') || 'all',
        createdBy: urlParams.get('uploader') || 'all',
        orientation: (urlParams.get('orientation') || 'all') as GalleryOrientation,
        sort: (sortParam && ['recent', 'oldest', 'updated_asc', 'name_asc', 'name_desc', 'size_desc', 'size_asc', 'used_desc', 'used_asc'].includes(sortParam)
            ? sortParam
            : (prefs.sort ?? 'recent')) as GallerySort,
        page: Math.max(1, Number(urlParams.get('page')) || 1),
        perPage: [24, 48, 96].includes(perPageParam)
            ? perPageParam
            : ([24, 48, 96].includes(Number(prefs.perPage)) ? Number(prefs.perPage) : 24),
        view: (viewParam && ['grid-md', 'grid-sm', 'table'].includes(viewParam)
            ? viewParam
            : (prefs.view && ['grid-md', 'grid-sm', 'table'].includes(prefs.view) ? prefs.view : 'grid-md')) as GalleryViewMode,
        sidebarOpen: prefs.sidebarOpen ?? true,
    })

    const initiated = ref(false)
    const loading = ref(false)
    const setup = ref<GallerySetupData | null>(null)
    const files = ref<GalleryFileItem[]>([])
    const currentFolder = ref<GalleryFileItem | null>(null)
    const breadcrumbs = ref<GalleryBreadcrumb[]>([])
    const currentFile = ref<GalleryFileItem | null>(null)
    const pagination = ref<GalleryPagination>({
        current_page: 1,
        last_page: 1,
        per_page: state.perPage,
        total: 0,
        from: 0,
        to: 0,
    })

    let fetchAbort: AbortController | null = null

    const trans = (key: string, replacements?: Record<string, string | number>): string => {
        const dict = setup.value?.i18n ?? {}
        let text = dict[key] ?? key
        if (replacements) {
            Object.entries(replacements).forEach(([k, v]) => {
                text = text.replace(`:${k}`, String(v))
            })
        }
        return text
    }

    const persistPrefs = () => {
        savePrefs({
            view: state.view,
            perPage: state.perPage,
            sort: state.sort,
            sidebarOpen: state.sidebarOpen,
            scope: state.scope,
        })
    }

    const syncUrl = (replace = false) => {
        const params = new URLSearchParams()
        if (state.folderId) params.set('folder', state.folderId)
        if (state.imageId) params.set('image', state.imageId)
        if (state.q) params.set('q', state.q)
        if (state.q && state.scope !== 'all') params.set('scope', state.scope)
        if (state.usage !== 'all') params.set('usage', state.usage)
        if (state.type !== 'all') params.set('type', state.type)
        if (state.visibilityId !== 'all') params.set('visibility', state.visibilityId)
        if (state.createdBy !== 'all') params.set('uploader', state.createdBy)
        if (state.orientation !== 'all') params.set('orientation', state.orientation)
        if (state.sort !== 'recent') params.set('sort', state.sort)
        if (state.page > 1) params.set('page', String(state.page))
        if (state.perPage !== 24) params.set('per_page', String(state.perPage))

        const qs = params.toString()
        const newUrl = window.location.pathname + (qs ? `?${qs}` : '')
        if (replace) {
            window.history.replaceState({}, '', newUrl)
        } else {
            window.history.pushState({}, '', newUrl)
        }
    }

    const activeFilterCount = computed(() => {
        let count = 0
        if (state.usage !== 'all') count++
        if (state.type !== 'all') count++
        if (state.visibilityId !== 'all') count++
        if (state.createdBy !== 'all') count++
        if (state.orientation !== 'all') count++
        return count
    })

    const hasActiveFiltersOrSearch = computed(() => {
        return activeFilterCount.value > 0 || state.q.trim().length > 0
    })

    const fetchItems = async (options: { pushUrl?: boolean; hydrateImage?: boolean } = {}) => {
        if (!setup.value?.api.items) return

        if (fetchAbort) {
            fetchAbort.abort()
        }
        fetchAbort = new AbortController()
        loading.value = true

        if (options.pushUrl !== false) {
            syncUrl(false)
        }

        try {
            const params: Record<string, string | number> = {
                page: state.page,
                per_page: state.perPage,
                sort: state.sort,
                scope: state.scope,
            }
            if (state.folderId) params.folder = state.folderId
            if (state.q.trim()) params.q = state.q.trim()
            if (state.usage !== 'all') params.usage = state.usage
            if (state.type !== 'all') params.type = state.type
            if (state.visibilityId !== 'all') params.visibility_id = state.visibilityId
            if (state.createdBy !== 'all') params.created_by = state.createdBy
            if (state.orientation !== 'all') params.orientation = state.orientation
            if (options.hydrateImage && state.imageId) params.image = state.imageId

            const res = await axios.get(setup.value.api.items, {
                params,
                signal: fetchAbort.signal,
            })

            files.value = (res.data.files || []).map((f: GalleryFileItem) => ({
                ...f,
                is_selected: false,
            }))
            currentFolder.value = res.data.folder ?? null
            breadcrumbs.value = res.data.breadcrumbs ?? []
            pagination.value = res.data.pagination ?? pagination.value

            if (options.hydrateImage && state.imageId) {
                const inList = files.value.find(f => f.id === state.imageId)
                currentFile.value = inList ?? res.data.selected_image ?? null
            }
        } catch (err: any) {
            if (axios.isCancel(err)) return
            console.error('Failed to fetch gallery items', err)
            window.showToast?.(err.response?.data?.message ?? 'Failed to load gallery items', 'error')
        } finally {
            loading.value = false
        }
    }

    const loadSetup = async (apiUrl: string) => {
        const res = await axios.get(apiUrl)
        setup.value = res.data
        initiated.value = true
        await fetchItems({ pushUrl: false, hydrateImage: Boolean(state.imageId) })
    }

    const resetFilters = () => {
        state.usage = 'all'
        state.type = 'all'
        state.visibilityId = 'all'
        state.createdBy = 'all'
        state.orientation = 'all'
        state.q = ''
        state.page = 1
        fetchItems()
    }

    const applyPopstate = () => {
        const params = new URLSearchParams(window.location.search)
        state.folderId = params.get('folder') || null
        state.imageId = params.get('image') || null
        state.q = params.get('q') || ''
        state.scope = (params.get('scope') as GalleryScope) || 'all'
        state.usage = (params.get('usage') as GalleryUsage) || 'all'
        state.type = (params.get('type') as GalleryFileType) || 'all'
        state.visibilityId = params.get('visibility') || 'all'
        state.createdBy = params.get('uploader') || 'all'
        state.orientation = (params.get('orientation') as GalleryOrientation) || 'all'
        state.sort = (params.get('sort') as GallerySort) || 'recent'
        state.page = Math.max(1, Number(params.get('page')) || 1)
        const pp = Number(params.get('per_page'))
        if ([24, 48, 96].includes(pp)) state.perPage = pp

        fetchItems({ pushUrl: false, hydrateImage: Boolean(state.imageId) })
    }

    return {
        state,
        initiated,
        loading,
        setup,
        files,
        currentFolder,
        breadcrumbs,
        currentFile,
        pagination,
        activeFilterCount,
        hasActiveFiltersOrSearch,
        trans,
        persistPrefs,
        syncUrl,
        fetchItems,
        loadSetup,
        resetFilters,
        applyPopstate,
    }
}
