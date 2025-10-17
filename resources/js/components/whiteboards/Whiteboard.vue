<template>
    <div class="w-full h-screen flex items-center justify-center align-middle text-2xl flex-col gap-4" v-if="loading">
        <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
        <span>Loading</span>
    </div>
    <div class="toolbar fixed w-full bg-base-100 p-2 flex items-center justify-between gap-2 z-50" v-if="!loading">
        <div class="flex gap-1 items-center">
            <a :href="urls.overview" :title="trans('back')" class="flex items-center gap-1">
                <i class="fa-regular fa-left-to-bracket" aria-hidden="true"></i>
                <span v-html="name"></span>
            </a>
        </div>


        <div class="actions flex items-center" v-if="!props.readonly">
            <button
                class="btn2 btn-sm btn-primary join-item"
                :class="{ 'btn-disabled': saving }"
                @click="saveWhiteboard">
                <i class="fa-regular fa-save" aria-hidden="true" v-if="!saving" />
                <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" v-else />
                <span v-html="trans('save')"></span>
            </button>
        </div>
    </div>

    <v-stage v-if="!loading"
        ref="stage"
        :config="stageSize"
        @click="handleStageClick"
        @mousedown="handleMouseDown"
        @mousemove="draw"
        @mouseup="handeMouseUp"
         @wheel="handleWheel"
    >
        <v-layer ref="layer">
            <v-group
                v-for="shape in shapes"
                :key="shape.id"
                :config="{
                    id: `group-${shape.id}`,
                    draggable: !shape.locked,
                    x: shape.x,
                    y: shape.y,
                    scaleX: shape.scaleX || 1,
                    scaleY: shape.scaleY || 1,
                    rotation: shape.rotation || 0
                }"
                @dragstart="handleDragstart(shape)"
                @dragmove="handleDragmove(shape)"
                @dragend="handleDragend($event, shape)"
                @click="selectShape(shape, $event)"
            >
                <v-rect v-if="shape.type==='rect'"
                        :config="{
                            x: 0, y: 0,
                            width: shape.width,
                            height: shape.height,
                            fill: shape.fill || 'lightblue',
                            cornerRadius: 6,
                            opacity: shape.opacity || 1
                        }"
                />
                <v-circle v-if="shape.type==='circle'"
                          :config="{
                            x: shape.radius,
                            y: shape.radius,
                            radius: shape.radius,
                            fill: shape.fill || 'lightgreen',
                            opacity: shape.opacity || 1
                        }"
                />
                <v-line v-if="shape.type === 'group'" v-for="line in shape.children"
                        :key="line.id"
                        :config="{
                            points: line.points,
                            stroke: line.fill,
                            strokeWidth: line.strokeWidth,
                            hitStrokeWidth: hitStrokeWidth,
                            lineCap: 'round',
                            lineJoin: 'round',
                            opacity: shape.opacity || 1
                        }" />

                <v-image v-if="shape.type === 'image'"
                         :config="{
                            width: shape.width,
                            height: shape.height,
                            image: getImageEl(shape),
                            cornerRadius: 4,
                            opacity: shape.opacity || 1
                         }" />


                <Entity v-if="shape.type === 'entity'"
                        :shape="shape"
                        :get-image-el="getImageEl">
                </Entity>


                <v-text v-if="shape.type === 'text' && (!editingTextId || editingTextId !== shape.id)"
                        :config="{
                            x: getTextPadding(shape),
                            y: getTextPadding(shape),
                            width: shape.width - (getTextPadding(shape) * 2),
                            height: shape.height - (getTextPadding(shape) * 2),
                            opacity: shape.opacity || 1,
                            text: shape.text,
                            fontSize: getTextSize(shape),
                            fontFamily: shape.fontFamily || 'Arial',
                            fill: getTextColor(shape),
                            align: 'center',
                            verticalAlign: 'middle',
                            wrap: 'word',
                        }"
                />

                <!-- Selection outline overlays (pointerEvents disabled so they don't block clicks) -->
                <v-rect
                    v-if="isSelected(shape.id) && selectedIds.length > 1 && shape.type !== 'circle'"
                    :config="{
                            x: 0,
                            y: 0,
                            width: shape.width,
                            height: shape.height,
                            stroke: cssVariable('--p'),
                            strokeWidth: 2,
                            strokeScaleEnabled: false,
                            dash: [6,4],
                            opacity: shape.opacity || 1,
                            listening: false
                        }"
                />
                <v-circle
                    v-if="isSelected(shape.id) && selectedIds.length > 1 && shape.type === 'circle'"
                    :config="{
                            x: shape.radius,
                            y: shape.radius,
                            radius: shape.radius + 2,
                            stroke: cssVariable('--p'),
                            strokeWidth: 2,
                            strokeScaleEnabled: false,
                            opacity: shape.opacity || 1,
                            dash: [6,4],
                            listening: false
                        }"
                />

            </v-group>

            <v-group v-if="tempGroup" :key="tempGroup.id" :config="{ id: `temp-group-${tempGroup.id}` }">
                <v-line v-for="line in tempGroup.children"
                        :key="line.id"
                        :config="{
                            points: line.points,
                            stroke: line.fill,
                            strokeWidth: line.strokeWidth,
                            lineCap: 'round',
                            lineJoin: 'round',
                        }" />
            </v-group>

            <v-group v-if="tempRect" :key="tempRect.id" :config="{ id: `temp-rect-${tempRect.id}` }">
                <v-rect
                    :config="{
                        x: tempRect.x || 0,
                        y: tempRect.y || 0,
                        width: tempRect.width || 0,
                        height: tempRect.height || 0,
                        fill: currentBgColor,
                        stroke: cssVariable('--p'),
                        strokeWidth: 2,
                        listening: false
                    }"
                />
            </v-group>
            <v-group v-if="tempCircle" :key="tempCircle.id" :config="{ id: `temp-circle-${tempCircle.id}` }">
                <v-circle
                    :config="{
                        x: tempCircle.cx || 0,
                        y: tempCircle.cy || 0,
                        radius: tempCircle.radius || 0,
                        fill: currentBgColor,
                        stroke: cssVariable('--p'),
                        strokeWidth: 2,
                        listening: false
                    }"
                />
            </v-group>




            <v-transformer
                ref="transformer"
                :config="{
                    resizeEnabled: true,
                    rotateEnabled: true,
                    borderEnabled: true,
                    borderStroke: cssVariable('--p'),
                    borderStrokeWidth: 1,
                    anchorStroke: cssVariable('--p'),
                    anchorFill: cssVariable('--pc'),
                    anchorSize: 8,
                    keepRatio: true,
                }"
            />
        </v-layer>
    </v-stage>

    <textarea
        v-if="editingTextId && !loading"
        ref="textInput"
        v-model="editingText"
        :style="inputStyle"
        class="absolute bg-transparent border-2 border-accent rounded resize-none outline-none z-50"
        @blur="saveText"
        @keydown.enter.exact="saveText"
        @keydown.escape="cancelTextEdit"
        @input="updateTextPreview"
    ></textarea>

    <div
        v-if="!loading"
        :style="toolbarStyle"
        class="fixed z-50 flex items-center justify-center inset-x-0 gap-1 bottom-8 tools"
        @mousedown.stop
        @click.stop
    >
        <div v-if="toolbarMode === 'drawing'" class="flex items-center gap-2 main-toolbar">
            <div class="join">

                <button
                    class="btn2 btn-sm join-item"
                    :title="trans('thin-stroke')"
                    :class="{ 'btn-disabled': strokeSize === 1 }"
                    @click.stop="strokeSize = 1"
                >
                    <i class="fa-regular fa-paintbrush-fine" aria-hidden="true"></i>
                    <span class="sr-only" v-html="trans('thin-stroke')"></span>
                </button>
                <button
                    class="btn2 btn-sm join-item"
                    :title="trans('large-stroke')"
                    :class="{ 'btn-disabled': strokeSize === 3 }"
                    @click.stop="strokeSize = 3"
                >
                    <i class="fa-regular fa-paintbrush" aria-hidden="true"></i>
                    <span class="sr-only" v-html="trans('large-stroke')"></span>
                </button>
                <button
                    class="btn2 btn-sm join-item"
                    :title="trans('color')"
                    :style="{'color': currentColor}"
                    @click.stop="openColorPicker"
                >
                    <i class="fa-regular fa-palette" aria-hidden="true"></i>
                    <span class="sr-only" v-html="trans('color')"></span>
                </button>
                <button
                    @click="toggleDrawing"
                    class="btn2 btn-sm join-item"
                    :title="trans('end-drawing')">
                    <i class="fa-regular fa-check" aria-hidden="true" />
                    <span class="sr-only" v-html="trans('end-drawing')"></span>
                </button>
            </div>
        </div>
        <div class="flex items-center gap-2 shape-toolbar " v-else-if="selectedShape">
            <div class="join">
                <button
                    class="btn2 btn-sm join-item"
                    :class="selectedShape.locked ? 'btn-warning' : ''"
                    :title="selectedShape.locked ? trans('unlock') : trans('lock')"
                    @click.stop="toggleLock"
                >
                    <i class="fa-regular" :class="selectedShape.locked ? 'fa-lock' : 'fa-lock-open'" aria-hidden="true"></i>
                    <span class="sr-only">{{ selectedShape.locked ? trans('unlock') : trans('lock') }}</span>
                </button>

                <button
                    class="btn2 btn-sm join-item"
                    :title="trans('duplicate')"
                    @click.stop="duplicateSelected"
                >
                    <i class="fa-regular" :class="'fa-copy'" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('duplicate') }}</span>
                </button>

                <button
                    class="btn2 btn-sm join-item"
                    :title="trans('color')"
                    @click.stop="openColorPicker"
                >
                    <i class="fa-regular fa-palette" aria-hidden="true"></i>
                    <span class="sr-only" v-html="trans('color')"></span>
                </button>

                <button
                    class="btn2 btn-sm join-item"
                    :class="{'btn-disabled': nothingToRotate()}"
                    :title="trans('reset-rotation')"
                    @click.stop="resetRotation()"
                >
                    <i class="fa-regular fa-rotate" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('reset-rotation') }}</span>
                </button>
            </div>

            <div class="join" v-if="selectedShape.type === 'text'">
                <button
                    class="btn2 btn-sm join-item"
                    :class="{'btn-disabled': editingTextId}"
                    :title="trans('auto-font')"
                    @click.stop="autoFont()"
                >
                    <i class="fa-regular fa-text-size" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('auto-font') }}</span>
                </button>


                <button
                    class="btn2 btn-sm join-item"
                    :class="{'btn-disabled': editingTextId || selectedShape.fontSize === 2}"
                    :title="trans('fmaller-font')"
                    @click.stop="smallerFont()"
                >
                    <i class="fa-regular fa-minus" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('smaller-font') }}</span>
                </button>

                <button
                    class="btn2 btn-sm join-item"
                    :class="{'btn-disabled': editingTextId || selectedShape.fontSize === 12}"
                    :title="trans('larger-font')"
                    @click.stop="biggerFont()"
                >
                    <i class="fa-regular fa-plus" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('larger-font') }}</span>
                </button>
            </div>

            <div class="join">
                <button
                    class="btn2 btn-sm join-item"
                    :title="trans('push-to-front')"
                    @click.stop="pushTo('front')"
                >
                    <i class="fa-regular fa-up-to-line" aria-hidden="true"></i>
                    <span class="sr-only" v-html="trans('push-to-front')"></span>
                </button>
                <button
                    class="btn2 btn-sm join-item"
                    :title="trans('push-to-back')"
                    @click.stop="pushTo('back')"
                >
                    <i class="fa-regular fa-down-to-line" aria-hidden="true"></i>
                    <span class="sr-only" v-html="trans('push-to-back')"></span>
                </button>
            </div>
            <button
                class="btn2 btn-sm text-error"
                :title="trans('delete')"
                @click.stop="deleteSelected"
            >
                <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                <span class="sr-only" v-html="trans('delete')"></span>
            </button>
        </div>
        <div v-else-if="toolbarMode !== 'drawing' && !readonly" class="flex items-center gap-2 main-toolbar">
            <div class="join">
                <button
                    @click="startSelect()"
                    class="btn2 btn-sm join-item"
                    :title="trans('select-shapes')"
                    :class="{ 'btn-disabled': toolbarMode === 'select' }">
                    <i class="fa-regular fa-mouse-pointer" aria-hidden="true"></i>
                    <span class="sr-only" v-html="trans('select-shapes')"></span>
                </button>
                <button
                    @click="startShapeDraw('rect')"
                    class="btn2 btn-sm join-item"
                    :title="trans('add-square')"
                    :class="{ 'btn-disabled': toolbarMode === 'rect' }">
                    <i class="fa-regular fa-square" aria-hidden="true" />
                    <span class="sr-only" v-html="trans('add-square')"></span>
                </button>
                <button
                    @click="startShapeDraw('circle')"
                    class="btn2 btn-sm join-item"
                    :title="trans('add-circle')"
                    :class="{ 'btn-disabled': toolbarMode === 'circle' }">
                    <i class="fa-regular fa-circle" aria-hidden="true" />
                    <span class="sr-only" v-html="trans('add-circle')"></span>
                </button>
                <button
                    @click="addShape('text')"
                    class="btn2 btn-sm join-item"
                    :title="trans('add-text')"
                    :class="{ 'btn-disabled': toolbarMode === 'text' }">
                    <i class="fa-regular fa-text" aria-hidden="true" />
                    <span class="sr-only" v-html="trans('add-text')"></span>
                </button>
                <button
                    @click="toggleDrawing"
                    :title="trans('start-drawing')"
                    class="btn2 btn-sm join-item">
                    <i class="fa-regular fa-scribble" aria-hidden="true" />
                    <span class="sr-only" v-html="trans('start-drawing')"></span>
                </button>
            </div>
            <div class="join">
                <button
                    @click="openSearch"
                    class="btn2 btn-sm join-item"
                    :title="trans('add-entity')"
                    :class="{ 'btn-disabled': toolbarMode === 'drawing' }">
                    <i class="fa-regular fa-search" aria-hidden="true" />
                    <span class="sr-only" v-html="trans('add-entity')"></span>
                </button>
                <button
                    @click="openGallery"
                    :title="trans('add-image')"
                    class="btn2 btn-sm join-item"
                    :class="{ 'btn-disabled': toolbarMode === 'drawing' }">
                    <i class="fa-regular fa-file-image" aria-hidden="true" />
                    <span class="sr-only" v-html="trans('add-image')"></span>
                </button>
            </div>
        </div>
        <div v-else-if="readonly">
            <i v-html="trans('readonly')"></i>
        </div>
    </div>

    <input
        v-if="!loading"
        ref="colorInput"
        type="color"
        class="hidden"
        :value="currentColor"
        @input="onPickColor"
        @change="onPickColor"
    />

    <Browser
        v-if="!loading"
        :api="props.gallery"
        :opened="galleryOpened"
        :i18n="i18n"
        @selected="selectImage"
        @closed="closedGallery"
    ></Browser>

    <Settings
        v-if="!loading"
        :name="name"
        :opened="settingsOpened"
        @closed="closedSettings"
        :i18n="i18n"
    ></Settings>

    <EntitySearch
        v-if="!loading"
        :api="props.search"
        :opened="searchOpened"
        :i18n="i18n"
        @selected="selectEntity"
        @closed="closedSearch">
    </EntitySearch>

