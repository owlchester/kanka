
<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { NodeViewWrapper, NodeViewContent } from '@tiptap/vue-3'

const props = defineProps<{
    editor: any
    node: any
    getPos: () => number
    selected: boolean
}>()

const isTableActive = ref(false)

const checkIfActive = () => {
    const pos = props.getPos()
    const { from, to } = props.editor.state.selection
    const nodeSize = props.node.nodeSize
    isTableActive.value = from >= pos && to <= pos + nodeSize
}

onMounted(() => {
    props.editor.on('selectionUpdate', checkIfActive)
    props.editor.on('focus', checkIfActive)
    checkIfActive()
})

onBeforeUnmount(() => {
    props.editor.off('selectionUpdate', checkIfActive)
    props.editor.off('focus', checkIfActive)
})

const addColumnAfter = () => {
    props.editor.chain().focus().addColumnAfter().run()
}

const addRowAfter = () => {
    props.editor.chain().focus().addRowAfter().run()
}
</script>

<template>
    <NodeViewWrapper class="table-wrapper" :class="{ 'is-active': isTableActive }">
        <NodeViewContent
            as="table"
            :class="node.attrs.class || 'table table-striped'"
            :style="node.attrs.style"
        />

        <!-- Add column button (right side) -->
<!--        <button-->
<!--            v-if="isTableActive"-->
<!--            class="add-column-btn hover:bg-base-200 rounded"-->
<!--            @click.prevent="addColumnAfter"-->
<!--            title="Add column"-->
<!--            contenteditable="false"-->
<!--        >-->
<!--            <i class="fa-regular fa-plus" aria-hidden="true"></i>-->
<!--        </button>-->

<!--        &lt;!&ndash; Add row button (bottom) &ndash;&gt;-->
<!--        <button-->
<!--            v-if="isTableActive"-->
<!--            class="add-row-btn hover:bg-base-200 rounded"-->
<!--            @click.prevent="addRowAfter"-->
<!--            title="Add row"-->
<!--            contenteditable="false"-->
<!--        >-->
<!--            <i class="fa-regular fa-plus" aria-hidden="true"></i>-->
<!--        </button>-->
    </NodeViewWrapper>
</template>

<style scoped>
.table-wrapper {
    display: inline-block;
    overflow-x: auto;
}

.add-column-btn,
.add-row-btn {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: .7rem;
    color: oklch(var(--bc) / 0.3);
    transition: background-color 0.15s, color 0.15s, border-color 0.15s;
}

.add-column-btn {
    right: 0;
    top: 0;
    bottom: 24px;
    width: 20px;
}

.add-row-btn {
    bottom: 0;
    left: 0;
    right: 24px;
    height: 20px;
}
</style>

<style>
/* Table functional styles (unscoped) */
.tiptap {

    table {

        td, th {

            /* Prevent margin jump when resize handle div is added */
            > p {
                margin-bottom: 0 !important;
            }
        }

        .selectedCell {
            background-color: hsl(var(--p) / .2) !important;
        }

        .column-resize-handle {
            background-color: hsl(var(--p) / 1);
            position: absolute;
            top: 0;
            bottom: 0;
            right: -2px;
            width: 4px;
            pointer-events: none;
            z-index: 10;
        }
    }

    &.resize-cursor {
        cursor: ew-resize;
        cursor: col-resize;
    }

}

</style>
