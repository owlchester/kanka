<template>
    <div
        class="w-full h-screen flex items-center justify-center text-2xl"
        v-if="loading || error || isTilingRunning"
    >
        <div class="flex items-center gap-2" v-if="loading && !error && !isTilingRunning">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ loadingText }}</span>
        </div>
        <div
            class="flex flex-col items-center gap-2 text-error-content"
            v-else-if="error"
        >
            <span>{{ error }}</span>
        </div>
        <div
            class="flex flex-col items-center gap-2"
            v-else-if="isTilingRunning"
        >
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ data.i18n.tiling.running }}</span>
        </div>
    </div>

    <template v-else>
        <div
            class="fixed top-4 left-4 z-[1200] items-center gap-4"
            :class="anyPanelOpen ? 'hidden md:flex' : 'flex'"
        >
            <button
                class="legend-toggle btn2 btn-default"
                @click="toggleLegend"
            >
                <i class="fa-regular fa-list" aria-hidden="true" />
            </button>
            <div>
                <button
                    class="text-2xl font-semibold leading-tight cursor-pointer text-shadow-[0_0_4px_hsl(var(--b1)),0_0_8px_hsl(var(--b1))]"
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
                <p class="text-sm text-neutral-content text-shadow-[0_0_4px_hsl(var(--b1)),0_0_8px_hsl(var(--b1))]">{{ markersCountText }}</p>
            </div>

            <div class="flex gap-1 overflow-hidden" v-if="data.interactive?.show_presence && activeUsers.length > 1">
                <span
                    v-for="user in activeUsers"
                    :key="user.id"
                    :aria-label="user.name"
                    class="bg-base-200 text-neutral-content rounded-full h-8 w-8 overflow-hidden flex items-center justify-center cursor-pointer flex-none"
                    :style="{ border: '3px solid ' + colourForUser(user.id) }"
                    v-tippy="presenceTooltip(user)"
                >
                    <img :src="user.image" v-if="user.image" class="w-8 h-8" />
                    <span v-else>{{ user.name.substring(0, 2).toUpperCase() }}</span>
                </span>
            </div>

            <i
                v-if="presenceError"
                class="fa-regular fa-triangle-exclamation text-warning flex-none"
                aria-hidden="true"
                v-tippy="presenceError"
            />
        </div>

        <div
            v-if="canEdit && data.map.tiling_prompt_eligible && !tilingPromptDismissed"
            class="fixed top-4 right-4 z-[1200] max-w-sm bg-base-100 border border-base-300 rounded-xl p-4 flex-col gap-2 shadow-lg"
            :class="anyPanelOpen ? 'hidden md:flex' : 'flex'"
        >
            <p class="text-sm text-base-content">{{ data.i18n.tiling_prompt.message }}</p>
            <div class="flex gap-2 justify-end">
                <button class="btn2 btn-default btn-sm" @click="respondToTilingPrompt('dismiss')">
                    {{ data.i18n.tiling_prompt.dismiss }}
                </button>
                <button class="btn2 btn-primary btn-sm" @click="respondToTilingPrompt('migrate')">
                    {{ data.i18n.tiling_prompt.migrate }}
                </button>
            </div>
        </div>

        <LegendPanel
            :open="legendOpen"
            :groups="data.groups"
            :pins="data.pins"
            :can-edit="canEdit"
            :i18n="data.i18n"
            @select="selectPin"
            @close="legendOpen = false"
            @add-group="openGroupModal"
        />

        <GroupModal
            ref="groupModalRef"
            :i18n="data.i18n"
            :groups="data.groups"
            :visibilities="data.visibilities"
            :group-store-url="data.map.group_store_url"
            @created="onGroupCreated"
        />

        <LeafletCanvas
            ref="leafletCanvasRef"
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            :editing-pin="editingPin"
            :preview-center="previewCenter"
            :can-edit="canEdit"
            :remote-cursors="remoteCursors"
            :legacy-pins="data.map.settings?.legacy_pins"
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
            @pin-moved="handlePinMoved"
            @draft-move="handleDraftMove"
            @cursor-move="handleCursorMove"
            @edit-move="handleEditMove"
            @edit-polygon-change="handleEditPolygonChange"
            @edit-circle-change="handleEditCircleChange"
            @edit-path-change="handleEditPathChange"
        />

        <DetailPanel
            :pin="selectedPin"
            :map="data.map"
            :i18n="data.i18n"
            @close="selectedPin = null"
            @center="centerNonce++"
            @deleted="removePin"
            @edit="openEditFromDetail"
            @duplicate="handleDuplicate"
        />

        <MarkerPanel
            :pin="activePanelPin"
            :variant="panelVariant"
            :i18n="data.i18n"
            :create-url="data.map.create_url"
            :boosted="boosted"
            :groups="data.groups"
            :search-url="data.map.search_url"
            :mentions-url="data.map.mentions_url"
            :gallery-url="data.map.gallery_url"
            :gallery-upload-url="data.map.gallery_upload_url"
            :visibilities="data.visibilities"
            :presets="data.presets"
            :preset-store-url="data.map.preset_store_url"
            :can-manage-presets="data.can_manage_presets"
            :rapid="rapid"
            @close="handlePanelClose"
            @created="onPinCreated"
            @updated="handlePinUpdated"
            @deleted="handlePinDeletedFromPanel"
            @icon-change="handleIconChange"
            @group-change="handleGroupChange"
            @entity-change="handleEntityChange"
            @visibility-change="handleVisibilityChange"
            @colour-change="handleColourChange"
            @opacity-change="handleOpacityChange"
            @name-change="handleNameChange"
            @entry-change="handleEntryChange"
            @border-colour-change="handleBorderColourChange"
            @stroke-width-change="handleStrokeWidthChange"
            @preset-change="handlePresetChange"
            @preset-created="onPresetCreated"
            @preset-updated="onPresetUpdated"
            @preset-deleted="onPresetDeleted"
        />

        <Toolbar
            :i18n="data.i18n"
            :can-edit="canEdit"
            :active-mode="activeMode"
            :rapid="rapid"
            :panel-open="anyPanelOpen"
            @mode-change="handleModeChange"
            @rapid-change="rapid = $event"
        />

        <SettingsPanel
            :open="settingsOpen"
            :map="data.map"
            :pins="data.pins"
            :i18n="data.i18n.settings"
            :pending-center="pendingCenter"
            @close="settingsOpen = false"
            @saved="handleSettingsSaved"
            @pick-center="handleModeChange('center-pick')"
            @preview-center="previewCenter = $event"
        />
    </template>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount, nextTick } from "vue";
