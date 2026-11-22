<template>
    <div class="flex flex-col gap-1.5">
        <div class="flex items-center gap-2">
            <label
                class="relative inline-flex items-center justify-center w-9 h-9 rounded-lg border border-base-300 shadow-xs cursor-pointer overflow-hidden shrink-0 transition-transform hover:scale-105"
                :style="{ backgroundColor: modelValue || 'transparent' }"
                :title="modelValue || 'Choose colour'"
            >
                <input
                    type="color"
                    class="sr-only"
                    :value="modelValue || '#3b82f6'"
                    @input="$emit('update:modelValue', $event.target.value)"
                />
                <i
                    v-if="!modelValue"
                    class="fa-solid fa-palette text-xs opacity-50"
                    aria-hidden="true"
                ></i>
            </label>

            <span class="text-xs font-mono opacity-75 truncate flex-1">
                {{ modelValue || 'Default' }}
            </span>

            <button
                v-if="modelValue"
                type="button"
                class="btn2 btn-xs btn-ghost"
                title="Clear"
                @click="$emit('update:modelValue', null)"
            >
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="flex flex-wrap gap-1.5">
            <button
                v-for="preset in presets"
                :key="preset"
                type="button"
                class="w-4 h-4 rounded-full border border-black/10 cursor-pointer transition-transform hover:scale-125"
                :class="modelValue === preset ? 'ring-2 ring-primary ring-offset-1' : ''"
                :style="{ backgroundColor: preset }"
                :title="preset"
                @click="$emit('update:modelValue', preset)"
            ></button>
        </div>
    </div>
</template>

<script setup>
defineProps({
    modelValue: { type: String, default: null },
});

defineEmits(['update:modelValue']);

const presets = [
    '#3b82f6',
    '#8b5cf6',
    '#ec4899',
    '#ef4444',
    '#f59e0b',
    '#10b981',
    '#06b6d4',
    '#64748b',
];
</script>
