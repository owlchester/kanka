<template>
    <div class="toolbar fixed w-full bg-base-100 p-2 flex items-center gap-2 z-50">
        <input v-model="name" placeholder="Whiteboard name" />

        <div class="actions flex items-center">
            <button
                class="btn2 btn-sm btn-primary join-item"
                @click="saveWhiteboard">
                <i class="fa-regular fa-save" aria-hidden="true" />
                Save
            </button>
        </div>
    </div>

    <v-stage
        ref="stage"
        :config="stageSize"
        @click="handleStageClick"
        @mousedown="handleMouseDown"
        @mousemove="draw"
        @mouseup="handeMouseUp"
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
                            x: 0, y: 0,x:
                            shape.radius,
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
                    anchorSize: 7,
                    keepRatio: true,
                }"
            />
        </v-layer>
    </v-stage>

    <textarea
        v-if="editingTextId"
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
        :style="toolbarStyle"
        class="fixed z-50 flex items-center justify-center inset-x-0 gap-1 bottom-8 tools"
        @mousedown.stop
        @click.stop
    >
        <div class="flex items-center gap-2 shape-toolbar " v-if="selectedShape">
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

            <input
                ref="colorInput"
                type="color"
                class="hidden"
                :value="selectedShape.fill || defaultFillFor(selectedShape)"
                @input="onPickColor"
                @change="onPickColor"
            />

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
        <div v-else class="flex items-center gap-2 main-toolbar">
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
                    <i class="fa-regular fa-scribble" aria-hidden="true" v-if="!drawingMode" />
                    <i class="fa-regular fa-check" aria-hidden="true" v-else />
                    <span class="sr-only" v-if="!drawingMode">Start drawing</span>
                    <span class="sr-only" v-else>End drawing</span>
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
    </div>

    <Browser
        :api="props.gallery"
        :opened="galleryOpened"
        :i18n="i18n"
        @selected="selectImage"
        @closed="closedGallery"
    ></Browser>

    <Entity
        :api="props.search"
        :opened="searchOpened"
        @selected="selectEntity"
        @closed="closedSearch">
    </Entity>

</template>

<script setup lang="ts">
import { ref, onMounted, reactive, nextTick, computed, watch} from 'vue';
import Browser from "../../gallery/Browser.vue";
import {useImage} from "vue-konva";
import Entity from "./Entity.vue";
import { hslFromVar, readCssVar, hslString, tweakHsl } from '../../utility/colours';

const props = defineProps<{
    api: String,
    gallery: String,
    search: String,
    new: Boolean,
    i18n: undefined
}>()

const shapes = ref([]);
const dragItemId = ref(null);
const selectedId = ref(null);
const name = ref('My whiteboard');
const stage = ref(null);
const transformer = ref(null);
const layer = ref(null);

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
const drawingMode = ref(false);
const isDrawing = ref(false);
const tempGroup = ref(null);

// Gallery
const galleryOpened = ref(false)
const imageRefs = ref({});

// Search
const searchOpened = ref(false)


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
    // If clicking a second time on a text, edit the text
    if (shape.text && selectedId.value === shape.id) {
        editText(shape)
    }
    selectedId.value = shape.id;
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
};

const toggleLock = () => {
    const s = selectedShape.value;
    if (!s) return;
    s.locked = !s.locked;
    updateTransformer();
    uiTick.value++;
};

const defaultFillFor = (shape) => {
    return shape.type === 'rect' ? '#add8e6' /* lightblue */ : '#90ee90' /* lightgreen */;
};

const openColorPicker = () => {
    colorInput.value?.click();
};

const onPickColor = (e: Event) => {
    const s = selectedShape.value;
    if (!s) return;
    const input = e.target as HTMLInputElement;
    if (input?.value) {
        s.fill = input.value;
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
    if (drawingMode.value) {
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
            fill: cssVariable('--bc')
        }
    }

    tempGroup.value.children.push({
        id: Date.now() + "-lin",
        type: "draw",
        points: [pos.x, pos.y],
        fill: cssVariable('--bc'),
        strokeWidth: 2,
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

    console.log('uuid', uuid);
    console.log('imgRefs', imageRefs.value);
    console.log('r', r);

    watch(
        () => r,
        (imgEl) => {
            console.log('imgEl', imgEl);
            if (imgEl) {
                // If you want the shape to match the real image size the first time it loads:
                const shape = shapes.value.find(s => s.id === shapeId);
                console.log('update shape', shape);
                if (shape && (!shape.width || !shape.height)) {
                    console.log('a');
                    // Use natural size on first load if width/height were falsy
                    shape.width = imgEl.naturalWidth || shape.width || 100;
                    shape.height = imgEl.naturalHeight || shape.height || 80;
                    console.log(imgEl.naturalWidth, imgEl.naturalHeight);
                }
                console.log('n');

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
    console.log('selected entity', entity);


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
        fill: '#add8e6',
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
    console.log('base', variable, base);
    if (!base) return `hsl(${readCssVar('--p')})`;
    return hslString(base);
}


const stageSize = {
    width: window.innerWidth,
    height: window.innerHeight,
    draggable: true,
};

</script>
