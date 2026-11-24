<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';

const props = defineProps({ searchUrl: String, excluded: Array, labels: Object });
const emit = defineEmits(['add', 'close']);

const pickerRoot = ref(null);
const searchInput = ref(null);
const query = ref('');
const results = ref([]);
const loading = ref(false);
const failed = ref(false);
const searched = ref(false);
const activeIndex = ref(0);

const excludedSet = computed(() => new Set(props.excluded || []));
const selectable = computed(() => results.value.filter(entity => !excludedSet.value.has(entity.entity_id)));

let timer, controller;

function onDocumentMousedown(event) {
    if (pickerRoot.value && !pickerRoot.value.contains(event.target)) {
        emit('close');
    }
}

onMounted(async () => {
    document.addEventListener('mousedown', onDocumentMousedown);
    await nextTick();
    searchInput.value?.focus();
});

watch(query, () => {
    clearTimeout(timer);
    controller?.abort();
    results.value = [];
    searched.value = false;
    loading.value = false;
    activeIndex.value = 0;
    if (query.value.trim().length < 2) return;
    timer = setTimeout(search, 250);
});

watch(selectable, (list) => {
    if (!list.length) {
        activeIndex.value = 0;
    } else if (activeIndex.value >= list.length) {
        activeIndex.value = list.length - 1;
    }
});

async function search() {
    controller?.abort();
    const request = new AbortController();
    controller = request;
    loading.value = true;
    failed.value = false;
    try {
        const response = await window.axios.get(props.searchUrl, {
            params: { q: query.value.trim(), v2: 'true' },
            signal: request.signal,
        });
        if (request.signal.aborted) return;
        const rows = Array.isArray(response.data) ? response.data : response.data?.data ?? response.data?.entities ?? [];
        if (!Array.isArray(rows)) throw new TypeError('Unexpected entity search response');
        results.value = rows
            .filter(Boolean)
            .map(row => ({
                entity_id: Number(row.id ?? row.entity_id),
                name: row.name ?? row.fullname ?? row.text,
                image: typeof row.image === 'string' && !row.image.trim().startsWith('<') ? row.image : null,
                url: row.link ?? row.url ?? '#',
                type: row.type ?? null,
                icon: row.icon ?? null,
            }))
            .filter(row => Number.isInteger(row.entity_id) && row.name);
        activeIndex.value = 0;
        searched.value = true;
    } catch {
        if (!request.signal.aborted) failed.value = true;
    } finally {
        if (!request.signal.aborted) loading.value = false;
    }
}

function isAdded(entity) {
    return excludedSet.value.has(entity.entity_id);
}

function selectEntity(entity) {
    if (isAdded(entity)) return;
    emit('add', [entity]);
    searchInput.value?.focus();
}

function moveActive(delta) {
    if (!selectable.value.length) return;
    const len = selectable.value.length;
    activeIndex.value = (activeIndex.value + delta + len) % len;
}

function selectActive() {
    const entity = selectable.value[activeIndex.value];
    if (entity) selectEntity(entity);
}

function clearQuery() {
    query.value = '';
    searchInput.value?.focus();
}

onBeforeUnmount(() => {
    clearTimeout(timer);
    controller?.abort();
    document.removeEventListener('mousedown', onDocumentMousedown);
});
</script>

<template>
    <div ref="pickerRoot" class="rounded-lg border border-base-300 bg-base-100 p-3 shadow-xs flex flex-col gap-2.5">
        <div class="flex items-center gap-2">
            <div class="relative grow min-w-0">
                <i class="fa-regular fa-magnifying-glass pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-neutral-content" aria-hidden="true"></i>
                <input
                    ref="searchInput"
                    v-model="query"
                    type="text"
                    class="w-full min-w-0 pl-9! pr-8!"
                    :placeholder="labels.search"
                    :aria-label="labels.search"
                    @keydown.down.prevent="moveActive(1)"
                    @keydown.up.prevent="moveActive(-1)"
                    @keydown.enter.prevent="selectActive"
                    @keydown.esc.prevent="$emit('close')"
                />
                <button
                    v-if="query"
                    type="button"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-neutral-content hover:text-base-content p-1"
                    :aria-label="labels.cancel"
                    @click="clearQuery"
                >
                    <i class="fa-regular fa-xmark text-xs" aria-hidden="true"></i>
                </button>
            </div>
            <button type="button" class="btn2 btn-ghost btn-sm shrink-0" :aria-label="labels.close" @click="$emit('close')">
                <i class="fa-regular fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <p v-if="loading" role="status" class="text-sm text-neutral-content px-1">{{ labels.searching }}</p>
        <div v-else-if="failed" role="alert" class="text-sm text-error px-1">
            {{ labels.search_failed }}
            <button type="button" class="underline" @click="search">{{ labels.retry }}</button>
        </div>
        <div v-else-if="selectable.length" class="flex flex-col gap-1 max-h-64 overflow-y-auto" role="listbox">
            <button
                v-for="(entity, index) in selectable"
                :key="entity.entity_id"
                type="button"
                role="option"
                :aria-selected="index === activeIndex"
                class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-left transition cursor-pointer"
                :class="index === activeIndex ? 'bg-base-200' : 'hover:bg-base-200'"
                @click="selectEntity(entity)"
            >
                <img v-if="entity.image" :src="entity.image" alt="" class="w-8 h-8 rounded-full object-cover shrink-0" />
                <span v-else class="w-8 h-8 rounded-full bg-base-200 flex items-center justify-center shrink-0 text-neutral-content">
                    <i v-if="entity.icon" :class="entity.icon" class="text-xs" aria-hidden="true"></i>
                    <i v-else class="fa-regular fa-circle-user text-xs" aria-hidden="true"></i>
                </span>
                <span class="min-w-0 grow flex items-center gap-2">
                    <span class="truncate font-medium">{{ entity.name }}</span>
                    <span v-if="entity.type" class="text-xs text-neutral-content bg-base-200/80 px-1.5 py-0.5 rounded shrink-0">{{ entity.type }}</span>
                </span>
                <i class="fa-regular fa-plus text-xs text-neutral-content shrink-0" aria-hidden="true"></i>
            </button>
        </div>
        <p v-else class="text-sm text-neutral-content px-1">{{ searched ? labels.no_results : labels.search_hint }}</p>
    </div>
</template>
