<script setup>
import { nextTick, ref } from 'vue';

const props = defineProps({
    participant: Object,
    editable: Boolean,
    staged: Boolean,
    index: Number,
    totalInGroup: Number,
    groups: Array,
    currentGroupKey: { type: String, default: null },
    menuOpen: Boolean,
    labels: Object,
});

const emit = defineEmits(['update-role', 'reorder', 'move', 'remove', 'toggle-menu']);

const editingRole = ref(false);
const roleValue = ref('');
const roleInput = ref(null);

function startEditRole() {
    if (!props.editable) return;
    editingRole.value = true;
    roleValue.value = props.participant.role || '';
    nextTick(() => roleInput.value?.focus());
}

function commitRole() {
    if (!editingRole.value) return;
    const trimmed = roleValue.value.trim();
    editingRole.value = false;
    if (trimmed === (props.participant.role || '')) return;
    emit('update-role', props.participant, trimmed);
}

function cancelRole() {
    editingRole.value = false;
}
</script>

<template>
    <div class="group/card relative flex items-start gap-3 rounded-lg border border-base-300/60 bg-base-100 p-3 transition hover:border-base-300 hover:shadow-xs">
        <span
            v-if="editable"
            class="participant-drag-handle touch-none cursor-grab active:cursor-grabbing text-neutral-content hover:text-base-content pt-2.5 shrink-0"
            :title="labels.drag_to_reorder"
        >
            <i class="fa-regular fa-grip-dots-vertical" aria-hidden="true"></i>
        </span>

        <a
            :href="participant.url"
            :target="staged ? '_blank' : undefined"
            :rel="staged ? 'noopener noreferrer' : undefined"
            class="shrink-0"
        >
            <img v-if="participant.image" :src="participant.image" alt="" class="rounded-full w-10 h-10 object-cover" />
            <span v-else class="w-10 h-10 rounded-full bg-base-200 flex items-center justify-center text-neutral-content">
                <i v-if="participant.icon" :class="participant.icon" aria-hidden="true"></i>
                <i v-else class="fa-regular fa-circle-user" aria-hidden="true"></i>
            </span>
        </a>

        <div class="min-w-0 grow flex flex-col gap-1">
            <div class="flex items-center gap-2 min-w-0">
                <a
                    :href="participant.url"
                    :target="staged ? '_blank' : undefined"
                    :rel="staged ? 'noopener noreferrer' : undefined"
                    class="font-medium text-link truncate"
                >
                    {{ participant.name }}
                </a>
                <span v-if="participant.type" class="text-xs text-neutral-content bg-base-200/80 px-1.5 py-0.5 rounded shrink-0">
                    {{ participant.type }}
                </span>
            </div>

            <template v-if="editable && editingRole">
                <input
                    ref="roleInput"
                    v-model="roleValue"
                    type="text"
                    class="w-full min-w-0 h-7 text-sm"
                    :placeholder="labels.role"
                    :aria-label="`${labels.role}: ${participant.name}`"
                    maxlength="191"
                    @blur="commitRole"
                    @keydown.enter.prevent="commitRole"
                    @keydown.esc.prevent="cancelRole"
                />
            </template>
            <template v-else-if="editable">
                <button
                    v-if="participant.role"
                    type="button"
                    class="self-start text-xs bg-base-200 hover:bg-base-300/70 text-base-content px-2 py-0.5 rounded-full truncate max-w-full transition cursor-pointer"
                    @click="startEditRole"
                >
                    {{ participant.role }}
                </button>
                <button
                    v-else
                    type="button"
                    class="self-start text-xs text-neutral-content hover:text-base-content opacity-100 md:opacity-0 md:group-hover/card:opacity-100 md:focus-visible:opacity-100 transition cursor-pointer"
                    @click="startEditRole"
                >
                    <i class="fa-regular fa-plus text-[10px]" aria-hidden="true"></i>
                    {{ labels.add_role }}
                </button>
            </template>
            <span v-else-if="participant.role" class="self-start text-xs bg-base-200 text-neutral-content px-2 py-0.5 rounded-full truncate max-w-full">
                {{ participant.role }}
            </span>
        </div>

        <div v-if="editable" class="flex items-center gap-0.5 shrink-0">
            <div class="relative js-participant-menu">
                <button
                    type="button"
                    class="btn2 btn-ghost btn-xs px-1.5 text-neutral-content"
                    :aria-label="`${labels.more_actions}: ${participant.name}`"
                    :aria-expanded="menuOpen"
                    @click.stop="emit('toggle-menu', participant.entity_id)"
                >
                    <i class="fa-regular fa-ellipsis-vertical" aria-hidden="true"></i>
                </button>
                <div
                    v-if="menuOpen"
                    class="absolute right-0 top-full mt-1 z-30 w-48 rounded-lg border border-base-300 bg-base-100 p-1 shadow-md flex flex-col text-sm"
                    role="menu"
                >
                    <button v-if="index > 0" type="button" class="flex items-center gap-2 rounded px-2.5 py-1.5 text-left hover:bg-base-200" role="menuitem" @click="emit('reorder', participant, -1)">
                        <i class="fa-regular fa-arrow-up w-4 text-center text-neutral-content" aria-hidden="true"></i>
                        {{ labels.move_up }}
                    </button>
                    <button v-if="index < totalInGroup - 1" type="button" class="flex items-center gap-2 rounded px-2.5 py-1.5 text-left hover:bg-base-200" role="menuitem" @click="emit('reorder', participant, 1)">
                        <i class="fa-regular fa-arrow-down w-4 text-center text-neutral-content" aria-hidden="true"></i>
                        {{ labels.move_down }}
                    </button>
                    <template v-if="groups.length">
                        <div class="px-2.5 pt-1.5 pb-1 text-xs font-medium text-neutral-content uppercase tracking-wide">
                            {{ labels.move_to_group }}
                        </div>
                        <button
                            v-for="target in groups.filter(g => g.key !== currentGroupKey)"
                            :key="target.key"
                            type="button"
                            class="flex items-center gap-2 rounded px-2.5 py-1.5 text-left hover:bg-base-200 truncate"
                            role="menuitem"
                            @click="emit('move', participant, target.key)"
                        >
                            <span class="w-2.5 h-2.5 rounded-full shrink-0" :style="{ backgroundColor: target.colour || 'currentColor' }"></span>
                            <span class="truncate">{{ target.name }}</span>
                        </button>
                        <button
                            v-if="currentGroupKey !== null"
                            type="button"
                            class="flex items-center gap-2 rounded px-2.5 py-1.5 text-left hover:bg-base-200"
                            role="menuitem"
                            @click="emit('move', participant, null)"
                        >
                            <i class="fa-regular fa-folder-minus w-4 text-center text-neutral-content" aria-hidden="true"></i>
                            {{ labels.ungrouped }}
                        </button>
                    </template>
                    <button type="button" class="flex items-center gap-2 rounded px-2.5 py-1.5 text-left text-error-content hover:bg-base-200 mt-1 border-t border-base-200 pt-2" role="menuitem" @click="emit('remove', participant)">
                        <i class="fa-regular fa-xmark w-4 text-center" aria-hidden="true"></i>
                        {{ labels.remove }}
                    </button>
                </div>
            </div>
            <button
                type="button"
                class="btn2 btn-ghost btn-xs px-1.5 text-neutral-content hover:text-error-content opacity-100 md:opacity-0 md:group-hover/card:opacity-100 md:focus-visible:opacity-100 transition"
                :aria-label="`${labels.remove}: ${participant.name}`"
                @click="emit('remove', participant)"
            >
                <i class="fa-regular fa-xmark" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</template>
