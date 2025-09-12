<template>
    <div class="toolbar">
        <input v-model="name" placeholder="Whiteboard name" />

        <div class="join">
            <button
                @click="addShape('rect')"
                class="btn2 btn-sm join-item">
                <i class="fa-regular fa-square" aria-hidden="true" />
                <span class="sr-only">Add square</span>
            </button>
            <button
                @click="addShape('circle')"
                class="btn2 btn-sm join-item">
                <i class="fa-regular fa-circle" aria-hidden="true" />
                <span class="sr-only">Add circle</span>
            </button>
            <button
                class="btn2 btn-sm btn-primary join-item"
                @click="saveWhiteboard">
                Save
            </button>
        </div>
    </div>

    <v-stage
        ref="stage"
        :config="stageSize"
        @click="handleStageClick">
        <v-layer ref="layer">
            <v-group
                v-for="shape in shapes"
                :key="shape.id"
                :config="{ id: `group-${shape.id}`, draggable: !shape.locked }"
                @dragstart="handleDragstart(shape.id)"
                @dragmove="handleDragmove(shape.id)"
                @dragend="handleDragend(shape.id)"
                @click="selectShape(shape)"
            >
                <v-rect v-if="shape.type==='rect'"
                        :config="{
                            x: shape.x, y: shape.y,
                            width: shape.width, height: shape.height,
                            fill: shape.fill || 'lightblue',
                            cornerRadius: 6,
                        }"
                />
                <v-circle v-if="shape.type==='circle'"
                          :config="{
                            x: shape.x, y: shape.y,
                            radius: shape.radius,
                            fill: shape.fill || 'lightgreen',
                        }"
                />

                <v-text v-if="!editingTextId || editingTextId !== shape.id"
                        :config="{
                            x: shape.type === 'rect' ? shape.x + getTextPadding(shape) : shape.x - shape.radius + getTextPadding(shape),
                            y: shape.type === 'rect' ? shape.y + getTextPadding(shape) : shape.y - getTextSize(shape) / 2,
                            width: shape.type === 'rect' ? shape.width - (getTextPadding(shape) * 2) : (shape.radius * 2) - (getTextPadding(shape) * 2),
                            height: shape.type === 'rect' ? shape.height - (getTextPadding(shape) * 2) : undefined,
                            text: shape.text,
                            fontSize: getTextSize(shape),
                            fontFamily: 'Arial',
                            fill: getTextColor(shape),
                            align: 'center',
                            verticalAlign: 'middle',
                            wrap: 'word',
                        }"
                        @click="editText(shape.id)"
                />
            </v-group>

            <v-transformer
                ref="transformer"
                :config="{
                    resizeEnabled: true,
                    rotateEnabled: true,
                    borderEnabled: true,
                    borderStroke: '#4285f4',
                    borderStrokeWidth: 1,
                    anchorStroke: '#4285f4',
                    anchorFill: 'white',
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
        class="absolute bg-transparent border-2 border-blue-400 rounded resize-none outline-none z-50"
        @blur="saveText"
        @keydown.enter.exact="saveText"
        @keydown.escape="cancelTextEdit"
        @input="updateTextPreview"
    ></textarea>
    <!-- Floating toolbar for selected group -->
    <div
        v-if="selectedShape && !editingTextId"
        :style="toolbarStyle"
        class="absolute z-50 flex items-center gap-1 bg-base-100 rounded px-1 py-1 shadow"
        @mousedown.stop
        @click.stop
    >
        <button
            class="btn2 btn-xs"
            title="Delete"
            @click.stop="deleteSelected"
        >
            <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
            <span class="sr-only">Delete</span>
        </button>

        <button
            class="btn2 btn-xs"
            :class="selectedShape.locked ? 'btn-warning' : ''"
            :title="selectedShape.locked ? 'Unlock' : 'Lock'"
            @click.stop="toggleLock"
        >
            <i class="fa-solid" :class="selectedShape.locked ? 'fa-lock' : 'fa-lock-open'"></i>
            <span class="sr-only">{{ selectedShape.locked ? 'Unlock' : 'Lock' }}</span>
        </button>

        <button
            class="btn2 btn-xs"
            title="Change color"
            @click.stop="openColorPicker"
        >
            <i class="fa-regular fa-palette" aria-hidden="true"></i>
            <span class="sr-only">Color</span>
        </button>
        <input
            ref="colorInput"
            type="color"
            class="hidden"
            :value="selectedShape.fill || defaultFillFor(selectedShape)"
            @input="onPickColor"
            @change="onPickColor"
        />
    </div>