import tippy from "tippy.js";
import { colourForUser, useMapPresence } from "../../composables/useMapPresence.js";
import { centroid } from "../../maps/polygon.js";
import { panelsToClose } from "../../maps/panelExclusivity.js";
import DetailPanel from "./DetailPanel.vue";
import GroupModal from "./GroupModal.vue";
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
const data = ref({ map: {}, layers: [], groups: [], pins: [], visibilities: [], presets: [], i18n: {} });
const legendOpen = ref(false);
const selectedPin = ref(null);
const centerNonce = ref(0);
const activeMode = ref(null);
const draftPin = ref(null);
const editingPin = ref(null);
const rapid = ref(false);
const settingsOpen = ref(false);
const pendingCenter = ref(null);
const previewCenter = ref(null);
const mapMenuBtnRef = ref(null);
const mapMenuRef = ref(null);
const leafletCanvasRef = ref(null);
const groupModalRef = ref(null);
let mapMenuInstance = null;

const {
    activeUsers,
    remoteCursors,
    error: presenceError,
    sendCursor,
} = useMapPresence(
    () => data.value.interactive,
    () => data.value.i18n?.presence,
    {
        canEdit: props.canEdit,
        onMapUpdated: handleRemoteMapUpdate,
        onContentsChanged: handleContentsChanged,
        onMarkerChanged: handleMarkerChanged,
        onTilingChanged: handleTilingChanged,
    },
);

const markersCountText = computed(() => {
    const count = data.value.pins.length;
    const template = count === 1 ? data.value.i18n.markers_count_one : data.value.i18n.markers_count_other;

    return template.replace(':count', count);
});

const isTilingRunning = computed(() => data.value.map.tiling === 'running');

