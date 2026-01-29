
<script setup lang="ts">
import { ref, watch, computed } from 'vue'

type SectionType = 'entities' | 'posts' | 'new' | 'attributes'

interface MentionItem {
    id?: string
    name: string
    image?: string
    url?: string
    mention?: string
    type?: string
    inject?: string
    value?: string
    section: SectionType
}

interface Section {
    key: SectionType
    label: string
    icon: string
    items: MentionItem[]
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

const sectionConfig: Record<SectionType, { label: string; icon: string }> = {
    entities: { label: 'Entities', icon: 'fa-regular fa-bookmark' },
    posts: { label: 'Posts', icon: 'fa-regular fa-newspaper' },
    attributes: { label: 'Attributes', icon: 'fa-regular fa-heart' },
    new: { label: 'Create New', icon: 'fa-regular fa-plus' },
}

const sections = computed<Section[]>(() => {
    const sectionOrder: SectionType[] = ['entities', 'posts', 'attributes', 'new']

    return sectionOrder
        .map(key => ({
            key,
            label: sectionConfig[key].label,
            icon: sectionConfig[key].icon,
            items: props.items.filter(item => item.section === key),
        }))
        .filter(section => section.items.length > 0)
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

// Get the flat index for an item within a section
const getFlatIndex = (sectionKey: SectionType, itemIndex: number): number => {
    let flatIndex = 0
    for (const section of sections.value) {
        if (section.key === sectionKey) {
            return flatIndex + itemIndex
        }
        flatIndex += section.items.length
    }
    return flatIndex
}

defineExpose({
    onKeyDown,
})
</script>

<template>
    <div class="mention-list bg-base-100 shadow-lg rounded-lg z-50 max-h-[300px] overflow-y-auto">
        <template v-if="items.length">
            <div v-for="section in sections" :key="section.key" class="mention-section">
                <!-- Section header -->
                <div class="section-header px-3 py-1 text-xs font-semibold text-neutral-content/70 bg-base-200/50 flex items-center gap-2">
                    <i :class="section.icon" aria-hidden="true"></i>
                    {{ section.label }}
                </div>

                <!-- Section items -->
                <button
                    v-for="(item, itemIndex) in section.items"
                    :key="item.id ?? `${section.key}-${itemIndex}`"
                    @click="selectItem(getFlatIndex(section.key, itemIndex))"
                    class="mention-item flex items-center gap-2 w-full text-left px-3 py-2 hover:bg-base-200 text-xs justify-between cursor-pointer"
                    :class="{ 'bg-base-200': getFlatIndex(section.key, itemIndex) === selectedIndex }"
                >
                    <div class="flex gap-2 items-center">
                        <template v-if="section.key === 'new'">
                            <i class="fa-regular fa-plus text-success" aria-hidden="true"></i>
                        </template>
                        <img
                            v-else-if="item.image"
                            :src="item.image"
                            :alt="item.name"
                            class="w-6 h-6 rounded-full object-cover"
                        />
                        <span class="mention-name" v-html="item.name"></span>
                    </div>
                    <span v-if="item.type" class="mention-type text-neutral-content" v-html="item.type"></span>
                    <span v-if="item.value" class="text-neutral-content" v-html="item.value"></span>
                </button>
            </div>
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
