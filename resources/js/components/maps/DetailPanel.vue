<template>
    <aside
        v-if="pin"
        class="fixed inset-0 bg-base-100 shadow-lg z-[1150] flex flex-col overflow-hidden md:top-4 md:right-4 md:bottom-4 md:left-auto md:w-80 md:rounded-2xl"
    >
        <div
            class="flex justify-end p-4 bg-cover bg-center"
            :class="preview?.entity_image ? 'pb-20' : ''"
            :style="
                preview?.entity_image
                    ? { backgroundImage: `url('${preview.entity_image}')` }
                    : {}
            "
        >
            <button
                class="btn2 btn-default btn-sm flex-none"
                @click="$emit('close')"
            >
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>

        <div
            class="px-4 flex flex-col gap-2"
            :class="preview?.entity_image ? '-mt-6' : ''"
        >
            <div
                class="w-10 h-10 rounded-lg flex items-center justify-center flex-none overflow-hidden"
                :class="
                    markerIcon.kind !== 'avatar' && !pin.colour
                        ? 'bg-neutral-content'
                        : ''
                "
                :style="
                    markerIcon.kind === 'avatar'
                        ? {
                              backgroundImage: `url('${markerIcon.value}')`,
                              backgroundSize: 'cover',
                              backgroundPosition: 'center',
                          }
                        : pin.colour
                          ? { backgroundColor: pin.colour }
                          : {}
                "
            >
                <i
                    v-if="markerIcon.kind === 'fa'"
                    :class="markerIcon.value"
                    class="text-white"
                    aria-hidden="true"
                ></i>
                <span
                    v-else-if="markerIcon.kind === 'html'"
                    class="text-white"
                    v-html="markerIcon.value"
                ></span>
            </div>
            <h2
                class="text-lg font-semibold marker-title"
                v-html="pin.name"
            ></h2>
        </div>

        <div v-if="loading" class="p-4 flex items-center gap-2">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ i18n.loading }}</span>
        </div>

        <div v-else-if="preview" class="flex flex-col grow min-h-0">
            <div
                class="p-4 pt-0 flex flex-col gap-3 overflow-y-auto grow min-h-0"
            >
                <p class="text-xs text-neutral-content flex items-center gap-1">
                    <span class="marker-type">{{ preview.type }}</span>
                    <span>-</span>
                    <span
                        class="inline-block w-2.5 h-2.5 rounded-full flex-none"
                        :class="
                            !preview.group_colour ? 'bg-neutral-content' : ''
                        "
                        :style="
                            preview.group_colour
                                ? { backgroundColor: preview.group_colour }
                                : {}
                        "
                    />
                    <span class="marker-group">{{
                        preview.group_name || i18n.ungrouped
                    }}</span>
                    <template v-if="distanceText || surfaceText">
                        <span>-</span>
                        <span>{{ distanceText || surfaceText }}</span>
                    </template>
                </p>

                <a
                    v-if="preview?.entity_url"
                    :href="preview.entity_url"
                    class="border border-neutral-content rounded-2xl flex gap-2 p-3 items-center"
                >
                    <div
                        class="bg-primary text-primary-content flex-none rounded-lg p-1 w-8 h-8 flex items-center justify-center"
                    >
                        <i class="fa-regular fa-link" aria-hidden="true"></i>
                    </div>
                    <div class="flex flex-col gap-0 grow overflow-hidden">
                        <span class="text-neutral-content text-2xs uppercase">
                            {{ i18n.linked_entry }}
                        </span>
                        <span class="truncate">{{ preview.entity_name }}</span>
                    </div>
                    <div class="flex-none">
                        <i
                            class="fa-regular fa-arrow-up-right"
                            aria-hidden="true"
                        ></i>
                    </div>
                </a>

                <div
                    class="marker-entry entity-content marker-custom-entry"
                    v-if="preview.marker_entry"
                    v-html="preview.marker_entry"
                ></div>

                <template v-if="preview.entity_entry">
                    <p
                        v-if="preview.marker_entry"
                        class="text-sm font-semibold"
                    >
                        {{ i18n.from_entry }}
                    </p>
                    <div
                        v-html="preview.entity_entry"
                        class="marker-entry entity-content"
                    ></div>
                </template>
            </div>

            <div class="p-4 flex flex-col gap-2 flex-none">
                <button
                    v-if="preview.can_edit"
                    type="button"
                    class="btn2 btn-primary btn-block"
                    @click="$emit('edit')"
                >
                    {{ i18n.edit_marker }}
                </button>

                <div class="flex gap-2">
                    <button
                        class="btn2 btn-default grow"
                        @click="$emit('center')"
                    >
                        {{ i18n.center }}
                    </button>
                    <button
                        v-if="preview.can_edit"
                        class="btn2 grow"
                        @click="duplicate"
                    >
                        {{ i18n.duplicate }}
                    </button>
                </div>

                <button
                    v-if="preview.can_edit"
                    class="btn2 btn-error btn-outline"
                    @click="handleDelete"
                >
                    {{ confirming ? i18n.delete_confirm : i18n.delete_marker }}
                </button>
                <p v-if="error" class="text-sm text-error-content">
                    {{ error }}
                </p>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { pathLength, polygonArea } from "../../maps/polygon.js";

