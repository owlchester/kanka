<template>
    <div class="w-full h-screen flex items-center justify-center align-middle text-2xl flex-col gap-4" v-if="loading">
        <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
        <span>Loading</span>
    </div>
    <div class="toolbar fixed w-full bg-base-100 p-2 flex items-center justify-between gap-2 z-50" v-if="!loading">
        <div class="flex gap-1 items-center">
            <span v-html="name"></span>
            <div
                v-if="!props.readonly"
                class="cursor-pointer"
                @click="openSettings"
            >
                <i
                    class="fa-regular fa-cog"
                    aria-hidden="true"
                >
                </i>
                <span class="sr-only">Edit settings</span>
            </div>
        </div>


        <div class="actions flex items-center" v-if="!props.readonly">
            <button
                class="btn2 btn-sm btn-primary join-item"
                :class="{ 'btn-disabled': saving }"
                @click="saveWhiteboard">
                <i class="fa-regular fa-save" aria-hidden="true" v-if="!saving" />
                <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" v-else />
                Save
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
                :config="{ id: `group-${shape.id}`, draggable: !shape.locked, x: shape.x, y: shape.y }"
                @dragstart="handleDragstart(shape)"
                @dragmove="handleDragmove(shape)"
                @dragend="handleDragend($event, shape)"
                @click="selectShape(shape)"
            >
                <v-rect v-if="shape.type==='rect'"
                        :config="{
                            x: 0, y: 0,
                            width: shape.width, height: shape.height,
                            fill: shape.fill || 'lightblue',
                            cornerRadius: 6,
                        }"
                />
                <v-circle v-if="shape.type==='circle'"
                          :config="{
                            x: shape.radius,
                            y: shape.radius,
                            radius: shape.radius,
                            fill: shape.fill || 'lightgreen',
                        }"
                />
                <v-line v-if="shape.type === 'group'" v-for="line in shape.children"
                        :key="line.id"
                        :config="{
                            points: line.points,
                            stroke: shape.fill,
                            strokeWidth: line.strokeWidth,
                            hitStrokeWidth: hitStrokeWidth,
                            lineCap: 'round',
                            lineJoin: 'round',
                        }" />

                <v-image v-if="shape.type === 'image'"
                         :config="{
                            width: shape.width,
                            height: shape.height,
                            image: getImageEl(shape),
                            cornerRadius: 4
                         }" />


                <v-image v-if="shape.type === 'entity'"
                         :config="{
                            width: shape.width,
                            height: shape.height,
                            image: getImageEl(shape),
                            cornerRadius: 4
                         }">
                </v-image>
                <v-text
                    v-if="shape.type === 'entity'"
                    @click="openEntityLink(shape)"
                    :config="{
                        x: 0,
                        y: shape.height + 6,
                        width: shape.width,
                        text: shape.name || '',
                        fontSize: 14,
                        fontFamily: 'Arial',
                        fill: shape.fill,
                        align: 'center',
                        draggable: false,
                        listening: true,
                        // show cursor-hand on hover
                    }"
                />

                <v-text v-if="shape.type === 'text' && (!editingTextId || editingTextId !== shape.id)"
                        :config="{
                            x: getTextPadding(shape),
                            y: getTextPadding(shape),
                            width: shape.width - (getTextPadding(shape) * 2),
                            height: shape.height - (getTextPadding(shape) * 2),

                            text: shape.text,
                            fontSize: getTextSize(shape),
                            fontFamily: 'Arial',
                            fill: getTextColor(shape),
                            align: 'center',
                            verticalAlign: 'middle',
                            wrap: 'word',
                        }"
                />
            </v-group>

            <v-group v-if="tempGroup" :key="tempGroup.id" :config="{ id: `temp-group-${tempGroup.id}` }">
                <v-line v-for="line in tempGroup.children"
                        :key="line.id"
                        :config="{
                            points: line.points,
                            stroke: tempGroup.fill,
                            strokeWidth: line.strokeWidth,
                            lineCap: 'round',
                            lineJoin: 'round',
                        }" />
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
        <div v-if="drawingMode" class="flex items-center gap-2 main-toolbar">
            <div class="join">

                <button
                    class="btn2 btn-sm join-item"
                    title="Thin stroke"
                    @click.stop="strokeSize = 1"
                >
                    <i class="fa-regular fa-paintbrush-fine" aria-hidden="true"></i>
                    <span class="sr-only">Thin stroke</span>
                </button>
                <button
                    class="btn2 btn-sm join-item"
                    title="Large stroke"
                    @click.stop="strokeSize = 3"
                >
                    <i class="fa-regular fa-paintbrush" aria-hidden="true"></i>
                    <span class="sr-only">Large stroke</span>
                </button>
                <button
                    class="btn2 btn-sm join-item"
                    title="Change color"
                    @click.stop="openColorPicker"
                >
                    <i class="fa-regular fa-palette" aria-hidden="true"></i>
                    <span class="sr-only">Color</span>
                </button>
                <button
                    @click="toggleDrawing"
                    class="btn2 btn-sm join-item">
                    <i class="fa-regular fa-check" aria-hidden="true" />
                    <span class="sr-only">End drawing</span>
                </button>
            </div>
        </div>
        <div class="flex items-center gap-2 shape-toolbar " v-else-if="selectedShape">
            <div class="join">
                <button
                    class="btn2 btn-sm join-item"
                    :class="selectedShape.locked ? 'btn-warning' : ''"
                    :title="selectedShape.locked ? 'Unlock' : 'Lock'"
                    @click.stop="toggleLock"
                >
                    <i class="fa-regular" :class="selectedShape.locked ? 'fa-lock' : 'fa-lock-open'" aria-hidden="true"></i>
                    <span class="sr-only">{{ selectedShape.locked ? 'Unlock' : 'Lock' }}</span>
                </button>

                <button
                    class="btn2 btn-sm join-item"
                    title="Change color"
                    @click.stop="openColorPicker"
                >
                    <i class="fa-regular fa-palette" aria-hidden="true"></i>
                    <span class="sr-only">Color</span>
                </button>
            </div>

            <div class="join">
                <button
                    class="btn2 btn-sm join-item"
                    title="Push to front"
                    @click.stop="pushTo('front')"
                >
                    <i class="fa-regular fa-up-to-line" aria-hidden="true"></i>
                    <span class="sr-only">Push to front</span>
                </button>
                <button
                    class="btn2 btn-sm join-item"
                    title="Push to back"
                    @click.stop="pushTo('back')"
                >
                    <i class="fa-regular fa-down-to-line" aria-hidden="true"></i>
                    <span class="sr-only">Push to back</span>
                </button>
            </div>
            <button
                class="btn2 btn-sm text-error"
                title="Delete"
                @click.stop="deleteSelected"
            >
                <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                <span class="sr-only">Delete</span>
            </button>
        </div>
        <div v-else-if="!drawingMode && !readonly" class="flex items-center gap-2 main-toolbar">
            <div class="join">
                <button
                    @click="addShape('rect')"
                    class="btn2 btn-sm join-item"
                    :class="{ 'btn-disabled': drawingMode }">
                    <i class="fa-regular fa-square" aria-hidden="true" />
                    <span class="sr-only">Add square</span>
                </button>
                <button
                    @click="addShape('circle')"
                    class="btn2 btn-sm join-item"
                    :class="{ 'btn-disabled': drawingMode }">
                    <i class="fa-regular fa-circle" aria-hidden="true" />
                    <span class="sr-only">Add circle</span>
                </button>
                <button
                    @click="addShape('text')"
                    class="btn2 btn-sm join-item"
                    :class="{ 'btn-disabled': drawingMode }">
                    <i class="fa-regular fa-text" aria-hidden="true" />
                    <span class="sr-only">Add text</span>
                </button>
                <button
                    @click="toggleDrawing"
                    class="btn2 btn-sm join-item">
                    <i class="fa-regular fa-scribble" aria-hidden="true" />
                    <span class="sr-only">Start drawing</span>
                </button>
            </div>
            <div class="join">
                <button
                    @click="openSearch"
                    class="btn2 btn-sm join-item"
                    :class="{ 'btn-disabled': drawingMode }">
                    <i class="fa-regular fa-search" aria-hidden="true" />
                    <span class="sr-only">Add entity</span>
                </button>
                <button
                    @click="openGallery"
                    class="btn2 btn-sm join-item"
                    :class="{ 'btn-disabled': drawingMode }">
                    <i class="fa-regular fa-file-image" aria-hidden="true" />
                    <span class="sr-only">Add image</span>
                </button>
            </div>
        </div>
        <div v-else-if="readonly">
            <i>Readonly</i>
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
    ></Settings>

    <Entity
        v-if="!loading"
        :api="props.search"
        :opened="searchOpened"
        @selected="selectEntity"
        @closed="closedSearch">
    </Entity>

