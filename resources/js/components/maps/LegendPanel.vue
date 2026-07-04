<template>
    <aside v-if="open" class="fixed top-0 left-0 h-screen w-72 bg-base-100 shadow-lg z-[1100] overflow-y-auto p-4">
        <ul class="flex flex-col gap-1">
            <li v-for="group in tree.groups" :key="group.id">
                <button class="flex items-center gap-2 w-full text-left font-semibold" @click="toggle(group.id)">
                    <i :class="isOpen(group.id) ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-right'" aria-hidden="true" />
                    <span>{{ group.name }}</span>
                </button>
                <ul v-if="isOpen(group.id)" class="pl-5 flex flex-col gap-1">
                    <li v-for="pin in group.pins" :key="pin.id">
                        <button class="text-left" @click="$emit('select', pin)">{{ pin.name }}</button>
                    </li>
                </ul>
            </li>

            <li v-if="tree.uncategorised.length">
                <button class="flex items-center gap-2 w-full text-left font-semibold" @click="toggle('uncategorised')">
                    <i :class="isOpen('uncategorised') ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-right'" aria-hidden="true" />
                    <span>Uncategorised</span>
                </button>
                <ul v-if="isOpen('uncategorised')" class="pl-5 flex flex-col gap-1">
                    <li v-for="pin in tree.uncategorised" :key="pin.id">
                        <button class="text-left" @click="$emit('select', pin)">{{ pin.name }}</button>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</template>

<script setup>
import { computed, reactive } from 'vue'
import { buildGroupTree } from '../../maps/groupTree.js'

const props = defineProps({
    open: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
})

defineEmits(['select'])

const tree = computed(() => buildGroupTree(props.groups, props.pins))
const openIds = reactive(new Set())

function toggle(id) {
    if (openIds.has(id)) {
        openIds.delete(id)
    } else {
        openIds.add(id)
    }
}

function isOpen(id) {
    return openIds.has(id)
}
</script>