const anyPanelOpen = computed(
    () => legendOpen.value || !!selectedPin.value || !!draftPin.value || !!editingPin.value || settingsOpen.value,
);

const activePanelPin = computed(() => draftPin.value || editingPin.value);

const panelVariant = computed(() => (editingPin.value ? 'edit' : 'create'));

function isMobileViewport() {
    return window.matchMedia("(max-width: 767px)").matches;
}

function closePanel(kind) {
    if (kind === "legend") {
        legendOpen.value = false;
    } else if (kind === "detail") {
        selectedPin.value = null;
    } else if (kind === "marker") {
        draftPin.value = null;
    } else if (kind === "edit") {
        editingPin.value = null;
    } else if (kind === "settings") {
        settingsOpen.value = false;
    }
}

function enforceExclusivity(openingKind) {
    panelsToClose(openingKind, isMobileViewport()).forEach(closePanel);
}

function toggleLegend() {
    if (!legendOpen.value) {
        enforceExclusivity("legend");
    }

    legendOpen.value = !legendOpen.value;
}

function presenceTooltip(user) {
    const i18n = data.value.i18n.presence;
    const role = user.role === "edit" ? i18n.role_edit : i18n.role_view;

    return (
        '<div class="flex flex-col gap-1">' +
        '<a class="text-link text-lg" href="' + user.url + '">' + user.name + "</a>" +
        '<span class="text-neutral-content text-xs">' + role + "</span></div>"
    );
}

function openSettings() {
    mapMenuInstance?.hide();
    enforceExclusivity("settings");
    settingsOpen.value = true;
}

const tilingPromptDismissed = ref(false);

async function respondToTilingPrompt(action) {
    tilingPromptDismissed.value = true;
    await axios.patch(data.value.map.tiling_prompt_url, { action });
}

function selectPin(pin) {
    enforceExclusivity("detail");
    selectedPin.value = pin;
}

function removePin(pin) {
    data.value.pins = data.value.pins.filter((p) => p.id !== pin.id);
    selectedPin.value = null;
}

function handlePinMoved({ id, latitude, longitude }) {
    data.value.pins = data.value.pins.map((pin) =>
        pin.id === id ? { ...pin, latitude, longitude } : pin
    );
}

function handleDraftMove({ lat, lng }) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, latitude: lat, longitude: lng };
}

function handleEditMove({ lat, lng }) {
    if (!editingPin.value) {
        return;
    }

    editingPin.value = { ...editingPin.value, latitude: lat, longitude: lng };
}

function handleCursorMove({ lat, lng }) {
    sendCursor(lat, lng);
}

function handleModeChange(mode) {
    activeMode.value = mode;
    selectedPin.value = null;
    draftPin.value = null;
    editingPin.value = null;

    if (mode !== "center-pick") {
        settingsOpen.value = false;
    }
}

function handleMeasureChange(active) {
    if (active) {
        activeMode.value = null;
        draftPin.value = null;
        editingPin.value = null;
    }
}

function handleSettingsSaved(map) {
    data.value.map = map;
}

function handleRemoteMapUpdate(map) {
    data.value.map = map;
}

function handleTilingChanged({ status }) {
    data.value.map = { ...data.value.map, tiling: status === 'running' ? 'running' : null };

    if (status !== 'running') {
        axios.get(props.api).then((res) => {
            data.value = res.data;
        });
    }
}

function handleContentsChanged({ groups, layers }) {
    data.value.groups = groups;
    data.value.layers = layers;
}

function handleMarkerChanged({ action, pin, id }) {
    if (action === 'deleted') {
        data.value.pins = data.value.pins.filter((p) => p.id !== id);
        return;
    }

    const index = data.value.pins.findIndex((p) => p.id === id);
    if (index === -1) {
        data.value.pins = [...data.value.pins, pin];
    } else {
        data.value.pins = data.value.pins.map((p) => (p.id === id ? pin : p));
    }
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
    if (activeMode.value === "center-pick") {
        pendingCenter.value = { lat, lng };
        activeMode.value = null;

        return;
    }

    if (activeMode.value !== "pin" && activeMode.value !== "text") {
        return;
    }

    if (draftPin.value) {
        draftPin.value = { ...draftPin.value, latitude: lat, longitude: lng };

        return;
    }

    const isText = activeMode.value === "text";

    enforceExclusivity("marker");

    draftPin.value = {
        name: "",
        entry: "",
        colour: defaultColour(),
        shape: isText ? "label" : "marker",
        shapeId: isText ? 2 : 1,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        isDraggable: false,
        css: null,
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: 100,
        latitude: lat,
        longitude: lng,
    };
}