</template>

<script setup lang="ts">
import { ref, onMounted, reactive, nextTick, computed, watch, onBeforeUnmount} from 'vue';
import {useImage} from "vue-konva";
import { hslFromVar, readCssVar, hslString, tweakHsl } from '../../utility/colours';
import Browser from "../../gallery/Browser.vue";
import EntitySearch from "./EntitySearch.vue";
import Entity from "./Entity.vue";
import Settings from "./Settings.vue";

const props = defineProps<{
    save: String,
    load: String,
    gallery: String,
    search: String,
    readonly: Boolean,
}>()

const shapes = ref([]);
const dragItemId = ref(null);
const selectedIds = ref([]);
const selectedId = ref(null);
const name = ref('My whiteboard');
const stage = ref(null);
const transformer = ref(null);
const layer = ref(null);
const i18n = ref(null);
const urls = ref(null);

// Select mode
const toolbarMode = ref('select')

// Saving
const saving = ref(false);
const loading = ref(true);
const savingUrl = ref()

// Text editing state
const editingTextId = ref(null);
const editingText = ref('');
const textInput = ref(null);

// UI tick to re-compute overlay position on Konva events without syncing geometry to Vue
const uiTick = ref(0);
const moving = ref(false);

// Toolbar refs and helpers
const colorInput = ref<HTMLInputElement|null>(null);
const selectedShape = computed(() => {
    // If multiple selected, prefer the primary selectedId for single-shape UI.
    if (selectedId.value) {
        return shapes.value.find(s => s.id === selectedId.value) || null;
    }
    // fallback to first of selectedIds when primary isn't set
    if (selectedIds.value.length > 0) {
        return shapes.value.find(s => s.id === selectedIds.value[0]) || null;
    }
    return null;
});

