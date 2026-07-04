<template>
    <div class="flex flex-col gap-2">
        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.colour }}</label>

        <div class="flex flex-wrap gap-1.5">
            <button
                v-for="swatch in swatches"
                :key="swatch"
                type="button"
                class="w-7 h-7 rounded-lg cursor-pointer border-2"
                :style="swatchStyle(swatch)"
                @click="selectColour(swatch)"
            />

            <div class="marker-colour-trigger">
                <button type="button" class="w-7 h-7 rounded-lg cursor-pointer border-base-200 border-2 flex items-center justify-center text-base-content bg-base-200" @click="openPicker">
                    <i class="fa-solid fa-palette" aria-hidden="true" />
                </button>

                <input ref="colorisInput" type="text" class="marker-colour-input" tabindex="-1" aria-hidden="true" />
            </div>
        </div>
    </div>
</template>

<style>
.marker-colour-trigger {
    position: relative;
    width: 2.25rem;
    height: 2.25rem;
}

.marker-colour-trigger .clr-field {
    position: absolute;
    inset: 0;
    display: block;
    opacity: 0;
    pointer-events: none;
}

.marker-colour-trigger .clr-field button {
    display: none;
}

.clr-picker {
    z-index: 1200 !important;
}
</style>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch } from "vue";
import Coloris from "@melloware/coloris";
import "@melloware/coloris/dist/coloris.css";

const props = defineProps({
    pin: { type: Object, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const RECENT_COLORS_KEY = "recent_colors";
const MAX_RECENTS = 10;
const TARGET_SWATCH_COUNT = 9;
const SUGGESTED_COLOURS = [
    "#93c5fd",
    "#f87171",
    "#fb923c",
    "#facc15",
    "#4ade80",
    "#2dd4bf",
    "#a78bfa",
    "#f472b6",
    "#94a3b8",
];

function loadRecents() {
    try {
        const raw = localStorage.getItem(RECENT_COLORS_KEY);

        return raw ? JSON.parse(raw) : [];
    } catch (e) {
        return [];
    }
}

const recentColours = ref(loadRecents());
const colorisInput = ref(null);

const swatches = computed(() => {
    const seen = new Set(recentColours.value.map((c) => c.toLowerCase()));
    const result = [...recentColours.value];

    for (const colour of SUGGESTED_COLOURS) {
        if (result.length >= TARGET_SWATCH_COUNT) {
            break;
        }
        if (seen.has(colour.toLowerCase())) {
            continue;
        }
        result.push(colour);
        seen.add(colour.toLowerCase());
    }

    return result;
});

function isSelected(swatch) {
    return props.pin.colour?.toLowerCase() === swatch.toLowerCase();
}

function swatchStyle(swatch) {
    const selected = isSelected(swatch);

    return {
        backgroundColor: swatch,
        borderColor: selected ? "var(--color-base-content)" : swatch,
        outline: selected ? `2px solid ${swatch}` : "none",
        outlineOffset: 0,
    };
}

function addToRecents(hex) {
    const recents = recentColours.value.filter((c) => c.toLowerCase() !== hex.toLowerCase());
    recents.unshift(hex);
    recentColours.value = recents.slice(0, MAX_RECENTS);
    localStorage.setItem(RECENT_COLORS_KEY, JSON.stringify(recentColours.value));
}

function selectColour(hex) {
    addToRecents(hex);
    emit("change", hex);
}

function openPicker() {
    colorisInput.value.click();
}

function onColorisInput(event) {
    emit("change", event.target.value);
}

function onColorisCommit(event) {
    addToRecents(event.target.value);
}

onMounted(() => {
    Coloris({
        el: ".marker-colour-input",
        theme: "pill",
        alpha: false,
        format: "hex",
        swatches: [],
    });

    colorisInput.value.value = props.pin.colour || "";
    colorisInput.value.addEventListener("input", onColorisInput);
    colorisInput.value.addEventListener("change", onColorisCommit);
});

watch(() => props.pin.colour, (colour) => {
    if (colorisInput.value) {
        colorisInput.value.value = colour || "";
    }
});

onBeforeUnmount(() => {
    colorisInput.value?.removeEventListener("input", onColorisInput);
    colorisInput.value?.removeEventListener("change", onColorisCommit);
});
</script>