const props = defineProps({
    pin: { type: Object, default: null },
    map: { type: Object, default: () => ({}) },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["close", "center", "deleted", "edit", "duplicate"]);

const loading = ref(false);
const preview = ref(null);
const confirming = ref(false);
const error = ref(null);

const markerIcon = computed(() => {
    if (props.pin.shape === "label") {
        return { kind: "fa", value: "fa-regular fa-font" };
    }

    if (props.pin.shape === "poly") {
        return { kind: "fa", value: "fa-regular fa-draw-polygon" };
    }

    if (props.pin.shape === "path") {
        return { kind: "fa", value: "fa-regular fa-route" };
    }

    if (props.pin.shape === "circle") {
        return { kind: "fa", value: "fa-regular fa-circle" };
    }

    if (props.pin.icon?.type === "fa") {
        return { kind: "fa", value: props.pin.icon.value };
    }

    if (props.pin.icon?.type === "html" || props.pin.icon?.type === "svg") {
        return { kind: "html", value: props.pin.icon.value };
    }

    if (props.pin.icon?.type === "avatar") {
        return { kind: "avatar", value: props.pin.icon.value };
    }

    return { kind: "fa", value: "fa-solid fa-location-dot" };
});

const distanceText = computed(() => {
    // Saved pins come back from the Explore API (PinResource) as `custom_shape`;
    // in-progress draft pins built client-side (see MapExplorer.vue) use `customShape`.
    // Mirrors the same fallback LeafletCanvas.vue uses when rendering shapes.
    const shape = props.pin?.custom_shape ?? props.pin?.customShape;
    if (props.pin?.shape !== "path" || !props.map?.has_distance_unit || !shape?.length) {
        return null;
    }

    return `${pathLength(shape, props.map).toFixed(2)} ${props.map.distance_name}`;
});

const surfaceText = computed(() => {
    const shape = props.pin?.custom_shape ?? props.pin?.customShape;
    if (props.pin?.shape !== "poly" || !props.map?.has_distance_unit || !shape?.length) {
        return null;
    }

    return `${polygonArea(shape, props.map).toFixed(2)} ${props.map.distance_name}²`;
});

function duplicate() {
    emit("duplicate", props.pin);
}

async function handleDelete() {
    if (!confirming.value) {
        confirming.value = true;
        error.value = null;

        return;
    }

    try {
        const res = await axios.delete(props.pin.destroy_url);
        if (res.status === 204) {
            emit("deleted", props.pin);
        }
    } catch (e) {
        confirming.value = false;
        error.value = props.i18n.error_delete;
    }
}

async function load(pin) {
    confirming.value = false;
    error.value = null;
    preview.value = null;

    if (!pin) {
        return;
    }

    loading.value = true;
    try {
        const res = await axios.get(pin.preview_url);
        preview.value = res.data;
    } finally {
        loading.value = false;
    }
}

watch(() => props.pin, load, { immediate: true });
</script>
