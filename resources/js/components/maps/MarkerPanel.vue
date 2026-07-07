<template>
    <aside
        v-if="pin"
        class="fixed top-4 right-4 w-80 bg-base-100 shadow-lg z-[1150] flex flex-col rounded-2xl overflow-hidden"
        :class="mode === 'full' ? 'bottom-4' : ''"
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
                    {{ i18n.new_pin }}
                </h2>
            </div>
            <button
                class="btn2 btn-default btn-sm flex-none"
                :disabled="saving"
                @click="$emit('close')"
            >
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>

        <div class="px-4 flex flex-col gap-3 grow min-h-0 overflow-y-auto">
            <input
                v-model="name"
                type="text"
                class="input input-bordered w-full"
                :placeholder="i18n.name_placeholder"
            />

            <ColourPicker
                v-if="mode === 'full'"
                :colour="pin.colour"
                :label="i18n.colour"
                @change="$emit('colour-change', $event)"
            />

            <ColourPicker
                v-if="mode === 'full' && pin.shape === 'poly'"
                :colour="pin.polygonStyle?.stroke"
                :label="i18n.border_colour"
                @change="$emit('border-colour-change', $event)"
            />

            <StrokeWidthPicker
                v-if="mode === 'full' && (pin.shape === 'poly' || pin.shape === 'path')"
                :width="pin.polygonStyle?.['stroke-width'] ?? 1"
                :i18n="i18n"
                @change="$emit('stroke-width-change', $event)"
            />

            <ShapePicker
                v-if="mode === 'full' && pin.shape !== 'label'"
                :pin="pin"
                :boosted="boosted"
                :i18n="i18n"
                @change="$emit('icon-change', $event)"
            />

            <GroupPicker
                v-if="mode === 'full' && groups.length"
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
                v-if="mode === 'full'"
                :pin="pin"
                :i18n="i18n"
                @change="$emit('opacity-change', $event)"
            />

            <VisibilitySelect
                v-if="mode === 'full'"
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
                    :disabled="saving"
                    @click="toggleMode"
                >
                    {{ mode === "full" ? i18n.less : i18n.details }}
                </button>
                <button
                    class="btn2 btn-primary grow"
                    :disabled="saving || (!name.trim() && !pin.entityId)"
                    @click="save"
                >
                    {{ rapid ? i18n.save_continue : i18n.save }}
                </button>
            </div>
            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>
    </aside>
</template>

<script setup>
import { ref, watch } from "vue";
import { serializeVertices } from "../../maps/polygon.js";
import ColourPicker from "./ColourPicker.vue";
import EntityLinkSelect from "./EntityLinkSelect.vue";
import GroupPicker from "./GroupPicker.vue";
import OpacityPicker from "./OpacityPicker.vue";
import ShapePicker from "./ShapePicker.vue";
import StrokeWidthPicker from "./StrokeWidthPicker.vue";
import VisibilitySelect from "./VisibilitySelect.vue";

const props = defineProps({
    pin: { type: Object, default: null },
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
    "icon-change",
    "group-change",
    "entity-change",
    "visibility-change",
    "colour-change",
    "opacity-change",
    "name-change",
    "border-colour-change",
    "stroke-width-change",
]);

const name = ref("");
const saving = ref(false);
const error = ref(null);
const mode = ref("light");

watch(
    () => props.pin,
    (newPin, oldPin) => {
        if (newPin && !oldPin) {
            name.value = "";
            error.value = null;
            saving.value = false;
            mode.value = "light";
        }
    },
);

watch(name, (value) => {
    emit("name-change", value);
});

function toggleMode() {
    mode.value = mode.value === "light" ? "full" : "light";
}

async function save() {
    saving.value = true;
    error.value = null;

    try {
        const isPolygon = props.pin.shape === "poly";
        const isPath = props.pin.shape === "path";
        const isCircle = props.pin.shape === "circle";
        const hasCustomShape = isPolygon || isPath;
        const res = await axios.post(props.createUrl, {
            name: name.value,
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
        });
        emit("created", res.data);
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}
</script>
