<template>
    <div class="flex flex-col gap-2">
        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.opacity }}</label>

        <input
            v-if="customMode"
            v-model="customText"
            type="number"
            min="0"
            max="100"
            class="input input-bordered w-full"
            autofocus
            @keydown.tab="commitCustom"
            @keydown.enter="commitCustom"
            @blur="commitCustom"
        />

        <div v-else class="flex flex-wrap gap-1">
            <button
                v-for="preset in PRESETS"
                :key="preset"
                type="button"
                class="rounded-lg px-2 h-9 cursor-pointer border-2 text-xs"
                :class="pin.opacity === preset ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="selectPreset(preset)"
            >
                {{ preset }}%
            </button>

            <button
                type="button"
                class="rounded-lg px-2 h-9 cursor-pointer border-2 text-xs"
                :class="isCustom ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="clickCustom"
            >
                {{ isCustom ? `${pin.opacity}%` : i18n.custom }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

const props = defineProps({
    pin: { type: Object, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const PRESETS = [25, 50, 75, 100];

const customMode = ref(false);
const customText = ref(null);

const isCustom = computed(() => !PRESETS.includes(props.pin.opacity));

function selectPreset(value) {
    emit("change", value);
}

function clickCustom() {
    customText.value = props.pin.opacity ?? 100;
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
    const value = customText.value === null || Number.isNaN(parsed) ? 100 : Math.min(100, Math.max(0, parsed));

    emit("change", value);
}
</script>
