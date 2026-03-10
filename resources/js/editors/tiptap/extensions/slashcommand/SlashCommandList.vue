
<script setup lang="ts">
import { ref, watch } from 'vue'

interface SlashCommandItem {
    title: string
    description: string
    icon: string
    command: (editor: any) => void
}

const props = defineProps<{
    items: SlashCommandItem[]
    command: (item: SlashCommandItem) => void
}>()

const selectedIndex = ref(0)

watch(() => props.items, () => {
    selectedIndex.value = 0
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
    <div class="slash-command-list bg-base-100 shadow-lg rounded-lg z-50 max-h-[300px] overflow-y-auto min-w-[200px]">
        <template v-if="items.length">
            <button
                v-for="(item, index) in items"
                :key="item.title"
                @click="selectItem(index)"
                class="slash-command-item flex items-center gap-2 w-full text-left px-3 py-2 hover:bg-base-300 text-sm cursor-pointer"
                :class="{ 'bg-base-300': index === selectedIndex }"
            >
                <div class="w-6 h-6 rounded bg-base-200 flex items-center justify-center">
                    <i :class="item.icon" class="text-xs" aria-hidden="true"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-medium text-sm">{{ item.title }}</span>
                    <span class="text-xs text-neutral-content">{{ item.description }}</span>
                </div>
            </button>
        </template>
        <div v-else class="px-3 py-2 text-neutral-content text-sm">
            No commands found
        </div>
    </div>
</template>

<style scoped>
.slash-command-item {
    transition: background-color 0.1s;
}
</style>
