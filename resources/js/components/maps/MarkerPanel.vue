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
                    <i class="fa-solid fa-map-pin text-white" aria-hidden="true" />
                </div>
                <h2 class="text-sm font-semibold uppercase tracking-wide">{{ i18n.new_pin }}</h2>
            </div>
            <button class="btn2 btn-default btn-sm flex-none" :disabled="saving" @click="$emit('close')">
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>

        <div class="px-4 flex flex-col gap-2">
            <input
                v-model="name"
                type="text"
                class="input input-bordered w-full"
                :placeholder="i18n.name_placeholder"
            />
        </div>

        <div class="p-4 mt-auto flex flex-col gap-2">
            <button
                class="btn2 btn-primary btn-block"
                :disabled="saving || !name.trim()"
                @click="save"
            >
                {{ i18n.save }}
            </button>
            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>
    </aside>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    pin: { type: Object, default: null },
    i18n: { type: Object, required: true },
    createUrl: { type: String, required: true },
});

const emit = defineEmits(["close", "created"]);

const name = ref("");
const saving = ref(false);
const error = ref(null);

watch(() => props.pin, (newPin, oldPin) => {
    if (newPin && !oldPin) {
        name.value = "";
        error.value = null;
        saving.value = false;
    }
});

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
            icon: 1,
        });
        emit("created", res.data);
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}
</script>
