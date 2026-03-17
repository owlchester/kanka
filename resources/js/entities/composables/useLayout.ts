import { ref } from 'vue'

interface LayoutOptions {
    initialMode: string
    api: string
    preferencesUrl: string
    csrf: string
    fetchEntities: (url: string) => Promise<any>
    addToUrl: (url: string, param: string, value: string) => string
}

export function useLayout(options: LayoutOptions) {
    const layout = ref(options.initialMode)

    const isGrid = (): boolean => layout.value === 'grid'

    const currentApiUrl = (): string => {
        const apiUrl = new URL(options.api, window.location.origin)
        const browserParams = new URLSearchParams(window.location.search)
        browserParams.forEach((value, key) => {
            apiUrl.searchParams.set(key, value)
        })
        return apiUrl.toString()
    }

    const switchLayout = () => {
        layout.value = isGrid() ? 'table' : 'grid'

        const url = options.addToUrl(currentApiUrl(), 'm', layout.value)
        options.fetchEntities(url)

        // Sync browser URL
        const currentUrl = new URL(window.location.href)
        currentUrl.searchParams.set('m', layout.value)
        window.history.pushState({}, '', currentUrl)

        // Persist preference
        if (options.preferencesUrl) {
            fetch(options.preferencesUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': options.csrf,
                },
                body: JSON.stringify({ layout: layout.value }),
            })
        }
    }

    return {
        layout,
        isGrid,
        switchLayout,
    }
}
