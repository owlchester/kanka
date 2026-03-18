import { ref, type Ref } from 'vue'

export function useBulkActions(entities: Ref<any[]>) {
    const selecting = ref(false)

    const toggleSelecting = () => {
        selecting.value = !selecting.value
        entities.value.forEach(e => {
            e.selected = false
        })
    }

    const allSelected = (): boolean =>
        entities.value.length > 0 && entities.value.every(e => e.selected)

    const toggleAll = () => {
        if (!entities.value.length) return
        const shouldSelect = !allSelected()
        entities.value.forEach(e => {
            e.selected = shouldSelect
        })
    }

    const selectedEntityIds = (): number[] => {
        return entities.value
            .filter(e => e.selected)
            .map(e => e.id)
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
        bulkDialog,
        bulkPrint,
    }
}
