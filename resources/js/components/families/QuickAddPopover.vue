<template>
    <dialog
        ref="dialogEl"
        class="dialog rounded-top md:rounded-2xl bg-base-100 shadow-md text-base-content w-full max-w-lg"
        aria-modal="true"
        @cancel.prevent="$emit('close')"
        @click="onBackdropClick"
    >
        <header class="flex items-center justify-between px-5 py-4">
            <h4 class="text-lg font-normal">{{ title }}</h4>
            <button
                type="button"
                class="text-xl opacity-50 hover:opacity-100 cursor-pointer"
                aria-label="Close"
                @click="$emit('close')"
            >
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
            </button>
        </header>

        <article class="px-5 pb-5 flex flex-col gap-4">
            <!-- Mode tabs: Character / Placeholder / Existing in Tree -->
            <div class="flex gap-1 bg-base-200 p-1 rounded-lg text-xs font-medium">
                <button
                    type="button"
                    class="flex-1 py-1.5 px-2 rounded-md transition-colors cursor-pointer"
                    :class="mode === 'character' ? 'bg-base-100 shadow-sm text-primary' : 'opacity-70 hover:opacity-100'"
                    @click="mode = 'character'"
                >
                    <i class="fa-regular fa-user mr-1" aria-hidden="true"></i>
                    {{ texts?.inspector?.character || 'Character' }}
                </button>
                <button
                    type="button"
                    class="flex-1 py-1.5 px-2 rounded-md transition-colors cursor-pointer"
                    :class="mode === 'placeholder' ? 'bg-base-100 shadow-sm text-primary' : 'opacity-70 hover:opacity-100'"
                    @click="mode = 'placeholder'"
                >
                    <i class="fa-regular fa-pen-to-square mr-1" aria-hidden="true"></i>
                    {{ texts?.placeholders?.badge || 'Placeholder' }}
                </button>
                <button
                    v-if="existingPeople.length > 0 && context?.action !== 'add-first'"
                    type="button"
                    class="flex-1 py-1.5 px-2 rounded-md transition-colors cursor-pointer"
                    :class="mode === 'existing' ? 'bg-base-100 shadow-sm text-primary' : 'opacity-70 hover:opacity-100'"
                    @click="mode = 'existing'"
                >
                    <i class="fa-solid fa-link mr-1" aria-hidden="true"></i>
                    {{ texts?.placeholders?.existing_in_tree || 'In tree' }}
                </button>
            </div>

            <!-- Character Search Mode -->
            <div v-if="mode === 'character'" class="flex flex-col gap-3">
                <div class="relative">
                    <input
                        ref="searchInput"
                        v-model="query"
                        type="text"
                        class="w-full input input-bordered input-sm"
                        :placeholder="texts?.placeholders?.search_placeholder || 'Search campaign characters…'"
                        @input="onSearchInput"
                    />
                    <i
                        v-if="isSearching"
                        class="fa-solid fa-spinner fa-spin absolute right-3 top-2.5 text-xs opacity-60"
                        aria-hidden="true"
                    ></i>
                </div>

                <div v-if="results.length > 0" class="max-h-44 overflow-y-auto flex flex-col gap-1 bg-base-200/50 rounded-lg p-1.5">
                    <button
                        v-for="item in results"
                        :key="item.id"
                        type="button"
                        class="w-full text-left px-3 py-1.5 rounded-md text-sm hover:bg-primary/10 flex items-center justify-between cursor-pointer"
                        :class="isEntityActive(item.id) ? 'bg-primary/15 text-primary font-medium' : ''"
                        @click="selectEntity(item.id, item.fullname || item.name || item.text)"
                    >
                        <span class="truncate">{{ item.fullname || item.name || item.text }}</span>
                        <i v-if="isEntityActive(item.id)" class="fa-solid fa-check text-xs" aria-hidden="true"></i>
                    </button>
                </div>

                <!-- Family Member Suggestions -->
                <div v-if="suggestions.length > 0" class="flex flex-col gap-1.5">
                    <span class="text-xs font-medium text-neutral-content">
                        {{ texts?.modals?.fields?.member || 'Member' }}
                    </span>
                    <div class="flex flex-wrap gap-1.5">
                        <button
                            v-for="s in suggestions"
                            :key="s.id"
                            type="button"
                            class="btn2 btn-xs"
                            :class="isEntityActive(s.id) ? 'btn-primary' : 'btn-outline'"
                            @click="selectEntity(s.id, s.name)"
                        >
                            {{ s.name }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Placeholder Mode -->
            <div v-else-if="mode === 'placeholder'" class="flex flex-col gap-3">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.placeholder_name || 'Placeholder name' }}</label>
                    <input
                        ref="placeholderInput"
                        v-model="placeholderName"
                        type="text"
                        maxlength="191"
                        class="w-full input input-bordered input-sm"
                        :placeholder="texts?.placeholders?.name_placeholder || 'e.g. Great Uncle Jim (leave blank for Unknown)'"
                        @keyup.enter="onPlaceholderEnter"
                    />
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.placeholder_subtitle || 'Subtitle / note' }}</label>
                    <input
                        v-model="placeholderSubtitle"
                        type="text"
                        maxlength="191"
                        class="w-full input input-bordered input-sm"
                        :placeholder="texts?.placeholders?.subtitle_placeholder || 'Optional note'"
                        @keyup.enter="onPlaceholderEnter"
                    />
                </div>
                <div v-if="isMultiChild" class="flex justify-end">
                    <button type="button" class="btn2 btn-xs btn-outline" @click="queuePlaceholder">
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        Add to list
                    </button>
                </div>
            </div>

            <!-- Existing in Tree Mode -->
            <div v-else-if="mode === 'existing'" class="flex flex-col gap-2">
                <div class="flex gap-2">
                    <select v-model="existingPersonId" class="w-full select select-bordered select-sm">
                        <option value="" disabled>Select person…</option>
                        <option v-for="p in existingPeople" :key="p.id" :value="p.id">
                            {{ p.label }}
                        </option>
                    </select>
                    <button
                        v-if="isMultiChild && existingPersonId"
                        type="button"
                        class="btn2 btn-sm btn-outline shrink-0"
                        @click="queueExistingPerson"
                    >
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <!-- Queued Children Chips (multi-child mode) -->
            <div v-if="isMultiChild && queuedChildren.length > 0" class="flex flex-col gap-1.5 bg-base-200/50 rounded-lg p-2.5">
                <span class="text-xs font-medium text-neutral-content">
                    Selected ({{ queuedChildren.length }})
                </span>
                <div class="flex flex-wrap gap-1.5">
                    <span
                        v-for="(item, idx) in queuedChildren"
                        :key="item.key"
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-base-100 text-xs font-medium shadow-xs"
                    >
                        <span class="truncate max-w-[160px]">{{ item.label }}</span>
                        <button
                            type="button"
                            class="opacity-60 hover:opacity-100 cursor-pointer"
                            aria-label="Remove"
                            @click="queuedChildren.splice(idx, 1)"
                        >
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </span>
                </div>
            </div>

            <!-- Relationship Type / Kind Selector -->
            <div v-if="context?.action === 'add-partner'" class="grid grid-cols-2 gap-3 pt-1">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.union_type || 'Partnership type' }}</label>
                    <select v-model="unionType" class="select select-bordered select-sm w-full">
                        <option v-for="(label, key) in unionTypes" :key="key" :value="key">{{ label }}</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.role || 'Role / note' }}</label>
                    <input
                        v-model="unionRole"
                        type="text"
                        maxlength="70"
                        class="input input-bordered input-sm w-full"
                        @keyup.enter="submit"
                    />
                </div>
            </div>

            <div
                v-else-if="isMultiChild || context?.action === 'add-parent'"
                class="grid grid-cols-2 gap-3 pt-1"
            >
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.kind || 'Lineage type' }}</label>
                    <select v-model="linkKind" class="select select-bordered select-sm w-full">
                        <option v-for="(label, key) in linkKinds" :key="key" :value="key">{{ label }}</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.label || 'Label' }}</label>
                    <input
                        v-model="linkLabel"
                        type="text"
                        maxlength="70"
                        class="input input-bordered input-sm w-full"
                        @keyup.enter="submit"
                    />
                </div>
            </div>
        </article>

        <footer class="flex justify-end gap-2 px-5 py-3 bg-base-200/40">
            <button type="button" class="btn2 btn-sm btn-ghost" @click="$emit('close')">
                Cancel
            </button>
            <button
                type="button"
                class="btn2 btn-sm btn-primary"
                :disabled="!canSubmit"
                @click="submit"
            >
                {{ submitLabel }}
            </button>
        </footer>
    </dialog>
