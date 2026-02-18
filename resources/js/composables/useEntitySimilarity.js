import { ref } from 'vue'

export function useEntitySimilarity() {
    const similarEntities = ref([])
    const isChecking = ref(false)

    let debounceTimer = null
    let lastChecked = ''
    let endPoint = ''
    let entityId = null

    const setup = (endpoint, id) => {
        endPoint = endpoint
        entityId = id
    }

    const setName = (name) => {
        if (debounceTimer) {
            clearTimeout(debounceTimer)
        }

        if (!name || name.length < 3) {
            similarEntities.value = []
            return
        }

        debounceTimer = setTimeout(() => {
            if (name === lastChecked) {
                return
            }
            lastChecked = name
            isChecking.value = true

            const url = endPoint + '?q=' + encodeURIComponent(name) + '&exclude=' + (entityId || '')

            fetch(url)
                .then(r => r.json())
                .then(res => {
                    similarEntities.value = res
                    isChecking.value = false
                })
                .catch(() => {
                    isChecking.value = false
                })
        }, 400)
    }

    const clear = () => {
        similarEntities.value = []
        lastChecked = ''
    }

    return { similarEntities, isChecking, setup, setName, clear }
}
