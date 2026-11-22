<template>
    <aside
        v-if="selection"
        class="w-80 shrink-0 bg-base-100 text-base-content rounded-xl shadow-md p-4 flex flex-col gap-4 overflow-y-auto max-h-[70vh]"
    >
        <header class="flex items-center justify-between">
            <h4 class="font-semibold text-base">{{ headerTitle }}</h4>
            <button
                type="button"
                class="opacity-60 hover:opacity-100 cursor-pointer"
                aria-label="Close"
                @click="$emit('close')"
            >
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
            </button>
        </header>

        <!-- PERSON INSPECTOR -->
        <template v-if="selection.type === 'person' && person">
            <div v-if="person.entity_id" class="flex items-center justify-between gap-2 bg-base-200/60 rounded-lg p-2.5">
                <div class="min-w-0">
                    <div class="text-xs text-neutral-content">{{ texts?.inspector?.character || 'Character' }}</div>
                    <a
                        v-if="entity"
                        :href="entity.url"
                        class="font-medium text-sm truncate block hover:underline"
                    >
                        {{ entity.name }}
                    </a>
                </div>
                <button
                    v-if="isEditing"
                    type="button"
                    class="btn2 btn-xs btn-ghost shrink-0"
                    :title="texts?.inspector?.convert_placeholder || 'Convert to placeholder'"
                    @click="convertToPlaceholder"
                >
                    <i class="fa-regular fa-pen-to-square" aria-hidden="true"></i>
                </button>
            </div>

            <!-- Placeholder controls -->
            <div v-else class="flex flex-col gap-2.5">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.placeholder_name || 'Placeholder name' }}</label>
                    <input
                        v-model="placeholderName"
                        type="text"
                        maxlength="191"
                        class="input input-bordered input-sm w-full"
                        :disabled="!isEditing"
                        @change="savePlaceholderFields"
                    />
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.placeholder_subtitle || 'Subtitle / note' }}</label>
                    <input
                        v-model="placeholderSubtitle"
                        type="text"
                        maxlength="191"
                        class="input input-bordered input-sm w-full"
                        :disabled="!isEditing"
                        @change="savePlaceholderFields"
                    />
                </div>

                <!-- Promote to Character -->
                <button
                    v-if="isEditing && canCreateCharacter"
                    type="button"
                    class="btn2 btn-sm btn-primary w-full"
                    :disabled="isPromoting || !placeholderName.trim()"
                    @click="promoteToCharacter"
                >
                    <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                    {{ texts?.inspector?.promote_character || 'Promote to Character' }}
                </button>

                <!-- Link Existing Character -->
                <div v-if="isEditing" class="flex flex-col gap-1 pt-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.link_character || 'Link existing character' }}</label>
                    <input
                        v-model="charQuery"
                        type="text"
                        class="input input-bordered input-sm w-full"
                        :placeholder="texts?.placeholders?.search_placeholder || 'Search campaign characters…'"
                        @input="onCharSearch"
                    />
                    <div v-if="charResults.length > 0" class="max-h-32 overflow-y-auto bg-base-200/50 rounded-lg p-1 flex flex-col gap-0.5">
                        <button
                            v-for="c in charResults"
                            :key="c.id"
                            type="button"
                            class="text-left text-xs px-2 py-1.5 rounded hover:bg-primary/10 truncate cursor-pointer"
                            @click="linkCharacter(c.id)"
                        >
                            {{ c.fullname || c.name || c.text }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Actions in Edit Mode -->
            <div v-if="isEditing" class="flex flex-wrap gap-1.5">
                <button type="button" class="btn2 btn-xs btn-outline" @click="$emit('quick-add', { action: 'add-parent', personId: person.id })">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    {{ texts?.actions?.add_parent || 'Add parent' }}
                </button>
                <button type="button" class="btn2 btn-xs btn-outline" @click="$emit('quick-add', { action: 'add-partner', personId: person.id })">
                    <i class="fa-solid fa-heart" aria-hidden="true"></i>
                    {{ texts?.actions?.add_partner || 'Add partner' }}
                </button>
                <button type="button" class="btn2 btn-xs btn-outline" @click="$emit('quick-add', { action: 'add-child', personId: person.id })">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    {{ texts?.actions?.add_child || 'Add child' }}
                </button>
            </div>

            <!-- Cross-tree appearances -->
            <div v-if="linkedTrees.length > 0" class="flex flex-col gap-1.5">
                <div class="text-xs font-medium text-neutral-content">{{ texts?.linked_trees?.title || 'Also appears in' }}</div>
                <a
                    v-for="lt in linkedTrees"
                    :key="lt.family_id"
                    :href="lt.url"
                    class="flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-base-200/60 hover:bg-primary/10 text-xs font-medium"
                >
                    <span class="truncate">{{ lt.name }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-60" aria-hidden="true"></i>
                </a>
            </div>

            <!-- Styling & Visibility -->
            <template v-if="isEditing">
                <div class="grid grid-cols-2 gap-2.5">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium">{{ texts?.inspector?.colour || 'Colour' }}</label>
                        <ColourPicker
                            :model-value="person.colour || null"
                            @update:model-value="updatePerson({ colour: $event })"
                        />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium">{{ texts?.inspector?.visibility || 'Visibility' }}</label>
                        <select
                            class="select select-bordered select-sm w-full"
                            :value="person.visibility ?? 1"
                            @change="updatePerson({ visibility: Number($event.target.value) })"
                        >
                            <option value="1">{{ texts?.modals?.fields?.visibility?.all || 'All' }}</option>
                            <option value="5">{{ texts?.modals?.fields?.visibility?.members || 'Members' }}</option>
                            <option value="2">{{ texts?.modals?.fields?.visibility?.admins || 'Admins' }}</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.css || 'CSS class' }}</label>
                    <input
                        :value="person.cssClass || ''"
                        type="text"
                        maxlength="70"
                        class="input input-bordered input-sm w-full"
                        @change="updatePerson({ cssClass: $event.target.value.trim() || null })"
                    />
                </div>

                <button
                    type="button"
                    class="btn2 btn-sm btn-error btn-outline w-full mt-2"
                    @click="$emit('delete-person', person.id)"
                >
                    <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                    {{ texts?.inspector?.delete_person || 'Remove from tree' }}
                </button>
            </template>
        </template>

        <!-- UNION INSPECTOR -->
        <template v-else-if="selection.type === 'union' && union">
            <div class="flex flex-col gap-3">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.union_type || 'Partnership type' }}</label>
                    <select
                        class="select select-bordered select-sm w-full"
                        :disabled="!isEditing"
                        :value="union.type || 'married'"
                        @change="updateUnion({ type: $event.target.value })"
                    >
                        <option v-for="(label, key) in texts?.union_types || {}" :key="key" :value="key">{{ label }}</option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.role || 'Role / note' }}</label>
                    <input
                        :value="union.role || ''"
                        type="text"
                        maxlength="70"
                        class="input input-bordered input-sm w-full"
                        :disabled="!isEditing"
                        @change="updateUnion({ role: $event.target.value.trim() || null })"
                    />
                </div>

                <template v-if="isEditing">
                    <button
                        type="button"
                        class="btn2 btn-xs btn-outline"
                        @click="$emit('quick-add', { action: 'add-union-child', unionId: union.id })"
                    >
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        {{ texts?.actions?.add_child || 'Add child' }}
                    </button>

                    <div class="grid grid-cols-2 gap-2.5">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-medium">{{ texts?.inspector?.colour || 'Colour' }}</label>
                            <ColourPicker
                                :model-value="union.colour || null"
                                @update:model-value="updateUnion({ colour: $event })"
                            />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-medium">{{ texts?.inspector?.visibility || 'Visibility' }}</label>
                            <select
                                class="select select-bordered select-sm w-full"
                                :value="union.visibility ?? 1"
                                @change="updateUnion({ visibility: Number($event.target.value) })"
                            >
                                <option value="1">{{ texts?.modals?.fields?.visibility?.all || 'All' }}</option>
                                <option value="5">{{ texts?.modals?.fields?.visibility?.members || 'Members' }}</option>
                                <option value="2">{{ texts?.modals?.fields?.visibility?.admins || 'Admins' }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium">{{ texts?.inspector?.css || 'CSS class' }}</label>
                        <input
                            :value="union.cssClass || ''"
                            type="text"
                            maxlength="70"
                            class="input input-bordered input-sm w-full"
                            @change="updateUnion({ cssClass: $event.target.value.trim() || null })"
                        />
                    </div>

                    <button
                        type="button"
                        class="btn2 btn-sm btn-error btn-outline w-full mt-2"
                        @click="$emit('delete-union', union.id)"
                    >
                        <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                        {{ texts?.inspector?.delete_union || 'Remove partnership' }}
                    </button>
                </template>
            </div>
        </template>

        <!-- LINK INSPECTOR -->
        <template v-else-if="selection.type === 'link' && link">
            <div class="flex flex-col gap-3">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.kind || 'Lineage type' }}</label>
                    <select
                        class="select select-bordered select-sm w-full"
                        :disabled="!isEditing"
                        :value="link.kind || 'biological'"
                        @change="updateLink({ kind: $event.target.value })"
                    >
                        <option v-for="(label, key) in texts?.link_kinds || {}" :key="key" :value="key">{{ label }}</option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium">{{ texts?.inspector?.label || 'Label' }}</label>
                    <input
                        :value="link.label || ''"
                        type="text"
                        maxlength="70"
                        class="input input-bordered input-sm w-full"
                        :disabled="!isEditing"
                        @change="updateLink({ label: $event.target.value.trim() || null })"
                    />
                </div>

                <template v-if="isEditing">
                    <div class="grid grid-cols-2 gap-2.5">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-medium">{{ texts?.inspector?.colour || 'Colour' }}</label>
                            <ColourPicker
                                :model-value="link.colour || null"
                                @update:model-value="updateLink({ colour: $event })"
                            />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-medium">{{ texts?.inspector?.visibility || 'Visibility' }}</label>
                            <select
                                class="select select-bordered select-sm w-full"
                                :value="link.visibility ?? 1"
                                @change="updateLink({ visibility: Number($event.target.value) })"
                            >
                                <option value="1">{{ texts?.modals?.fields?.visibility?.all || 'All' }}</option>
                                <option value="5">{{ texts?.modals?.fields?.visibility?.members || 'Members' }}</option>
                                <option value="2">{{ texts?.modals?.fields?.visibility?.admins || 'Admins' }}</option>
                            </select>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="btn2 btn-sm btn-error btn-outline w-full mt-2"
                        @click="$emit('delete-link', link.id)"
                    >
                        <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                        {{ texts?.inspector?.delete_link || 'Remove link' }}
                    </button>
                </template>
            </div>
        </template>
    </aside>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import axios from 'axios';