</template>

<script setup>
import { computed, nextTick, ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    open: { type: Boolean, default: false },
    context: { type: Object, default: null },
    searchApi: { type: String, required: true },
    suggestions: { type: Array, default: () => [] },
    existingPeople: { type: Array, default: () => [] },
    texts: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['close', 'confirm']);

const dialogEl = ref(null);
const mode = ref('character');
const query = ref('');
const results = ref([]);
const isSearching = ref(false);
const selectedEntityId = ref(null);
const placeholderName = ref('');
const placeholderSubtitle = ref('');
const existingPersonId = ref('');
const queuedChildren = ref([]);
const unionType = ref('married');
const unionRole = ref('');
const linkKind = ref('biological');
const linkLabel = ref('');
const searchInput = ref(null);
const placeholderInput = ref(null);

let debounceTimer = null;
let queueKeySeq = 0;

const isMultiChild = computed(() => ['add-child', 'add-union-child'].includes(props.context?.action));

watch(
    () => props.open,
    async (isOpen) => {
        const el = dialogEl.value;
        if (!el) {
            return;
        }
        if (!isOpen) {
            if (el.open) {
                el.close();
            }
            return;
        }

        mode.value = 'character';
        query.value = '';
        results.value = [];
        selectedEntityId.value = null;
        placeholderName.value = '';
        placeholderSubtitle.value = '';
        existingPersonId.value = '';
        queuedChildren.value = [];
        unionType.value = 'married';
        unionRole.value = '';
        linkKind.value = 'biological';
        linkLabel.value = '';

        if (!el.open) {
            el.showModal();
        }
        await nextTick();
        searchInput.value?.focus();
    }
);

