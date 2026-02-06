<script setup lang="ts">
import { ref, computed, onBeforeUnmount } from 'vue'
import { NodeViewWrapper } from '@tiptap/vue-3'

const props = defineProps<{
    editor: any
    node: any
    getPos: () => number
    selected: boolean
    updateAttributes: (attrs: Record<string, any>) => void
}>()

type ResizeDirection = 'right' | 'bottom' | 'corner' | null

const resizeDirection = ref<ResizeDirection>(null)
const startX = ref(0)
const startY = ref(0)
const startWidth = ref(0)
const startHeight = ref(0)
const imageRef = ref<HTMLImageElement | null>(null)

const isActive = computed(() => props.selected)

const imageClass = computed(() => {
    const classes: string[] = []
    if (props.node.attrs.class) {
        classes.push(props.node.attrs.class)
    }
    if (isActive.value) {
        classes.push('is-resizable')
    }
    return classes.join(' ')
})

const imageStyle = computed(() => {
    const styles: Record<string, string> = {}
    if (props.node.attrs.width) {
        styles.width = props.node.attrs.width
    }
    return styles
})

const wrapperClass = computed(() => {
    const classes = ['image-wrapper']
    const nodeClass = props.node.attrs.class || ''

    if (isActive.value) {
        classes.push('is-active')
    }

    if (nodeClass.includes('float-left') || nodeClass.includes('note-float-left')) {
        classes.push('image-wrapper-left')
    } else if (nodeClass.includes('float-right') || nodeClass.includes('note-float-right')) {
        classes.push('image-wrapper-right')
    }

    return classes
})

const onMouseDown = (event: MouseEvent, direction: ResizeDirection) => {
    event.preventDefault()
    resizeDirection.value = direction
    startX.value = event.clientX
    startY.value = event.clientY
    startWidth.value = imageRef.value?.offsetWidth || 200
    startHeight.value = imageRef.value?.offsetHeight || 200

    document.addEventListener('mousemove', onMouseMove)
    document.addEventListener('mouseup', onMouseUp)
}

const onMouseMove = (event: MouseEvent) => {
    if (!resizeDirection.value || !imageRef.value) return

    const diffX = event.clientX - startX.value
    const diffY = event.clientY - startY.value

    if (resizeDirection.value === 'right') {
        const newWidth = Math.max(50, startWidth.value + diffX)
        imageRef.value.style.width = `${newWidth}px`
        imageRef.value.style.height = 'auto'
    } else if (resizeDirection.value === 'bottom') {
        const newHeight = Math.max(50, startHeight.value + diffY)
        imageRef.value.style.height = `${newHeight}px`
        imageRef.value.style.width = 'auto'
    } else if (resizeDirection.value === 'corner') {
        const newWidth = Math.max(50, startWidth.value + diffX)
        const newHeight = Math.max(50, startHeight.value + diffY)
        imageRef.value.style.width = `${newWidth}px`
        imageRef.value.style.height = `${newHeight}px`
    }
}

const onMouseUp = () => {
    if (!resizeDirection.value) return

    resizeDirection.value = null
    document.removeEventListener('mousemove', onMouseMove)
    document.removeEventListener('mouseup', onMouseUp)

    if (imageRef.value) {
        const attrs: Record<string, string | null> = {}
        const computedStyle = window.getComputedStyle(imageRef.value)

        if (imageRef.value.style.width && imageRef.value.style.width !== 'auto') {
            attrs.width = `${imageRef.value.offsetWidth}px`
        }

        props.updateAttributes(attrs)
    }
}

onBeforeUnmount(() => {
    document.removeEventListener('mousemove', onMouseMove)
    document.removeEventListener('mouseup', onMouseUp)
})
</script>

<template>
    <NodeViewWrapper
        :class="wrapperClass"
        :style="node.attrs.style"
    >
        <img
            ref="imageRef"
            :src="node.attrs.src"
            :alt="node.attrs.alt"
            :title="node.attrs.title"
            :class="imageClass"
            :style="imageStyle"
            draggable="false"
        />

        <template v-if="isActive">
            <div
                class="resize-handle resize-handle-right"
                @mousedown="onMouseDown($event, 'right')"
            />
            <div
                class="resize-handle resize-handle-bottom"
                @mousedown="onMouseDown($event, 'bottom')"
            />
            <div
                class="resize-handle resize-handle-corner"
                @mousedown="onMouseDown($event, 'corner')"
            />
        </template>
    </NodeViewWrapper>
</template>

<style scoped>
.image-wrapper {
    display: inline-block;
    position: relative;
    line-height: 0;
}

.image-wrapper-left {
    float: left;
    margin-right: 1rem;
    margin-bottom: 0.5rem;
}

.image-wrapper-right {
    float: right;
    margin-left: 1rem;
    margin-bottom: 0.5rem;
}

.image-wrapper img {
    display: block;
    max-width: 100%;
    height: auto;
}

.image-wrapper img.is-resizable {
    outline: 2px solid hsl(var(--p)/0.8);
    border-radius: var(--border-btn);
    outline-offset: 2px;
}

.resize-handle {
    position: absolute;
    background-color: oklch(var(--p));
    z-index: 10;
}

.resize-handle-right {
    top: 0;
    right: -6px;
    bottom: 0;
    width: 6px;
    cursor: ew-resize;
    border-radius: 3px;
}

.resize-handle-bottom {
    left: 0;
    right: 0;
    bottom: -6px;
    height: 6px;
    cursor: ns-resize;
    border-radius: 3px;
}

.resize-handle-corner {
    right: -6px;
    bottom: -6px;
    width: 12px;
    height: 12px;
    cursor: nwse-resize;
    border-radius: 3px;
}
</style>
