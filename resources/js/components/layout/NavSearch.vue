<template>
    <button
        type="button"
        class="search-trigger group btn2 btn-outline flex-none h-9.5 min-h-9.5! px-3! text-neutral-content"
        data-shortcut="k"
        data-shortcut-action="click"
        data-tooltip
        :data-title="keyboard_tooltip"
        data-html="true"
        :aria-label="placeholder"
        @click="open"
    >
        <i class="fa-solid fa-magnifying-glass flex-none" aria-hidden="true"></i>
        <span class="search-trigger-text hidden md:inline">{{ placeholder }}</span>
        <span class="hidden md:inline-flex items-center justify-center rounded bg-base-200 group-hover:bg-base-300 px-1.5 py-0.5 text-xs font-mono leading-none text-base-content/70 transition-colors" aria-hidden="true">K</span>
    </button>
</template>

<script>
import { onBeforeUnmount, onMounted } from 'vue';
import { useCommandCenter } from '../../composables/useCommandCenter.js';

export default {
    name: 'NavSearch',

    props: {
        placeholder: { type: String, default: 'Search' },
        keyboard_tooltip: { type: String, default: '' },
    },

    setup() {
        const { open } = useCommandCenter();

        onMounted(() => {
            window.addEventListener('command-center:open', open);
        });

        onBeforeUnmount(() => {
            window.removeEventListener('command-center:open', open);
        });

        return { open };
    },
};
</script>
