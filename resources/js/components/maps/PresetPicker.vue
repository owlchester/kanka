<template>
    <div class="flex flex-col gap-2">
        <div class="flex items-center justify-between">
            <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.templates }}</label>
            <button
                v-if="canManage"
                type="button"
                class="text-xs text-neutral-content hover:text-base-content cursor-pointer"
                @click="manageMode = !manageMode"
            >
                {{ manageMode ? i18n.done : i18n.manage }}
            </button>
        </div>

        <div class="flex flex-wrap gap-1">
            <button
                v-for="preset in presets"
                :key="preset.id"
                type="button"
                class="flex items-center gap-2 px-2 py-1.5 rounded-xl text-left text-sm border border-base-300 hover:bg-base-200 cursor-pointer max-w-40"
                @click="handleClick(preset)"
            >
                <span
                    class="w-6 h-6 rounded flex items-center justify-center flex-none"
                    :style="{ backgroundColor: preset.config?.colour || '#ccc' }"
                >
                    <i :class="badgeIcon(preset)" class="text-white text-xs" aria-hidden="true" />
                </span>
                <span class="truncate">{{ preset.name }}</span>
                <i v-if="manageMode" class="fa-solid fa-pen text-xs text-neutral-content flex-none" aria-hidden="true" />
            </button>

            <button
                v-if="canManage && !manageMode"
                type="button"
                class="flex items-center gap-2 px-2 py-1.5 rounded-xl text-left text-sm border border-dashed border-base-300 text-neutral-content hover:bg-base-200 cursor-pointer"
                @click="$emit('save-current')"
            >
                <span class="w-6 h-6 rounded flex items-center justify-center flex-none">
                    <i class="fa-solid fa-plus text-xs" aria-hidden="true" />
                </span>
                <span>{{ i18n.save_current }}</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { pinIconFa, SHAPE_ICON_BY_ID } from "../../maps/markerIcons.js";

defineProps({
    presets: { type: Array, default: () => [] },
    i18n: { type: Object, required: true },
    canManage: { type: Boolean, default: false },
});

const emit = defineEmits(["select", "edit", "save-current"]);

const manageMode = ref(false);

function handleClick(preset) {
    emit(manageMode.value ? "edit" : "select", preset);
}

function badgeIcon(preset) {
    const shapeId = preset.config?.shape_id;

    if (shapeId && SHAPE_ICON_BY_ID[shapeId]) {
        return SHAPE_ICON_BY_ID[shapeId];
    }

    return pinIconFa(preset.config?.icon, preset.config?.custom_icon);
}
</script>
