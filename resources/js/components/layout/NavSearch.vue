<template>
    <button
        type="button"
        class="search-trigger btn2 btn-outline flex-none w-11 min-w-11! h-11 min-h-11! p-1! md:w-36 md:min-w-0! md:h-9.5 md:min-h-9.5! md:px-3! text-neutral-content"
        data-shortcut="k"
        data-shortcut-action="click"
        @click="open"
        :title="keyboard_tooltip"
    >
        <div class="flex items-center justify-center md:justify-start gap-2">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            <span class="search-trigger-text hidden md:inline">{{ placeholder }}</span>
        </div>
        <span class="hidden md:inline" aria-hidden="true">K</span>
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
