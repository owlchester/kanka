<template>
    <aside
        v-if="open"
        class="fixed top-4 right-4 bottom-4 w-80 bg-base-100 shadow-lg z-[1150] flex flex-col rounded-2xl overflow-hidden"
    >
        <div class="flex items-center justify-between gap-2 p-4">
            <h2 class="text-sm font-semibold uppercase tracking-wide">
                {{ i18n.title }}
            </h2>
            <button
                class="btn2 btn-default btn-sm flex-none"
                :disabled="saving"
                @click="$emit('close')"
            >
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>

        <div class="px-4 flex flex-col gap-3 grow min-h-0 overflow-y-auto">
            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.grid }}
                <input v-model.number="form.grid" type="number" min="1" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.zoom_min }}
                <input v-model.number="form.min_zoom" type="number" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.zoom_max }}
                <input v-model.number="form.max_zoom" type="number" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.zoom_initial }}
                <input v-model.number="form.initial_zoom" type="number" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.distance_name }}
                <input v-model="form.distance_name" type="text" maxlength="20" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.distance_measure }}
                <input v-model.number="form.distance_measure" type="number" min="0.001" max="100.99" step="0.0001" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>
        </div>

        <div class="p-4 mt-auto flex flex-col gap-2">
            <button
                class="btn2 btn-primary"
                :disabled="saving"
                @click="save"
            >
                {{ i18n.save }}
            </button>
            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>
    </aside>
</template>

<script setup>
import { reactive, ref, watch } from "vue";

const props = defineProps({
    open: { type: Boolean, default: false },
    map: { type: Object, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["close", "saved"]);

const saving = ref(false);
const error = ref(null);

const form = reactive({
    grid: null,
    min_zoom: null,
    max_zoom: null,
    initial_zoom: null,
    distance_name: null,
    distance_measure: null,
});

watch(
    () => props.open,
    (isOpen) => {
        if (!isOpen) {
            return;
        }

        const settings = props.map.settings || {};
        form.grid = settings.grid;
        form.min_zoom = settings.min_zoom;
        form.max_zoom = settings.max_zoom;
        form.initial_zoom = settings.initial_zoom;
        form.distance_name = settings.distance_name;
        form.distance_measure = settings.distance_measure;
        error.value = null;
    },
);

async function save() {
    saving.value = true;
    error.value = null;

    try {
        const res = await axios.patch(props.map.settings_url, {
            grid: form.grid,
            min_zoom: form.min_zoom,
            max_zoom: form.max_zoom,
            initial_zoom: form.initial_zoom,
            distance_name: form.distance_name,
            distance_measure: form.distance_measure,
        });
        emit("saved", res.data);
        emit("close");
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}
</script>
