
<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
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
    // Check if selection is within this table
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
        <div class="table-inner">
            <NodeViewContent as="table" class="table-tiptap" />
        </div>

        <!-- Add column button (right side) -->
        <button
            v-if="isTableActive"
            class="add-column-btn"
            @click.prevent="addColumnAfter"
            title="Add column"
            contenteditable="false"
        >
            <i class="fa-regular fa-plus" aria-hidden="true"></i>
        </button>

        <!-- Add row button (bottom) -->
        <button
            v-if="isTableActive"
            class="add-row-btn"
            @click.prevent="addRowAfter"
            title="Add row"
            contenteditable="false"
        >
            <i class="fa-regular fa-plus" aria-hidden="true"></i>
        </button>
    </NodeViewWrapper>
</template>

<style scoped>
.table-wrapper {
    display: inline-block;
    position: relative;
    padding-right: 28px;
    padding-bottom: 28px;
    margin: 0.5rem 0;
}

.table-inner {
    border-radius: 0.5rem;
    overflow: hidden;
    border: 1px solid oklch(var(--bc) / 0.2);
}

.add-column-btn,
.add-row-btn {
    position: absolute;
    width: 22px;
    height: 22px;
    background-color: oklch(var(--b2));
    border: 1px solid oklch(var(--bc) / 0.2);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 11px;
    color: oklch(var(--bc) / 0.5);
    transition: background-color 0.2s;
}

.add-column-btn:hover,
.add-row-btn:hover {
    background-color: oklch(var(--b3));
    color: oklch(var(--bc));
}

.add-column-btn {
    right: 0;
    top: calc(50% - 14px);
}

.add-row-btn {
    bottom: 0;
    left: calc(50% - 14px);
}
</style>

<style>
/* Table functional styles (unscoped) */
.tiptap {

    /* Column resize handle */
    table {
        border-collapse: collapse;
        table-layout: fixed;
        overflow: hidden;
        margin: 0;
        /* Selected cell */

        td, th {
            position: relative;
            vertical-align: top;
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
        }
    }

    .tableWrapper {
        margin: 1.5rem 0;
        overflow-x: auto;
    }

    &.resize-cursor {
        cursor: ew-resize;
        cursor: col-resize;
    }

}

</style>
