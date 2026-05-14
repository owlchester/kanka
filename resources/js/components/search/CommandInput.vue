<template>
    <div class="flex gap-2 items-center justify-between">
        <div class="flex gap-1 items-center w-full">
            <span class="cmd-icon flex-0" aria-hidden="true">
                <i class="fa-regular fa-magnifying-glass"></i>
            </span>
            <input
                ref="inputRef"
                type="text"
                class="cmd-input focus-none! border-0! border-base-100 grow"
                :placeholder="placeholder"
                v-model="query"
                @input="onInput"
                @keydown.up.prevent="$emit('navigate', -1)"
                @keydown.down.prevent="$emit('navigate', 1)"
                @keydown.enter.prevent="$emit('submit')"
                autocomplete="off"
                spellcheck="false"
            />
        </div>
        <div class="flex rounded-lg bg-base-200 p-0.5 text-xs gap-0.5 shrink-0">
            <button
                type="button"
                class="rounded px-2 py-1 transition-colors cursor-pointer flex gap-1 items-center"
                :class="mode === 'name' ? 'bg-base-100' : 'bg-transparent text-neutral-content'"
                @click="setMode('name')"
            >
                <i class="fa-regular fa-magnifying-glass" aria-hidden="true"></i>
                {{ entitiesLabel }}
            </button>
            <button
                type="button"
                class="rounded px-2 py-1 transition-colors cursor-pointer flex gap-1 items-center"
                :class="mode === 'fulltext' ? 'bg-base-100' : 'bg-transparent text-neutral-content'"
                @click="setMode('fulltext')"
            >
                <i class="fa-regular fa-plus" aria-hidden="true"></i>
                 {{ everywhereLabel }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CommandInput',

    props: {
        placeholder: { type: String, default: 'Search…' },
        entitiesLabel: { type: String, default: 'Entities' },
        everywhereLabel: { type: String, default: 'Yoyo' },
    },

    emits: ['query-changed', 'mode-changed', 'navigate', 'submit'],

    data() {
        return {
            query: '',
            mode: localStorage.getItem('kanka_search_mode') || 'name',
            debounceTimer: null,
        };
    },

    mounted() {
        this.$nextTick(() => this.$refs.inputRef?.focus());
    },

    methods: {
        onInput() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.$emit('query-changed', this.query);
            }, 350);
        },

        setMode(newMode) {
            if (this.mode === newMode) {
                return;
            }
            this.mode = newMode;
            localStorage.setItem('kanka_search_mode', this.mode);
            this.$emit('mode-changed', this.mode);
            if (this.query.length >= 2) {
                this.$emit('query-changed', this.query);
            }
        },

        toggleMode() {
            this.setMode(this.mode === 'name' ? 'fulltext' : 'name');
        },

        clear() {
            this.query = '';
            this.$emit('query-changed', '');
        },
    },
};
</script>