watch(mode, async (newMode) => {
    await nextTick();
    if (newMode === 'character') {
        searchInput.value?.focus();
    } else if (newMode === 'placeholder') {
        placeholderInput.value?.focus();
    }
});

function onBackdropClick(e) {
    if (e.target === dialogEl.value) {
        emit('close');
    }
}

const unionTypes = computed(() => props.texts?.union_types || {
    married: 'Married',
    partner: 'Partner',
    divorced: 'Divorced',
    affair: 'Affair',
    betrothed: 'Betrothed',
    custom: 'Custom',
});

const linkKinds = computed(() => props.texts?.link_kinds || {
    biological: 'Biological',
    adopted: 'Adopted',
    foster: 'Foster',
    step: 'Step',
    bastard: 'Illegitimate',
    custom: 'Custom',
});

const title = computed(() => {
    switch (props.context?.action) {
        case 'add-parent':
            return props.texts?.actions?.add_parent || 'Add parent';
        case 'add-partner':
            return props.texts?.actions?.add_partner || 'Add partner';
        case 'add-child':
        case 'add-union-child':
            return props.texts?.actions?.add_child || 'Add child';
        default:
            return props.texts?.actions?.add_first || 'Add person';
    }
});

const canSubmit = computed(() => {
    if (isMultiChild.value && queuedChildren.value.length > 0) {
        return true;
    }
    if (mode.value === 'character') {
        return Boolean(selectedEntityId.value);
    }
    if (mode.value === 'existing') {
        return Boolean(existingPersonId.value);
    }
    return true;
});

const submitLabel = computed(() => {
    const base = props.texts?.actions?.save || 'Save';
    if (isMultiChild.value && queuedChildren.value.length > 1) {
        return `${base} (${queuedChildren.value.length})`;
    }
    return base;
});

