<template>
    <dialog
        ref="dialogRef"
        class="dialog rounded-2xl bg-base-100 text-base-content w-full md:w-[32rem]"
        aria-modal="true"
        @close="dialogOpen = false"
        @click.self="closeDialog"
    >
        <header class="flex gap-4 items-center p-4 md:p-6 justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-lg flex-none" :style="{ backgroundColor: colour }" />
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.new_group }}</p>
                    <h2 class="text-lg font-semibold truncate">{{ name || i18n.untitled_group }}</h2>
                </div>
            </div>
            <button type="button" class="btn2 btn-default btn-sm flex-none" @click="closeDialog">
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </header>

        <article class="p-4 md:p-6 flex flex-col gap-3 w-full overflow-x-hidden">
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.name }}</label>
                <input
                    ref="nameInputRef"
                    v-model="name"
                    type="text"
                    class="input input-bordered w-full"
                    :placeholder="i18n.group_name_placeholder"
                />
            </div>

            <ColourPicker :colour="colour" :label="i18n.colour" @change="colour = $event" />

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.parent_group }}</label>
                <select class="select select-bordered w-full" :value="parentId ?? ''" @change="onParentChange">
                    <option value="">{{ i18n.top_level }}</option>
                    <option v-for="group in groups" :key="group.id" :value="group.id">{{ group.name }}</option>
                </select>
            </div>

            <div v-if="siblings.length" class="flex flex-col gap-1">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.placement }}</label>
                <select class="select select-bordered w-full" :value="afterId ?? ''" @change="onAfterChange">
                    <option value="">{{ i18n.placement_first }}</option>
                    <option v-for="sibling in siblings" :key="sibling.id" :value="sibling.id">
                        {{ i18n.placement_after.replace(':name', sibling.name) }}
                    </option>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="flex items-start gap-2 cursor-pointer">
                    <input v-model="isShown" type="checkbox" class="checkbox checkbox-sm mt-0.5" />
                    <span class="text-sm">{{ i18n.show_group_marker }}</span>
                </label>
                <p class="text-xs text-neutral-content">{{ i18n.show_group_marker_help }}</p>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.visibility }}</label>
                <select class="select select-bordered w-full" :value="visibilityId" @change="onVisibilityChange">
                    <option v-for="option in visibilities" :key="option.id" :value="option.id">{{ option.name }}</option>
                </select>
            </div>

            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </article>

        <footer class="p-4 md:px-6">
            <menu class="flex justify-end gap-3">
                <button type="button" class="btn2 btn-default" :disabled="saving" @click="closeDialog">
                    {{ i18n.cancel }}
                </button>
                <button type="button" class="btn2 btn-primary" :disabled="saving" @click="submit">
                    {{ i18n.create_group }}
                </button>
            </menu>
        </footer>
    </dialog>
</template>

<script setup>
import { computed, nextTick, ref } from "vue";
import { sortGroups } from "../../maps/groupTree.js";
import ColourPicker from "./ColourPicker.vue";

const props = defineProps({
    i18n: { type: Object, required: true },
    groups: { type: Array, default: () => [] },
    visibilities: { type: Array, default: () => [] },
    groupStoreUrl: { type: String, default: null },
});

const emit = defineEmits(["created"]);

const dialogRef = ref(null);
const nameInputRef = ref(null);
const dialogOpen = ref(false);
const saving = ref(false);
const error = ref(null);

const name = ref("");
const colour = ref("#93c5fd");
const parentId = ref(null);
const afterId = ref(null);
const isShown = ref(false);
const visibilityId = ref(null);

const siblings = computed(() =>
    sortGroups(props.groups.filter((group) => (group.parent_id ?? null) === parentId.value)),
);

function resetState(defaultVisibilityId) {
    name.value = "";
    colour.value = "#93c5fd";
    parentId.value = null;
    afterId.value = null;
    isShown.value = false;
    visibilityId.value = defaultVisibilityId ?? props.visibilities[0]?.id ?? null;
    error.value = null;
    saving.value = false;
}

async function open(defaultVisibilityId) {
    resetState(defaultVisibilityId);
    dialogOpen.value = true;
    dialogRef.value?.showModal();

    await nextTick();
    nameInputRef.value?.focus();
}

function closeDialog() {
    dialogRef.value?.close();
}

function onParentChange(event) {
    const value = event.target.value;
    parentId.value = value === "" ? null : Number(value);
    // The sibling list depends on the chosen parent, so any previously chosen "after"
    // placement no longer refers to a sibling in scope.
    afterId.value = null;
}

function onAfterChange(event) {
    const value = event.target.value;
    afterId.value = value === "" ? null : Number(value);
}

function onVisibilityChange(event) {
    visibilityId.value = Number(event.target.value);
}

async function submit() {
    if (!name.value.trim()) {
        error.value = props.i18n.error_group_name_required;

        return;
    }

    saving.value = true;
    error.value = null;

    try {
        const payload = {
            name: name.value.trim(),
            colour: colour.value,
            parent_id: parentId.value,
            after_id: afterId.value,
            is_shown: isShown.value,
            visibility_id: visibilityId.value,
        };
        const res = await axios.post(props.groupStoreUrl, payload);

        emit("created", res.data);
        closeDialog();
    } catch (e) {
        error.value = props.i18n.error_save_group;
    } finally {
        saving.value = false;
    }
}

defineExpose({ open });
</script>
