<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { VueDraggableNext as Draggable } from 'vue-draggable-next';
import ParticipantCard from './ParticipantCard.vue';
import EntityPicker from './ParticipantPicker.vue';
import {
    mergeParticipants,
    moveParticipantToGroup,
    removeGroupAndUngroup,
    reorderGroups,
    reorderWithinGroup,
    syncSectionOrder,
} from './participantState.js';

const props = defineProps({ initial: Object, editable: Boolean, staged: Boolean, saveUrl: String, searchUrl: String, labels: Object });
const state = ref(JSON.parse(JSON.stringify(props.initial)));
const confirmed = ref(JSON.stringify(state.value));
const saving = ref(false);
const pendingSave = ref(false);
const error = ref('');
const fieldErrors = ref({});
const saved = ref(false);
const picker = ref(undefined);
const groupName = ref('');
const addingGroup = ref(false);
const groupNameInput = ref(null);
const moveAnnouncement = ref('');

const editingGroupKey = ref(null);
const editingGroupName = ref('');
const groupTitleInput = ref(null);
const confirmingDeleteGroupKey = ref(null);
const collapsedGroups = ref({});

const openGroupMenuKey = ref(null);
const openParticipantMenuId = ref(null);
const draggingParticipant = ref(false);

const l = props.labels;
const dirty = computed(() => JSON.stringify(state.value) !== confirmed.value);
const isEmptyState = computed(() => (
    state.value.participants.length === 0
    && state.value.groups.length === 0
    && !addingGroup.value
    && picker.value === undefined
));
const membersByGroup = computed(() => {
    const map = { __ungrouped: [] };
    for (const group of state.value.groups) {
        map[group.key] = [];
    }
    for (const participant of state.value.participants) {
        const key = participant.group && map[participant.group] ? participant.group : '__ungrouped';
        map[key].push(participant);
    }
    return map;
});
const ungroupedMembers = computed(() => membersByGroup.value.__ungrouped);
const showUngroupedCard = computed(() => (
    state.value.groups.length === 0
    || ungroupedMembers.value.length > 0
    || picker.value === null
    || draggingParticipant.value
));
const ungroupedTitle = computed(() => (state.value.groups.length ? l.other : l.title));
const stagedValue = computed(() => JSON.stringify(state.value));

watch(state, () => {
    if (props.staged) window.entityFormHasUnsavedChanges = true;
}, { deep: true });

function payload() {
    return {
        revision: state.value.revision,
        groups: state.value.groups.map(({ key, name, colour }) => ({ key, name, colour: colour || null })),
        participants: state.value.participants.map(({ entity_id, group, role }) => ({ entity_id, group, role: role || null })),
    };
}

function remapNewGroupKeys(sentGroups, serverGroups) {
    const keyMap = new Map();
    sentGroups.forEach((sentGroup, index) => {
        const serverGroup = serverGroups[index];
        if (sentGroup.key?.startsWith('new-') && serverGroup?.key) {
            keyMap.set(sentGroup.key, serverGroup.key);
        }
    });
    if (!keyMap.size) return;

    state.value.groups.forEach(group => {
        if (keyMap.has(group.key)) {
            group.key = keyMap.get(group.key);
        }
    });
    state.value.participants.forEach(participant => {
        if (participant.group && keyMap.has(participant.group)) {
            participant.group = keyMap.get(participant.group);
        }
    });
}

async function save() {
    if (props.staged || !dirty.value) return;
    if (saving.value) {
        pendingSave.value = true;
        return;
    }

    saving.value = true;
    saved.value = false;
    error.value = '';
    fieldErrors.value = {};
    const sentPayload = payload();

    try {
        const response = await window.axios.put(props.saveUrl, sentPayload, { headers: { Accept: 'application/json' } });
        if (pendingSave.value) {
            state.value.revision = response.data.revision;
            remapNewGroupKeys(sentPayload.groups, response.data.groups || []);
            pendingSave.value = false;
            saving.value = false;
            await save();
            return;
        }
        state.value = response.data;
        confirmed.value = JSON.stringify(state.value);
        saved.value = true;
    } catch (err) {
        pendingSave.value = false;
        const errors = err.response?.data?.errors;
        fieldErrors.value = errors || {};
        error.value = errors ? Object.values(errors).flat().join(' ') : err.response?.status === 409 ? l.conflict : l.save_failed;
    } finally {
        saving.value = false;
    }
}

