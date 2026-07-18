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
                <div
                    class="w-10 h-10 rounded-lg flex items-center justify-center flex-none"
                    :style="{ backgroundColor: colour }"
                >
                    <i :class="iconState.icon?.value || 'fa-solid fa-map-pin'" class="text-white" aria-hidden="true" />
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ isEdit ? i18n.edit_template : i18n.new_template }}</p>
                    <h2 class="text-lg font-semibold truncate">{{ name || i18n.untitled_template }}</h2>
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
                    :placeholder="i18n.template_name_placeholder"
                />
            </div>

            <ColourPicker :colour="colour" :label="i18n.colour" @change="colour = $event" />

            <ShapePicker
                v-if="sourceShape !== 'label' && sourceShape !== 'path'"
                :pin="iconState"
                :boosted="boosted"
                :i18n="i18n"
                @change="handleIconChange"
            />

            <OpacityPicker :pin="{ opacity }" :i18n="i18n" @change="opacity = $event" />

            <div class="flex flex-col gap-1">
                <label class="flex items-start gap-2 cursor-pointer">
                    <input v-model="isDraggable" type="checkbox" class="checkbox checkbox-sm mt-0.5" />
                    <span class="text-sm">{{ i18n.is_draggable }}</span>
                </label>
                <p class="text-xs text-neutral-content">{{ i18n.is_draggable_help }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.css_class }}</label>
                <input v-model="cssClass" type="text" maxlength="45" class="input input-bordered w-full" />
                <p class="text-xs text-neutral-content">{{ i18n.css_class_help }}</p>
            </div>

            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </article>

        <footer class="p-4 md:px-6">
            <menu class="flex justify-between gap-3">
                <button
                    v-if="isEdit"
                    type="button"
                    class="btn2 btn-error btn-outline"
                    :disabled="saving || deleting"
                    @click="handleDelete"
                >
                    {{ confirmingDelete ? i18n.delete_confirm : i18n.delete_template }}
                </button>
                <div v-else />

                <div class="flex gap-3">
                    <button type="button" class="btn2 btn-default" :disabled="saving || deleting" @click="closeDialog">
                        {{ i18n.cancel }}
                    </button>
                    <button type="button" class="btn2 btn-primary" :disabled="saving || deleting" @click="submit">
                        {{ isEdit ? i18n.save_changes : i18n.create_template }}
                    </button>
                </div>
            </menu>
        </footer>
    </dialog>
</template>

<script setup>
import { computed, nextTick, ref } from "vue";
import { pinIconFa, SHAPE_STRING_BY_ID } from "../../maps/markerIcons.js";
import ColourPicker from "./ColourPicker.vue";
import OpacityPicker from "./OpacityPicker.vue";
import ShapePicker from "./ShapePicker.vue";

const props = defineProps({
    i18n: { type: Object, required: true },
    boosted: { type: Boolean, default: false },
    storeUrl: { type: String, default: null },
});

const emit = defineEmits(["created", "updated", "deleted"]);

const dialogRef = ref(null);
const nameInputRef = ref(null);
const dialogOpen = ref(false);
const saving = ref(false);
const deleting = ref(false);
const confirmingDelete = ref(false);
const error = ref(null);
const editingPreset = ref(null);

const name = ref("");
const colour = ref("#93c5fd");
const opacity = ref(100);
const isDraggable = ref(false);
const cssClass = ref("");
const sourceShape = ref("marker");
const iconState = ref({ iconId: 1, customIcon: null, icon: { type: "fa", value: "fa-solid fa-map-pin" } });

const isEdit = computed(() => !!editingPreset.value);

function resetState() {
    error.value = null;
    saving.value = false;
    deleting.value = false;
    confirmingDelete.value = false;
}

async function showDialog() {
    dialogOpen.value = true;
    dialogRef.value?.showModal();

    await nextTick();
    nameInputRef.value?.focus();
}

// Seeds every field from the marker currently being created — the modal is otherwise a
// self-contained mini form the user can freely tweak before saving, independent of the
// in-progress draft (nothing here writes back to it).
async function open(sourcePin) {
    editingPreset.value = null;
    name.value = "";
    colour.value = sourcePin.colour || "#93c5fd";
    opacity.value = sourcePin.opacity ?? 100;
    isDraggable.value = !!sourcePin.isDraggable;
    cssClass.value = sourcePin.css || "";
    sourceShape.value = sourcePin.shape;
    iconState.value = {
        iconId: sourcePin.iconId,
        customIcon: sourcePin.customIcon,
        icon: sourcePin.icon,
    };
    resetState();
    await showDialog();
}

// Seeds every field from an existing preset's config, for the "Manage" edit flow.
async function openEdit(preset) {
    const config = preset.config || {};

    editingPreset.value = preset;
    name.value = preset.name || "";
    colour.value = config.colour || "#93c5fd";
    opacity.value = config.opacity ?? 100;
    isDraggable.value = !!config.is_draggable;
    cssClass.value = config.css || "";
    sourceShape.value = SHAPE_STRING_BY_ID[config.shape_id] || "marker";
    iconState.value = {
        iconId: config.icon,
        customIcon: config.custom_icon || null,
        icon: { type: "fa", value: pinIconFa(config.icon, config.custom_icon) },
    };
    resetState();
    await showDialog();
}

function closeDialog() {
    dialogRef.value?.close();
}

function handleIconChange(payload) {
    iconState.value = { iconId: payload.icon, customIcon: payload.custom_icon, icon: payload.render };
}

async function submit() {
    if (!name.value.trim()) {
        error.value = props.i18n.error_template_name_required;

        return;
    }

    saving.value = true;
    error.value = null;

    try {
        const payload = {
            name: name.value.trim(),
            shape: sourceShape.value,
            colour: colour.value,
            icon: iconState.value.iconId,
            custom_icon: iconState.value.customIcon,
            opacity: opacity.value,
            is_draggable: isDraggable.value,
            css: cssClass.value.trim() || null,
        };
        const res = isEdit.value
            ? await axios.patch(editingPreset.value.update_url, payload)
            : await axios.post(props.storeUrl, payload);

        emit(isEdit.value ? "updated" : "created", res.data);
        closeDialog();
    } catch (e) {
        error.value = props.i18n.error_save_template;
    } finally {
        saving.value = false;
    }
}

async function handleDelete() {
    if (!confirmingDelete.value) {
        confirmingDelete.value = true;
        error.value = null;

        return;
    }

    deleting.value = true;
    try {
        const res = await axios.delete(editingPreset.value.destroy_url);
        if (res.status === 204) {
            emit("deleted", editingPreset.value);
            closeDialog();
        }
    } catch (e) {
        confirmingDelete.value = false;
        error.value = props.i18n.error_delete_template;
    } finally {
        deleting.value = false;
    }
}

defineExpose({ open, openEdit });
</script>
