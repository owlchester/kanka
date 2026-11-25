<template>
    <Teleport to="body">
        <dialog
            class="dialog command-center-dialog rounded-t-2xl md:rounded-2xl bg-base-100 text-base-content w-screen max-md:max-w-screen! max-md:max-h-[90dvh]! md:w-fit md:min-w-2xl overflow-hidden flex flex-col md:max-h-[85dvh]"
            ref="dialogRef"
            @cancel="close"
            :aria-label="search_text"
        >
            <MobilePanelHeader class="md:hidden" :title="search_text" :back-label="back_text" @back="close" />
            <div class="command-center-header px-5 pb-4 md:p-4">
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
            </div>
            <article class="min-h-0 overflow-y-auto">
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
                    :maintenance-message="maintenanceMessage"
                    ref="resultsRef"
                />
            </article>
            <footer class="hidden md:flex gap-4 p-4 text-xs text-base-content/50 items-center justify-between">
                <div class="flex gap-4 items-center">
                    <div class="flex gap-1 items-center">
                        <kbd class="w-8 inline-block text-center rounded bg-base-200">↑</kbd>
                        <kbd class="w-8 inline-block text-center rounded bg-base-200">↓</kbd>
                        <span>navigate</span>
                    </div>
                    <span><kbd class="w-8 inline-block text-center rounded bg-base-200">↵</kbd> open</span>
                    <span><kbd class="min-w-8 inline-block text-center rounded bg-base-200">{{ isMac ? '⌘' : 'Ctrl+' }}F</kbd> full text</span>
                </div>
                <span><kbd class="w-10 inline-block text-center rounded bg-base-200">Esc</kbd> close</span>
            </footer>
        </dialog>
    </Teleport>
</template>

<script>
import { useCommandCenter } from '../../composables/useCommandCenter.js';
import CommandInput from './CommandInput.vue';
import CommandResults from './CommandResults.vue';
import MobilePanelHeader from '../layout/MobilePanelHeader.vue';
import { applySearchAvailability } from './searchAvailability.js';

export default {
    name: 'CommandCenter',

    components: { CommandInput, CommandResults, MobilePanelHeader },

    props: {
        api_command: { type: String, required: true },
        api_recent: { type: String, required: true },
        placeholder: { type: String, default: 'Search…' },
        back_text: { type: String, default: 'Back' },
        search_text: { type: String, default: 'Search' },
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
            searchAvailability: { available: null, message: '' },
            abortController: null,
            requestIdentity: 0,
            recentRequestIdentity: 0,
            maintenanceVersion: 0,
            isOpenState: false,
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

    computed: {
        maintenanceMessage() {
            return this.mode === 'fulltext' && this.searchAvailability.available === false
                ? this.searchAvailability.message
                : '';
        },
    },

    watch: {
        isOpen(opened) {
            if (opened) {
                this.isOpenState = true;
                this.maintenanceVersion++;
                this.searchAvailability = { available: null, message: '' };
                this.$refs.dialogRef.showModal();
                setTimeout(() => this.$refs.inputRef?.focus(), 50);
                this.fetchRestData();
                this._fulltextKeyHandler = (e) => {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                        e.preventDefault();
                        this.$refs.inputRef?.toggleMode();
                    }
                };
                document.addEventListener('keydown', this._fulltextKeyHandler, true);
            } else {
                this.isOpenState = false;
                this.recentRequestIdentity++;
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
            const identity = ++this.recentRequestIdentity;
            const maintenanceVersion = this.maintenanceVersion;
            try {
                const response = await fetch(this.api_recent);
                if (!response.ok) return;
                const data = await response.json();
                if (identity !== this.recentRequestIdentity || !this.isOpenState) return;
                this.restData = {
                    recent: data.recent ?? [],
                    bookmarks: data.bookmarks ?? [],
                    indexes: data.indexes ?? [],
                    texts: data.texts ?? {},
                };
                if (maintenanceVersion === this.maintenanceVersion) {
                    this.searchAvailability = applySearchAvailability(
                        this.searchAvailability,
                        data.texts?.fulltext_search_available,
                        '',
                    );
                }
            } catch {
                // non-critical
            }
        },

        async onQueryChanged(q) {
            this.query = q;
            const requestMode = this.mode;
            const identity = ++this.requestIdentity;
            this.abortController?.abort();

            if (q.length < 2) {
                this.abortController = null;
                this.loading = false;
                this.entities = [];
                this.pages = [];
                this.results = [];
                return;
            }

            const controller = new AbortController();
            this.abortController = controller;
            this.loading = true;

            try {
                const url = `${this.api_command}?q=${encodeURIComponent(q)}&mode=${this.mode}`;
                const response = await fetch(url, { signal: controller.signal });
                if (!response.ok) throw new Error('Search request failed');
                const data = await response.json();

                if (identity !== this.requestIdentity || controller !== this.abortController || this.mode !== requestMode) return;
                if (requestMode === 'fulltext') {
                    if (typeof data.maintenance === 'boolean') {
                        this.maintenanceVersion++;
                        this.searchAvailability = applySearchAvailability(
                            this.searchAvailability,
                            !data.maintenance,
                            data.maintenance && typeof data.message === 'string' ? data.message : '',
                            this.restData.texts.fulltext_maintenance || '',
                        );
                    }
                    this.results = data.results ?? [];
                    this.pages = data.pages ?? [];
                } else {
                    this.entities = data.entities ?? [];
                    this.pages = data.pages ?? [];
                }
            } catch (e) {
                if (e.name !== 'AbortError' && identity === this.requestIdentity && controller === this.abortController && this.mode === requestMode) {
                    this.entities = [];
                    this.pages = [];
                    this.results = [];
                }
            } finally {
                if (identity === this.requestIdentity && controller === this.abortController) this.loading = false;
            }
        },

        onModeChanged(newMode) {
            this.requestIdentity++;
            this.abortController?.abort();
            this.mode = newMode;
            this.loading = false;
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
            this.requestIdentity++;
            this.abortController?.abort();
            this.maintenanceVersion++;
            this.searchAvailability = { available: null, message: '' };
            this.$refs.inputRef?.clear();
        },
    },
};
</script>
