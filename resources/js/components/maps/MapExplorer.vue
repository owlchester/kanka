<template>
    <div
        class="w-full h-screen flex items-center justify-center text-2xl"
        v-if="loading || error"
    >
        <div class="flex items-center gap-2" v-if="loading && !error">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ loadingText }}</span>
        </div>
        <div
            class="flex flex-col items-center gap-2 text-error-content"
            v-else-if="error"
        >
            <span>{{ error }}</span>
        </div>
    </div>

    <template v-else>
        <div class="fixed top-4 left-4 z-[1200] flex items-center gap-4">
            <button
                class="legend-toggle btn2 btn-default"
                @click="legendOpen = !legendOpen"
            >
                <i class="fa-regular fa-list" aria-hidden="true" />
            </button>
            <div>
                <h1 class="text-lg font-semibold leading-tight">
                    {{ data.map.name }}
                </h1>
                <p class="text-sm opacity-75">{{ markersCountText }}</p>
            </div>
        </div>

        <LegendPanel
            :open="legendOpen"
            :groups="data.groups"
            :pins="data.pins"
            :i18n="data.i18n"
            @select="selectPin"
        />

        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            @pin-click="selectPin"
            @map-click="handleMapClick"
        />

        <DetailPanel
            :pin="selectedPin"
            :i18n="data.i18n"
            @close="selectedPin = null"
            @center="centerNonce++"
            @deleted="removePin"
        />

        <MarkerPanel
            :pin="draftPin"
            :i18n="data.i18n"
            :create-url="data.map.create_url"
            :boosted="boosted"
            :groups="data.groups"
            :search-url="data.map.search_url"
            :visibilities="data.visibilities"
            @close="draftPin = null"
            @created="onPinCreated"
            @icon-change="handleIconChange"
            @group-change="handleGroupChange"
            @entity-change="handleEntityChange"
            @visibility-change="handleVisibilityChange"
            @colour-change="handleColourChange"
            @opacity-change="handleOpacityChange"
        />

        <Toolbar
            :i18n="data.i18n"
            :can-edit="canEdit"
            :active-mode="activeMode"
            @mode-change="handleModeChange"
        />
    </template>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import Toolbar from "./Toolbar.vue";

const props = defineProps({
    api: { type: String, required: true },
    loadingText: { type: String, required: true },
    errorText: { type: String, required: true },
    canEdit: { type: Boolean, default: false },
    boosted: { type: Boolean, default: false },
});

const loading = ref(true);
const error = ref(null);
const data = ref({ map: {}, layers: [], groups: [], pins: [], visibilities: [], i18n: {} });
const legendOpen = ref(false);
const selectedPin = ref(null);
const centerNonce = ref(0);
const activeMode = ref(null);
const draftPin = ref(null);

const markersCountText = computed(() => {
    const count = data.value.pins.length;
    const template = count === 1 ? data.value.i18n.markers_count_one : data.value.i18n.markers_count_other;

    return template.replace(':count', count);
});

function selectPin(pin) {
    selectedPin.value = pin;
}

function removePin(pin) {
    data.value.pins = data.value.pins.filter((p) => p.id !== pin.id);
    selectedPin.value = null;
}

function handleModeChange(mode) {
    activeMode.value = mode;
    selectedPin.value = null;
    draftPin.value = null;
}

function defaultColour() {
    try {
        const raw = localStorage.getItem("recent_colors");
        const recents = raw ? JSON.parse(raw) : [];

        return recents[0] || "#93c5fd";
    } catch (e) {
        return "#93c5fd";
    }
}

function handleMapClick({ lat, lng }) {
    if (activeMode.value !== "pin") {
        return;
    }

    if (draftPin.value) {
        draftPin.value = { ...draftPin.value, latitude: lat, longitude: lng };

        return;
    }

    draftPin.value = {
        name: "",
        colour: defaultColour(),
        shape: "marker",
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: 100,
        latitude: lat,
        longitude: lng,
    };
}

function handleIconChange(payload) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = {
        ...draftPin.value,
        iconId: payload.icon,
        customIcon: payload.custom_icon,
        icon: payload.render,
    };
}

function handleGroupChange(groupId) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, groupId };
}

function handleEntityChange(payload) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, entityId: payload.id, entityName: payload.text };
}

function handleVisibilityChange(visibilityId) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, visibilityId };
}

function handleColourChange(colour) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, colour };
}

function handleOpacityChange(opacity) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, opacity };
}

function onPinCreated(pin) {
    data.value.pins = [...data.value.pins, pin];
    draftPin.value = null;
    activeMode.value = null;
}

onMounted(async () => {
    try {
        const res = await axios.get(props.api);
        data.value = res.data;
    } catch (e) {
        error.value = props.errorText;
    } finally {
        loading.value = false;
    }
});
</script>