function patchActivePin(patch) {
    if (draftPin.value) {
        draftPin.value = { ...draftPin.value, ...patch };
    } else if (editingPin.value) {
        editingPin.value = { ...editingPin.value, ...patch };
    }
}

function handleNameChange(name) {
    patchActivePin({ name });
}

function handleEntryChange(text) {
    // Tiptap's emitted HTML is already edit-ready (mentions rendered the same way
    // entry_for_edition is), so keep entryForEdition in step with entry — otherwise
    // reopening the description dialog later in the same session would show the
    // stale pre-edit entryForEdition instead of what was just typed.
    patchActivePin({ entry: text, entryForEdition: text });
}

function handleIconChange(payload) {
    patchActivePin({
        iconId: payload.icon,
        customIcon: payload.custom_icon,
        icon: payload.render,
    });
}

function handleGroupChange(groupId) {
    patchActivePin({ groupId });
}

function handleEntityChange(payload) {
    patchActivePin({ entityId: payload.id, entityName: payload.text });
}

function handleVisibilityChange(visibilityId) {
    patchActivePin({ visibilityId });
}

function handleColourChange(colour) {
    patchActivePin({ colour });
}

function handleOpacityChange(opacity) {
    patchActivePin({ opacity });
}

function handlePresetChange(patch) {
    patchActivePin(patch);
}

function onPresetCreated(preset) {
    data.value.presets = [...data.value.presets, preset];
}

function onPresetUpdated(preset) {
    data.value.presets = data.value.presets.map((p) => (p.id === preset.id ? preset : p));
}

function onPresetDeleted(preset) {
    data.value.presets = data.value.presets.filter((p) => p.id !== preset.id);
}

function openGroupModal() {
    groupModalRef.value?.open(data.value.default_visibility_id);
}