function isEntityActive(id) {
    const numId = Number(id);
    if (isMultiChild.value) {
        return queuedChildren.value.some((c) => c.personData?.entity_id === numId);
    }
    return selectedEntityId.value === numId;
}

function onSearchInput() {
    clearTimeout(debounceTimer);
    const term = query.value.trim();
    if (term.length < 1) {
        results.value = [];
        return;
    }
    debounceTimer = setTimeout(async () => {
        isSearching.value = true;
        try {
            const resp = await axios.get(props.searchApi, { params: { q: term } });
            const list = Array.isArray(resp.data) ? resp.data : resp.data?.results || [];
            results.value = list;
        } catch {
            results.value = [];
        } finally {
            isSearching.value = false;
        }
    }, 220);
}

function selectEntity(id, label = '') {
    const numId = Number(id);
    if (isMultiChild.value) {
        const existingIdx = queuedChildren.value.findIndex((c) => c.personData?.entity_id === numId);
        if (existingIdx >= 0) {
            queuedChildren.value.splice(existingIdx, 1);
        } else {
            queuedChildren.value.push({
                key: `entity-${numId}-${++queueKeySeq}`,
                label: label || `#${numId}`,
                personData: { entity_id: numId },
            });
        }
        return;
    }
    selectedEntityId.value = numId;
}

function queuePlaceholder() {
    const name = placeholderName.value.trim();
    const subtitle = placeholderSubtitle.value.trim();
    queuedChildren.value.push({
        key: `ph-${++queueKeySeq}`,
        label: name || (props.texts?.placeholders?.unknown || 'Unknown'),
        personData: {
            entity_id: null,
            placeholder: { name, subtitle },
        },
    });
    placeholderName.value = '';
    placeholderSubtitle.value = '';
    placeholderInput.value?.focus();
}

function onPlaceholderEnter() {
    if (isMultiChild.value) {
        queuePlaceholder();
    } else {
        submit();
    }
}

function queueExistingPerson() {
    if (!existingPersonId.value) {
        return;
    }
    const already = queuedChildren.value.some((c) => c.personData?.existingPersonId === existingPersonId.value);
    if (!already) {
        const found = props.existingPeople.find((p) => p.id === existingPersonId.value);
        queuedChildren.value.push({
            key: `ex-${existingPersonId.value}`,
            label: found?.label || 'Person',
            personData: { existingPersonId: existingPersonId.value },
        });
    }
    existingPersonId.value = '';
}

function buildCurrentModePersonData() {
    if (mode.value === 'character' && selectedEntityId.value) {
        return { entity_id: selectedEntityId.value };
    }
    if (mode.value === 'existing' && existingPersonId.value) {
        return { existingPersonId: existingPersonId.value };
    }
    if (mode.value === 'placeholder') {
        return {
            entity_id: null,
            placeholder: {
                name: placeholderName.value.trim(),
                subtitle: placeholderSubtitle.value.trim(),
            },
        };
    }
    return null;
}

function submit() {
    if (!canSubmit.value) {
        return;
    }

    let peopleData;
    if (isMultiChild.value) {
        peopleData = queuedChildren.value.map((c) => c.personData);
        if (peopleData.length === 0) {
            const single = buildCurrentModePersonData();
            if (single) {
                peopleData = [single];
            }
        } else if (mode.value === 'placeholder' && placeholderName.value.trim() !== '') {
            peopleData.push({
                entity_id: null,
                placeholder: {
                    name: placeholderName.value.trim(),
                    subtitle: placeholderSubtitle.value.trim(),
                },
            });
        }
    } else {
        const single = buildCurrentModePersonData();
        peopleData = single ? [single] : [];
    }

    if (peopleData.length === 0) {
        return;
    }

    emit('confirm', {
        context: props.context,
        personData: peopleData[0],
        peopleData,
        unionType: unionType.value,
        unionRole: unionRole.value.trim(),
        linkKind: linkKind.value,
        linkLabel: linkLabel.value.trim(),
    });
}
</script>