// Shape mode drawing
const tempRect = ref<any>(null);
const tempCircle = ref<any>(null);
const shapeDrawStart = ref<{ x: number; y: number } | null>(null);


// Drawing
const isDrawing = ref(false)
const tempGroup = ref(null)
const strokeSize = ref(1)
const currentColor = ref(null)
const currentBgColor = ref(null)
const hitStrokeWidth = ref(12)

// Gallery
const galleryOpened = ref(false)
const imageRefs = ref({})

// Search
const searchOpened = ref(false)

// Settings
const settingsOpened = ref(false)


// Reactive input style that updates automatically
const inputStyle = computed(() => {
    // depend on uiTick so Konva drag/transform events can refresh this computed
    void uiTick.value;

    if (!editingTextId.value) return {};

    const shape = shapes.value.find(s => s.id === editingTextId.value);
    if (!shape) return {};

    const stageNode = stage.value?.getNode();
    if (!stageNode) return {};

    // Get current position from the actual Konva node
    const groupNode = stageNode.findOne(`#group-${editingTextId.value}`);
    if (!groupNode) return {};

    const stageContainer = stageNode.container();
    const containerRect = stageContainer.getBoundingClientRect();

    // Use getClientRect() of the actual node so transforms/scale are accounted for
    let rect: { x: number; y: number; width: number; height: number } | null = null;

    const r = groupNode.getClientRect();
    rect = { x: r.x, y: r.y, width: r.width, height: r.height };
    const padding = Math.max(5, Math.min(rect.width, rect.height) * 0.1);
    const fontSize = Math.max(10, Math.min(rect.height * 0.15, rect.width * 0.08, 24));

    return {
        left: (containerRect.left + rect.x + padding) + 'px',
        top: (containerRect.top + rect.y + padding) + 'px',
        width: (rect.width - (padding * 2)) + 'px',
        height: (rect.height - (padding * 2)) + 'px',
        fontSize: fontSize + 'px',
        textAlign: 'center',
        fontFamily: 'Arial',
        color: getTextColor(shape),
    };
});


