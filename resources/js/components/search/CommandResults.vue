<template>
    <div class="flex flex-col gap-2 px-4 py-2" ref="resultsRef">
        <!-- Rest state: no query -->
        <template v-if="!hasQuery">
            <div v-if="recent.length > 0" class="flex flex-col">
                <div class="uppercase text-neutral-content text-xs py-2">{{ texts.recents }}</div>
                <button
                    v-for="(item, i) in recent"
                    :key="'recent-' + item.id"
                    type="button"
                    data-nav-item
                    class="cursor-pointer flex items-center gap-2 rounded-lg p-2 border border-base-100"
                    :class="{ 'border-base-300': focusedIndex === i }"
                    @click="openItem(item)"
                    @mouseenter="focusedIndex = i"
                >
                    <img v-if="item.image" :src="item.image" class="rounded-full w-8 h-8" alt="" />
                    <span v-else class="cmd-avatar cmd-avatar-placeholder"></span>
                    <span class="cmd-item-meta">
                        <span class="cmd-item-name">{{ item.name }}</span>
                        <span class="cmd-item-type">{{ item.type }}<i v-if="item.is_private" class="fa-solid fa-lock cmd-private-icon"></i></span>
                    </span>
                </button>
            </div>

            <div v-if="bookmarks.length > 0" class="flex flex-col gap-0">
                <div class="text-neutral-content text-xs uppercase">{{ texts.bookmarks }}</div>
                <a
                    v-for="(item, i) in bookmarks"
                    :key="'bookmark-' + i"
                    :href="item.url"
                    data-nav-item
                    class="cursor-pointer flex items-center gap-2 rounded-lg p-2 border border-base-100"
                    :class="{ 'border-base-300 shadow-xs': focusedIndex === recent.length + i }"
                    @mouseenter="focusedIndex = recent.length + i"
                >
                    <span class="cmd-item-icon"><i :class="item.icon"></i></span>
                    <span class="cmd-item-name">{{ item.text }}</span>
                </a>
            </div>

            <div v-if="indexes.length > 0" class="flex flex-col">
                <div class="text-neutral-content text-xs uppercase">{{ texts.index }}</div>
                <a
                    v-for="(item, i) in indexes"
                    :key="'index-' + i"
                    :href="item.url"
                    data-nav-item
                    class="cursor-pointer flex items-center gap-2 rounded-lg p-2 border border-base-100"
                    :class="{ 'border-base-300 shadow-xs': focusedIndex === recent.length + bookmarks.length + i }"
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
                <div v-if="typeSummary.length > 0" class="flex flex-wrap gap-1.5 pb-2">
                    <span class="uppercase text-neutral-content text-xs self-center mr-1">{{ texts.results }}</span>
                    <span
                        v-for="group in typeSummary"
                        :key="group.type"
                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-base-200 text-xs"
                    >
                        <i :class="group.icon" class="text-xs"></i>
                        {{ group.type }}
                        <span class="text-neutral-content">{{ group.count }}</span>
                    </span>
                </div>

                <div v-if="entities.length > 0" class="flex flex-col">
                    <button
                        v-for="(item, i) in entities"
                        :key="'entity-' + item.id"
                        type="button"
                        data-nav-item
                        class="cursor-pointer flex items-center gap-2 rounded-lg p-2 border border-base-100"
                        :class="{ 'border-base-300 shadow-xs': focusedIndex === i }"
                        @click="openItem(item)"
                        @mouseenter="focusedIndex = i"
                    >
                        <img v-if="item.image" :src="item.image" class="rounded-full w-8 h-8" alt="" />
                        <span v-else class="cmd-avatar cmd-avatar-placeholder"></span>

                        <div class="cmd-item-meta flex gap-2 items-center">
                            <span class="cmd-item-name font-normal">{{ item.name }}</span>
                            <span class="cmd-item-type text-neutral-content text-xs uppercase">{{ item.type }}</span>
                        </div>
                    </button>
                </div>

                <div v-if="pages.length > 0">
                    <div class="cmd-section-label">{{ texts.pages }}</div>
                    <a
                        v-for="(item, i) in pages"
                        :key="'page-' + i"
                        :href="item.url"
                        data-nav-item
                        class="cursor-pointer flex items-center gap-2 rounded-lg p-2 border border-base-100"
                        :class="{ 'border-base-300 shadow-xs': focusedIndex === entities.length + i }"
                        @mouseenter="focusedIndex = entities.length + i"
                    >
                        <span class="cmd-item-icon"><i :class="item.icon"></i></span>
                        <span class="cmd-item-name">{{ item.name }}</span>
                    </a>
                </div>

                <div v-if="entities.length === 0 && pages.length === 0" class="text-neutral-content">
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
                    <div v-if="typeSummary.length > 0" class="flex flex-wrap gap-1.5 pb-2">
                        <span class="uppercase text-neutral-content text-xs self-center mr-1">{{ texts.matches }}</span>
                        <span
                            v-for="group in typeSummary"
                            :key="group.type"
                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-base-200 text-xs"
                        >
                            <i :class="group.icon" class="text-xs"></i>
                            {{ group.type }}
                            <span class="text-neutral-content">{{ group.count }}</span>
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <button
                            v-for="(item, i) in results"
                            :key="'result-' + item.id"
                            type="button"
                            data-nav-item
                            class="cursor-pointer flex items-center gap-2 rounded-lg p-2 border border-base-100"
                            :class="{ 'border-base-300 shadow-xs': focusedIndex === i }"
                            @click="openItem(item)"
                            @mouseenter="focusedIndex = i"
                        >
                            <img v-if="item.image" :src="item.image" class="rounded-full w-8 h-8" alt="" />
                            <span v-else class="cmd-avatar cmd-avatar-placeholder"></span>
                            <span class="cmd-item-meta flex gap-1 flex-col min-w-0 flex-1 text-left">
                                <div class="flex items-center gap-2">
                                    <span class="cmd-item-name normal">{{ item.name }}</span>
                                    <span class="cmd-item-type text-neutral-content text-xs uppercase">{{ item.type }}</span>
                                </div>
                                <span v-if="item.snippet" class="block text-neutral-content text-xs truncate max-w-2xl" v-html="item.snippet"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div v-else class="text-neutral-content">
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
                results: 'Entries',
                pages: 'Pages',
                entries: 'Entries',
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

        typeSummary() {
            const items = this.mode === 'fulltext' ? this.results : this.entities;
            const map = {};
            for (const item of items) {
                if (!item.type) {
                    continue;
                }
                if (!map[item.type]) {
                    map[item.type] = { type: item.type, icon: item.icon || '', count: 0 };
                }
                map[item.type].count++;
            }
            return Object.values(map);
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
            this.$nextTick(() => {
                const items = this.$el.querySelectorAll('[data-nav-item]');
                items[this.focusedIndex]?.scrollIntoView({ block: 'nearest' });
            });
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
