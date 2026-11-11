<template>
    <button
        type="button"
        class="search-trigger btn2 btn-outline flex-none min-w-0 text-neutral-content"
        data-shortcut="k"
        data-shortcut-action="click"
        @click="open"
        :title="keyboard_tooltip"
    >
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            <span class="search-trigger-text hidden md:inline">{{ placeholder }}</span>
        </div>
        <span class="" aria-hidden="true">K</span>
    </button>
</template>

<script>
import { useCommandCenter } from '../../composables/useCommandCenter.js';

export default {
    name: 'NavSearch',

    props: {
        placeholder: { type: String, default: 'Search…' },
        keyboard_tooltip: { type: String, default: '' },
    },

    setup() {
        const { open } = useCommandCenter();
        return { open };
    },
};
</script>
