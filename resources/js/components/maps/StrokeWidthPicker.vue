<template>
    <div class="flex flex-col gap-2">
        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.stroke_width }}</label>

        <input
            v-if="customMode"
            v-model="customText"
            type="number"
            min="1"
            max="20"
            class="input input-bordered w-full"
            autofocus
            @keydown.tab="commitCustom"
            @keydown.enter="commitCustom"
            @blur="commitCustom"
        />

        <div v-else class="flex flex-wrap gap-1">
            <button
                v-for="preset in presets"
                :key="preset.value"
                type="button"
                class="rounded-lg px-2 h-9 cursor-pointer border-2 text-xs"
                :class="width === preset.value ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="selectPreset(preset.value)"
            >
                {{ preset.label }}
            </button>

            <button
                type="button"
                class="rounded-lg px-2 h-9 cursor-pointer border-2 text-xs"
                :class="isCustom ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="clickCustom"
            >
                {{ isCustom ? `${width}px` : i18n.custom }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

const props = defineProps({
    width: { type: Number, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const PRESET_VALUES = [1, 3, 6];

const presets = computed(() => [
    { value: 1, label: props.i18n.stroke_thin },
    { value: 3, label: props.i18n.stroke_normal },
    { value: 6, label: props.i18n.stroke_bold },
]);

const customMode = ref(false);
const customText = ref(null);

const isCustom = computed(() => !PRESET_VALUES.includes(props.width));

function selectPreset(value) {
    emit("change", value);
}

function clickCustom() {
    customText.value = props.width ?? 1;
    customMode.value = true;
}

function commitCustom() {
    if (!customMode.value) {
        return;
    }

    customMode.value = false;

    // <input type="number"> auto-casts v-model to a Number (or null when empty), not a string,
    // so this must not assume a string value (e.g. calling .trim()) like a text input would allow.
    const parsed = Math.round(Number(customText.value));
    const value = customText.value === null || Number.isNaN(parsed) ? 1 : Math.min(20, Math.max(1, parsed));

    emit("change", value);
}
</script>
