<template>
    <Teleport to="body">
        <dialog
            class="dialog rounded-2xl bg-base-100 text-base-content w-full md:w-fit md:min-w-2xl overflow-hidden"
            ref="dialogRef"
            @cancel="close"
            aria-label="Command Center"
        >
            <header class="p-4">
                <CommandInput
                    :placeholder="mode === 'fulltext' ? restData.texts.hint_fulltext : restData.texts.hint_entries || placeholder"
                    :entities-label="restData.texts.entities || 'Entries'"
                    :everywhere-label="restData.texts.everywhere || 'Everywhere'"
                    @query-changed="onQueryChanged"
                    @mode-changed="onModeChanged"
                    @navigate="navigate"
                    @submit="submit"
                    ref="inputRef"
                />
            </header>
            <article class="flex-1 min-h-0">
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
            </article>
            <footer class="flex gap-4 p-4 text-xs text-base-content/50 items-center justify-between">
                <div class="flex gap-4 items-center">
                    <span><kbd>↑↓</kbd> navigate</span>
                    <span><kbd>↵</kbd> open</span>
                    <span><kbd>{{ isMac ? '⌘' : 'Ctrl+' }}F</kbd> full text</span>
                </div>
                <span><kbd>Esc</kbd> close</span>
            </footer>
        </dialog>
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
        api_command: { type: String, required: true },
        api_recent: { type: String, required: true },
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
            isMac: /Mac/i.test(navigator.userAgent),
            _fulltextKeyHandler: null,
        };
    },

    mounted() {
        let backdropMousedown = false;
        this.$refs.dialogRef.addEventListener('mousedown', (event) => {
            backdropMousedown = event.target === this.$refs.dialogRef;
        });
        this.$refs.dialogRef.addEventListener('click', (event) => {
            if (backdropMousedown && event.target === this.$refs.dialogRef) {
                this.close();
            }
        });
    },

    watch: {
        isOpen(opened) {
            if (opened) {
                this.$refs.dialogRef.showModal();
                this.fetchRestData();
                this._fulltextKeyHandler = (e) => {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                        e.preventDefault();
                        this.$refs.inputRef?.toggleMode();
                    }
                };
                document.addEventListener('keydown', this._fulltextKeyHandler, true);
            } else {
                this.$refs.dialogRef.close();
                this.reset();
                if (this._fulltextKeyHandler) {
                    document.removeEventListener('keydown', this._fulltextKeyHandler, true);
                    this._fulltextKeyHandler = null;
                }
            }
        },
    },

    methods: {
        async fetchRestData() {
            try {
                const response = await fetch(this.api_recent);
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
                const url = `${this.api_command}?q=${encodeURIComponent(q)}&mode=${this.mode}`;
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