function onGroupCreated(group) {
    data.value.groups = [...data.value.groups, group];
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

    enforceExclusivity("marker");

    draftPin.value = {
        name: "",
        entry: "",
        colour: style.colour,
        shape: "poly",
        shapeId: 5,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        isDraggable: false,
        css: null,
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

function handleEditPolygonChange(vertices) {
    const pin = draftPin.value || editingPin.value;
    if (!pin || pin.shape !== "poly") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    patchActivePin({ customShape: vertices, latitude: lat, longitude: lng });
}

function handleBorderColourChange(colour) {
    const target = draftPin.value || editingPin.value;
    if (!target) {
        return;
    }

    patchActivePin({ polygonStyle: { ...target.polygonStyle, stroke: colour } });
}

function handleStrokeWidthChange(width) {
    const target = draftPin.value || editingPin.value;
    if (!target) {
        return;
    }

    patchActivePin({ polygonStyle: { ...target.polygonStyle, "stroke-width": width } });
}

function handleCircleFinish({ lat, lng, radius }) {
    const style = defaultPolygonStyle();

    enforceExclusivity("marker");

    draftPin.value = {
        name: "",
        entry: "",
        colour: style.colour,
        shape: "circle",
        shapeId: 3,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        isDraggable: false,
        css: null,
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

function handleEditCircleChange({ lat, lng, radius }) {
    const pin = draftPin.value || editingPin.value;
    if (!pin || pin.shape !== "circle") {
        return;
    }

    patchActivePin({ circleRadius: radius, latitude: lat, longitude: lng });
}

function handlePathFinish(vertices) {
    const [lat, lng] = centroid(vertices);
    const style = defaultPolygonStyle();

    enforceExclusivity("marker");

    draftPin.value = {
        name: "",
        entry: "",
        colour: style.colour,
        shape: "path",
        shapeId: 6,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        isDraggable: false,
        css: null,
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

function handleEditPathChange(vertices) {
    const pin = draftPin.value || editingPin.value;
    if (!pin || pin.shape !== "path") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    patchActivePin({ customShape: vertices, latitude: lat, longitude: lng });
}

function onPinCreated(pin) {
    data.value.pins = [...data.value.pins, pin];
    draftPin.value = null;

    if (! rapid.value) {
        activeMode.value = null;
    }
}

function toEditingPin(pin) {
    return {
        id: pin.id,
        name: pin.name,
        entry: pin.entry,
        entryForEdition: pin.entry_for_edition,
        colour: pin.colour,
        shape: pin.shape,
        shapeId: pin.shape_id,
        icon: pin.icon,
        iconId: pin.icon_id,
        customIcon: pin.custom_icon,
        isDraggable: pin.is_draggable,
        css: pin.css,
        customShape: pin.custom_shape,
        polygonStyle: pin.polygon_style,
        circleRadius: pin.circle_radius,
        pin_size: pin.pin_size,
        groupId: pin.group_id,
        entityId: pin.entity_id,
        entityName: pin.entity_name,
        visibilityId: pin.visibility_id,
        opacity: pin.opacity,
        latitude: pin.latitude,
        longitude: pin.longitude,
        update_url: pin.update_url,
        destroy_url: pin.destroy_url,
    };
}

function openEditFromDetail() {
    const pin = selectedPin.value;
    if (! pin) {
        return;
    }

    enforceExclusivity("edit");
    editingPin.value = toEditingPin(pin);
}

const DUPLICATE_OFFSET_PX = 50;

function handleDuplicate(pin) {
    if (!pin) {
        return;
    }

    // Offset in screen pixels (top-right), not a fixed lat/lng delta — a fixed delta would be
    // imperceptible on a real (degree-scale) map and enormous on a large image (pixel-scale)
    // one. A pixel offset reads as the same small, sensible gap regardless of the map's CRS
    // or current zoom.
    const offset = leafletCanvasRef.value?.offsetLatLng(pin.latitude, pin.longitude, DUPLICATE_OFFSET_PX, -DUPLICATE_OFFSET_PX)
        ?? { lat: pin.latitude, lng: pin.longitude };
    const dLat = offset.lat - pin.latitude;
    const dLng = offset.lng - pin.longitude;

    const duplicate = toEditingPin(pin);
    delete duplicate.id;
    delete duplicate.update_url;
    delete duplicate.destroy_url;
    duplicate.latitude = offset.lat;
    duplicate.longitude = offset.lng;
    // A poly/path's latitude/longitude is just its centroid — the real geometry lives in
    // customShape, so every vertex needs the same translation or the shape stays put while
    // only its reported center moves.
    if (Array.isArray(duplicate.customShape)) {
        duplicate.customShape = duplicate.customShape.map(([lat, lng]) => [lat + dLat, lng + dLng]);
    }

    enforceExclusivity("marker");
    draftPin.value = duplicate;
}

function handlePanelClose() {
    draftPin.value = null;
    editingPin.value = null;
}

function handleGlobalKeydown(event) {
    if (event.key !== "Escape" || event.defaultPrevented) {
        return;
    }

    // A nested dialog (e.g. the description editor) already owns Escape while open — don't
    // also exit the marker panel underneath it.
    if (document.querySelector("dialog[open]")) {
        return;
    }

    if (editingPin.value) {
        editingPin.value = null;
    } else if (draftPin.value) {
        draftPin.value = null;
        activeMode.value = null;
    } else if (activeMode.value === "area" || activeMode.value === "path") {
        // Still mid-draw (vertices placed but not yet finished into a draft pin) — cancel
        // the whole thing. The activeMode watchers in LeafletCanvas tear down the in-progress
        // polygon/path layer once activeMode stops matching.
        activeMode.value = null;
    }
}

function handlePinUpdated(pin) {
    data.value.pins = data.value.pins.map((p) => (p.id === pin.id ? pin : p));
    editingPin.value = null;
}

function handlePinDeletedFromPanel(pin) {
    removePin(pin);
    editingPin.value = null;
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

    window.addEventListener("keydown", handleGlobalKeydown);
});

onBeforeUnmount(() => {
    mapMenuInstance?.destroy();
    window.removeEventListener("keydown", handleGlobalKeydown);
});
</script>