const toolbarStyle = computed(() => {

});


const handleDragstart = (shape) => {
    dragItemId.value = shape.id;
    shape.moving = true;
    moving.value = true;
    shape.opacity = 0.9;

    // Move the dragged group visually on top without mutating shapes array
    const stageNode = stage.value?.getNode();
    const groupNode = stageNode?.findOne(`#group-${shape.id}`);
    groupNode?.moveToTop();

};

const handleDragend = (e, shape) => {
    dragItemId.value = null;
    shape.moving = false;
    moving.value = false;
    shape.opacity = 1;

    const pos = {
        x: e.target.x(),
        y: e.target.y()
    };
    shape.x = pos.x;
    shape.y = pos.y;
};

const handleDragmove = () => {
    if (editingTextId.value) {
        uiTick.value++; // refresh inputStyle without syncing geometry into shapes
    }
};

const startSelect = () => {
    toolbarMode.value = 'select';
    tempRect.value = null;
    tempCircle.value = null;
}

// Called from UI when user clicks the "add square" toolbar button.
const startShapeDraw = (type: 'rect'|'circle') => {
    // Cancel other modes
    toolbarMode.value = type;
    tempRect.value = null;
    tempCircle.value = null;
    shapeDrawStart.value = null;

    // Prevent stage panning while drawing a shape
    const stageNode = stage.value?.getNode();
    if (stageNode) {
        stageNode.draggable(false);
    }
};


const setupTransformerEvents = () => {
    const transformerNode = transformer.value?.getNode();
    if (!transformerNode) return;

    // Recompute textarea overlay while transforming
    transformerNode.off('transform.transformer'); // prevent duplicate handlers
    transformerNode.off('dragmove.transformer');
    transformerNode.off('transformend.transformer');
    transformerNode.off('dragend.transformer');

    transformerNode.on('transformend.transformer', (e) => {
        if (!selectedIds.value || !selectedIds.value.length) return;
        const nodes = transformerNode.nodes() || [];
        if (!nodes.length) return;

        // When multiple nodes are selected, persist each node's transform back to its shape model.
        nodes.forEach((group) => {
            // group.id() is `group-<shapeId>`; extract the shape id suffix.
            const gid = group.id();
            const match = gid && gid.toString().match(/^group-(.+)$/);
            if (!match) return;
            const sid = match[1];
            const shape = shapes.value.find(s => s.id === sid);
            if (!shape) return;

            const scaleX = group.scaleX() || 1;
            const scaleY = group.scaleY() || 1;

            // Persist transforms/position/rotation
            shape.scaleX = scaleX;
            shape.scaleY = scaleY;
            shape.rotation = group.rotation() || 0;
            shape.x = group.x();
            shape.y = group.y();
        });

        // Force redraw and update overlays
        uiTick.value++;
        transformerNode.getLayer().batchDraw();
    });
};

const selectShape = (shape, event?: MouseEvent) => {
    // Don't do any selection while in drawing mode to avoid confusion
    if (toolbarMode.value === 'drawing') {
        return;
    }

    // If clicking a second time on a text, edit the text
    let editingText = false;
    if (shape.text && selectedId.value === shape.id) {
        editText(shape)
        editingText = true;
    }

    // Shift-click: add/remove from multi-selection
    if (event && event.evt && event.evt.shiftKey) {
        const idx = selectedIds.value.indexOf(shape.id);
        if (idx === -1) {
            // add
            selectedIds.value.push(shape.id);
            // if no primary selectedId set, make this primary
            if (!selectedId.value) selectedId.value = shape.id;
        } else {
            // remove
            selectedIds.value.splice(idx, 1);
            // if it was primary, clear or pick next
            if (selectedId.value === shape.id) {
                selectedId.value = selectedIds.value.length ? selectedIds.value[0] : null;
            }
        }

        // update transformer to reflect multiple selection
        nextTick(() => {
            updateTransformer(false);
            setupTransformerEvents();
        });
        return;
    }

    // Regular click: select only this shape
    selectedIds.value = [shape.id];
    selectedId.value = shape.id;

    if (shape.fill) {
        currentColor.value = shape.fill;
    }
    nextTick(() => {
        updateTransformer(editingText);
        setupTransformerEvents();
    });
};

// Helper used by the template to check whether a shape is in current multi-selection
const isSelected = (id: string) => {
    return selectedIds.value.indexOf(id) !== -1;
};


const updateTransformer = (editingText: boolean = false) => {
    const transformerNode = transformer.value?.getNode();
    const stageNode = stage.value?.getNode();

    if (!transformerNode || !stageNode) {
        return;
    }

    // Build node list from selectedIds
    const nodeList = selectedIds.value
        .map(id => stageNode.findOne(`#group-${id}`))
        .filter(n => !!n);

    // If nothing selected, clear transformer
    if (!nodeList.length) {
        transformerNode.nodes([]);
        transformerNode.getLayer().batchDraw();
        return;
    }

    // If any of selected shapes are locked or editing text -> disable transformer
    const anyLocked = selectedIds.value.some(id => {
        const s = shapes.value.find(x => x.id === id);
        return s && s.locked;
    });
    if (anyLocked || editingText) {
        transformerNode.nodes([]);
        transformerNode.getLayer().batchDraw();
        return;
    }

    transformerNode.nodes(nodeList);
    transformerNode.getLayer().batchDraw();
};


// Actions: delete, lock, color
const deleteSelected = () => {
    if (!selectedIds.value.length) return;

    // Remove all selected shapes from shapes array
    const idsToRemove = new Set(selectedIds.value);
    for (let i = shapes.value.length - 1; i >= 0; i--) {
        if (idsToRemove.has(shapes.value[i].id)) {
            shapes.value.splice(i, 1);
        }
    }

    // Clear selection state
    selectedIds.value = [];
    selectedId.value = null;
    editingTextId.value = null;
    uiTick.value++;

    // Ensure transformer no longer references removed nodes
    updateTransformer();
};