</template>

<script setup lang="ts">
import { ref, onMounted, reactive, nextTick, computed, watch, onBeforeUnmount} from 'vue';
import {useImage} from "vue-konva";
import { hslFromVar, readCssVar, hslString, tweakHsl } from '../../utility/colours';
import Browser from "../../gallery/Browser.vue";
import Entity from "./Entity.vue";
import Settings from "./Settings.vue";

const props = defineProps<{
    save: String,
    load: String,
    gallery: String,
    search: String,
    i18n: undefined,
    readonly: Boolean,
}>()

const shapes = ref([]);
const dragItemId = ref(null);
const selectedId = ref(null);
const name = ref('My whiteboard');
const stage = ref(null);
const transformer = ref(null);
const layer = ref(null);

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
const selectedShape = computed(() => shapes.value.find(s => s.id === selectedId.value) || null);

// Drawing
const drawingMode = ref(false)
const isDrawing = ref(false)
const tempGroup = ref(null)
const strokeSize = ref(1)
const currentColor = ref(null)
const strokeSizePicker = ref(false)
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

    // Move the dragged group visually on top without mutating shapes array
    const stageNode = stage.value?.getNode();
    const groupNode = stageNode?.findOne(`#group-${shape.id}`);
    groupNode?.moveToTop();

};

