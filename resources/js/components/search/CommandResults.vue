<template>
    <div class="cmd-results" ref="resultsRef">
        <!-- Rest state: no query -->
        <template v-if="!hasQuery">
            <div v-if="recent.length > 0">
                <div class="cmd-section-label">{{ texts.recents }}</div>
                <button
                    v-for="(item, i) in recent"
                    :key="'recent-' + item.id"
                    type="button"
                    class="cmd-item"
                    :class="{ focused: focusedIndex === i }"
                    @click="openItem(item)"
                    @mouseenter="focusedIndex = i"
                >
                    <img v-if="item.image" :src="item.image" class="cmd-avatar" alt="" />
                    <span v-else class="cmd-avatar cmd-avatar-placeholder"></span>
                    <span class="cmd-item-meta">
                        <span class="cmd-item-name">{{ item.name }}</span>
                        <span class="cmd-item-type">{{ item.type }}<i v-if="item.is_private" class="fa-solid fa-lock cmd-private-icon"></i></span>
                    </span>
                </button>
            </div>

            <div v-if="bookmarks.length > 0">
                <div class="cmd-section-label">{{ texts.bookmarks }}</div>
                <a
                    v-for="(item, i) in bookmarks"
                    :key="'bookmark-' + i"
                    :href="item.url"
                    class="cmd-item"
                    :class="{ focused: focusedIndex === recent.length + i }"
                    @mouseenter="focusedIndex = recent.length + i"
                >
                    <span class="cmd-item-icon"><i :class="item.icon"></i></span>
                    <span class="cmd-item-name">{{ item.text }}</span>
                </a>
            </div>

            <div v-if="indexes.length > 0">
                <div class="cmd-section-label">{{ texts.index }}</div>
                <a
                    v-for="(item, i) in indexes"
                    :key="'index-' + i"
                    :href="item.url"
                    class="cmd-item"
                    :class="{ focused: focusedIndex === recent.length + bookmarks.length + i }"
                    @mouseenter="focusedIndex = recent.length + bookmarks.length + i"
                >
                    <span class="cmd-item-icon"><i :class="item.icon"></i></span>
                    <span class="cmd-item-name">{{ item.name }}</span>
                </a>
            </div>
        </template>

        <!-- Name search results -->
        <template v-else-if="mode === 'name'">
            <div v-if="loading" class="cmd-loading">
                <i class="fa-solid fa-spinner fa-spin"></i>
            </div>
            <template v-else>
                <div v-if="entities.length > 0">
                    <div class="cmd-section-label">{{ texts.results }}</div>
                    <button
                        v-for="(item, i) in entities"
                        :key="'entity-' + item.id"
                        type="button"
                        class="cmd-item"
                        :class="{ focused: focusedIndex === i }"
                        @click="openItem(item)"
                        @mouseenter="focusedIndex = i"
                    >
                        <img v-if="item.image" :src="item.image" class="cmd-avatar" alt="" />
                        <span v-else class="cmd-avatar cmd-avatar-placeholder"></span>
                        <span class="cmd-item-meta">
                            <span class="cmd-item-name">{{ item.name }}</span>
                            <span class="cmd-item-type">{{ item.type }}<i v-if="item.is_private" class="fa-solid fa-lock cmd-private-icon"></i></span>
                        </span>
                    </button>
                </div>

                <div v-if="pages.length > 0">
                    <div class="cmd-section-label">{{ texts.pages }}</div>
                    <a
                        v-for="(item, i) in pages"
                        :key="'page-' + i"
                        :href="item.url"
                        class="cmd-item"
                        :class="{ focused: focusedIndex === entities.length + i }"
                        @mouseenter="focusedIndex = entities.length + i"
                    >
                        <span class="cmd-item-icon"><i :class="item.icon"></i></span>
                        <span class="cmd-item-name">{{ item.name }}</span>
                    </a>
                </div>

                <div v-if="entities.length === 0 && pages.length === 0" class="cmd-empty">
                    {{ texts.no_results }}
                </div>
            </template>
        </template>

        <!-- Full-text results -->
        <template v-else-if="mode === 'fulltext'">
            <div v-if="loading" class="cmd-loading">
                <i class="fa-solid fa-spinner fa-spin"></i>
            </div>
            <template v-else>
                <div v-if="results.length > 0">
                    <div class="cmd-section-label">{{ texts.content_matches }}</div>
                    <button
                        v-for="(item, i) in results"
                        :key="'result-' + item.id"
                        type="button"
                        class="cmd-item cmd-item-snippet"
                        :class="{ focused: focusedIndex === i }"
                        @click="openItem(item)"
                        @mouseenter="focusedIndex = i"
                    >
                        <img v-if="item.image" :src="item.image" class="cmd-avatar" alt="" />
                        <span v-else class="cmd-avatar cmd-avatar-placeholder"></span>
                        <span class="cmd-item-meta">
                            <span class="cmd-item-name">{{ item.name }}</span>
                            <span class="cmd-item-type">{{ item.type }}</span>
                            <span v-if="item.snippet" class="cmd-item-snippet-text" v-html="item.snippet"></span>
                        </span>
                    </button>
                </div>
                <div v-else class="cmd-empty">
                    {{ texts.no_results }}
                </div>
            </template>
        </template>
    </div>
</template>

<script>
export default {
    name: 'CommandResults',

    props: {
        mode: { type: String, default: 'name' },
        query: { type: String, default: '' },
        loading: { type: Boolean, default: false },
        recent: { type: Array, default: () => [] },
        bookmarks: { type: Array, default: () => [] },
        indexes: { type: Array, default: () => [] },
        entities: { type: Array, default: () => [] },
        pages: { type: Array, default: () => [] },
        results: { type: Array, default: () => [] },
        texts: {
            type: Object,
            default: () => ({
                recents: 'Recent',
                bookmarks: 'Bookmarks',
                index: 'Quick jump',
                results: 'Entities',
                pages: 'Pages',
                content_matches: 'Content matches',
                no_results: 'No results found',
            }),
        },
    },

    data() {
        return {
            focusedIndex: 0,
        };
    },

    computed: {
        hasQuery() {
            return this.query.length >= 2;
        },

        flatItems() {
            if (!this.hasQuery) {
                return [
                    ...this.recent,
                    ...this.bookmarks.map(b => ({ ...b, link: b.url })),
                    ...this.indexes.map(ix => ({ ...ix, link: ix.url })),
                ];
            }
            if (this.mode === 'name') {
                return [
                    ...this.entities,
                    ...this.pages.map(p => ({ ...p, link: p.url })),
                ];
            }
            return this.results;
        },
    },

    watch: {
        query() {
            this.focusedIndex = 0;
        },
        mode() {
            this.focusedIndex = 0;
        },
    },

    methods: {
        navigate(direction) {
            const max = this.flatItems.length - 1;
            this.focusedIndex = Math.max(0, Math.min(max, this.focusedIndex + direction));
        },

        submit() {
            const item = this.flatItems[this.focusedIndex];
            if (item) {
                this.openItem(item);
            }
        },

        openItem(item) {
            const url = item.link || item.url;
            if (!url) {
                return;
            }
            if (item.log_url) {
                fetch(item.log_url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    },
                });
            }
            window.location.href = url;
        },
    },
};
</script>
