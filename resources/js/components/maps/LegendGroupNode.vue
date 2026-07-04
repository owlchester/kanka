<template>
    <li>
        <button class="flex items-center gap-2 w-full text-left font-semibold" @click="toggle(group.id)">
            <i :class="isOpen(group.id) ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-right'" aria-hidden="true" />
            <span>{{ group.name }}</span>
        </button>
        <ul v-if="isOpen(group.id)" class="pl-5 flex flex-col gap-1">
            <li v-for="pin in group.pins" :key="pin.id">
                <button class="text-left" @click="select(pin)">{{ pin.name }}</button>
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
defineProps({
    group: { type: Object, required: true },
    isOpen: { type: Function, required: true },
    toggle: { type: Function, required: true },
    select: { type: Function, required: true },
})
</script>
