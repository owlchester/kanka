<script setup>
import { computed, onBeforeUnmount, ref, watch } from 'vue';

const props = defineProps({ searchUrl: String, excluded: Array, labels: Object });
const emit = defineEmits(['add', 'close']);
const query = ref('');
const results = ref([]);
const selected = ref([]);
const loading = ref(false);
const failed = ref(false);
const searched = ref(false);
const available = computed(() => results.value.filter(e => !props.excluded.includes(e.entity_id)));
let timer, controller;

watch(query, () => {
    clearTimeout(timer);
    controller?.abort();
    results.value = [];
    searched.value = false;
    loading.value = false;
    if (query.value.trim().length < 2) return;
    timer = setTimeout(search, 250);
});

async function search() {
    controller?.abort();
    const request = new AbortController();
    controller = request;
    loading.value = true;
    failed.value = false;
    try {
        const response = await window.axios.get(props.searchUrl, { params: { q: query.value.trim(), v2: 'true' }, signal: request.signal });
        if (request.signal.aborted) return;
        const rows = Array.isArray(response.data) ? response.data : response.data?.data ?? response.data?.entities ?? [];
        if (!Array.isArray(rows)) throw new TypeError('Unexpected entity search response');
        results.value = rows.filter(row => row && !row.action).map(row => ({
            entity_id: Number(row.id ?? row.entity_id),
            name: row.name ?? row.fullname ?? row.text,
            image: typeof row.image === 'string' && !row.image.trim().startsWith('<') ? row.image : null,
            url: row.link ?? row.url ?? '#',
        })).filter(row => Number.isInteger(row.entity_id) && row.name);
        searched.value = true;
    } catch (error) {
        if (!request.signal.aborted) failed.value = true;
    } finally {
        if (!request.signal.aborted) loading.value = false;
    }
}

function toggle(entity) {
    const index = selected.value.findIndex(e => e.entity_id === entity.entity_id);
    if (index >= 0) selected.value.splice(index, 1);
    else selected.value.push(entity);
}

function add() {
    emit('add', selected.value);
    selected.value = [];
}
onBeforeUnmount(() => { clearTimeout(timer); controller?.abort(); });
</script>

<template>
    <div class="flex flex-col gap-3">
        <div class="flex gap-2 items-center">
            <input v-model="query" type="search" class="w-full min-w-0" :placeholder="labels.search" :aria-label="labels.search" @keydown.enter.prevent="selected.length && add()" @keydown.esc.prevent="$emit('close')" />
            <button type="button" class="btn2 btn-ghost btn-sm" :aria-label="labels.close" @click="$emit('close')">×</button>
        </div>
        <p v-if="loading" role="status" class="text-sm text-neutral-content">{{ labels.searching }}</p>
        <div v-else-if="failed" role="alert" class="text-sm text-error">
            {{ labels.search_failed }} <button type="button" class="underline" @click="search">{{ labels.retry }}</button>
        </div>
        <div v-else-if="available.length" class="flex flex-col gap-1 max-h-64 overflow-y-auto">
            <label v-for="entity in available" :key="entity.entity_id" class="flex gap-3 items-center rounded-lg p-2 hover:bg-base-200 cursor-pointer">
                <input type="checkbox" :checked="selected.some(e => e.entity_id === entity.entity_id)" @change="toggle(entity)" />
                <img v-if="entity.image" :src="entity.image" alt="" class="w-8 h-8 rounded-full object-cover" />
                <span>{{ entity.name }}</span>
            </label>
        </div>
        <p v-else class="text-sm text-neutral-content">{{ searched ? labels.no_results : labels.search_hint }}</p>
        <div v-if="selected.length" class="flex flex-wrap gap-2">
            <button v-for="entity in selected" :key="entity.entity_id" type="button" class="btn2 btn-xs" @click="toggle(entity)">{{ entity.name }} ×</button>
        </div>
        <div class="flex justify-end">
            <button type="button" class="btn2 btn-primary btn-sm" :disabled="!selected.length" @click="add">{{ labels.add_selected }}<span v-if="selected.length"> ({{ selected.length }})</span></button>
        </div>
    </div>
</template>
