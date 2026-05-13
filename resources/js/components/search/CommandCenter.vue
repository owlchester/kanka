<template>
    <Teleport to="body">
        <div v-if="isOpen" class="cmd-overlay" @click.self="close">
            <div class="cmd-dialog" role="dialog" aria-modal="true" aria-label="Command Center">
                <CommandInput
                    :placeholder="restData.texts.hint || placeholder"
                    :fulltext-label="restData.texts.fulltext || 'Full text'"
                    @query-changed="onQueryChanged"
                    @mode-changed="onModeChanged"
                    @navigate="navigate"
                    @submit="submit"
                    ref="inputRef"
                />
                <div class="cmd-divider"></div>
                <CommandResults
                    :mode="mode"
                    :query="query"
                    :loading="loading"
                    :recent="restData.recent"
                    :bookmarks="restData.bookmarks"
                    :indexes="restData.indexes"
                    :entities="entities"
                    :pages="pages"
                    :results="results"
                    :texts="restData.texts"
                    ref="resultsRef"
                />
                <div class="cmd-footer">
                    <span class="cmd-hint"><kbd>↑↓</kbd> navigate</span>
                    <span class="cmd-hint"><kbd>↵</kbd> open</span>
                    <span class="cmd-hint"><kbd>Ctrl+F</kbd> full text</span>
                    <span class="cmd-hint"><kbd>Esc</kbd> close</span>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script>
import { useCommandCenter } from '../../composables/useCommandCenter.js';
import CommandInput from './CommandInput.vue';
import CommandResults from './CommandResults.vue';

export default {
    name: 'CommandCenter',

    components: { CommandInput, CommandResults },

    props: {
        apiCommand: { type: String, required: true },
        apiRecent: { type: String, required: true },
        placeholder: { type: String, default: 'Search…' },
    },

    setup() {
        const { isOpen, close } = useCommandCenter();
        return { isOpen, close };
    },

    data() {
        return {
            query: '',
            mode: localStorage.getItem('kanka_search_mode') || 'name',
            loading: false,
            restData: { recent: [], bookmarks: [], indexes: [], texts: {} },
            entities: [],
            pages: [],
            results: [],
            abortController: null,
        };
    },

    watch: {
        isOpen(opened) {
            if (opened) {
                this.fetchRestData();
                document.addEventListener('keydown', this.onKeydown);
                document.body.style.overflow = 'hidden';
            } else {
                document.removeEventListener('keydown', this.onKeydown);
                document.body.style.overflow = '';
                this.reset();
            }
        },
    },

    methods: {
        async fetchRestData() {
            try {
                const response = await fetch(this.apiRecent);
                const data = await response.json();
                this.restData = {
                    recent: data.recent ?? [],
                    bookmarks: data.bookmarks ?? [],
                    indexes: data.indexes ?? [],
                    texts: data.texts ?? {},
                };
            } catch {
                // non-critical
            }
        },

        async onQueryChanged(q) {
            this.query = q;

            if (q.length < 2) {
                this.entities = [];
                this.pages = [];
                this.results = [];
                return;
            }

            if (this.abortController) {
                this.abortController.abort();
            }
            this.abortController = new AbortController();
            this.loading = true;

            try {
                const url = `${this.apiCommand}?q=${encodeURIComponent(q)}&mode=${this.mode}`;
                const response = await fetch(url, { signal: this.abortController.signal });
                const data = await response.json();

                if (this.mode === 'fulltext') {
                    this.results = data.results ?? [];
                } else {
                    this.entities = data.entities ?? [];
                    this.pages = data.pages ?? [];
                }
            } catch (e) {
                if (e.name !== 'AbortError') {
                    this.entities = [];
                    this.pages = [];
                    this.results = [];
                }
            } finally {
                this.loading = false;
            }
        },

        onModeChanged(newMode) {
            this.mode = newMode;
            this.entities = [];
            this.pages = [];
            this.results = [];
        },

        navigate(direction) {
            this.$refs.resultsRef?.navigate(direction);
        },

        submit() {
            this.$refs.resultsRef?.submit();
        },

        onKeydown(e) {
            if (e.key === 'Escape') {
                this.close();
            }
        },

        reset() {
            this.query = '';
            this.entities = [];
            this.pages = [];
            this.results = [];
            this.loading = false;
        },
    },
};
</script>
