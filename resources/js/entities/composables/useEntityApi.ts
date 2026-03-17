import { ref, type Ref } from 'vue'

interface EntityApiOptions {
    api: string
}

export function useEntityApi(options: EntityApiOptions) {
    const entities: Ref<any[]> = ref([])
    const entitiesData: Ref<any> = ref(null)
    const parent: Ref<any> = ref(null)
    const csrf: Ref<string> = ref('')
    const loading = ref(true)
    const paginating = ref(false)
    const columns: Ref<any[]> = ref([])
    const columnPreferences: Ref<string[]> = ref([])
    const ads: Ref<{ enabled: boolean; frequency: number }> = ref({ enabled: false, frequency: 7 })

    const importEntities = (response: any) => {
        entities.value = []
        entitiesData.value = response.entities
        response.entities.data.forEach((a: any) => {
            entities.value.push(a)
        })
        csrf.value = response.csrf
        columns.value = response.columns ?? []
        columnPreferences.value = response.columnPreferences ?? []
        ads.value = response.ads ?? { enabled: false, frequency: 7 }
    }

    const fetchEntities = (url: string) => {
        return fetch(url)
            .then(response => response.json())
            .then(response => {
                importEntities(response)
                return response
            })
    }

    const loadInitial = () => {
        return fetchEntities(options.api)
    }

    const currentApiUrl = (): string => {
        const apiUrl = new URL(options.api, window.location.origin)
        const browserParams = new URLSearchParams(window.location.search)
        browserParams.forEach((value, key) => {
            apiUrl.searchParams.set(key, value)
        })
        return apiUrl.toString()
    }

    const loadPage = (page: number) => {
        paginating.value = true
        const url = addToUrl(currentApiUrl(), 'page', String(page))
        return fetchEntities(url).then(() => {
            paginating.value = false
        })
    }

    const addToUrl = (url: string, param: string, value: string): string => {
        const urlObject = new URL(url, window.location.origin)
        urlObject.searchParams.set(param, value)
        return urlObject.toString()
    }

    return {
        entities,
        entitiesData,
        parent,
        csrf,
        loading,
        paginating,
        columns,
        columnPreferences,
        ads,
        fetchEntities,
        loadInitial,
        loadPage,
        addToUrl,
    }
}
