<template>
    <div v-click-outside="onClickOutside" class="flex grow mr-2">
        <div class="relative grow field flex items-center">
            <input type="text" class="leading-4 w-20 md:w-full" maxlength="25"
                ref="searchField"
                id="entity-lookup"
                v-model="term"
                v-on:click="focus()"
                @focus="focus()"
                @keydown.esc="escape()"
                :placeholder="placeholder"
            />
            <span class="absolute right-1  hidden md:inline">
                <span class="flex-none keyboard-shortcut py-1" id="lookup-kb-shortcut" data-toggle="tooltip" v-bind:data-title="keyboard_tooltip" data-html="true" data-placement="bottom">
                    K
                </span>
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
                <div class="grow flex flex-col gap-5 p-2">
                    <div class="search-results flex flex-col gap-2" v-if="show_results">
                        <div class="text-sm uppercase">{{ texts.results }}</div>

                        <div class="text-neutral-content text-sm" v-if="results.length === 0">
                            {{ texts.empty_results }}
                        </div>
                        <LookupEntity
                            v-else v-for="entity in results"
                            :entity="entity"
                            @preview="loadPreview"
                        >
                        </LookupEntity>
                        <a class="grow text-sm uppercase hover:underline" v-bind:href="searchFullTextUrl()">
                            {{ texts.fulltext }}
                        </a>

                    </div>
                    <div class="recent-searches flex flex-col gap-2" v-if="recent.length > 0">
                        <div class="text-sm uppercase ">{{ texts.recents }}</div>

                        <LookupEntity
                            v-for="entity in recent"
                            :entity="entity"
                            @preview="loadPreview"
                        >
                        </LookupEntity>
                    </div>

                    <div class="flex gap-5 justify-center" v-if="bookmarks.length > 0">
                        <button class="grow text-sm uppercase hover:underline"
                                v-bind:class="this.modeClass(true)"
                                v-if="bookmarks.length > 0"
                                @click="showBookmarks()">{{ texts.bookmarks }}
                        </button>
                        <button class="grow text-sm uppercase hover:underline"
                                v-bind:class="this.modeClass(false)"
                                @click="showIndexes()">
                            {{ texts.index }}
                        </button>
                    </div>

                    <div class="flex flex-col gap-4" v-if="show_bookmarks">
                        <a
                            v-for="bookmark in bookmarks"
                            v-bind:href="bookmark.url"
                            v-on:click.stop
                            :title="bookmark.text"
                            class="flex gap-2 items-center ">
                            <i class="w-4" v-bind:class="bookmark.icon" aria-hidden="true"></i>
                            <span v-html="bookmark.text"></span>
                        </a>
                    </div>
                    <div class="flex flex-col gap-4" v-else>
                        <a
                            v-for="link in indexes"
                            v-bind:href="link.url"
                            v-on:click.stop
                            :title="link.name"
                            class="flex gap-2 items-center ">
                            <i class="w-4 text-center" v-bind:class="link.icon" aria-hidden="true"></i>
                            <span v-html="link.name"></span>
                        </a>
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
            show_bookmarks: false,
            recent: [],
            bookmarks: [],
            indexes: [],
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

            fetch(this.api_lookup + '?' + new URLSearchParams({q: term, v2: true}))
                .then(response => response.json())
                .then(response => this.parseLookupResponse(response, cacheKey));
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
            fetch(this.api_recent)
                .then(response => response.json())
                .then(response => {
                this.recent = response.recent;
                this.bookmarks = response.bookmarks;
                this.indexes = response.indexes;
                this.texts.recents = response.texts.recents;
                this.texts.results = response.texts.results;
                this.texts.hint = response.texts.hint;
                this.texts.bookmarks = response.texts.bookmarks;
                this.texts.index = response.texts.index;
                this.texts.keyboard = response.texts.keyboard;
                this.texts.empty_results = response.texts.empty_results;
                this.texts.fulltext = response.texts.fulltext;
                this.texts.fulltext_route = response.fulltext_route;
                this.show_loading = false;
                this.show_recent = true;
                this.has_recent = true;
                if (this.bookmarks.length > 0) {
                    this.show_bookmarks = true;
                } else {
                    this.show_bookmarks = false;
                }
            }).catch(error => {
                // Probably un-logged user
                this.show_loading = false;
                this.show_recent = true;
                this.has_recent = false;
            });
        },
        // Load results from a search
        parseLookupResponse(response, cacheKey) {
            this.results = response.entities;
            this.cached[cacheKey] = response.entities;
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
          fetch(entity.preview)
              .then(response => response.json())
              .then(response => this.parsePreviewResponse(response));
        },
        parsePreviewResponse(response) {
            this.preview_entity = response;
            //console.log('preview_entity', this.preview_entity);
            this.show_loading = false;
            this.show_preview = true;
            this.show_recent = false;
        },
        // When clicking outside  the area, close the search panel
        onClickOutside (event) {
            //console.log('Clicked outside. Event: ', event)
            this.close();
        },
        close() {
            this.show_recent = false;
            this.show_loading = false;
            this.show_preview = false;
            this.$refs.searchField.blur();
        },
        showBookmarks() {
            this.show_bookmarks = true;
        },
        searchFullTextUrl() {
            return `${this.texts.fulltext_route}?term=${this.term}`;
        },
        showIndexes() {
            this.show_bookmarks = false;
        },
        modeClass(bookmark) {
            if (bookmark && this.show_bookmarks) {
                return ' underline';
            } else if (!bookmark && !this.show_bookmarks) {
                return ' underline';
            }
            return '';
        }
    },
};
</script>
