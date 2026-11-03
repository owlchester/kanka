<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { VueDraggableNext as Draggable } from 'vue-draggable-next';
import EntityPicker from './ParticipantPicker.vue';

const props = defineProps({ initial: Object, editable: Boolean, staged: Boolean, saveUrl: String, searchUrl: String, labels: Object });
const state = ref(JSON.parse(JSON.stringify(props.initial)));
const confirmed = ref(JSON.stringify(state.value));
const saving = ref(false);
const error = ref('');
const fieldErrors = ref({});
const saved = ref(false);
const picker = ref(undefined);
const groupName = ref('');
const addingGroup = ref(false);
const groupNameInput = ref(null);
const moveAnnouncement = ref('');
const l = props.labels;
const dirty = computed(() => JSON.stringify(state.value) !== confirmed.value);
const sections = computed(() => [
    ...state.value.groups.map(group => ({ ...group, members: state.value.participants.filter(p => p.group === group.key) })),
    { key: null, name: state.value.groups.length ? l.other : l.title, colour: null, members: state.value.participants.filter(p => p.group === null) },
]);
const stagedValue = computed(() => JSON.stringify(state.value));
watch(state, () => { if (props.staged) window.entityFormHasUnsavedChanges = true; }, { deep: true });

function payload() {
    return {
        revision: state.value.revision,
        groups: state.value.groups.map(({ key, name, colour }) => ({ key, name, colour: colour || null })),
        participants: state.value.participants.map(({ entity_id, group, role }) => ({ entity_id, group, role: role || null })),
    };
}

async function save() {
    if (props.staged || saving.value || !dirty.value) return;
    saving.value = true;
    saved.value = false;
    error.value = '';
    fieldErrors.value = {};
    try {
        const response = await window.axios.put(props.saveUrl, payload(), { headers: { Accept: 'application/json' } });
        state.value = response.data;
        confirmed.value = JSON.stringify(state.value);
        saved.value = true;
    } catch (err) {
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

function removeGroup(group) {
    if (!window.confirm(l.delete_group_confirm)) return;
    state.value.participants.forEach(p => { if (p.group === group.key) p.group = null; });
    state.value.groups = state.value.groups.filter(g => g.key !== group.key);
    save();
}

function editGroup(key, field, value) {
    const group = state.value.groups.find(g => g.key === key);
    if (group) group[field] = value;
    save();
}

function reorderGroup(key, direction) {
    const index = state.value.groups.findIndex(g => g.key === key);
    const target = index + direction;
    if (target < 0 || target >= state.value.groups.length) return;
    const groups = state.value.groups;
    [groups[index], groups[target]] = [groups[target], groups[index]];
    save();
}

function reorderParticipant(participant, direction) {
    const members = state.value.participants.filter(p => p.group === participant.group);
    const index = members.indexOf(participant);
    const neighbour = members[index + direction];
    if (!neighbour) return;
    const all = state.value.participants;
    const a = all.indexOf(participant), b = all.indexOf(neighbour);
    [all[a], all[b]] = [all[b], all[a]];
    save();
}

function addParticipants(entities) {
    for (const entity of entities) {
        if (!state.value.participants.some(p => p.entity_id === entity.entity_id)) {
            state.value.participants.push({ ...entity, group: picker.value, role: '' });
        }
    }
    picker.value = undefined;
    save();
}

function removeParticipant(participant) {
    state.value.participants = state.value.participants.filter(p => p.entity_id !== participant.entity_id);
    save();
}

function participantDropped(section, event) {
    const participant = event.added?.element;
    if (!participant || saving.value || participant.group === section.key) return;
    participant.group = section.key;
    const destination = section.key === null
        ? l.other
        : state.value.groups.find(group => group.key === section.key)?.name;
    moveAnnouncement.value = `${participant.name} ${l.moved_to} ${destination || l.ungrouped}`;
    save();
}

function cancelRole(participant, event) {
    const original = JSON.parse(confirmed.value).participants.find(p => p.entity_id === participant.entity_id);
    participant.role = original?.role || '';
    event.target.blur();
}

function beforeUnload(event) {
    if (!props.staged && (dirty.value || saving.value)) {
        event.preventDefault();
        event.returnValue = '';
    }
}
window.addEventListener('beforeunload', beforeUnload);
onMounted(async () => {
    await nextTick();
    window.triggerEvent?.();
});
onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', beforeUnload);
});
</script>