function addGroup() {
    if (!groupName.value.trim()) return;
    const key = `new-${Date.now().toString(36)}-${Math.random().toString(36).slice(2)}`;
    state.value.groups.push({ key, name: groupName.value.trim(), colour: null });
    groupName.value = '';
    addingGroup.value = false;
    save();
}

watch(addingGroup, async (open) => {
    if (open) {
        await nextTick();
        groupNameInput.value?.focus();
    }
});

watch(() => state.value.groups.length, async () => {
    await nextTick();
    window.triggerEvent?.();
});

function startEditGroup(group) {
    openGroupMenuKey.value = null;
    editingGroupKey.value = group.key;
    editingGroupName.value = group.name;
    nextTick(() => {
        const el = Array.isArray(groupTitleInput.value) ? groupTitleInput.value[0] : groupTitleInput.value;
        el?.focus();
        el?.select();
    });
}

function commitEditGroup(group) {
    if (editingGroupKey.value !== group.key) return;
    const trimmed = editingGroupName.value.trim();
    editingGroupKey.value = null;
    if (!trimmed || trimmed === group.name) return;
    group.name = trimmed;
    save();
}

function cancelEditGroup() {
    editingGroupKey.value = null;
}

function editGroupColour(key, value) {
    const group = state.value.groups.find(g => g.key === key);
    if (!group) return;
    group.colour = value || null;
    save();
}

function requestDeleteGroup(group) {
    openGroupMenuKey.value = null;
    confirmingDeleteGroupKey.value = group.key;
}

function confirmDeleteGroup(group) {
    confirmingDeleteGroupKey.value = null;
    const updated = removeGroupAndUngroup(state.value.groups, state.value.participants, group.key);
    state.value.groups = updated.groups;
    state.value.participants = updated.participants;
    if (picker.value === group.key) picker.value = undefined;
    save();
}

function moveGroup(key, direction) {
    openGroupMenuKey.value = null;
    state.value.groups = reorderGroups(state.value.groups, key, direction);
    save();
}

function toggleGroupCollapse(key) {
    collapsedGroups.value[key] = !collapsedGroups.value[key];
}

function addParticipants(entities) {
    const targetGroup = picker.value === undefined ? null : picker.value;
    state.value.participants = mergeParticipants(state.value.participants, entities, targetGroup);
    save();
}

function removeParticipant(participant) {
    openParticipantMenuId.value = null;
    state.value.participants = state.value.participants.filter(p => p.entity_id !== participant.entity_id);
    save();
}

function reorderParticipant(participant, direction) {
    openParticipantMenuId.value = null;
    state.value.participants = reorderWithinGroup(state.value.participants, participant.entity_id, direction);
    save();
}

function moveParticipant(participant, targetGroupKey) {
    openParticipantMenuId.value = null;
    if (participant.group === targetGroupKey) return;
    state.value.participants = moveParticipantToGroup(state.value.participants, participant.entity_id, targetGroupKey);
    const destination = targetGroupKey === null
        ? l.other
        : state.value.groups.find(group => group.key === targetGroupKey)?.name;
    moveAnnouncement.value = `${participant.name} ${l.moved_to} ${destination || l.ungrouped}`;
    save();
}

function updateParticipantRole(participant, role) {
    participant.role = role;
    save();
}

function toggleParticipantMenu(entityId) {
    openGroupMenuKey.value = null;
    openParticipantMenuId.value = openParticipantMenuId.value === entityId ? null : entityId;
}

function onParticipantChange(sectionKey, members, event) {
    if (!event.added && !event.moved) return;
    state.value.participants = syncSectionOrder(state.value.participants, sectionKey, members);
    if (event.added) {
        const participant = event.added.element;
        const destination = sectionKey === null
            ? l.other
            : state.value.groups.find(group => group.key === sectionKey)?.name;
        moveAnnouncement.value = `${participant.name} ${l.moved_to} ${destination || l.ungrouped}`;
    }
    save();
}

