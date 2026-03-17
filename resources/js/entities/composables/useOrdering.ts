import { ref, type Ref } from 'vue'

interface OrderingOptions {
    api: string
    fetchEntities: (url: string) => Promise<any>
    addToUrl: (url: string, param: string, value: string) => string
}

export function useOrdering(options: OrderingOptions) {
    const order: Ref<Record<string, string>> = ref({})
    const ordering = ref(false)

    const setOrder = (orderData: Record<string, string>) => {
        order.value = orderData
    }

    const currentApiUrl = (): string => {
        const apiUrl = new URL(options.api, window.location.origin)
        const browserParams = new URLSearchParams(window.location.search)
        browserParams.forEach((value, key) => {
            apiUrl.searchParams.set(key, value)
        })
        return apiUrl.toString()
    }

    const orderBy = (field: string, sortKey?: string | null) => {
        ordering.value = true
        const sortField = sortKey || field

        const url = new URL(currentApiUrl())
        const currentUrl = new URL(window.location.href)

        if (isOrderingAscending(sortField)) {
            // ASC → DESC
            url.searchParams.set('order', sortField)
            url.searchParams.set('desc', '1')
            currentUrl.searchParams.set('order', sortField)
            currentUrl.searchParams.set('desc', '1')
            order.value = { [sortField]: 'DESC' }
        } else if (isOrdering(sortField)) {
            // DESC → reset (clear sort)
            url.searchParams.set('order', 'clear')
            url.searchParams.delete('desc')
            currentUrl.searchParams.delete('order')
            currentUrl.searchParams.delete('desc')
            order.value = {}
        } else {
            // Not sorted → ASC
            url.searchParams.set('order', sortField)
            url.searchParams.delete('desc')
            currentUrl.searchParams.set('order', sortField)
            currentUrl.searchParams.delete('desc')
            order.value = { [sortField]: 'ASC' }
        }

        options.fetchEntities(url.toString()).then(() => {
            ordering.value = false
        })

        window.history.pushState({}, '', currentUrl)
    }

    const isOrdering = (field: string): boolean => {
        return !!order.value[field]
    }

    const isOrderingAscending = (field: string): boolean => {
        return order.value[field] === 'ASC'
    }

    const orderByClass = (field: string): string => {
        const css = 'flex items-center gap-2 px-2'
        return isOrdering(field) ? css + ' font-extrabold' : css
    }

    const orderByIcon = (field: string): string => {
        return isOrderingAscending(field)
            ? 'fa-regular fa-arrow-down-a-z'
            : 'fa-regular fa-arrow-down-z-a'
    }

    return {
        order,
        ordering,
        setOrder,
        orderBy,
        isOrdering,
        isOrderingAscending,
        orderByClass,
        orderByIcon,
    }
}
