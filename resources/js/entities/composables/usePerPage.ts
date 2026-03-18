import { ref, type Ref } from 'vue'

interface PerPageOptions {
    api: string
    preferencesUrl: string
    csrf: string
    fetchEntities: (url: string) => Promise<any>
    addToUrl: (url: string, param: string, value: string) => string
    subscribeUrl: string
    isSubscriber: boolean
}

export function usePerPage(options: PerPageOptions) {
    const perPage: Ref<number> = ref(25)
    const isSubscriber: Ref<boolean> = ref(options.isSubscriber)
    const loading: Ref<boolean> = ref(false)
    const perPageOptions: Ref<number[]> = ref([])
    const subscriberPerPageOptions: Ref<number[]> = ref([])

    const setPerPage = (value: number) => {
        perPage.value = value
    }

    const setSubscriber = (value: boolean) => {
        isSubscriber.value = value
    }

    const setOptions = (opts: number[], subscriberOpts: number[]) => {
        perPageOptions.value = opts
        subscriberPerPageOptions.value = subscriberOpts
    }

    const isSubscriberOnly = (value: number): boolean => {
        return subscriberPerPageOptions.value.includes(value)
    }

    // Mirrors the currentApiUrl() pattern used in useNesting and useLayout:
    // start from options.api, layer in all current browser params so filters/order etc. are preserved.
    const currentApiUrl = (): string => {
        const apiUrl = new URL(options.api, window.location.origin)
        const browserParams = new URLSearchParams(window.location.search)
        browserParams.forEach((value, key) => {
            apiUrl.searchParams.set(key, value)
        })
        return apiUrl.toString()
    }

    const selectPerPage = (value: number) => {
        if (!perPageOptions.value.includes(value)) return

        if (isSubscriberOnly(value) && !isSubscriber.value) {
            ;(window as any).openDialog('primary-dialog', options.subscribeUrl)
            return
        }

        perPage.value = value

        // Re-fetch from page 1 with the new per_page param
        const fetchUrl = options.addToUrl(
            options.addToUrl(currentApiUrl(), 'pp', String(value)),
            'page', '1'
        )
        loading.value = true
        options.fetchEntities(fetchUrl).finally(() => {
            loading.value = false
        })

        // Sync browser URL
        const currentUrl = new URL(window.location.href)
        currentUrl.searchParams.set('pp', String(value))
        currentUrl.searchParams.delete('page')
        window.history.pushState({}, '', currentUrl)

        // Persist preference
        if (options.preferencesUrl) {
            fetch(options.preferencesUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': options.csrf,
                },
                body: JSON.stringify({ per_page: value }),
            })
        }
    }

    return {
        perPage,
        isSubscriber,
        loading,
        perPageOptions,
        subscriberPerPageOptions,
        setPerPage,
        setSubscriber,
        setOptions,
        isSubscriberOnly,
        selectPerPage,
    }
}
