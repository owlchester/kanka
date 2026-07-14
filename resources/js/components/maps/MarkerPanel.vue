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

            <DescriptionField
                v-if="detailLevel === 'full'"
                :pin="pin"
                :i18n="i18n"
                @change="$emit('entry-change', $event)"
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
    </aside>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { htmlToPlainText } from "../../maps/entryText.js";
import { serializeVertices } from "../../maps/polygon.js";
import ColourPicker from "./ColourPicker.vue";
import DescriptionField from "./DescriptionField.vue";
import EntityLinkSelect from "./EntityLinkSelect.vue";
import GroupPicker from "./GroupPicker.vue";
import OpacityPicker from "./OpacityPicker.vue";
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
    rapid: { type: Boolean, default: false },
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
]);

const name = ref("");
const saving = ref(false);
const deleting = ref(false);
const confirmingDelete = ref(false);
const error = ref(null);
const detailLevel = ref("light");
const peeked = ref(false);
const nameInputRef = ref(null);

const isEdit = computed(() => props.variant === "edit");

watch(
    () => props.pin,
    (newPin, oldPin) => {
        if (newPin && !oldPin) {
            name.value = isEdit.value ? (newPin.name || "") : "";
            error.value = null;
            saving.value = false;
            deleting.value = false;
            confirmingDelete.value = false;
            detailLevel.value = isEdit.value ? "full" : "light";
            peeked.value = false;
        }
    },
);

watch(name, (value) => {
    emit("name-change", value);
});

function toggleDetailLevel() {
    detailLevel.value = detailLevel.value === "light" ? "full" : "light";
}

function buildPayload() {
    const isPolygon = props.pin.shape === "poly";
    const isPath = props.pin.shape === "path";
    const isCircle = props.pin.shape === "circle";
    const hasCustomShape = isPolygon || isPath;

    return {
        name: name.value,
        // props.pin.entry may still be the raw HTML loaded from the server (if the user
        // never touched the description field this session) or already-plain text (if
        // they did) — htmlToPlainText() is a no-op on plain text, so this always sends
        // plain text to the backend regardless of which state it's currently in.
        entry: htmlToPlainText(props.pin.entry),
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
