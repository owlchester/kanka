<template>
    <li>
        <button class="flex items-center gap-2 w-full text-left font-semibold" @click="toggle(group.id)">
            <i :class="isOpen(group.id) ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-right'" aria-hidden="true" />
            <span class="grow">{{ group.name }}</span>
            <span class="text-xs opacity-60">{{ totalCount }}</span>
        </button>
        <ul v-if="isOpen(group.id)" class="pl-5 flex flex-col gap-1">
            <li v-for="pin in group.pins" :key="pin.id">
                <button class="flex items-center gap-2 text-left" @click="select(pin)">
                    <span class="inline-block w-2.5 h-2.5 rounded-full flex-none" :style="{ backgroundColor: pin.colour || '#ccc' }" />
                    <span>{{ pin.name }}</span>
                </button>
            </li>
            <LegendGroupNode
                v-for="child in group.children"
                :key="child.id"
                :group="child"
                :is-open="isOpen"
                :toggle="toggle"
                :select="select"
            />
        </ul>
    </li>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    group: { type: Object, required: true },
    isOpen: { type: Function, required: true },
    toggle: { type: Function, required: true },
    select: { type: Function, required: true },
})

function countPins(group) {
    return group.pins.length + group.children.reduce((sum, child) => sum + countPins(child), 0)
}

const totalCount = computed(() => countPins(props.group))
</script>
