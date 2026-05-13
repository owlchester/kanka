<template>
    <div class="cmd-input-row">
        <span class="cmd-icon" aria-hidden="true">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input
            ref="inputRef"
            type="text"
            class="cmd-input"
            :placeholder="placeholder"
            v-model="query"
            @input="onInput"
            @keydown.up.prevent="$emit('navigate', -1)"
            @keydown.down.prevent="$emit('navigate', 1)"
            @keydown.enter.prevent="$emit('submit')"
            @keydown.ctrl.f.prevent="toggleMode"
            autocomplete="off"
            spellcheck="false"
        />
        <button
            type="button"
            class="cmd-mode-toggle"
            :class="{ active: mode === 'fulltext' }"
            @click="toggleMode"
            :title="mode === 'fulltext' ? 'Switch to name search' : 'Switch to full-text search (Ctrl+F)'"
        >
            {{ fulltextLabel }}
        </button>
    </div>
</template>

<script>
export default {
    name: 'CommandInput',

    props: {
        placeholder: { type: String, default: 'Search…' },
        fulltextLabel: { type: String, default: 'Full text' },
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

        toggleMode() {
            this.mode = this.mode === 'name' ? 'fulltext' : 'name';
            localStorage.setItem('kanka_search_mode', this.mode);
            this.$emit('mode-changed', this.mode);
            if (this.query.length >= 2) {
                this.$emit('query-changed', this.query);
            }
        },

        clear() {
            this.query = '';
            this.$emit('query-changed', '');
        },
    },
};
</script>
