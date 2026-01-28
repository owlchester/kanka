
<script setup lang="ts">
import { ref, watch, computed } from 'vue'

interface MentionItem {
    id: string
    name: string
    image?: string
    url?: string
    mention: string
}

const props = defineProps<{
    items: MentionItem[]
    command: (item: MentionItem) => void
    loading: boolean
    query: string
}>()

const selectedIndex = ref(0)

watch(() => props.items, () => {
    selectedIndex.value = 0
})

const showMinCharacterMessage = computed(() => {
    return props.query.length < 3
})

const showLoading = computed(() => {
    return !showMinCharacterMessage.value && props.loading
})

const showNoResults = computed(() => {
    return !showMinCharacterMessage.value && !props.loading && props.items.length === 0
})

const onKeyDown = ({ event }: { event: KeyboardEvent }): boolean => {
    if (event.key === 'ArrowUp') {
        upHandler()
        return true
    }

    if (event.key === 'ArrowDown') {
        downHandler()
        return true
    }

    if (event.key === 'Enter') {
        enterHandler()
        return true
    }

    return false
}

const upHandler = () => {
    selectedIndex.value = ((selectedIndex.value + props.items.length) - 1) % props.items.length
}

const downHandler = () => {
    selectedIndex.value = (selectedIndex.value + 1) % props.items.length
}

const enterHandler = () => {
    selectItem(selectedIndex.value)
}

const selectItem = (index: number) => {
    const item = props.items[index]

    if (item) {
        props.command(item)
    }
}

defineExpose({
    onKeyDown,
})
</script>

<template>
    <div class="mention-list bg-base-100 shadow-lg rounded-lg z-50 max-h-[300px] overflow-y-auto">
        <template v-if="items.length">
            <button
                v-for="(item, index) in items"
                :key="item.id"
                @click="selectItem(index)"
                class="mention-item flex items-center gap-2 w-full text-left px-3 py-2 hover:bg-base-200 text-neutral-content text-xs"
                :class="{ 'bg-base-200': index === selectedIndex }"
            >
                <img
                    v-if="item.image"
                    :src="item.image"
                    :alt="item.name"
                    class="w-6 h-6 rounded-full object-cover"
                />
                <span class="mention-name">{{ item.name }}</span>
            </button>
        </template>
        <div v-else class="px-3 py-2 text-neutral-content text-xs">
            <span v-if="showMinCharacterMessage">
                Type at least 3 characters
            </span>
            <span v-else-if="showLoading">
                <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                Loading...
            </span>
            <span v-else-if="showNoResults">
                No results
            </span>
        </div>
    </div>
</template>

<style scoped>
.mention-list {
    min-width: 200px;
}

.mention-item {
    transition: background-color 0.1s;
}
</style>
