import { ref, type Ref } from 'vue'

export function useBulkActions(entities: Ref<any[]>) {
    const selecting = ref(false)

    const toggleSelecting = () => {
        selecting.value = !selecting.value
        entities.value.forEach(e => {
            e.selected = false
        })
    }

    const toggleAll = () => {
        if (!entities.value.length) return
        const shouldSelect = !entities.value[0].selected
        entities.value.forEach(e => {
            e.selected = shouldSelect
        })
    }

    const selectedEntityIds = (): number[] => {
        return entities.value
            .filter(e => e.selected)
            .map(e => e.id)
    }

    const bulkDialog = (url: string, actionsBtn?: Ref<any>) => {
        actionsBtn?.value?._tippy?.hide()
        const ids = selectedEntityIds()
        if (ids.length === 0) return

        const parsedUrl = new URL(url, window.location.origin)
        ids.forEach(id => {
            parsedUrl.searchParams.append('entities[]', String(id))
        })

        ;(window as any).openDialog('primary-dialog', parsedUrl.toString())
    }

    const bulkPrint = (printForm: Ref<HTMLFormElement | null>, actionsBtn?: Ref<any>) => {
        actionsBtn?.value?._tippy?.hide()
        const ids = selectedEntityIds()
        if (ids.length === 0) return
        printForm.value?.submit()
    }

    return {
        selecting,
        toggleSelecting,
        toggleAll,
        selectedEntityIds,
        bulkDialog,
        bulkPrint,
    }
}
