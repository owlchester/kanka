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

    const orderBy = (field: string, sortKey?: string | null) => {
        ordering.value = true
        const sortField = sortKey || field

        const url = new URL(options.api, window.location.origin)
        url.searchParams.set('order', sortField)
        if (isOrderingAscending(sortField)) {
            url.searchParams.set('desc', '1')
        } else {
            url.searchParams.delete('desc')
        }

        options.fetchEntities(url.toString()).then(() => {
            ordering.value = false
        })

        // Sync browser URL
        const currentUrl = new URL(window.location.href)
        currentUrl.searchParams.set('order', sortField)
        if (isOrderingAscending(sortField)) {
            currentUrl.searchParams.set('desc', '1')
        } else {
            currentUrl.searchParams.delete('desc')
        }
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
            ? 'fa-regular fa-arrow-down-z-a'
            : 'fa-regular fa-arrow-down-a-z'
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
