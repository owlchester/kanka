<template>
    <div class="flex flex-col gap-2">
        <label class="text-xs font-semibold uppercase tracking-wide opacity-75">{{ i18n.group }}</label>

        <div class="flex flex-wrap gap-1">
            <button
                type="button"
                class="flex items-center gap-1.5 rounded-full px-2.5 py-1 cursor-pointer border-2"
                :class="pin.groupId === null ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="selectGroup(null)"
            >
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-neutral-content flex-none" aria-hidden="true" />
                <span>{{ i18n.none }}</span>
            </button>

            <button
                v-for="group in sortedGroups"
                :key="group.id"
                type="button"
                class="flex items-center gap-1.5 rounded-full px-2.5 py-1 cursor-pointer border-2"
                :class="pin.groupId === group.id ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="selectGroup(group.id)"
            >
                <span
                    class="inline-block w-2.5 h-2.5 rounded-full flex-none"
                    :class="!group.colour ? 'bg-neutral-content' : ''"
                    :style="group.colour ? { backgroundColor: group.colour } : {}"
                    aria-hidden="true"
                />
                <span>{{ group.name }}</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    pin: { type: Object, required: true },
    groups: { type: Array, default: () => [] },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const sortedGroups = computed(() => [...props.groups].sort((a, b) => b.position - a.position));

function selectGroup(groupId) {
    emit("change", groupId);
}
</script>
