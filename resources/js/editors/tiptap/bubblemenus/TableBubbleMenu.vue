<script setup lang="ts">
import type { Editor } from '@tiptap/core'
import { buttonClass } from '../utils'

const props = defineProps<{
    editor: Editor
}>()

const addColumnAfter = () => {
    props.editor.chain().focus().addColumnAfter().run()
}

const addRowAfter = () => {
    props.editor.chain().focus().addRowAfter().run()
}

const deleteTable = () => {
    props.editor.chain().focus().deleteTable().run()
}

const deleteRow = () => {
    props.editor.chain().focus().deleteRow().run()
}

const deleteColumn = () => {
    props.editor.chain().focus().deleteColumn().run()
}

const toggleHeaderRow = () => {
    props.editor.chain().focus().toggleHeaderRow().run()
}
</script>

<template>
    <div class="flex gap-1 items-center text-xs text-neutral-content px-2">
        <button
            @click.prevent="addColumnAfter"
            :class="buttonClass(false)"
            title="Add column"
        >
            <i class="fa-solid fa-table-columns" aria-hidden="true" />
            <i class="fa-solid fa-plus text-[8px]" aria-hidden="true" />
        </button>
        <button
            @click.prevent="addRowAfter"
            :class="buttonClass(false)"
            title="Add row"
        >
            <i class="fa-solid fa-table-rows" aria-hidden="true" />
            <i class="fa-solid fa-plus text-[8px]" aria-hidden="true" />
        </button>
        <button
            @click.prevent="deleteColumn"
            :class="buttonClass(false)"
            title="Delete column"
        >
            <i class="fa-solid fa-table-columns" aria-hidden="true" />
            <i class="fa-solid fa-minus text-[8px]" aria-hidden="true" />
        </button>
        <button
            @click.prevent="deleteRow"
            :class="buttonClass(false)"
            title="Delete row"
        >
            <i class="fa-solid fa-table-rows" aria-hidden="true" />
            <i class="fa-solid fa-minus text-[8px]" aria-hidden="true" />
        </button>
        <button
            @click.prevent="toggleHeaderRow"
            :class="buttonClass(false)"
            title="Toggle header row"
        >
            <i class="fa-solid fa-heading" aria-hidden="true" />
        </button>
        <button
            @click.prevent="deleteTable"
            class="hover:text-error px-2 py-1"
            title="Delete table"
        >
            <i class="fa-solid fa-trash" aria-hidden="true" />
        </button>
    </div>
</template>