function closeMenus() {
    openGroupMenuKey.value = null;
    openParticipantMenuId.value = null;
}

function onDocumentClick(event) {
    if (!event.target.closest('.js-participant-menu')) {
        closeMenus();
    }
}

function onDocumentKeydown(event) {
    if (event.key === 'Escape') {
        closeMenus();
    }
}

function beforeUnload(event) {
    if (!props.staged && (dirty.value || saving.value)) {
        event.preventDefault();
        event.returnValue = '';
    }
}

window.addEventListener('beforeunload', beforeUnload);
onMounted(async () => {
    document.addEventListener('click', onDocumentClick);
    document.addEventListener('keydown', onDocumentKeydown);
    await nextTick();
    window.triggerEvent?.();
});
onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', beforeUnload);
    document.removeEventListener('click', onDocumentClick);
    document.removeEventListener('keydown', onDocumentKeydown);
});
</script>

<template>
    <div class="flex w-full min-w-0 flex-col gap-5">
        <input v-if="staged" type="hidden" name="event_participants" :value="stagedValue" />

        <div class="flex flex-wrap items-start justify-between gap-3">
            <div class="min-w-0">
                <h2 class="text-2xl font-light">{{ l.title }}</h2>
                <p class="text-neutral-content">{{ l.helper }}</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <span class="text-sm text-neutral-content italic" role="status" aria-live="polite">
                    <template v-if="staged">{{ dirty ? l.staged_hint : '' }}</template>
                    <template v-else>{{ moveAnnouncement || (saving ? l.saving : saved && !dirty ? l.saved : '') }}</template>
                </span>
                <button
                    v-if="editable && !isEmptyState"
                    type="button"
                    class="btn2 btn-outline btn-sm"
                    @click="addingGroup = true"
                >
                    <i class="fa-regular fa-plus" aria-hidden="true"></i>
                    {{ l.add_group }}
                </button>
            </div>
        </div>

        <div v-if="error" role="alert" class="rounded-lg bg-box shadow-xs p-4 flex flex-wrap items-center justify-between gap-3 text-error">
            <p>{{ error }}</p>
            <div class="flex gap-2">
                <button type="button" class="btn2 btn-sm" :disabled="saving" @click="save">{{ l.retry }}</button>
                <button type="button" class="btn2 btn-sm btn-ghost" @click="state = JSON.parse(confirmed); error = ''; fieldErrors = {}">{{ l.discard }}</button>
            </div>
        </div>

        <!-- Empty State -->
        <div v-if="isEmptyState" class="rounded-lg bg-box shadow-xs p-8 text-center flex flex-col items-center gap-3">
            <span class="w-12 h-12 rounded-full bg-base-200 flex items-center justify-center text-neutral-content">
                <i class="fa-regular fa-users text-xl" aria-hidden="true"></i>
            </span>
            <div class="max-w-md">
                <p class="font-medium">{{ l.empty }}</p>
                <p v-if="editable" class="text-sm text-neutral-content mt-1">{{ l.empty_hint }}</p>
            </div>
            <div v-if="editable" class="flex flex-wrap items-center justify-center gap-2 mt-1">
                <button type="button" class="btn2 btn-primary btn-sm" @click="picker = null">
                    <i class="fa-regular fa-plus" aria-hidden="true"></i>
                    {{ l.add_many }}
                </button>
                <button type="button" class="btn2 btn-outline btn-sm" @click="addingGroup = true">
                    <i class="fa-regular fa-folder-plus" aria-hidden="true"></i>
                    {{ l.add_group }}
                </button>
            </div>
        </div>

        <!-- Named Groups -->
        <Draggable
            v-if="state.groups.length"
            :list="state.groups"
            item-key="key"
            handle=".group-drag-handle"
            :animation="150"
            :disabled="!editable"
            class="flex flex-col gap-4"
            @end="save"
        >
            <section
                v-for="(group, groupIndex) in state.groups"
                :key="group.key"
                class="rounded-lg shadow-xs bg-box p-4 flex flex-col gap-3 transition"
                :class="[
                    group.colour ? 'border-l-4 rounded-l-none' : '',
                    draggingParticipant ? 'ring-1 ring-dashed ring-primary/30' : '',
                ]"
                :style="group.colour ? { borderLeftColor: group.colour } : {}"
                :aria-label="group.name"
            >
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2 min-w-0 grow">
                        <span
                            v-if="editable && state.groups.length > 1"
                            class="group-drag-handle touch-none cursor-grab active:cursor-grabbing text-neutral-content hover:text-base-content p-1"
                            :title="l.drag_to_reorder"
                        >
                            <i class="fa-regular fa-grip-dots-vertical" aria-hidden="true"></i>
                        </span>

                        <button
                            v-if="membersByGroup[group.key].length"
                            type="button"
                            class="btn2 btn-ghost btn-xs px-1.5 text-neutral-content"
                            :aria-label="collapsedGroups[group.key] ? l.expand_group : l.collapse_group"
                            @click="toggleGroupCollapse(group.key)"
                        >
                            <i class="fa-regular" :class="collapsedGroups[group.key] ? 'fa-chevron-right' : 'fa-chevron-down'" aria-hidden="true"></i>
                        </button>

                        <div v-if="editable" class="clr-field event-group-colour relative h-7 w-7 shrink-0 rounded-full border border-base-300 bg-base-100 flex! items-center justify-center">
                            <span v-if="group.colour" class="block w-4 h-4 rounded-full pointer-events-none" :style="{ backgroundColor: group.colour }" aria-hidden="true"></span>
                            <i v-else class="fa-regular fa-palette text-xs pointer-events-none text-neutral-content" aria-hidden="true"></i>
                            <input
                                type="text"
                                :value="group.colour || ''"
                                :aria-label="l.colour"
                                :title="l.colour"
                                class="spectrum absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                data-append-to="body"
                                readonly
                                @change="editGroupColour(group.key, $event.target.value)"
                            />
                        </div>

                        <div class="min-w-0 grow flex items-center gap-2">
                            <template v-if="editable && editingGroupKey === group.key">
                                <input
                                    ref="groupTitleInput"
                                    v-model="editingGroupName"
                                    type="text"
                                    :aria-label="l.group_name"
                                    class="h-8 min-w-0 grow max-w-sm"
                                    maxlength="191"
                                    @blur="commitEditGroup(group)"
                                    @keydown.enter.prevent="commitEditGroup(group)"
                                    @keydown.esc.prevent="cancelEditGroup"
                                />
                            </template>
                            <template v-else>
                                <h3
                                    class="text-lg font-medium truncate"
                                    :class="editable ? 'cursor-pointer hover:underline decoration-base-300 underline-offset-4' : ''"
                                    :style="group.colour ? { color: group.colour } : {}"
                                    @click="editable && startEditGroup(group)"
                                >
                                    {{ group.name }}
                                </h3>
                                <span class="text-xs font-medium text-neutral-content bg-base-200 px-2 py-0.5 rounded-full shrink-0">
                                    {{ membersByGroup[group.key].length }}
                                </span>
                            </template>
                        </div>
                    </div>

                    <div v-if="editable" class="flex items-center gap-1.5 shrink-0">
                        <button
                            type="button"
                            class="btn2 btn-outline btn-xs"
                            @click="picker = picker === group.key ? undefined : group.key"
                        >
                            <i class="fa-regular fa-plus" aria-hidden="true"></i>
                            {{ l.add_many }}
                        </button>

                        <div class="relative js-participant-menu">
                            <button
                                type="button"
                                class="btn2 btn-ghost btn-xs px-2"
                                :aria-label="l.more_actions"
                                :aria-expanded="openGroupMenuKey === group.key"
                                @click.stop="openParticipantMenuId = null; openGroupMenuKey = openGroupMenuKey === group.key ? null : group.key"
                            >
                                <i class="fa-regular fa-ellipsis-vertical" aria-hidden="true"></i>
                            </button>
                            <div
                                v-if="openGroupMenuKey === group.key"
                                class="absolute right-0 top-full mt-1 z-30 w-44 rounded-lg border border-base-300 bg-base-100 p-1 shadow-md flex flex-col text-sm"
                                role="menu"
                            >
                                <button type="button" class="flex items-center gap-2 rounded px-2.5 py-1.5 text-left hover:bg-base-200" role="menuitem" @click="startEditGroup(group)">
                                    <i class="fa-regular fa-pen w-4 text-center text-neutral-content" aria-hidden="true"></i>
                                    {{ l.edit_group }}
                                </button>
                                <button v-if="groupIndex > 0" type="button" class="flex items-center gap-2 rounded px-2.5 py-1.5 text-left hover:bg-base-200" role="menuitem" @click="moveGroup(group.key, -1)">
                                    <i class="fa-regular fa-arrow-up w-4 text-center text-neutral-content" aria-hidden="true"></i>
                                    {{ l.move_up }}
                                </button>
                                <button v-if="groupIndex < state.groups.length - 1" type="button" class="flex items-center gap-2 rounded px-2.5 py-1.5 text-left hover:bg-base-200" role="menuitem" @click="moveGroup(group.key, 1)">
                                    <i class="fa-regular fa-arrow-down w-4 text-center text-neutral-content" aria-hidden="true"></i>
                                    {{ l.move_down }}
                                </button>
                                <button type="button" class="flex items-center gap-2 rounded px-2.5 py-1.5 text-left text-error-content hover:bg-base-200" role="menuitem" @click="requestDeleteGroup(group)">
                                    <i class="fa-regular fa-trash-can w-4 text-center" aria-hidden="true"></i>
                                    {{ l.delete_group }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <p v-if="fieldErrors[`groups.${groupIndex}.name`]" class="text-sm text-error">
                    {{ fieldErrors[`groups.${groupIndex}.name`][0] }}
                </p>

                <div v-if="confirmingDeleteGroupKey === group.key" class="rounded-lg border border-error/30 bg-error/5 p-3 flex flex-wrap items-center justify-between gap-2 text-sm">
                    <span>{{ l.confirm_delete_group }}</span>
                    <div class="flex items-center gap-2">
                        <button type="button" class="btn2 btn-xs btn-error" @click="confirmDeleteGroup(group)">{{ l.confirm_delete_group_action }}</button>
                        <button type="button" class="btn2 btn-xs btn-ghost" @click="confirmingDeleteGroupKey = null">{{ l.cancel }}</button>
                    </div>
                </div>

                <EntityPicker
                    v-if="editable && picker === group.key"
                    :search-url="searchUrl"
                    :excluded="state.participants.map(p => p.entity_id)"
                    :labels="l"
                    @add="addParticipants"
                    @close="picker = undefined"
                />

                <template v-if="!collapsedGroups[group.key]">
                    <Draggable
                        :list="membersByGroup[group.key]"
                        item-key="entity_id"
                        :group="{ name: 'event-participants', pull: true, put: true }"
                        :sort="true"
                        :disabled="!editable"
                        handle=".participant-drag-handle"
                        :animation="150"
                        :delay="150"
                        :delay-on-touch-only="true"
                        :touch-start-threshold="4"
                        class="grid grid-cols-1 md:grid-cols-2 gap-3 min-h-12"
                        @start="draggingParticipant = true"
                        @end="draggingParticipant = false"
                        @change="onParticipantChange(group.key, membersByGroup[group.key], $event)"
                    >
                        <ParticipantCard
                            v-for="(participant, index) in membersByGroup[group.key]"
                            :key="participant.entity_id"
                            :participant="participant"
                            :editable="editable"
                            :staged="staged"
                            :index="index"
                            :total-in-group="membersByGroup[group.key].length"
                            :groups="state.groups"
                            :current-group-key="group.key"
                            :menu-open="openParticipantMenuId === participant.entity_id"
                            :labels="l"
                            @update-role="updateParticipantRole"
                            @reorder="reorderParticipant"
                            @move="moveParticipant"
                            @remove="removeParticipant"
                            @toggle-menu="toggleParticipantMenu"
                        />
                    </Draggable>

                    <p v-if="!membersByGroup[group.key].length && picker !== group.key" class="text-sm text-neutral-content">
                        {{ l.empty_group }}
                    </p>
                </template>
            </section>
        </Draggable>

        <!-- In-place Draft Group Creation -->
        <div v-if="addingGroup && editable" class="rounded-lg bg-box shadow-xs p-4 flex flex-wrap items-center gap-2">
            <label class="sr-only" for="event-group-name">{{ l.group_name }}</label>
            <input
                id="event-group-name"
                ref="groupNameInput"
                v-model="groupName"
                type="text"
                class="grow min-w-0"
                maxlength="191"
                :placeholder="l.group_name"
                @keydown.enter.prevent="addGroup"
                @keydown.esc.prevent="addingGroup = false"
            />
            <button type="button" class="btn2 btn-primary btn-sm" :disabled="!groupName.trim()" @click="addGroup">{{ l.create_group }}</button>
            <button type="button" class="btn2 btn-ghost btn-sm" @click="addingGroup = false">{{ l.cancel }}</button>
        </div>

        <!-- Ungrouped Section -->
        <section
            v-if="!isEmptyState && showUngroupedCard"
            class="rounded-lg shadow-xs bg-box p-4 flex flex-col gap-3 transition"
            :class="draggingParticipant ? 'ring-1 ring-dashed ring-primary/30' : ''"
            :aria-label="ungroupedTitle"
        >
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2 min-w-0">
                    <h3 class="text-lg font-medium truncate">{{ ungroupedTitle }}</h3>
                    <span class="text-xs font-medium text-neutral-content bg-base-200 px-2 py-0.5 rounded-full shrink-0">
                        {{ ungroupedMembers.length }}
                    </span>
                </div>
                <button
                    v-if="editable"
                    type="button"
                    class="btn2 btn-outline btn-xs"
                    @click="picker = picker === null ? undefined : null"
                >
                    <i class="fa-regular fa-plus" aria-hidden="true"></i>
                    {{ l.add_many }}
                </button>
            </div>

            <EntityPicker
                v-if="editable && picker === null"
                :search-url="searchUrl"
                :excluded="state.participants.map(p => p.entity_id)"
                :labels="l"
                @add="addParticipants"
                @close="picker = undefined"
            />

            <Draggable
                :list="ungroupedMembers"
                item-key="entity_id"
                :group="{ name: 'event-participants', pull: true, put: true }"
                :sort="true"
                :disabled="!editable"
                handle=".participant-drag-handle"
                :animation="150"
                :delay="150"
                :delay-on-touch-only="true"
                :touch-start-threshold="4"
                class="grid grid-cols-1 md:grid-cols-2 gap-3 min-h-12"
                @start="draggingParticipant = true"
                @end="draggingParticipant = false"
                @change="onParticipantChange(null, ungroupedMembers, $event)"
            >
                <ParticipantCard
                    v-for="(participant, index) in ungroupedMembers"
                    :key="participant.entity_id"
                    :participant="participant"
                    :editable="editable"
                    :staged="staged"
                    :index="index"
                    :total-in-group="ungroupedMembers.length"
                    :groups="state.groups"
                    :current-group-key="null"
                    :menu-open="openParticipantMenuId === participant.entity_id"
                    :labels="l"
                    @update-role="updateParticipantRole"
                    @reorder="reorderParticipant"
                    @move="moveParticipant"
                    @remove="removeParticipant"
                    @toggle-menu="toggleParticipantMenu"
                />
            </Draggable>

            <p v-if="!ungroupedMembers.length && picker !== null" class="text-sm text-neutral-content">
                {{ draggingParticipant ? l.drop_to_ungroup : l.empty }}
            </p>
        </section>

        <div v-else-if="editable && !isEmptyState && state.groups.length" class="flex justify-start">
            <button type="button" class="btn2 btn-ghost btn-sm text-neutral-content" @click="picker = null">
                <i class="fa-regular fa-plus" aria-hidden="true"></i>
                {{ l.other }}
            </button>
        </div>
    </div>
</template>

<style scoped>
:deep(.event-group-colour button) {
    top: 50% !important;
    right: 0.25rem !important;
    width: 1.25rem !important;
    height: 1.25rem !important;
    border-radius: 50% !important;
}
</style>
