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

    const switchLayout = () => {
        layout.value = isGrid() ? 'table' : 'grid'

        const url = options.addToUrl(options.api, 'm', layout.value)
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

    const gridLayoutClass = (): string => {
        return isGrid()
            ? 'entities-grid flex flex-wrap gap-3 lg:gap-5 w-full'
            : 'entities-grid flex flex-col gap-1 w-full'
    }

    return {
        layout,
        isGrid,
        switchLayout,
        gridLayoutClass,
    }
}
