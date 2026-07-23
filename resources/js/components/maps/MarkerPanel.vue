<template>
    <aside
        v-if="pin"
        class="fixed z-[1150] bg-base-100 shadow-lg flex flex-col overflow-hidden md:top-4 md:right-4 md:left-auto md:w-80 md:rounded-2xl"
        :class="[
            peeked ? 'bottom-0 left-0 right-0 top-auto rounded-t-2xl' : 'inset-0',
            detailLevel === 'full' ? 'md:bottom-4' : 'md:bottom-auto',
        ]"
    >
        <div class="flex items-center justify-between gap-2 p-4">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg flex items-center justify-center flex-none"
                    :style="{ backgroundColor: pin.colour }"
                >
                    <span
                        v-if="pin.shape === 'label'"
                        class="text-white font-semibold"
                        >T</span
                    >
                    <i
                        v-else
                        :class="pin.icon?.value || 'fa-solid fa-map-pin'"
                        class="text-white"
                        aria-hidden="true"
                    />
                </div>
                <h2 class="text-sm font-semibold uppercase tracking-wide">
                    {{ isEdit ? (pin.name || i18n.new_pin) : i18n.new_pin }}
                </h2>
            </div>
            <div class="flex items-center gap-2 flex-none">
                <button
                    type="button"
                    class="btn2 btn-default btn-sm md:hidden"
                    :disabled="saving || deleting"
                    @click="peeked = !peeked"
                >
                    <i
                        :class="peeked ? 'fa-solid fa-up-right-and-down-left-from-center' : 'fa-solid fa-down-left-and-up-right-to-center'"
                        aria-hidden="true"
                    />
                    <span class="sr-only">{{ peeked ? i18n.peek_panel : i18n.peek_map }}</span>
                </button>
                <button
                    class="btn2 btn-default btn-sm"
                    :disabled="saving || deleting"
                    @click="$emit('close')"
                >
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                </button>
            </div>
        </div>

        <div v-show="!peeked" class="px-4 flex flex-col gap-3 grow min-h-0 overflow-y-auto">
            <input
                ref="nameInputRef"
                v-model="name"
                type="text"
                class="input input-bordered w-full"
                :placeholder="i18n.name_placeholder"
            />

            <PresetPicker
                v-if="detailLevel === 'full' && !isEdit"
                :presets="presets"
                :i18n="i18n"
                :can-manage="canManagePresets"
                @select="handlePresetSelect"
                @edit="handlePresetEdit"
                @save-current="handleSaveCurrent"
            />

            <ColourPicker
                v-if="detailLevel === 'full'"
                :colour="pin.colour"
                :label="i18n.colour"
                @change="$emit('colour-change', $event)"
            />

            <ColourPicker
                v-if="detailLevel === 'full' && pin.shape === 'poly'"
                :colour="pin.polygonStyle?.stroke"
                :label="i18n.border_colour"
                @change="$emit('border-colour-change', $event)"
            />

            <StrokeWidthPicker
                v-if="detailLevel === 'full' && (pin.shape === 'poly' || pin.shape === 'path')"
                :width="pin.polygonStyle?.['stroke-width'] ?? 1"
                :i18n="i18n"
                @change="$emit('stroke-width-change', $event)"
            />

            <ShapePicker
                v-if="detailLevel === 'full' && pin.shape !== 'label' && pin.shape !== 'path'"
                :pin="pin"
                :boosted="boosted"
                :i18n="i18n"
                @change="$emit('icon-change', $event)"
            />

            <GroupPicker
                v-if="detailLevel === 'full' && groups.length"
                :pin="pin"
                :groups="groups"
                :i18n="i18n"
                @change="$emit('group-change', $event)"
            />

            <EntityLinkSelect
                :pin="pin"
                :search-url="searchUrl"
                :i18n="i18n"
                @change="$emit('entity-change', $event)"
            />

            <DescriptionField
                v-if="detailLevel === 'full'"
                :pin="pin"
                :i18n="i18n"
                :mentions-url="mentionsUrl"
                :gallery-url="galleryUrl"
                :gallery-upload-url="galleryUploadUrl"
                @change="handleEntryFieldChange"
            />

            <OpacityPicker
                v-if="detailLevel === 'full'"
                :pin="pin"
                :i18n="i18n"
                @change="$emit('opacity-change', $event)"
            />

            <VisibilitySelect
                v-if="detailLevel === 'full'"
                :pin="pin"
                :options="visibilities"
                :i18n="i18n"
                @change="$emit('visibility-change', $event)"
            />

            <div v-if="detailLevel === 'full'" class="flex flex-col gap-3">
                <button
                    type="button"
                    class="text-xs font-semibold uppercase tracking-wide text-neutral-content text-left flex items-center gap-1"
                    @click="advancedOpen = !advancedOpen"
                >
                    <i
                        class="fa-solid fa-chevron-right transition-transform"
                        :class="{ 'rotate-90': advancedOpen }"
                        aria-hidden="true"
                    />
                    <span>{{ i18n.advanced }}</span>
                </button>

                <div v-if="advancedOpen" class="flex flex-col gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="flex items-start gap-2 cursor-pointer">
                            <input
                                v-model="isDraggable"
                                type="checkbox"
                                class="checkbox checkbox-sm mt-0.5"
                            />
                            <span class="text-sm">{{ i18n.is_draggable }}</span>
                        </label>
                        <p class="text-xs text-neutral-content">{{ i18n.is_draggable_help }}</p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.css_class }}</label>
                        <input
                            v-model="cssClass"
                            type="text"
                            maxlength="45"
                            class="input input-bordered w-full"
                        />
                        <p class="text-xs text-neutral-content">{{ i18n.css_class_help }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 mt-auto flex flex-col gap-2">
            <div class="flex gap-2">
                <button
                    class="btn2 btn-outline"
                    :disabled="saving || deleting"
                    @click="toggleDetailLevel"
                >
                    {{ detailLevel === "full" ? i18n.less : i18n.details }}
                </button>
                <button
                    class="btn2 btn-primary grow"
                    :disabled="saving || deleting"
                    @click="save"
                >
                    {{ isEdit ? i18n.save_changes : (rapid ? i18n.save_continue : i18n.save) }}
                </button>
            </div>

            <p v-if="!isEdit && rapid" class="text-xs text-neutral-content">
                {{ i18n.rapid_active_hint }}
            </p>

            <button
                v-if="isEdit"
                type="button"
                class="btn2 btn-error btn-outline"
                :disabled="saving || deleting"
                @click="handleDelete"
            >
                {{ confirmingDelete ? i18n.delete_confirm : i18n.delete_marker }}
            </button>

            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>

        <PresetModal
            ref="presetModalRef"
            :i18n="i18n"
            :boosted="boosted"
            :store-url="presetStoreUrl"
            @created="handlePresetCreated"
            @updated="handlePresetUpdated"
            @deleted="handlePresetDeleted"
        />
    </aside>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { pinIconFa } from "../../maps/markerIcons.js";
import { serializeVertices } from "../../maps/polygon.js";
import ColourPicker from "./ColourPicker.vue";
import DescriptionField from "./DescriptionField.vue";
import EntityLinkSelect from "./EntityLinkSelect.vue";
import GroupPicker from "./GroupPicker.vue";
import OpacityPicker from "./OpacityPicker.vue";
import PresetModal from "./PresetModal.vue";
import PresetPicker from "./PresetPicker.vue";
import ShapePicker from "./ShapePicker.vue";
import StrokeWidthPicker from "./StrokeWidthPicker.vue";
import VisibilitySelect from "./VisibilitySelect.vue";

const props = defineProps({
    pin: { type: Object, default: null },
    variant: { type: String, default: "create" },
    i18n: { type: Object, required: true },
    createUrl: { type: String, required: true },
    boosted: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    searchUrl: { type: String, required: true },
    visibilities: { type: Array, default: () => [] },
    presets: { type: Array, default: () => [] },
    presetStoreUrl: { type: String, default: null },
    canManagePresets: { type: Boolean, default: false },
    rapid: { type: Boolean, default: false },
    mentionsUrl: { type: String, default: null },
    galleryUrl: { type: String, default: null },
    galleryUploadUrl: { type: String, default: null },
});

const emit = defineEmits([
    "close",
    "created",
    "updated",
    "deleted",
    "icon-change",
    "group-change",
    "entity-change",
    "visibility-change",
    "colour-change",
    "opacity-change",
    "name-change",
    "entry-change",
    "border-colour-change",
    "stroke-width-change",
    "preset-change",
    "preset-created",
    "preset-updated",
    "preset-deleted",
]);

const name = ref("");
const saving = ref(false);
const deleting = ref(false);
const confirmingDelete = ref(false);
const error = ref(null);
const detailLevel = ref("light");
const peeked = ref(false);
const nameInputRef = ref(null);
const entryTouched = ref(false);
const advancedOpen = ref(false);
const isDraggable = ref(false);
const cssClass = ref("");
const presetModalRef = ref(null);

const isEdit = computed(() => props.variant === "edit");

watch(
    () => props.pin,
    (newPin, oldPin) => {
        if (newPin && !oldPin) {
            // Not gated on isEdit: every from-scratch draft pin (handleMapClick et al.) already
            // sets name to "" itself, so this just needs to reflect whatever the pin actually
            // has — which matters for a duplicated draft pin, whose name should carry over.
            name.value = newPin.name || "";
            error.value = null;
            saving.value = false;
            deleting.value = false;
            confirmingDelete.value = false;
            detailLevel.value = isEdit.value ? "full" : "light";
            peeked.value = false;
            entryTouched.value = false;
            advancedOpen.value = false;
            isDraggable.value = !!newPin.isDraggable;
            cssClass.value = newPin.css || "";
        }
    },
);

watch(name, (value) => {
    emit("name-change", value);
});

function toggleDetailLevel() {
    detailLevel.value = detailLevel.value === "light" ? "full" : "light";
}

function handleEntryFieldChange(value) {
    entryTouched.value = true;
    emit("entry-change", value);
}

// A preset's config only carries whatever keys the legacy preset editor happened to save
// (today: icon, custom_icon, opacity, colour — css/is_draggable/group_id aren't authorable
// yet, but are handled here too so nothing needs to change once they are). Keys missing from
// config are left untouched rather than reset, so applying a partial preset never blanks out
// fields it doesn't define.
function handlePresetSelect(preset) {
    const config = preset.config || {};

    if ("css" in config) {
        cssClass.value = config.css || "";
    }

    if ("is_draggable" in config) {
        isDraggable.value = !!config.is_draggable;
    }

    const patch = {};

    if ("colour" in config) {
        patch.colour = config.colour;
    }

    if ("opacity" in config) {
        patch.opacity = config.opacity;
    }

    if ("group_id" in config) {
        patch.groupId = config.group_id;
    }

    if ("icon" in config || "custom_icon" in config) {
        const customIcon = config.custom_icon || null;
        patch.customIcon = customIcon;
        patch.iconId = customIcon ? 1 : (Number(config.icon) || 1);
        patch.icon = { type: "fa", value: pinIconFa(config.icon, customIcon) };
    }

    if (Object.keys(patch).length) {
        emit("preset-change", patch);
    }
}

// css/is_draggable live only as local refs here (see the pin watcher above), not on
// props.pin, so the modal needs them merged in to see the marker's current values.
function handleSaveCurrent() {
    presetModalRef.value?.open({
        ...props.pin,
        css: cssClass.value,
        isDraggable: isDraggable.value,
    });
}

function handlePresetEdit(preset) {
    presetModalRef.value?.openEdit(preset);
}

function handlePresetCreated(preset) {
    emit("preset-created", preset);
}

function handlePresetUpdated(preset) {
    emit("preset-updated", preset);
}

function handlePresetDeleted(preset) {
    emit("preset-deleted", preset);
}

function buildPayload() {
    const isPolygon = props.pin.shape === "poly";
    const isPath = props.pin.shape === "path";
    const isCircle = props.pin.shape === "circle";
    const hasCustomShape = isPolygon || isPath;

    return {
        name: name.value,
        // Only send entry when creating (nothing to lose) or when the user actually
        // touched the field this session — omitting it on an untouched edit (e.g. just
        // moving the pin) avoids overwriting server-side content with a stale client copy.
        entry: (!isEdit.value || entryTouched.value) ? props.pin.entry : undefined,
        latitude: props.pin.latitude,
        longitude: props.pin.longitude,
        colour: props.pin.colour,
        shape_id: props.pin.shapeId,
        icon: props.pin.iconId,
        custom_icon: props.pin.customIcon,
        group_id: props.pin.groupId,
        entity_id: props.pin.entityId,
        visibility_id: props.pin.visibilityId,
        opacity: props.pin.opacity,
        is_draggable: isDraggable.value,
        css: cssClass.value.trim() || null,
        custom_shape: hasCustomShape ? serializeVertices(props.pin.customShape) : undefined,
        polygon_style: hasCustomShape ? props.pin.polygonStyle : undefined,
        circle_radius: isCircle ? Math.round(props.pin.circleRadius) : undefined,
    };
}

async function save() {
    if (!name.value.trim() && !props.pin.entityId) {
        error.value = props.i18n.error_name_required;
        peeked.value = false;
        nameInputRef.value?.focus();

        return;
    }

    saving.value = true;
    error.value = null;

    try {
        const payload = buildPayload();
        const res = isEdit.value
            ? await axios.patch(props.pin.update_url, payload)
            : await axios.post(props.createUrl, payload);

        emit(isEdit.value ? "updated" : "created", res.data);
    } catch (e) {
        error.value = props.i18n.error_save;
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
        const res = await axios.delete(props.pin.destroy_url);
        if (res.status === 204) {
            emit("deleted", props.pin);
        }
    } catch (e) {
        confirmingDelete.value = false;
        error.value = props.i18n.error_delete;
    } finally {
        deleting.value = false;
    }
}
</script>
