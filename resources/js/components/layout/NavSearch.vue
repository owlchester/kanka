<template>
    <div v-click-outside="onClickOutside" class="flex grow mr-2">
        <div class="relative grow">
            <input type="text" class="form-control leading-4 w-20 md:w-full" maxlength="25"
                ref="searchField"
                id="entity-lookup"
                v-model="term"
                v-on:click="focus()"
                @focus="focus()"
                @keydown.esc="escape()"
                :placeholder="placeholder"
            />
            <span class="form-control-feedback hidden-xs hidden-sm">
                <span class="flex-none keyboard-shortcut py-1" id="lookup-kb-shortcut" data-toggle="tooltip" v-bind:title="keyboard_tooltip" data-html="true" data-placement="bottom" >K</span>
            </span>
        </div>

        <aside class="search-drawer absolute top-0 left-0 mt-12 h-sidebar w-sidebar bg-navbar bg-base-100 shadow-r overflow-y-auto  " v-if="show_recent || show_loading || show_preview">
            <div class="text-center" v-if="show_loading">
                <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" aria-label="Loading"></i>
            </div>
            <div class="search-recent bg-lookup p-2 min-h-full shadow-r flex flex-col items-stretch" v-if="show_recent">
                <div class="flex-none" v-if="!show_results">
                    <p class="italic text-xs text-center">
                        {{ texts.hint}}
                    </p>
                </div>
                <div class="grow">
                    <div class="search-results mb-2" v-if="show_results">
                        <div class="text-sm uppercase mb-2 my-2 mx-1">{{ texts.results }}</div>

                        <div class="italic m-2" v-if="results.length === 0">
                            {{ texts.empty_results }}
                        </div>
                        <LookupEntity v-else v-for="entity in results"
                                      :entity="entity"
                        >
                        </LookupEntity>
                    </div>

                    <div class="recent-searches" v-if="recent.length > 0">
                        <div class="text-sm uppercase my-2 mx-1">{{ texts.recents }}</div>

                        <LookupEntity v-for="entity in recent"
                                      :entity="entity"
                        >
                        </LookupEntity>
                    </div>
                </div>

                <div class="flex-none text-xs text-center" v-if="!show_loading">
                    <hr />
                    <p class="italic text-xs text-center" v-html="texts.keyboard" />
                </div>
            </div>
            <div class="search-preview bg-lookup min-h-full shadow-r" v-if="show_preview">
                <EntityPreview
                    :entity="preview_entity">
                </EntityPreview>
            </div>
        </aside>
    </div>

</template>

<script>
import LookupEntity from "./Lookup/LookupEntity.vue";
import EntityPreview from "./Lookup/EntityPreview.vue";
import vClickOutside from "click-outside-vue3";
export default {
    directives: {
        clickOutside: vClickOutside.directive
    },
    /* Properties provided by the html component initialisation */
    props: {
        /* API used for making searches */
        api_lookup: String,
        /* API used to load recently viewed entities from the user */
        api_recent: String,
        /* Placeholder text for the search field */
        placeholder: String,
        /** Tooltip for the keyboard shortcut **/
        keyboard_tooltip: String,
    },
    components: {
        LookupEntity,
        EntityPreview
    },
    data() {
        return {
            has_drawer: false,
            term: null,
            show_loading: false,
            show_recent: false,
            show_preview: false,
            show_results: false,
            recent: [],
            results: [],
            cached: {},
            has_recent: false,
            texts: {},
            timeout_id: null,
            preview_entity: null,
        }
    },
    watch: {
        term(after, before) {
            this.termChanged();
        }
    },
    methods: {
        termChanged() {
            let lookup = this.term.trim();
            if (lookup.length < 3) {
                return;
            }

            // Cancel previous timeout if it's set
            if (this.timeout_id !== undefined) {
                clearTimeout(this.timeout_id);
            }
            // Start a timer to get data from the db
            this.show_loading = true;
            this.timeout_id = setTimeout(() => this.lookup(), 500);
        },
        lookup() {
            let term = this.term.trim();

            let cacheKey = term.toLowerCase ().replace (/ /g,'-').replace (/ [^\w-]+/g,'');
            if (this.cached[cacheKey]) {
                return this.displayCached(cacheKey);
            }

            axios.get(this.api_lookup, {params: {q: term, v2: true}}).then(response => {
                this.parseLookupResponse(response, cacheKey);
            });
        },
        focus() {
            // Unlogged in users don't get a recent list pop out when focusing on the search field
            if (!this.api_recent) {
                //console.log('no recent');
                return;
            }
            this.show_preview = false;
            this.has_drawer = true;
            this.fetch();
        },
        // User pressed ESC while focused on the search field
        escape() {
            if (this.timeout_id !== undefined) {
                clearTimeout(this.timeout_id);
            }
            this.close();
        },
        // Get the recent searches from the user
        fetch() {
            if (this.has_recent) {
                this.show_recent = true;
                return;
            }

            this.show_loading = true;
            axios.get(this.api_recent).then(response => {
                this.recent = response.data.recent;
                this.texts.recents = response.data.texts.recents;
                this.texts.results = response.data.texts.results;
                this.texts.hint = response.data.texts.hint;
                this.texts.keyboard = response.data.texts.keyboard;
                this.texts.empty_results = response.data.texts.empty_results;
                this.show_loading = false;
                this.show_recent = true;
                this.has_recent = true;
            }).catch(error => {
                // Probably unlogged user
                this.show_loading = false;
                this.show_recent = true;
                this.has_recent = false;
            });
        },
        // Load results from a search
        parseLookupResponse(response, cacheKey) {
            this.results = response.data.entities;
            this.cached[cacheKey] = response.data.entities;
            this.showResults();
        },
        displayCached(key) {
            this.results = this.cached[key];
            this.showResults();
        },
        showResults() {
            this.timeout_id = null;
            this.show_preview = false;
            this.show_loading = false;
            this.show_results = true;
        },
        // Preview an entity
        loadPreview(entity) {
            this.show_loading = true;
            axios.get(entity.preview).then(response => {
                this.parsePreviewResponse(response);
            });
        },
        parsePreviewResponse(response) {
            this.preview_entity = response.data;
            //console.log('preview_entity', this.preview_entity);
            this.show_loading = false;
            this.show_preview = true;
            this.show_recent = false;
        },
        // When clicking outside of the area, close the search pannel
        onClickOutside (event) {
            //console.log('Clicked outside. Event: ', event)
            this.close();
        },
        close() {
            this.show_recent = false;
            this.show_loading = false;
            this.show_preview = false;
            this.$refs.searchField.blur();
        }
    },
    mounted() {
        this.emitter.on('preview', (entity) => {
            this.loadPreview(entity);
        });
    }
};
</script>