const duplicateSelected = () => {
    if (!selectedIds.value.length) return;

    const offset = 30;
    const newShapes = [];

    // Duplicate each selected shape
    for (const id of selectedIds.value) {
        const shape = shapes.value.find(s => s.id === id);
        if (!shape) continue;

        const clone = JSON.parse(JSON.stringify(shape));

        // Generate new unique ID
        clone.id = Math.round(Math.random() * 10000).toString();

        // Offset position
        if (typeof clone.x === 'number') clone.x += offset;
        if (typeof clone.y === 'number') clone.y += offset;

        shapes.value.push(clone);
        newShapes.push(clone);
    }

    // Update selection to new clones
    selectedIds.value = newShapes.map(s => s.id);
    selectedId.value = newShapes.length === 1 ? newShapes[0].id : null;
    editingTextId.value = null;

    // update transformer to reflect multiple selection
    nextTick(() => {
        updateTransformer(false);
        setupTransformerEvents();
    });

    uiTick.value++;
};

const toggleLock = () => {
    const s = selectedShape.value;
    if (!s) return;
    s.locked = !s.locked;
    updateTransformer();
    uiTick.value++;
};

const openColorPicker = () => {
    colorInput.value?.click();
};

const onPickColor = (e: Event) => {
    const input = e.target as HTMLInputElement
    if (!input) return
    if (toolbarMode.value === 'drawing') {
        tempGroup.value.fill = input.value
        currentColor.value = input.value
        currentBgColor.value = input.value
        return
    }
    const s = selectedShape.value;
    if (!s) return;
    if (input?.value) {
        s.fill = input.value;
        currentColor.value = input.value;
        currentBgColor.value = input.value
        uiTick.value++;
    }
};

const getTextSize = (shape) => {
    if (!shape) return 14;

    if (shape.fontSize) {
        return shape.fontSize;
    }

    let fontSize = 42;
    const text = (shape.text || '').toString();

    // Decrease font size until fits
    while (true) {
        const tmp = new Konva.Text({
            text,
            fontSize,
            fontFamily: shape.fontFamily,
        });
        const { width, height } = tmp.getClientRect();

        if (width <= shape.width && height <= shape.height) break;
        fontSize -= 1;
        if (fontSize <= 1) break;
    }
    return fontSize;
};

const getTextPadding = (shape) => {
    return 5;
};

const editText = (shape) => {;
    if (!shape || shape.locked) return;
    editingTextId.value = shape.id;
    editingText.value = shape.text || '';
    nextTick(() => {
        textInput.value?.focus();
    });
};

const updateTextPreview = () => {
    if (editingTextId.value) {
        const shape = shapes.value.find(s => s.id === editingTextId.value);
        if (shape) {
            shape.text = editingText.value;
        }
    }
};

const saveText = () => {
    if (editingTextId.value) {
        const shape = shapes.value.find(s => s.id === editingTextId.value);
        if (shape) {
            shape.text = editingText.value;
        }
    }
    cancelTextEdit();
};

const cancelTextEdit = () => {
    editingTextId.value = null;
    editingText.value = '';
};

const addShape = (type) => {
    const { x: tlx, y: tly, scaleX, scaleY } = getStageVisibleTopLeft();
    // Convert 50px screen offset into stage-space offset
    const offsetX = 50 / scaleX;
    const offsetY = 50 / scaleY;


    shapes.value.push({
        id: Math.round(Math.random() * 10000).toString(),
        type,
        x: tlx + offsetX,
        y: tly + offsetY,
        scaleX: 1,
        scaleY: 1,
        width: 100,
        height: type === "text" ? 50 : 80,
        radius: type === "circle" ? 40 : null,
        fill: type === 'text' ? cssVariable('--bc') : cssVariable('--b1'),
        text: type === "text" ? "Click to edit" : null,
        fontFamily: type === "text" ? 'Arial' : null,
        locked: false,
        moving: false,
    });
};

const handleStageClick = (e) => {
    if (toolbarMode.value === 'drawing' || props.readonly) {
        return;
    }
    if (e.target === e.target.getStage()) {
        selectedId.value = null;
        selectedIds.value = [];
        updateTransformer();
        if (editingTextId.value) {
            cancelTextEdit();
        }
    }
};

const getTextColor = (shape) => {
    return (shape.fill || '#000').toString();
};

const toggleDrawing = () => {
    // Start
    if (toolbarMode.value !== 'drawing') {
        toolbarMode.value = 'drawing';
        return;
    }

    // Finalize
    toolbarMode.value = 'select';
    if (tempGroup.value) {
        // Measure visual bounds and normalize children points
        const stageNode = stage.value?.getNode();
        const node = stageNode?.findOne(`#temp-group-${tempGroup.value.id}`);
        // console.log('on a le node', node);
        if (node) {
            const r = node.getClientRect();

            // Normalize points from stage-space to group-local space
            tempGroup.value.children = tempGroup.value.children.map((line) => {
                const pts = line.points;
                const normalized = pts.map((v, idx) => (idx % 2 === 0 ? v - r.x : v - r.y));
                return { ...line, points: normalized };
            });

            // Save group geometry
            tempGroup.value.x = r.x;
            tempGroup.value.y = r.y;
            tempGroup.value.width = r.width;
            tempGroup.value.height = r.height;
        }

        tempGroup.value.moving = false;
        tempGroup.value.locked = false;
        tempGroup.value.draggable = true;
        shapes.value.push(tempGroup.value);
        tempGroup.value = null;
    }
}

