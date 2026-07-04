<template>
    <div class="flex flex-col gap-2">
        <input
            v-if="customMode"
            v-model="customText"
            type="text"
            class="input input-bordered w-full"
            autofocus
            @keydown.tab="commitCustom"
            @blur="commitCustom"
        />

        <div v-else class="flex flex-wrap gap-1">
            <button
                v-for="shape in shapes"
                :key="shape.key"
                type="button"
                class="w-9 h-9 rounded-lg flex items-center justify-center cursor-pointer"
                :class="isSelected(shape) ? 'bg-accent text-accent-content' : 'bg-base-200'"
                @click="selectShape(shape)"
            >
                <i :class="shape.fa" aria-hidden="true" />
            </button>

            <button
                type="button"
                class="w-9 h-9 rounded-lg flex items-center justify-center cursor-pointer"
                :class="pin.customIcon ? 'bg-accent text-accent-content' : 'bg-base-200'"
                @click="clickCustom"
            >
                <i :class="pin.customIcon || 'fa-solid fa-ellipsis'" aria-hidden="true" />
            </button>
        </div>

        <p v-if="showPremiumError" class="text-sm text-error-content">{{ i18n.premium_custom_icon }}</p>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    pin: { type: Object, required: true },
    boosted: { type: Boolean, default: false },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const shapes = [
    { key: "pin", icon: 1, fa: "fa-solid fa-map-pin" },
    { key: "question", icon: 2, fa: "fa-solid fa-question" },
    { key: "exclamation", icon: 3, fa: "fa-solid fa-exclamation" },
    { key: "square", icon: 6, fa: "fa-solid fa-square" },
    { key: "circle", icon: 7, fa: "fa-solid fa-circle" },
    { key: "diamond", icon: 8, fa: "fa-solid fa-diamond" },
    { key: "triangle", icon: 9, fa: "fa-solid fa-caret-up" },
];

const customMode = ref(false);
const customText = ref("");
const showPremiumError = ref(false);

watch(() => props.pin, (newPin, oldPin) => {
    if (newPin && !oldPin) {
        customMode.value = false;
        customText.value = "";
        showPremiumError.value = false;
    }
});

function isSelected(shape) {
    return !props.pin.customIcon && props.pin.iconId === shape.icon;
}

function selectShape(shape) {
    showPremiumError.value = false;
    emit("change", { icon: shape.icon, custom_icon: null, render: { type: "fa", value: shape.fa } });
}

function clickCustom() {
    if (!props.boosted) {
        showPremiumError.value = true;

        return;
    }

    showPremiumError.value = false;
    customText.value = props.pin.customIcon || "";
    customMode.value = true;
}

function commitCustom() {
    if (!customMode.value) {
        return;
    }

    const value = customText.value.trim();
    customMode.value = false;

    if (!value) {
        return;
    }

    emit("change", { icon: 1, custom_icon: value, render: { type: "fa", value } });
}
</script>
