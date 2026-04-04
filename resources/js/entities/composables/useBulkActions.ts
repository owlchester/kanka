import { ref, type Ref } from 'vue'

export function useBulkActions(entities: Ref<any[]>) {
    const selecting = ref(false)
    const childSelectedIds = ref<Set<number>>(new Set())

    const toggleSelecting = () => {
        selecting.value = !selecting.value
        entities.value.forEach(e => {
            e.selected = false
        })
        childSelectedIds.value = new Set()
    }

    const allSelected = (): boolean =>
        entities.value.length > 0 && entities.value.every(e => e.selected)

    const toggleAll = () => {
        if (!entities.value.length) return
        const shouldSelect = !allSelected()
        entities.value.forEach(e => {
            e.selected = shouldSelect
        })
        if (!shouldSelect) {
            childSelectedIds.value = new Set()
        }
    }

    const toggleChildId = (id: number) => {
        const ids = new Set(childSelectedIds.value)
        if (ids.has(id)) {
            ids.delete(id)
        } else {
            ids.add(id)
        }
        childSelectedIds.value = ids
    }

    const selectedEntityIds = (): number[] => {
        const topLevel = entities.value.filter(e => e.selected).map(e => e.id)
        return [...new Set([...topLevel, ...childSelectedIds.value])]
    }

    const bulkDialog = (url: string, actionsBtn?: HTMLElement) => {
        (actionsBtn as any)?._tippy?.hide()
        const ids = selectedEntityIds()
        if (ids.length === 0) return

        const parsedUrl = new URL(url, window.location.origin)
        ids.forEach(id => {
            parsedUrl.searchParams.append('entities[]', String(id))
        })

        ;(window as any).openDialog('primary-dialog', parsedUrl.toString())
    }

    const bulkPrint = (printForm: HTMLFormElement | null, actionsBtn?: HTMLElement) => {
        (actionsBtn as any)?._tippy?.hide()
        const ids = selectedEntityIds()
        if (ids.length === 0) return
        printForm?.submit()
    }

    return {
        selecting,
        toggleSelecting,
        toggleAll,
        allSelected,
        selectedEntityIds,
        toggleChildId,
        bulkDialog,
        bulkPrint,
    }
}