const handleMouseDown = (e) => {
    // Ignore mousedown when clicking on an existing shape/group so Konva's drag handling
    // can proceed without us starting a new temporary drawing stroke/shape.
    try {
        const node = e.target;
        // If the event target or any of its parent groups is a shape group (id starts with 'group-'),
        // bail out — this is a user interacting with an existing shape (drag/transform/etc).
        if (node && typeof node.getParent === 'function') {
            let p = node;
            while (p) {
                const id = typeof p.id === 'function' ? p.id() : (p.id ?? null);
                if (id && id.toString().startsWith('group-')) {
                    return;
                }
                p = p.getParent ? p.getParent() : null;
                // stop when we reach the stage
                if (p && p.getStage && p.getStage() === p) break;
            }
        }
    } catch (err) {
        // ignore any unexpected shape of the event object and continue normally
    }


    // If freehand drawing mode
    if (toolbarMode.value === 'drawing') {
        isDrawing.value = true;

        const pos = getPointerInLayerSpace();
        if (!pos) return;

        if (!tempGroup.value) {
            tempGroup.value = {
                id: Date.now(),
                type: "group",
                children: [],
                scaleX: 1,
                scaleY: 1,
            }
        }

        tempGroup.value.children.push({
            id: Date.now() + "-lin",
            type: "draw",
            points: [pos.x, pos.y],
            fill: currentColor.value,
            strokeWidth: strokeSize.value,
            hitStrokeWidth: hitStrokeWidth.value,
        });
        return;
    }

    // If shape-draw (rectangle) mode
    if (toolbarMode.value === 'rect') {
        const pos = getPointerInLayerSpace();
        if (!pos) return;
        shapeDrawStart.value = pos;

        // Create a temporary visual rect
        tempRect.value = {
            id: 'temp-rect-' + Date.now(),
            type: 'rect',
            x: pos.x,
            y: pos.y,
            width: 0,
            height: 0,
            scaleX: 1,
            scaleY: 1,
            fill: currentBgColor.value || cssVariable('--b1'),
            stroke: null,
            locked: false,
            moving: false,
        };
        return;
    }
    // If shape-draw (circle) mode
    if (toolbarMode.value === 'circle') {
        const pos = getPointerInLayerSpace();
        if (!pos) return;
        shapeDrawStart.value = pos;

        // Create a temporary visual circle (center at start point, radius 0 initially)
        tempCircle.value = {
            id: 'temp-circle-' + Date.now(),
            type: 'circle',
            cx: pos.x,
            cy: pos.y,
            radius: 0,
            scaleX: 1,
            scaleY: 1,
            fill: currentBgColor.value || cssVariable('--b1'),
            stroke: null,
            locked: false,
            moving: false,
        };
        return;
    }



    if (toolbarMode.value === 'select') return;

    const pos = getPointerInLayerSpace();
    if (!pos) return;

    if (!tempGroup.value) {
        tempGroup.value = {
            id: Date.now(),
            type: "group",
            children: [],
            scaleX: 1,
            scaleY: 1,
        }
    }

    tempGroup.value.children.push({
        id: Date.now() + "-lin",
        type: "draw",
        points: [pos.x, pos.y],
        fill: currentColor.value,
        strokeWidth: strokeSize.value,
        hitStrokeWidth: hitStrokeWidth.value,
    });
}

// Add this helper to convert pointer position into the layer's local coordinates
function getPointerInLayerSpace() {
    const stageNode = stage.value?.getNode();
    const layerNode = (stageNode && stageNode.findOne('Layer')) || layer.value?.getNode();
    if (!stageNode || !layerNode) return null;

    const p = stageNode.getPointerPosition();
    if (!p) return null;

    // Transform pointer from screen/stage space into this layer's local space
    const tr = layerNode.getAbsoluteTransform().copy();
    tr.invert();
    const local = tr.point(p);
    return { x: local.x, y: local.y };
}


const draw = (e) => {
    // Freehand drawing
    if (isDrawing.value && toolbarMode.value === 'drawing') {
        const pos = getPointerInLayerSpace();
        if (!pos) return;

        const last = tempGroup.value.children[tempGroup.value.children.length - 1];
        last.points = last.points.concat([pos.x, pos.y]);
        return;
    }

    // Rectangle live preview
    if (toolbarMode.value === 'rect' && shapeDrawStart.value && tempRect.value) {
        const pos = getPointerInLayerSpace();
        if (!pos) return;

        // Compute box that supports dragging in any direction
        const sx = shapeDrawStart.value.x;
        const sy = shapeDrawStart.value.y;
        const x = Math.min(sx, pos.x);
        const y = Math.min(sy, pos.y);
        const w = Math.abs(pos.x - sx);
        const h = Math.abs(pos.y - sy);

        tempRect.value.x = x;
        tempRect.value.y = y;
        tempRect.value.width = Math.max(1, w);
        tempRect.value.height = Math.max(1, h);
        // request overlay update
        uiTick.value++;
    }
    // Circle live preview
    if (toolbarMode.value === 'circle' && shapeDrawStart.value && tempCircle.value) {
        const pos = getPointerInLayerSpace();
        if (!pos) return;

        const sx = shapeDrawStart.value.x;
        const sy = shapeDrawStart.value.y;
        const dx = pos.x - sx;
        const dy = pos.y - sy;
        const r = Math.max(1, Math.sqrt(dx * dx + dy * dy));

        tempCircle.value.cx = sx;
        tempCircle.value.cy = sy;
        tempCircle.value.radius = r;
        uiTick.value++;
    }
}

const handeMouseUp = (e) => {
    // Finalize freehand drawing
    if (toolbarMode.value === 'drawing') {
        isDrawing.value = false;
        return;
    }

    // Finalize rectangle drawing
    if (toolbarMode.value === 'rect') {
        if (tempRect.value) {
            // Push normalized rect into shapes
            const newRect = {
                id: Math.round(Math.random() * 10000).toString(),
                type: 'rect',
                x: tempRect.value.x,
                y: tempRect.value.y,
                scaleX: 1,
                scaleY: 1,
                width: tempRect.value.width,
                height: tempRect.value.height,
                radius: null,
                fill: tempRect.value.fill || cssVariable('--b1'),
                locked: false,
                moving: false,
            };
            shapes.value.push(newRect);
            uiTick.value++;
        }

        // Clear temporary state and exit shape draw mode
        tempRect.value = null;
        return;
    }

    // Finalize circle drawing
    if (toolbarMode.value === 'circle') {
        if (tempCircle.value) {
            const newCircle = {
                id: Math.round(Math.random() * 10000).toString(),
                type: 'circle',
                x: tempCircle.value.cx - tempCircle.value.radius,
                y: tempCircle.value.cy - tempCircle.value.radius,
                scaleX: 1,
                scaleY: 1,
                width: tempCircle.value.radius * 2,
                height: tempCircle.value.radius * 2,
                radius: tempCircle.value.radius,
                fill: tempCircle.value.fill || cssVariable('--b1'),
                locked: false,
                moving: false,
            };
            shapes.value.push(newCircle);
            uiTick.value++;
        }

        tempCircle.value = null;
        return;
    }
}


// Disable stage dragging while in drawing mode
watch(toolbarMode, (isOn) => {
    const stageNode = stage.value?.getNode();
    if (stageNode) {
        stageNode.draggable(!isOn);
        stageNode.getLayer()?.batchDraw?.();
    }
});