<template>
    <div class="flex w-full min-w-0 flex-col gap-5">
        <input v-if="staged" type="hidden" name="event_participants" :value="stagedValue" />
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-2xl font-light">{{ l.title }}</h2>
                <p class="text-neutral-content">{{ l.helper }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-neutral-content" role="status" aria-live="polite">{{ moveAnnouncement || (saving ? l.saving : saved && !dirty ? l.saved : '') }}</span>
                <button v-if="editable" type="button" class="btn2 btn-outline btn-sm" :disabled="saving" @click="addingGroup = !addingGroup"><i class="fa-regular fa-plus" aria-hidden="true"></i> {{ l.add_group }}</button>
            </div>
        </div>

        <div v-if="error" role="alert" class="rounded-lg bg-box shadow-xs p-4 flex flex-col gap-3 text-error">
            <p>{{ error }}</p>
            <div class="flex gap-2">
                <button type="button" class="btn2 btn-sm" :disabled="saving" @click="save">{{ l.retry }}</button>
                <button type="button" class="btn2 btn-sm btn-ghost" @click="state = JSON.parse(confirmed); error = ''; fieldErrors = {}">{{ l.discard }}</button>
            </div>
        </div>

        <fieldset :disabled="saving" class="flex flex-col gap-5 min-w-0">
            <div v-if="addingGroup && editable" class="bg-box rounded-lg shadow-xs p-4 flex flex-wrap gap-2">
                <label class="sr-only" for="event-group-name">{{ l.group_name }}</label>
                <input id="event-group-name" ref="groupNameInput" v-model="groupName" type="text" class="grow min-w-0" maxlength="191" :placeholder="l.group_name" @keydown.enter.prevent="addGroup" @keydown.esc.prevent="addingGroup = false" />
                <button type="button" class="btn2 btn-primary" :disabled="!groupName.trim()" @click="addGroup">{{ l.create_group }}</button>
                <button type="button" class="btn2 btn-ghost" @click="addingGroup = false">{{ l.cancel }}</button>
            </div>

            <section v-for="(section, sectionIndex) in sections" :key="section.key ?? 'ungrouped'" class="rounded-lg shadow-xs bg-box p-4 flex flex-col gap-3" :aria-label="section.name">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0 grow">
                        <template v-if="editable && section.key">
                            <div class="clr-field btn2 btn-outline btn-sm relative shrink-0 focus-within:outline-2 focus-within:outline-offset-2">
                                <span v-if="section.colour" class="block w-4 h-4 rounded-full pointer-events-none" :style="{ backgroundColor: section.colour }" aria-hidden="true"></span>
                                <i v-else class="fa-regular fa-palette pointer-events-none" aria-hidden="true"></i>
                                <input type="text" :value="section.colour || ''" :aria-label="l.colour" :title="l.colour" class="spectrum absolute inset-0 w-full h-full opacity-0 cursor-pointer" data-append-to="body" readonly @change="editGroup(section.key, 'colour', $event.target.value || null)" />
                            </div>
                            <div class="grow min-w-0">
                                <input type="text" :value="section.name" :aria-label="l.group_name" :aria-invalid="Boolean(fieldErrors[`groups.${sectionIndex}.name`])" class="min-w-0 w-full" maxlength="191" @change="editGroup(section.key, 'name', $event.target.value)" @keydown.enter.prevent="$event.target.blur()" />
                                <p v-if="fieldErrors[`groups.${sectionIndex}.name`]" class="text-sm text-error">{{ fieldErrors[`groups.${sectionIndex}.name`][0] }}</p>
                            </div>
                        </template>
                        <h3 v-else class="text-lg font-normal" :style="section.colour ? { color: section.colour } : {}">{{ section.name }}</h3>
                        <span class="text-sm text-neutral-content">{{ section.members.length }}</span>
                    </div>
                    <div v-if="editable && section.key" class="flex items-center gap-1">
                        <button type="button" class="btn2 btn-ghost btn-xs" :aria-label="l.move_up" :disabled="sectionIndex === 0" @click="reorderGroup(section.key, -1)">↑</button>
                        <button type="button" class="btn2 btn-ghost btn-xs" :aria-label="l.move_down" :disabled="sectionIndex === state.groups.length - 1" @click="reorderGroup(section.key, 1)">↓</button>
                        <button type="button" class="btn2 btn-ghost btn-xs" :aria-label="l.delete_group" @click="removeGroup(section)">×</button>
                    </div>
                </div>

                <Draggable :list="section.members" item-key="entity_id" :group="{ name: 'event-participants', pull: true, put: true }" :sort="false" :disabled="!editable || saving" handle=".participant-drag-handle" :animation="150" :delay="150" :delay-on-touch-only="true" :touch-start-threshold="4" class="flex min-h-10 flex-col gap-2" @change="participantDropped(section, $event)">
                    <div v-for="(participant, index) in section.members" :key="participant.entity_id" class="flex flex-wrap items-center gap-2 p-2 rounded hover:bg-base-200">
                        <span v-if="editable" class="participant-drag-handle touch-none cursor-grab active:cursor-grabbing text-neutral-content" :title="l.drag_to_move"><i class="fa-regular fa-grip-dots-vertical" aria-hidden="true"></i></span>
                        <a :href="participant.url" class="flex items-center gap-3 min-w-0 grow basis-40 text-link">
                            <img v-if="participant.image" :src="participant.image" alt="" class="rounded-full w-9 h-9 object-cover shrink-0" />
                            <span class="truncate">{{ participant.name }}</span>
                        </a>
                        <template v-if="editable">
                            <input v-model="participant.role" type="text" class="min-w-0 w-36" :placeholder="l.role" :aria-label="`${l.role}: ${participant.name}`" maxlength="191" @blur="save" @keydown.enter.prevent="$event.target.blur()" @keydown.esc.prevent="cancelRole(participant, $event)" />
                            <div class="flex gap-1">
                                <button type="button" class="btn2 btn-ghost btn-xs" :aria-label="`${l.move_up}: ${participant.name}`" :disabled="index === 0" @click="reorderParticipant(participant, -1)">↑</button>
                                <button type="button" class="btn2 btn-ghost btn-xs" :aria-label="`${l.move_down}: ${participant.name}`" :disabled="index === section.members.length - 1" @click="reorderParticipant(participant, 1)">↓</button>
                                <button type="button" class="btn2 btn-ghost btn-xs" :aria-label="`${l.remove}: ${participant.name}`" @click="removeParticipant(participant)">×</button>
                            </div>
                        </template>
                        <span v-else-if="participant.role" class="text-sm text-neutral-content">{{ participant.role }}</span>
                    </div>
                </Draggable>

                <p v-if="!section.members.length" class="text-neutral-content">{{ section.key ? l.empty_group : l.empty }}</p>
                <div v-if="editable">
                    <button v-if="picker !== section.key" type="button" class="btn2 btn-outline btn-sm" @click="picker = section.key"><i class="fa-regular fa-plus" aria-hidden="true"></i> {{ l.add_many }}</button>
                    <EntityPicker v-else :search-url="searchUrl" :excluded="state.participants.map(p => p.entity_id)" :labels="l" @add="addParticipants" @close="picker = undefined" />
                </div>
            </section>
        </fieldset>
    </div>
</template>