</template>

<script setup lang="ts">
import { ref, onMounted, reactive, nextTick, computed} from 'vue';

const props = defineProps<{
    api: String,
    new: Boolean
}>()

const shapes = ref([]);
const dragItemId = ref(null);
const selectedId = ref(null);
const name = ref('My whiteboard');
const stage = ref(null);
const transformer = ref(null);

// Text editing state
const editingTextId = ref(null);
const editingText = ref('');
const textInput = ref(null);

// UI tick to re-compute overlay position on Konva events without syncing geometry to Vue
const uiTick = ref(0);

// Toolbar refs and helpers
const colorInput = ref<HTMLInputElement|null>(null);
const selectedShape = computed(() => shapes.value.find(s => s.id === selectedId.value) || null);


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

    if (shape.type === 'rect') {
        const rectNode = groupNode.findOne('Rect');
        if (!rectNode) return {};
        const r = rectNode.getClientRect({ relativeTo: stageNode });
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
    } else if (shape.type === 'circle') {
        const circleNode = groupNode.findOne('Circle');
        if (!circleNode) return {};
        const c = circleNode.getClientRect({ relativeTo: stageNode });
        rect = { x: c.x, y: c.y, width: c.width, height: c.height };

        const radiusPx = Math.min(rect.width, rect.height) / 2;
        const padding = Math.max(3, radiusPx * 0.15);
        const fontSize = Math.max(8, Math.min(radiusPx * 0.25, 20));

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
    }

    return {};
});


// Position toolbar above selected group
const toolbarStyle = computed(() => {
    void uiTick.value; // follow during drag/transform

    if (!selectedShape.value) return { display: 'none' };

    const stageNode = stage.value?.getNode();
    if (!stageNode) return { display: 'none' };

    const groupNode = stageNode.findOne(`#group-${selectedShape.value.id}`);
    if (!groupNode) return { display: 'none' };

    // Use the group's visual bounds
    const bounds = groupNode.getClientRect({ relativeTo: stageNode });
    const containerRect = stageNode.container().getBoundingClientRect();

    // Place toolbar centered horizontally, a few pixels above the shape
    const top = containerRect.top + bounds.y - 40; // 40px above; adjust as needed
    const left = containerRect.left + bounds.x + bounds.width / 2;

    return {
        position: 'absolute',
        top: `${top}px`,
        left: `${left}px`,
        transform: 'translateX(-50%)',
        pointerEvents: 'auto'
    };
});


const handleDragstart = (id) => {
    dragItemId.value = id;

    // Move the dragged group visually on top without mutating shapes array
    const stageNode = stage.value?.getNode();
    const groupNode = stageNode?.findOne(`#group-${id}`);
    groupNode?.moveToTop();

};

const handleDragend = (id) => {
    dragItemId.value = null;
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
    selectedId.value = shape.id;
    nextTick(() => {
        updateTransformer();
        setupTransformerEvents();
    });
};