// Compute the visible top-left of the stage in stage coordinates
function getStageVisibleTopLeft() {
    const stageNode = stage.value?.getNode();
    if (!stageNode) return { x: 0, y: 0, scaleX: 1, scaleY: 1 };

    const scaleX = stageNode.scaleX() || 1;
    const scaleY = stageNode.scaleY() || 1;

    // When the stage is panned to (stage.x(), stage.y()), the visible top-left
    // in stage coordinates is (-x/scaleX, -y/scaleY)
    const x = -stageNode.x() / scaleX;
    const y = -stageNode.y() / scaleY;

    return { x, y, scaleX, scaleY };
}

const openGallery = () => {
    galleryOpened.value = true
}

// Force redraw when an image finishes loading
function watchImage(uuid: string, shapeId: string) {
    const r = imageRefs.value[uuid];
    if (!r) return;

    watch(
        () => r,
        (imgEl) => {
            if (imgEl) {
                // If you want the shape to match the real image size the first time it loads:
                const shape = shapes.value.find(s => s.id === shapeId);
                if (shape && (!shape.width || !shape.height)) {
                    // Use natural size on first load if width/height were falsy
                    shape.width = imgEl.naturalWidth || shape.width || 100;
                    shape.height = imgEl.naturalHeight || shape.height || 80;
                }

                // Force Konva to repaint immediately
                const layerNode = layer.value?.getNode();
                layerNode?.batchDraw?.();
            }
        },
        { immediate: true }
    );
}


const selectImage = (image) => {
    const [imageNode] = useImage(image.src, 'anonymous');
    imageRefs.value[image.uuid] = imageNode;

    const { x: tlx, y: tly, scaleX, scaleY } = getStageVisibleTopLeft();
    // Convert 50px screen offset into stage-space offset
    const offsetX = 50 / scaleX;
    const offsetY = 50 / scaleY;

    const id = Math.round(Math.random() * 10000).toString();

    shapes.value.push({
        id: id,
        type: "image",
        x: tlx + offsetX,
        y: tly + offsetY,
        scaleX: 1,
        scaleY: 1,
        width: null,
        height: null,
        uuid: image.uuid,
        name: image.name,
        locked: false,
        moving: false,
    });
    watchImage(image.uuid, id);
}

const closedGallery = () => {
    galleryOpened.value = false
}

// Return the actual HTMLImageElement (or null) for Konva
const getImageEl = (shape) => {
    if (shape.type === 'entity') {
        return imageRefs.value[shape.entity] || null;
    }
    return imageRefs.value[shape.uuid] || null;
}

const openSearch = () => {
    searchOpened.value = true
}

const closedSearch = () => {
    searchOpened.value = false
}

const selectEntity = (entity) => {
    searchOpened.value = false;


    const [imageNode] = useImage(entity.image, 'anonymous');
    imageRefs.value[entity.id] = imageNode;

    const { x: tlx, y: tly, scaleX, scaleY } = getStageVisibleTopLeft();
    // Convert 50px screen offset into stage-space offset
    const offsetX = 50 / scaleX;
    const offsetY = 50 / scaleY;

    const id = Math.round(Math.random() * 10000).toString();

    shapes.value.push({
        id: id,
        type: "entity",
        x: tlx + offsetX,
        y: tly + offsetY,
        width: 128,
        height: 128,
        scaleX: 1,
        scaleY: 1,
        entity: entity.id,
        name: entity.name,
        link: entity.link,
        fill: cssVariable('--bc'),
        locked: false,
        moving: false,
    });
}



const saveWhiteboard = () => {
    if (saving.value) return

    let data = {
        'name': name.value,
        'data': shapes.value
    }

    saving.value = true;

    axios({
        method: 'put',
        url: savingUrl.value,
        data: data
    })
        .then(res => {

            if (res.data?.toast) {
                window.showToast(res.data.toast);
            }

            saving.value = false
        }).catch(err => {
        // Result with a response, hopefully a 422 error
        saving.value = false

        if (err.response.data.errors) {
            Object.entries(err.response.data.errors).forEach(([name, text]) => {
                window.showToast(text, 'error');
            })
        }
    })
}

const resetRotation = () => {
    if (!selectedIds.value || !selectedIds.value.length) return;

    selectedIds.value.forEach(id => {
        const shape = shapes.value.find(s => s.id === id);
        if (shape) {
            shape.rotation = 0;
        }
    })
}

const nothingToRotate = () => {
    if (!selectedIds.value || !selectedIds.value.length) {
        console.log('nothing selected');
        return true;
    }
    let rotatable = false;
    selectedIds.value.forEach(id => {
        const shape = shapes.value.find(s => s.id === id);
        if (shape && shape.rotation) {
            rotatable = true;
        }
    })
    return !rotatable;
}

const pushTo = (where: 'front' | 'back') => {
    if (!selectedIds.value || !selectedIds.value.length) return;

    // Build a map for quick lookup of selected ids
    const selectedSet = new Set(selectedIds.value);

    // Extract selected items preserving their current relative order
    const selectedItems = shapes.value.filter(s => selectedSet.has(s.id));

    // Remove selected items from shapes array in-place (iterate backwards)
    for (let i = shapes.value.length - 1; i >= 0; i--) {
        if (selectedSet.has(shapes.value[i].id)) {
            shapes.value.splice(i, 1);
        }
    }
    if (where === 'front') {
        // Append selected items in their original relative order -> top of canvas
        selectedItems.forEach(item => shapes.value.push(item));
    } else {
        // Prepend selected items in their original relative order -> bottom of canvas
        // To maintain original relative order when unshifting, insert them in reverse.
        for (let i = selectedItems.length - 1; i >= 0; i--) {
            shapes.value.unshift(selectedItems[i]);
        }
    }


    // Force UI refresh for overlays and transformer
    uiTick.value++;

}

const cssVariable = (variable: string) => {
    const base = hslFromVar(variable);
    if (!base) return `hsl(${readCssVar('--p')})`;
    return hslString(base);
}

const loadImages = (images) => {
    //console.log(images);
    Object.entries(images).forEach(([id, src]) => {
        const [imageNode] = useImage(src, 'anonymous');
        imageRefs.value[id] = imageNode;
    })
}



const openSettings = () => {
    settingsOpened.value = true
}
const closedSettings = (newName) => {
    settingsOpened.value = false
    name.value = newName;
}


const stageSize = {
    width: window.innerWidth,
    height: window.innerHeight,
    draggable: true,
};


