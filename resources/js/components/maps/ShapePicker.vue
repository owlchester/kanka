<template>
    <div class="flex flex-col gap-2">
        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.shape }}</label>

        <input
            v-if="customMode"
            ref="customInputRef"
            v-model="customText"
            type="text"
            class="input input-bordered w-full"
            @keydown.tab="commitCustom"
            @keydown.enter="commitCustom"
            @blur="commitCustom"
            @paste="handleIconPaste"
        />

        <div v-else class="flex flex-wrap gap-1">
            <button
                v-for="shape in shapes"
                :key="shape.key"
                type="button"
                class="w-9 h-9 rounded-lg flex items-center justify-center cursor-pointer border-2"
                :class="isSelected(shape) ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="selectShape(shape)"
            >
                <i :class="shape.fa" aria-hidden="true" />
            </button>

            <button
                type="button"
                class="w-9 h-9 rounded-lg flex items-center justify-center cursor-pointer border-2"
                :class="pin.customIcon ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="clickCustom"
            >
                <i :class="pin.customIcon || 'fa-solid fa-ellipsis'" aria-hidden="true" />
            </button>
        </div>

        <p v-if="showPremiumError" class="text-sm text-error-content">{{ i18n.premium_custom_icon }}</p>
    </div>
</template>

<script setup>
import { nextTick, ref, watch } from "vue";
import { PIN_ICON_SHAPES } from "../../maps/markerIcons.js";

const props = defineProps({
    pin: { type: Object, required: true },
    boosted: { type: Boolean, default: false },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const shapes = PIN_ICON_SHAPES;

const customMode = ref(false);
const customText = ref("");
const showPremiumError = ref(false);
const customInputRef = ref(null);

watch(() => props.pin, (newPin, oldPin) => {
    if (newPin && !oldPin) {
        customMode.value = false;
        customText.value = "";
        showPremiumError.value = false;
    }
});

function isSelected(shape) {
    return !props.pin.customIcon && Number(props.pin.iconId) === shape.icon;
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

    nextTick(() => customInputRef.value?.focus());
}

function handleIconPaste(e) {
    const pasteData = (e.clipboardData || window.clipboardData).getData("text");

    if (!pasteData.startsWith('<i class="fa') && !pasteData.startsWith('<i class="ra')) {
        return;
    }

    const tempDiv = document.createElement("div");
    tempDiv.innerHTML = pasteData;
    const iconClass = tempDiv.querySelector("i")?.getAttribute("class");

    if (iconClass) {
        e.preventDefault();
        customText.value = iconClass;
    }
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
