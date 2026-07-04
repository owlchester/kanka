<template>
    <aside
        v-if="pin"
        class="fixed top-4 right-4 bottom-4 w-80 bg-base-100 shadow-lg z-[1150] flex flex-col rounded-2xl overflow-hidden"
    >
        <div class="flex items-center justify-between gap-2 p-4">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg flex items-center justify-center flex-none"
                    :style="{ backgroundColor: pin.colour }"
                >
                    <i :class="pin.icon?.value || 'fa-solid fa-map-pin'" class="text-white" aria-hidden="true" />
                </div>
                <h2 class="text-sm font-semibold uppercase tracking-wide">{{ i18n.new_pin }}</h2>
            </div>
            <button class="btn2 btn-default btn-sm flex-none" :disabled="saving" @click="$emit('close')">
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>

        <div class="px-4 flex flex-col gap-2 grow min-h-0 overflow-y-auto">
            <input
                v-model="name"
                type="text"
                class="input input-bordered w-full"
                :placeholder="i18n.name_placeholder"
            />

            <ShapePicker
                v-if="mode === 'full'"
                :pin="pin"
                :boosted="boosted"
                :i18n="i18n"
                @change="$emit('icon-change', $event)"
            />

            <GroupPicker
                v-if="mode === 'full'"
                :pin="pin"
                :groups="groups"
                :i18n="i18n"
                @change="$emit('group-change', $event)"
            />

            <EntityLinkSelect
                v-if="mode === 'full'"
                :pin="pin"
                :search-url="searchUrl"
                :i18n="i18n"
                @change="$emit('entity-change', $event)"
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
                <button class="btn2 btn-outline" :disabled="saving" @click="toggleMode">
                    {{ mode === "full" ? i18n.less : i18n.details }}
                </button>
                <button
                    class="btn2 btn-primary grow"
                    :disabled="saving || !name.trim()"
                    @click="save"
                >
                    {{ i18n.save }}
                </button>
            </div>
            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>
    </aside>
</template>

<script setup>
import { ref, watch } from "vue";
import EntityLinkSelect from "./EntityLinkSelect.vue";
import GroupPicker from "./GroupPicker.vue";
import ShapePicker from "./ShapePicker.vue";
import VisibilitySelect from "./VisibilitySelect.vue";

const props = defineProps({
    pin: { type: Object, default: null },
    i18n: { type: Object, required: true },
    createUrl: { type: String, required: true },
    boosted: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    searchUrl: { type: String, required: true },
    visibilities: { type: Array, default: () => [] },
});

const emit = defineEmits(["close", "created", "icon-change", "group-change", "entity-change", "visibility-change"]);

const name = ref("");
const saving = ref(false);
const error = ref(null);
const mode = ref("light");

watch(() => props.pin, (newPin, oldPin) => {
    if (newPin && !oldPin) {
        name.value = "";
        error.value = null;
        saving.value = false;
        mode.value = "light";
    }
});

function toggleMode() {
    mode.value = mode.value === "light" ? "full" : "light";
}

async function save() {
    saving.value = true;
    error.value = null;

    try {
        const res = await axios.post(props.createUrl, {
            name: name.value,
            latitude: props.pin.latitude,
            longitude: props.pin.longitude,
            colour: props.pin.colour,
            shape_id: 1,
            icon: props.pin.iconId,
            custom_icon: props.pin.customIcon,
            group_id: props.pin.groupId,
            entity_id: props.pin.entityId,
            visibility_id: props.pin.visibilityId,
        });
        emit("created", res.data);
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}
</script>