// Zoom state and helpers
const minScale = 0.2;
const maxScale = 3;
const zoomStep = 1.15; // multiplicative step for smooth zooming

function setStageScale(newScale: number, pointer?: { x: number; y: number }) {
    const stageNode = stage.value?.getNode();
    if (!stageNode) return;

    // Clamp
    const scale = Math.max(minScale, Math.min(maxScale, newScale));

    if (pointer) {
        // Zoom to pointer: compute position in stage coords before changing scale
        const mousePointTo = {
            x: (pointer.x - stageNode.x()) / (stageNode.scaleX() || 1),
            y: (pointer.y - stageNode.y()) / (stageNode.scaleY() || 1),
        };

        stageNode.scale({ x: scale, y: scale });

        // after scale, adjust stage position so that the pointer stays pointing at same stage coordinate
        const newPos = {
            x: pointer.x - mousePointTo.x * scale,
            y: pointer.y - mousePointTo.y * scale,
        };
        stageNode.x(newPos.x);
        stageNode.y(newPos.y);
    } else {
        // center-preserving fallback: keep center in place
        const container = stageNode.container();
        const rect = container.getBoundingClientRect();
        const stageCenter = { x: rect.width / 2, y: rect.height / 2 };
        setStageScale(newScale, stageCenter);
        return;
    }

    stageNode.getLayer()?.batchDraw?.();
    uiTick.value++; // update overlays
}

const zoomBy = (factor: number, pointer?: { x: number; y: number }) => {
    const stageNode = stage.value?.getNode();
    if (!stageNode) return;
    const current = stageNode.scaleX() || 1;
    setStageScale(current * factor, pointer);
};

const zoomIn = (ev?: MouseEvent) => {
    const stageNode = stage.value?.getNode();
    if (!stageNode) return;
    const pointer = ev ? { x: ev.clientX, y: ev.clientY } : undefined;
    zoomBy(zoomStep, pointer);
};

const zoomOut = (ev?: MouseEvent) => {
    const stageNode = stage.value?.getNode();
    if (!stageNode) return;
    const pointer = ev ? { x: ev.clientX, y: ev.clientY } : undefined;
    zoomBy(1 / zoomStep, pointer);
};

// Wheel handler: when Shift is pressed, zoom; otherwise default behavior (we keep stage draggable)
const handleWheel = (e) => {
    // Only act if shift key is held. This avoids interfering with normal panning or other interactions.
    //if (!e.shiftKey) return;

    // Prevent page scroll
    e.evt.preventDefault();

    const stageNode = stage.value?.getNode();
    if (!stageNode) return;

    const pointer = { x: e.evt.clientX, y: e.evt.clientY };

    // Use deltaY to determine zoom direction; normalize sign.
    const zoomDirection = e.evt.deltaY > 0 ? 1 / zoomStep : zoomStep;
    zoomBy(zoomDirection, pointer);
};

const trans = (key: string) => {
    return i18n.value[key] || key
}



onMounted(() => {
    currentColor.value = cssVariable('--bc')
    currentBgColor.value = cssVariable('--b1')
    savingUrl.value = props.save

    if (props.new) {
        loading.value = false
        return
    }

    axios.get(props.load).then(res => {
        if (res.data) {
            name.value = res.data.name
            shapes.value = res.data.data
            i18n.value = res.data.i18n
            urls.value = res.data.urls

            if (res.data.images) {
                loadImages(res.data.images)
            }
        }
        loading.value = false
    })

    window.addEventListener('keydown', handleKeyDown);

    // Clean up listener on unmount
    onBeforeUnmount(() => {
        cleanupBeforeUnmount();
    });

})


// Keyboard handler: delete selected shape when Delete key pressed
const handleKeyDown = (e: KeyboardEvent) => {
    // Ignore if readonly, or currently editing text (we don't want to delete while typing),
    // or if focus is inside an input/textarea (native behavior)
    const active = document.activeElement;
    const inputFocused = active && (
        active.tagName === 'INPUT' ||
        active.tagName === 'TEXTAREA' ||
        (active as HTMLElement).isContentEditable
    );

    if (props.readonly || editingTextId.value || inputFocused) return;

    // Support both 'Delete' and legacy keyCode 46
    if (e.key === 'Delete' || (e as any).keyCode === 46) {
        e.preventDefault();
        deleteSelected();
    }

    // Support duplicating selected shapes with Ctrl+D or Cmd+D
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'd') {
        e.preventDefault(); // prevent browser "bookmark" shortcut
        duplicateSelected();
    }

    if (e.key === 'Escape' || (e as any).keyCode === 27) {
        e.preventDefault();

        // If currently in freehand drawing and there is a tempGroup, discard it and stop drawing
        if (toolbarMode.value === 'drawing') {
            isDrawing.value = false;
            tempGroup.value = null;
            // exit drawing mode
            toolbarMode.value = 'select';
            uiTick.value++;
            return;
        }

        // If in rectangle or circle draw mode: cancel the temporary rect/circle and exit to select
        if (toolbarMode.value === 'rect' || toolbarMode.value === 'circle') {
            tempRect.value = null;
            shapeDrawStart.value = null;
            toolbarMode.value = 'select';
            uiTick.value++;
            return;
        }

        // If any shapes are selected, clear selection
        if (selectedIds.value && selectedIds.value.length) {
            selectedIds.value = [];
            selectedId.value = null;
            updateTransformer();
            uiTick.value++;
            return;
        }
    }
    if (e.key === 'Enter' || (e as any).keyCode === 13) {
        if (toolbarMode.value === 'drawing') {
            e.preventDefault();
            // Reuse the same finalization as the UI toggle: push tempGroup into shapes
            toggleDrawing();
            return;
        }
    }
};

const autoFont = () => {
    if (!selectedShape.value || selectedShape.value.type !== 'text') return
    delete selectedShape.value.fontSize;
}

const biggerFont = () => {
    if (!selectedShape.value || selectedShape.value.type !== 'text') return
    selectedShape.value.fontSize = (selectedShape.value.fontSize || 10) + 2
}

const smallerFont = () => {
    if (!selectedShape.value || selectedShape.value.type !== 'text') return
    selectedShape.value.fontSize = (selectedShape.value.fontSize || 12) - 2
}

const cleanupBeforeUnmount = () => {
    window.removeEventListener('keydown', handleKeyDown);
}

</script>
