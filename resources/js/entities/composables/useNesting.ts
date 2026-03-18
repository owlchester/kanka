import { ref } from 'vue'

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

    const setNested = (value: boolean) => {
        nested.value = value
    }

    const currentApiUrl = (): string => {
        const apiUrl = new URL(options.api, window.location.origin)
        const browserParams = new URLSearchParams(window.location.search)
        browserParams.forEach((value, key) => {
            apiUrl.searchParams.set(key, value)
        })
        return apiUrl.toString()
    }

    const switchMode = () => {
        nesting.value = true
        nested.value = !nested.value

        const url = options.addToUrl(currentApiUrl(), 'n', nested.value ? '1' : '0')
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

    return {
        nested,
        nesting,
        setNested,
        switchMode,
    }
}
