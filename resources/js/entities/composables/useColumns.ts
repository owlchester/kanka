import { ref, computed, type Ref } from 'vue'

interface ColumnsOptions {
    preferencesUrl: string
    csrf: string
}

interface ColumnDefinition {
    key: string
    type: string
    label: string | null
    sortable: boolean
    sortKey?: string | null
    alwaysVisible?: boolean
    adminOnly?: boolean
    moduleGate?: string | null
    icon?: string | null
    tooltip?: string | null
}

let debounceTimer: ReturnType<typeof setTimeout> | null = null

export function useColumns(options: ColumnsOptions) {
    const availableColumns: Ref<ColumnDefinition[]> = ref([])
    const visibleColumnKeys: Ref<string[]> = ref([])

    const setColumns = (columns: ColumnDefinition[], preferences: string[]) => {
        availableColumns.value = columns
        visibleColumnKeys.value = preferences
    }

    const visibleColumns = computed(() => {
        return availableColumns.value.filter(
            col => col.alwaysVisible || visibleColumnKeys.value.includes(col.key)
        )
    })

    const isColumnVisible = (key: string): boolean => {
        const col = availableColumns.value.find(c => c.key === key)
        if (col?.alwaysVisible) return true
        return visibleColumnKeys.value.includes(key)
    }

    const toggleColumn = (key: string) => {
        const col = availableColumns.value.find(c => c.key === key)
        if (col?.alwaysVisible) return

        const idx = visibleColumnKeys.value.indexOf(key)
        if (idx > -1) {
            visibleColumnKeys.value.splice(idx, 1)
        } else {
            visibleColumnKeys.value.push(key)
        }

        persistPreferences()
    }

    const resetToDefaults = () => {
        if (!options.preferencesUrl) return

        fetch(options.preferencesUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': options.csrf,
            },
        }).then(() => {
            // Reload to get fresh defaults
            window.location.reload()
        })
    }

    const persistPreferences = () => {
        if (!options.preferencesUrl) return

        // Debounce 500ms
        if (debounceTimer) clearTimeout(debounceTimer)
        debounceTimer = setTimeout(() => {
            fetch(options.preferencesUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': options.csrf,
                },
                body: JSON.stringify({ columns: visibleColumnKeys.value }),
            })
        }, 500)
    }

    return {
        availableColumns,
        visibleColumnKeys,
        visibleColumns,
        setColumns,
        isColumnVisible,
        toggleColumn,
        resetToDefaults,
    }
}
