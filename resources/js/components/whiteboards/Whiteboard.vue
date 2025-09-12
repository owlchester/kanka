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
                :config="{ id: `group-${shape.id}`, draggable: true }"
                @dragstart="handleDragstart(shape.id)"
                @dragmove="handleDragmove(shape.id)"
                @dragend="handleDragend(shape.id)"
                @click="selectShape(shape.id)"
            >
                <v-rect v-if="shape.type==='rect'"
                        :config="{
              x: shape.x, y: shape.y,
              width: shape.width, height: shape.height,
              fill: 'lightblue',
            }"
                />
                <v-circle v-if="shape.type==='circle'"
                          :config="{
              x: shape.x, y: shape.y,
              radius: shape.radius,
              fill: 'lightgreen',
            }"
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
                }"
            />

        </v-layer>
    </v-stage>
</template>

<script setup lang="ts">
import { ref, onMounted , reactive, nextTick} from 'vue';

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


const handleDragstart = (id) => {
    // save drag element:
    dragItemId.value = id;
    // move current element to the top:
    const item = shapes.value.find(i => i.id === dragItemId.value);
    const index = shapes.value.indexOf(item);
    shapes.value.splice(index, 1);
    shapes.value.push(item);
};

const handleDragmove = (id) => {
    // Update transformer position during drag if this shape is selected
    if (selectedId.value === id) {
        const transformerNode = transformer.value?.getNode();
        if (transformerNode) {
            transformerNode.getLayer().batchDraw();
        }
    }
};


const handleDragend = (id) => {
    dragItemId.value = null;
    // Update transformer position after drag if this shape is selected
    if (selectedId.value === id) {
        const transformerNode = transformer.value?.getNode();
        if (transformerNode) {
            transformerNode.getLayer().batchDraw();
        }
    }

};

const stageSize = {
    width: window.innerWidth,
    height: window.innerHeight
};
const addShape = (type) => {
    console.log('add shape');
    shapes.value.push({
        id: Math.round(Math.random() * 10000).toString(),
        type,
        x: 100,
        y: 100,
        rotation: Math.random() * 180,
        scale: Math.random(),
        width: type === "rect" ? 120 : 80,
        height: type === "rect" ? 80 : 80,
        radius: type === "circle" ? 40 : null,
    });
};

const selectShape = (id) => {
    selectedId.value = id;
    nextTick(() => {
        updateTransformer();
    });
};


const handleStageClick = (e) => {
    // Check if we clicked on the stage (not on a shape)
    if (e.target === e.target.getStage()) {
        selectedId.value = null;
        updateTransformer();
    }
};

const updateTransformer = () => {
    const transformerNode = transformer.value?.getNode();
    const stageNode = stage.value?.getNode();

    if (!transformerNode || !stageNode) return;

    if (selectedId.value) {
        // Find the selected group by ID
        const selectedGroup = stageNode.findOne(`#group-${selectedId.value}`);

        if (selectedGroup) {
            transformerNode.nodes([selectedGroup]);
            transformerNode.getLayer().batchDraw();
        }
    } else {
        transformerNode.nodes([]);
        transformerNode.getLayer().batchDraw();
    }
};


</script>
