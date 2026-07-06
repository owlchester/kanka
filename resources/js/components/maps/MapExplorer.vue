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
                <button
                    class="text-lg font-semibold leading-tight cursor-pointer"
                    :ref="el => (mapMenuBtnRef = el)"
                >
                    {{ data.map.name }}
                </button>
                <div ref="mapMenuRef" class="flex flex-col gap-1">
                    <a
                        :href="data.map.show_url"
                        class="flex items-center gap-2 px-2 py-1.5 hover:bg-base-200 rounded-xl text-xs text-base-content"
                    >
                        <i class="fa-regular fa-arrow-right w-5 text-center text-neutral-content" aria-hidden="true" />
                        <span>{{ data.i18n.header.overview }}</span>
                    </a>
                    <template v-if="canEdit">
                        <button
                            type="button"
                            class="flex items-center gap-2 px-2 py-1.5 hover:bg-base-200 rounded-xl text-xs text-base-content text-left w-full"
                            @click="openSettings"
                        >
                            <i class="fa-regular fa-gear w-5 text-center text-neutral-content" aria-hidden="true" />
                            <span>{{ data.i18n.header.settings }}</span>
                        </button>
                        <a
                            :href="data.map.edit_url"
                            class="flex items-center gap-2 px-2 py-1.5 hover:bg-base-200 rounded-xl text-xs text-base-content"
                        >
                            <i class="fa-regular fa-pencil w-5 text-center text-neutral-content" aria-hidden="true" />
                            <span>{{ data.i18n.header.edit }}</span>
                        </a>
                    </template>
                </div>
                <p class="text-sm text-neutral-content">{{ markersCountText }}</p>
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
            :default-polygon-style="defaultPolygonStyle()"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
            @circle-change="handleCircleChange"
            @circle-finish="handleCircleFinish"
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
            @measure-change="handleMeasureChange"
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
            @name-change="handleNameChange"
            @border-colour-change="handleBorderColourChange"
            @stroke-width-change="handleStrokeWidthChange"
        />

        <Toolbar
            :i18n="data.i18n"
            :can-edit="canEdit"
            :active-mode="activeMode"
            :rapid="rapid"
            @mode-change="handleModeChange"
            @rapid-change="rapid = $event"
        />

        <SettingsPanel
            :open="settingsOpen"
            :map="data.map"
            :i18n="data.i18n.settings"
            @close="settingsOpen = false"
            @saved="handleSettingsSaved"
        />
    </template>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount, nextTick } from "vue";
import tippy from "tippy.js";
import { centroid } from "../../maps/polygon.js";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import SettingsPanel from "./SettingsPanel.vue";
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
const rapid = ref(false);
const settingsOpen = ref(false);
const mapMenuBtnRef = ref(null);
const mapMenuRef = ref(null);
let mapMenuInstance = null;

const markersCountText = computed(() => {
    const count = data.value.pins.length;
    const template = count === 1 ? data.value.i18n.markers_count_one : data.value.i18n.markers_count_other;

    return template.replace(':count', count);
});

function openSettings() {
    mapMenuInstance?.hide();
    settingsOpen.value = true;
}

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

function handleMeasureChange(active) {
    if (active) {
        activeMode.value = null;
        draftPin.value = null;
    }
}

function handleSettingsSaved(map) {
    data.value.map = map;
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
    if (activeMode.value !== "pin" && activeMode.value !== "text") {
        return;
    }

    if (draftPin.value) {
        draftPin.value = { ...draftPin.value, latitude: lat, longitude: lng };

        return;
    }

    const isText = activeMode.value === "text";

    draftPin.value = {
        name: "",
        colour: defaultColour(),
        shape: isText ? "label" : "marker",
        shapeId: isText ? 2 : 1,
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

function handleNameChange(name) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, name };
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

const DEFAULT_STROKE_WIDTH = 1;
const DEFAULT_POLYGON_OPACITY = 50;

function defaultPolygonStyle() {
    const colour = defaultColour();

    return {
        colour,
        opacity: DEFAULT_POLYGON_OPACITY,
        stroke: colour,
        "stroke-width": DEFAULT_STROKE_WIDTH,
    };
}

function handlePolygonFinish(vertices) {
    const [lat, lng] = centroid(vertices);
    const style = defaultPolygonStyle();

    draftPin.value = {
        name: "",
        colour: style.colour,
        shape: "poly",
        shapeId: 5,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        customShape: vertices,
        polygonStyle: { stroke: style.stroke, "stroke-width": style["stroke-width"] },
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: style.opacity,
        latitude: lat,
        longitude: lng,
    };
}

function handlePolygonChange(vertices) {
    if (!draftPin.value || draftPin.value.shape !== "poly") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    draftPin.value = { ...draftPin.value, customShape: vertices, latitude: lat, longitude: lng };
}

function handleBorderColourChange(colour) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, polygonStyle: { ...draftPin.value.polygonStyle, stroke: colour } };
}

function handleStrokeWidthChange(width) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, polygonStyle: { ...draftPin.value.polygonStyle, "stroke-width": width } };
}

function handleCircleFinish({ lat, lng, radius }) {
    const style = defaultPolygonStyle();

    draftPin.value = {
        name: "",
        colour: style.colour,
        shape: "circle",
        shapeId: 3,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        circleRadius: radius,
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: style.opacity,
        latitude: lat,
        longitude: lng,
    };
}

function handleCircleChange({ lat, lng, radius }) {
    if (!draftPin.value || draftPin.value.shape !== "circle") {
        return;
    }

    draftPin.value = { ...draftPin.value, circleRadius: radius, latitude: lat, longitude: lng };
}

function handlePathFinish(vertices) {
    const [lat, lng] = centroid(vertices);
    const style = defaultPolygonStyle();

    draftPin.value = {
        name: "",
        colour: style.colour,
        shape: "path",
        shapeId: 6,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        customShape: vertices,
        polygonStyle: { "stroke-width": style["stroke-width"] },
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: style.opacity,
        latitude: lat,
        longitude: lng,
    };
}

function handlePathChange(vertices) {
    if (!draftPin.value || draftPin.value.shape !== "path") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    draftPin.value = { ...draftPin.value, customShape: vertices, latitude: lat, longitude: lng };
}

function onPinCreated(pin) {
    data.value.pins = [...data.value.pins, pin];
    draftPin.value = null;

    if (! rapid.value) {
        activeMode.value = null;
    }
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

    await nextTick();

    if (mapMenuBtnRef.value && mapMenuRef.value) {
        mapMenuInstance = tippy(mapMenuBtnRef.value, {
            content: mapMenuRef.value,
            theme: "kanka-dropdown",
            placement: "bottom-start",
            interactive: true,
            trigger: "click",
            allowHTML: true,
            arrow: true,
            zIndex: 890,
        });
    }
});

onBeforeUnmount(() => {
    mapMenuInstance?.destroy();
});
</script>
