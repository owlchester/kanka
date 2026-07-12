<template>
    <aside
        v-if="open"
        class="fixed inset-0 bg-base-100 shadow-lg z-[1100] overflow-y-auto p-4 flex flex-col gap-3 md:top-20 md:left-4 md:right-auto md:bottom-24 md:w-72 md:rounded-2xl"
    >
        <div class="flex flex-col gap-2">
            <p class="flex items-center justify-between gap-2">
                <span>{{ i18n.legend_title }}</span>
                <span class="flex items-center gap-2">
                    <button
                        v-tippy="allOpen ? i18n.legend_collapse : i18n.legend_expand"
                        class="cursor-pointer"
                        @click="toggleAll"
                    >
                        <i class="fa-regular fa-sort" aria-hidden="true" />
                    </button>
                    <button
                        class="btn2 btn-default btn-sm flex-none"
                        @click="$emit('close')"
                    >
                        <i class="fa-solid fa-xmark" aria-hidden="true" />
                    </button>
                </span>
            </p>
            <input
                v-model="query"
                type="text"
                :placeholder="i18n.legend_search"
                class="input input-bordered w-full"
            />
        </div>

        <ul class="flex flex-col gap-1">
            <LegendGroupNode
                v-for="group in filtered.groups"
                :key="group.id"
                :group="group"
                :is-open="isOpen"
                :toggle="toggle"
                :select="selectPin"
            />

            <li v-if="filtered.uncategorised.length">
                <p class="flex items-center justify-between">
                    <span class="font-semibold">{{ i18n.ungrouped }}</span>
                    <span class="text-xs text-neutral-content">{{
                        filtered.uncategorised.length
                    }}</span>
                </p>
                <ul class="pl-3 flex flex-col gap-1 pt-1.5">
                    <li v-for="pin in filtered.uncategorised" :key="pin.id">
                        <button
                            class="flex items-center gap-2 text-left cursor-pointer"
                            @click="selectPin(pin)"
                        >
                            <span
                                class="inline-block w-2.5 h-2.5 rounded-full flex-none"
                                :class="!pin.colour ? 'bg-neutral-content' : ''"
                                :style="
                                    pin.colour
                                        ? { backgroundColor: pin.colour }
                                        : {}
                                "
                            />
                            <span>{{ pin.name }}</span>
                        </button>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { buildGroupTree, filterGroupTree } from "../../maps/groupTree.js";
import LegendGroupNode from "./LegendGroupNode.vue";

const props = defineProps({
    open: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["select", "close"]);

const query = ref("");
const tree = computed(() => buildGroupTree(props.groups, props.pins));
const filtered = computed(() => filterGroupTree(tree.value, query.value));
const openIds = reactive(new Set());

onMounted(() => {
    props.groups.forEach((group) => openIds.add(group.id));
});

function toggle(id) {
    if (openIds.has(id)) {
        openIds.delete(id);
    } else {
        openIds.add(id);
    }
}

function isOpen(id) {
    if (query.value && filtered.value.matchedGroupIds.has(id)) {
        return true;
    }

    return openIds.has(id);
}

const allOpen = computed(() =>
    props.groups.every((group) => openIds.has(group.id)),
);

function toggleAll() {
    if (allOpen.value) {
        openIds.clear();
    } else {
        props.groups.forEach((group) => openIds.add(group.id));
    }
}

function selectPin(pin) {
    emit("select", pin);
}
</script>
