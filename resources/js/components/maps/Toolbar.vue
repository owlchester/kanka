<template>
    <div
        v-if="canEdit"
        class="fixed bottom-4 left-1/2 -translate-x-1/2 z-[1100] flex flex-col items-center gap-2"
    >
        <div
            v-if="props.activeMode"
            class="bg-accent opacity-60 text-accent-content rounded-full px-3 py-1.5 text-xs whitespace-nowrap"
        >
            {{ helperText }}
        </div>

        <div
            class="bg-base-100 rounded-2xl shadow-lg flex items-center gap-1 px-2 py-2"
        >
            <button
                type="button"
                class="flex items-center gap-2 rounded-full px-3 py-1.5 cursor-pointer"
                :class="rapid ? 'bg-accent text-accent-content' : ''"
                @click="rapid = !rapid"
            >
                <span
                    class="inline-block w-2 h-2 rounded-full bg-current"
                    aria-hidden="true"
                />
                <span>{{ i18n.toolbar.rapid }}</span>
            </button>

            <div
                class="w-px self-stretch bg-base-content/20 mx-1"
                aria-hidden="true"
            />

            <button
                v-for="mode in modes"
                :key="mode.key"
                type="button"
                class="flex flex-col items-center gap-1 rounded-xl px-3 py-1.5 cursor-pointer"
                :class="
                    props.activeMode === mode.key
                        ? 'bg-accent text-accent-content'
                        : ''
                "
                @click="selectMode(mode.key)"
            >
                <i :class="mode.icon" aria-hidden="true" />
                <span class="text-xs">{{ mode.label }}</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

const props = defineProps({
    i18n: { type: Object, required: true },
    canEdit: { type: Boolean, default: false },
    activeMode: { type: String, default: null },
});

const emit = defineEmits(["mode-change"]);

const rapid = ref(false);

const modes = computed(() => [
    {
        key: "pin",
        icon: "fa-regular fa-location-dot",
        label: props.i18n.toolbar.pin,
    },
    { key: "text", icon: "fa-regular fa-font", label: props.i18n.toolbar.text },
    {
        key: "area",
        icon: "fa-regular fa-draw-polygon",
        label: props.i18n.toolbar.area,
    },
    {
        key: "circle",
        icon: "fa-regular fa-circle",
        label: props.i18n.toolbar.circle,
    },
    {
        key: "path",
        icon: "fa-regular fa-route",
        label: props.i18n.toolbar.path,
    },
]);

const helperText = computed(() => {
    if (!props.activeMode) {
        return "";
    }

    return props.i18n.toolbar.helper[props.activeMode];
});

function selectMode(key) {
    emit("mode-change", props.activeMode === key ? null : key);
}
</script>