const updateTransformer = () => {
    const transformerNode = transformer.value?.getNode();
    const stageNode = stage.value?.getNode();

    if (!transformerNode || !stageNode) return;

    if (selectedId.value) {
        const shape = shapes.value.find(s => s.id === selectedId.value);
        const selectedGroup = stageNode.findOne(`#group-${selectedId.value}`);
        if (selectedGroup && shape) {
            if (shape.locked) {
                transformerNode.nodes([]);
            } else {
                transformerNode.nodes([selectedGroup]);
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
    if (shape.type === 'rect') {
        const baseSizeFromHeight = shape.height * 0.15;
        const baseSizeFromWidth = shape.width * 0.08;
        const baseSize = Math.min(baseSizeFromHeight, baseSizeFromWidth);
        return Math.max(10, Math.min(baseSize, 24));
    } else if (shape.type === 'circle') {
        const baseSize = shape.radius * 0.25;
        return Math.max(8, Math.min(baseSize, 20));
    }
    return 12;
};

const getTextPadding = (shape) => {
    if (shape.type === 'rect') {
        return Math.max(5, Math.min(shape.width, shape.height) * 0.1);
    } else if (shape.type === 'circle') {
        return Math.max(3, shape.radius * 0.15);
    }
    return 5;
};

const editText = (id) => {
    const shape = shapes.value.find(s => s.id === id);
    if (!shape || shape.locked) return;
    editingTextId.value = id;
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
    shapes.value.push({
        id: Math.round(Math.random() * 10000).toString(),
        type,
        x: 100,
        y: 100,
        width: type === "rect" ? 120 : 80,
        height: type === "rect" ? 80 : 80,
        radius: type === "circle" ? 40 : null,
        fill: type === "rect" ? '#add8e6' : '#90ee90',
        text: "Click to edit",
        locked: false,
    });
};

const handleStageClick = (e) => {
    if (e.target === e.target.getStage()) {
        selectedId.value = null;
        updateTransformer();
        if (editingTextId.value) {
            cancelTextEdit();
        }
    }
};


// Choose readable text color (black or white) based on shape's fill using WCAG contrast
const getTextColor = (shape) => {
    const bg = (shape.fill || defaultFillFor(shape) || '#ffffff').toString();
    const rgb = parseColorToRgb(bg);
    if (!rgb) return '#000000';

    const contrastWithBlack = contrastRatio(rgb, { r: 0, g: 0, b: 0 });
    const contrastWithWhite = contrastRatio(rgb, { r: 255, g: 255, b: 255 });

    return contrastWithWhite >= contrastWithBlack ? '#ffffff' : '#000000';
};

// Parse #RGB/#RRGGBB or rgb()/rgba() into {r,g,b}
function parseColorToRgb(input: string): { r: number; g: number; b: number } | null {
    if (!input) return null;
    const str = input.trim().toLowerCase();

    // Hex formats
    if (str[0] === '#') {
        const hex = str.slice(1);
        if (hex.length === 3) {
            const r = parseInt(hex[0] + hex[0], 16);
            const g = parseInt(hex[1] + hex[1], 16);
            const b = parseInt(hex[2] + hex[2], 16);
            return { r, g, b };
        }
        if (hex.length === 6) {
            const r = parseInt(hex.slice(0, 2), 16);
            const g = parseInt(hex.slice(2, 4), 16);
            const b = parseInt(hex.slice(4, 6), 16);
            return { r, g, b };
        }
        return null;
    }

    // rgb/rgba
    const rgbMatch = str.match(/^rgba?\(([^)]+)\)$/);
    if (rgbMatch) {
        const parts = rgbMatch[1].split(',').map(p => p.trim());
        if (parts.length >= 3) {
            const to255 = (v: string) => v.endsWith('%') ? Math.round(parseFloat(v) * 2.55) : parseInt(v, 10);
            const r = to255(parts[0]);
            const g = to255(parts[1]);
            const b = to255(parts[2]);
            if (Number.isFinite(r) && Number.isFinite(g) && Number.isFinite(b)) return { r, g, b };
        }
        return null;
    }

    // Unsupported formats (e.g., hsl) -> fallback
    return null;
}

// WCAG relative luminance and contrast ratio
function relativeLuminance({ r, g, b }: { r: number; g: number; b: number }): number {
    const srgb = [r, g, b].map(v => v / 255).map(c =>
        c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4)
    );
    return 0.2126 * srgb[0] + 0.7152 * srgb[1] + 0.0722 * srgb[2];
}

function contrastRatio(c1: { r: number; g: number; b: number }, c2: { r: number; g: number; b: number }): number {
    const L1 = relativeLuminance(c1);
    const L2 = relativeLuminance(c2);
    const [lighter, darker] = L1 >= L2 ? [L1, L2] : [L2, L1];
    return (lighter + 0.05) / (darker + 0.05);
}


const stageSize = {
    width: window.innerWidth,
    height: window.innerHeight,
    draggable: true,
};

</script>
