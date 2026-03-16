import { ref, type Ref } from 'vue'

interface NestingOptions {
    api: string
    preferencesUrl: string
    csrf: string
    fetchEntities: (url: string) => Promise<any>
    addToUrl: (url: string, param: string, value: string) => string
}

export function useNesting(options: NestingOptions) {
    const nested = ref(true)
    const nesting = ref(false)
    const expandedEntities: Ref<Record<number, any[]>> = ref({})
    const loadingChildren: Ref<Record<number, boolean>> = ref({})

    const setNested = (value: boolean) => {
        nested.value = value
    }

    const switchMode = () => {
        nesting.value = true
        nested.value = !nested.value

        const url = options.addToUrl(options.api, 'n', nested.value ? '1' : '0')
        options.fetchEntities(url).then(() => {
            nesting.value = false
        })

        // Sync browser URL
        const currentUrl = new URL(window.location.href)
        currentUrl.searchParams.set('n', nested.value ? '1' : '0')
        window.history.pushState({}, '', currentUrl)

        // Persist preference
        if (options.preferencesUrl) {
            fetch(options.preferencesUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': options.csrf,
                },
                body: JSON.stringify({ nested: nested.value }),
            })
        }
    }

    const loadChildren = async (entityId: number, childrenApiUrl: string) => {
        if (expandedEntities.value[entityId]) {
            // Toggle collapse
            delete expandedEntities.value[entityId]
            return
        }

        loadingChildren.value[entityId] = true
        try {
            const response = await fetch(childrenApiUrl)
            const data = await response.json()
            expandedEntities.value[entityId] = data.entities.data
        } finally {
            delete loadingChildren.value[entityId]
        }
    }

    const isExpanded = (entityId: number): boolean => {
        return !!expandedEntities.value[entityId]
    }

    const isLoadingChildren = (entityId: number): boolean => {
        return !!loadingChildren.value[entityId]
    }

    const getChildren = (entityId: number): any[] => {
        return expandedEntities.value[entityId] ?? []
    }

    return {
        nested,
        nesting,
        setNested,
        switchMode,
        loadChildren,
        isExpanded,
        isLoadingChildren,
        getChildren,
    }
}