const handleDragend = (e, shape) => {
    dragItemId.value = null;
    shape.moving = false;
    moving.value = false;

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


const setupTransformerEvents = () => {
    const transformerNode = transformer.value?.getNode();
    if (!transformerNode) return;

    // Recompute textarea overlay while transforming
    transformerNode.off('transform.transformer'); // prevent duplicate handlers
    transformerNode.off('dragmove.transformer');
    transformerNode.off('transformend.transformer');
    transformerNode.off('dragend.transformer');

    transformerNode.on('transform.transformer dragmove.transformer', () => {
        if (editingTextId.value) uiTick.value++;

        // Live-adjust corner radius to keep it visually ~6px
        const group = transformerNode.nodes()[0];
        if (!group) return;
        const rectNode = group.findOne('Rect');
        if (rectNode) {
            const abs = group.getAbsoluteScale();
            const s = Math.max(abs.x, abs.y) || 1; // keepRatio true -> x≈y
            // Set model corner radius so rendered radius ≈ 6px
            rectNode.cornerRadius(6 / s);
            rectNode.getLayer()?.batchDraw();
        }
    });
    transformerNode.on('transformend.transformer dragend.transformer', () => {
        if (editingTextId.value) uiTick.value++;
    });
};

const selectShape = (shape) => {
    // Don't do any selection while in drawing mode to avoid confusion
    if (drawingMode.value) {
        return;
    }
    // If clicking a second time on a text, edit the text
    if (shape.text && selectedId.value === shape.id) {
        editText(shape)
    }
    selectedId.value = shape.id;
    if (shape.fill) {
        currentColor.value = shape.fill;
    }
    nextTick(() => {
        updateTransformer();
        setupTransformerEvents();
    });
};

const updateTransformer = () => {
    const transformerNode = transformer.value?.getNode();
    const stageNode = stage.value?.getNode();

    if (!transformerNode || !stageNode) {
        return;
    }

    if (selectedId.value) {
        const shape = shapes.value.find(s => s.id === selectedId.value);
        const selectedGroup = stageNode.findOne(`#group-${selectedId.value}`);
        // console.log(selectedGroup);
        if (selectedGroup && shape) {
            if (shape.locked) {
                transformerNode.nodes([]);
            } else {
                transformerNode.nodes([selectedGroup]);
                if (shape.type === 'entity') {
                    transformerNode.keepRatio(true);
                } else {
                    transformerNode.keepRatio(false);
                }

            }
            transformerNode.getLayer().batchDraw();
        }
    } else {
        transformerNode.nodes([]);
        transformerNode.getLayer().batchDraw();
    }
};


// Actions: delete, lock, color
const deleteSelected = () => {
    if (!selectedShape.value) return;
    const id = selectedShape.value.id;
    const idx = shapes.value.findIndex(s => s.id === id);
    if (idx !== -1) shapes.value.splice(idx, 1);
    selectedId.value = null;
    editingTextId.value = null;
    uiTick.value++;

    // Ensure transformer no longer references the removed node and force redraw.
    // updateTransformer() will clear transformer nodes when selectedId is null.
    updateTransformer();

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
    if (drawingMode.value) {
        tempGroup.value.fill = input.value
        currentColor.value = input.value
        return
    }
    const s = selectedShape.value;
    if (!s) return;
    if (input?.value) {
        s.fill = input.value;
        currentColor.value = input.value;
        uiTick.value++;
    }
};

const getTextSize = (shape) => {
    const baseSizeFromHeight = shape.height * 0.15;
    const baseSizeFromWidth = shape.width * 0.08;
    const baseSize = Math.min(baseSizeFromHeight, baseSizeFromWidth);
    return Math.max(10, Math.min(baseSize, 24));
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
        width: 100,
        height: type === "text" ? 50 : 80,
        radius: type === "circle" ? 40 : null,
        fill: type === 'text' ? cssVariable('--bc') : cssVariable('--b1'),
        text: type === "text" ? "Click to edit" : null,
        locked: false,
        moving: false,
    });
};

