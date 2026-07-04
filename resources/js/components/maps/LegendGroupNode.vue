<template>
    <li>
        <button
            class="flex items-center gap-2 w-full text-left cursor-pointer"
            @click="toggle(group.id)"
        >
            <span
                class="inline-block w-2.5 h-2.5 rounded-full flex-none"
                :class="!group.colour ? 'bg-neutral-content' : ''"
                :style="group.colour ? { backgroundColor: group.colour } : {}"
            />
            <span class="grow font-semibold">{{ group.name }}</span>
            <span class="text-xs text-neutral-content">{{ totalCount }}</span>
        </button>
        <ul v-if="isOpen(group.id)" class="pl-3 flex flex-col gap-1 pt-1.5">
            <li v-for="pin in group.pins" :key="pin.id">
                <button
                    class="flex items-center gap-2 text-left cursor-pointer"
                    @click="select(pin)"
                >
                    <span
                        class="inline-block w-2.5 h-2.5 rounded-full flex-none"
                        :class="!pin.colour ? 'bg-neutral-content' : ''"
                        :style="
                            pin.colour ? { backgroundColor: pin.colour } : {}
                        "
                    />
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
import { computed } from "vue";

const props = defineProps({
    group: { type: Object, required: true },
    isOpen: { type: Function, required: true },
    toggle: { type: Function, required: true },
    select: { type: Function, required: true },
});

function countPins(group) {
    return (
        group.pins.length +
        group.children.reduce((sum, child) => sum + countPins(child), 0)
    );
}

const totalCount = computed(() => countPins(props.group));
</script>