import ColourPicker from './ColourPicker.vue';

const props = defineProps({
    selection: { type: Object, default: null },
    graph: { type: Object, required: true },
    entities: { type: Object, default: () => ({}) },
    linkedTreesMap: { type: Object, default: () => ({}) },
    texts: { type: Object, default: () => ({}) },
    isEditing: { type: Boolean, default: false },
    canCreateCharacter: { type: Boolean, default: false },
    searchApi: { type: String, required: true },
    promoteApi: { type: String, required: true },
});

const emit = defineEmits([
    'close',
    'update-person',
    'update-union',
    'update-link',
    'delete-person',
    'delete-union',
    'delete-link',
    'quick-add',
    'link-character',
    'promote-character',
]);

const placeholderName = ref('');
const placeholderSubtitle = ref('');
const charQuery = ref('');
const charResults = ref([]);
const isPromoting = ref(false);
let searchTimer = null;

const person = computed(() =>
    props.selection?.type === 'person'
        ? props.graph.people?.find((p) => p.id === props.selection.id) || null
        : null
);

const union = computed(() =>
    props.selection?.type === 'union'
        ? props.graph.unions?.find((u) => u.id === props.selection.id) || null
        : null
);

const link = computed(() =>
    props.selection?.type === 'link'
        ? props.graph.links?.find((l) => l.id === props.selection.id) || null
        : null
);

