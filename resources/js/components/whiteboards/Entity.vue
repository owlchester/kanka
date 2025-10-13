<template>
    <v-rect
        :config="{
            x: 0, y: 0,
            width: shape.width,
            height: shape.height + nameHeight,
            fill: cssVariable('--b1'),
            cornerRadius: radius,
            opacity: shape.opacity || 1,
        }">

    </v-rect>
    <v-image
        :config="{
            width: shape.width,
            height: shape.height,
            image: imageEl,
            cornerRadius: radius,
            opacity: shape.opacity || 1,
         }">
    </v-image>
    <v-text
        @click="handleClick"
        @mouseenter="handleMouseEnter"
        @mouseleave="handleMouseLeave"
        :config="{
            x: 0,
            y: shape.height,
            width: shape.width,
            height: nameHeight,
            text: shape.name || '',
            padding: 6,
            fontSize: 14,
            fontFamily: shape.fontFamily || 'Arial',
            fill: shape.fill,
            align: 'center',
            verticalAlign: 'middle',
            draggable: false,
            listening: true,
            opacity: shape.opacity || 1,
        }"
    />
</template>
<script setup lang="ts">
import { computed, ref } from 'vue';
import { hslFromVar, readCssVar, hslString, tweakHsl } from '../../utility/colours';

const radius = ref(2);
const nameHeight = ref(26);

const props = defineProps<{
    shape: any,
    // function that receives shape and returns HTMLImageElement|null
    getImageEl: (shape: any) => HTMLImageElement | null,
    // function that opens entity link, receives shape
}>();

const imageEl = computed(() => {
    // call provided helper to get image element; keep compatible with previous approach
    return props.getImageEl ? props.getImageEl(props.shape) : null;
});


const handleClick = (e: Event) => {
    if (!props.shape || !props.shape.link) return;
    try {
        window.open(props.shape.link, '_blank', 'noopener');
    } catch (e) {
        // Fallback: set location
        window.location.href = props.shape.link;
    }
}

const handleMouseEnter = (e: any) => {
    try {
        const konvaNode = e.target;
        const stage = konvaNode.getStage?.();
        const container = stage?.container?.();
        if (container) container.style.cursor = 'pointer';
    } catch (err) {
        // ignore
    }
};

const handleMouseLeave = (e: any) => {
    try {
        const konvaNode = e.target;
        const stage = konvaNode.getStage?.();
        const container = stage?.container?.();
        if (container) container.style.cursor = '';
    } catch (err) {
        // ignore
    }
};


const cssVariable = (variable: string) => {
    const base = hslFromVar(variable);
    if (!base) return `hsl(${readCssVar('--p')})`;
    return hslString(base);
}


</script>