const handleStageClick = (e) => {
    if (drawingMode.value || props.readonly) {
        return;
    }
    if (e.target === e.target.getStage()) {
        selectedId.value = null;
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
    if (!drawingMode.value) {
        drawingMode.value = true;
        return;
    }

    // Finalize
    drawingMode.value = false;
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
    if (!drawingMode.value) return;
    isDrawing.value = true;

    const pos = getPointerInLayerSpace();
    if (!pos) return;

    if (!tempGroup.value) {
        tempGroup.value = {
            id: Date.now(),
            type: "group",
            children: [],
            fill: currentColor.value
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
    if (!isDrawing.value) return;

    const pos = getPointerInLayerSpace();
    if (!pos) return;

    const last = tempGroup.value.children[tempGroup.value.children.length - 1];
    last.points = last.points.concat([pos.x, pos.y]);
}

const handeMouseUp = (e) => {
    if (!drawingMode.value) {
        return
    }
    isDrawing.value = false;
}


// Disable stage dragging while in drawing mode
watch(drawingMode, (isOn) => {
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
        entity: entity.id,
        name: entity.name,
        link: entity.link,
        fill: cssVariable('--bc'),
        locked: false,
        moving: false,
    });
}

const openEntityLink = (shape) => {
    if (!shape || !shape.link) return;
    try {
        window.open(shape.link, '_blank', 'noopener');
    } catch (e) {
        // Fallback: set location
        window.location.href = shape.link;
    }
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

const pushTo = (where: 'front' | 'back') => {
    const s = selectedShape.value;
    if (!s) return;

    // Find current index in model array
    const idx = shapes.value.findIndex(x => x.id === s.id);
    if (idx === -1) return;

    // Reorder shapes array so Vue re-renders and Konva will reflect stacking
    // when layer is redrawn. Splice out and insert at proper position.
    const [item] = shapes.value.splice(idx, 1);

    if (where === 'front') {
        // move to end => top in rendering order
        shapes.value.push(item);
    } else {
        // move to start => bottom in rendering order
        shapes.value.unshift(item);
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




onMounted(() => {
    currentColor.value = cssVariable('--bc')
    savingUrl.value = props.save

    if (props.new) {
        loading.value = false
        return
    }

    axios.get(props.load).then(res => {
        if (res.data) {
            name.value = res.data.name
            shapes.value = res.data.data

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
};

const cleanupBeforeUnmount = () => {
    window.removeEventListener('keydown', handleKeyDown);
}

</script>