const entity = computed(() => (person.value?.entity_id ? props.entities[person.value.entity_id] || null : null));
const linkedTrees = computed(() => (person.value?.entity_id ? props.linkedTreesMap[person.value.entity_id] || [] : []));

watch(
    person,
    (p) => {
        placeholderName.value = p?.placeholder?.name || '';
        placeholderSubtitle.value = p?.placeholder?.subtitle || '';
        charQuery.value = '';
        charResults.value = [];
    },
    { immediate: true }
);

const headerTitle = computed(() => {
    if (props.selection?.type === 'union') {
        return props.texts?.inspector?.union_title || 'Partnership';
    }
    if (props.selection?.type === 'link') {
        return props.texts?.inspector?.link_title || 'Parent-Child Link';
    }
    return props.texts?.inspector?.person_title || 'Person';
});

function updatePerson(patch) {
    if (person.value) {
        emit('update-person', { id: person.value.id, patch });
    }
}

function updateUnion(patch) {
    if (union.value) {
        emit('update-union', { id: union.value.id, patch });
    }
}

function updateLink(patch) {
    if (link.value) {
        emit('update-link', { id: link.value.id, patch });
    }
}

function savePlaceholderFields() {
    updatePerson({
        placeholder: {
            name: placeholderName.value.trim(),
            subtitle: placeholderSubtitle.value.trim(),
        },
    });
}

function convertToPlaceholder() {
    const currentName = entity.value?.name || '';
    updatePerson({
        entity_id: null,
        placeholder: { name: currentName, subtitle: '' },
    });
}

function onCharSearch() {
    clearTimeout(searchTimer);
    const term = charQuery.value.trim();
    if (!term) {
        charResults.value = [];
        return;
    }
    searchTimer = setTimeout(async () => {
        try {
            const resp = await axios.get(props.searchApi, { params: { q: term } });
            charResults.value = Array.isArray(resp.data) ? resp.data : resp.data?.results || [];
        } catch {
            charResults.value = [];
        }
    }, 220);
}

function linkCharacter(entityId) {
    if (person.value) {
        emit('link-character', { personId: person.value.id, entityId: Number(entityId) });
    }
}

async function promoteToCharacter() {
    if (!person.value || !placeholderName.value.trim() || isPromoting.value) {
        return;
    }
    isPromoting.value = true;
    try {
        const resp = await axios.post(props.promoteApi, {
            name: placeholderName.value.trim(),
            add_to_family: true,
        });
        if (resp.status === 201 && resp.data?.id) {
            emit('promote-character', { personId: person.value.id, entity: resp.data });
        }
    } finally {
        isPromoting.value = false;
    }
}
</script>
