<script setup lang="ts">
import { computed } from 'vue'
import type { Editor } from '@tiptap/core'
import { buttonClass } from '../utils'
import { toggleTableClass } from '../extensions/table/tableClasses.js'
import { t } from '../i18n.js'

const props = defineProps<{
    editor: Editor
}>()

// Get the current table node and position
const getTableInfo = () => {
    const { selection } = props.editor.state
    const { $from } = selection

    for (let depth = $from.depth; depth > 0; depth--) {
        const node = $from.node(depth)
        if (node.type.name === 'table') {
            return { node, pos: $from.before(depth) }
        }
    }
    return null
}

// Parse class string into array
const getClassList = () => {
    const info = getTableInfo()
    const classStr = info?.node.attrs.class || ''
    return classStr.split(' ').filter(Boolean)
}

// Check if table has a specific class
const hasClass = (className: string) => {
    return getClassList().includes(className)
}

// Computed properties for button states
const hasBorderless = computed(() => hasClass('table-borderless'))
const hasStriped = computed(() => hasClass('table-striped'))
const hasLeft = computed(() => hasClass('table-left'))
const hasRight = computed(() => hasClass('table-right'))

// Update table class attribute
const updateTableClass = (newClassList: string[]) => {
    const info = getTableInfo()
    if (!info) return

    // Ensure 'table' is always first if there are other table-* classes
    if (newClassList.some(c => c.startsWith('table-')) && !newClassList.includes('table')) {
        newClassList.unshift('table')
    }

    const { tr } = props.editor.state
    tr.setNodeMarkup(info.pos, undefined, {
        ...info.node.attrs,
        class: newClassList.join(' ') || null,
    })
    props.editor.view.dispatch(tr)
}

// Toggle a class on/off
const toggleClass = (className: string, removeClasses: string[] = []) => {
    updateTableClass(toggleTableClass(getClassList(), className, removeClasses))
}

const toggleBorderless = () => toggleClass('table-borderless', ['table-bordered'])
const toggleStriped = () => toggleClass('table-striped')
const toggleLeft = () => toggleClass('table-left', ['table-right'])
const toggleRight = () => toggleClass('table-right', ['table-left'])

const addColumnBefore = () => {
    props.editor.chain().focus().addColumnBefore().run()
}

const addColumnAfter = () => {
    props.editor.chain().focus().addColumnAfter().run()
}

const addRowBefore = () => {
    props.editor.chain().focus().addRowBefore().run()
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
    <div class="flex gap-1 items-center text-xs text-neutral-content px-2 flex-wrap">
        <button
            type="button"
            @click.prevent="addColumnBefore"
            :class="buttonClass(false)"
            :title="t('add_column_before', 'Add column left')"
        >
            <i class="fa-regular fa-arrow-left text-[8px]" aria-hidden="true" />
            <i class="fa-regular fa-table-columns" aria-hidden="true" />
        </button>
        <button
            type="button"
            @click.prevent="addColumnAfter"
            :class="buttonClass(false)"
            :title="t('add_column_after', 'Add column right')"
        >
            <i class="fa-regular fa-table-columns" aria-hidden="true" />
            <i class="fa-regular fa-plus text-[8px]" aria-hidden="true" />
        </button>
        <button
            type="button"
            @click.prevent="addRowBefore"
            :class="buttonClass(false)"
            :title="t('add_row_before', 'Add row above')"
        >
            <i class="fa-regular fa-arrow-up text-[8px]" aria-hidden="true" />
            <i class="fa-regular fa-table-rows" aria-hidden="true" />
        </button>
        <button
            type="button"
            @click.prevent="addRowAfter"
            :class="buttonClass(false)"
            :title="t('add_row_after', 'Add row below')"
        >
            <i class="fa-regular fa-table-rows" aria-hidden="true" />
            <i class="fa-regular fa-plus text-[8px]" aria-hidden="true" />
        </button>
        <button
            type="button"
            @click.prevent="deleteColumn"
            :class="buttonClass(false)"
            :title="t('delete_column', 'Delete column')"
        >
            <i class="fa-regular fa-table-columns" aria-hidden="true" />
            <i class="fa-regular fa-minus text-[8px]" aria-hidden="true" />
        </button>
        <button
            type="button"
            @click.prevent="deleteRow"
            :class="buttonClass(false)"
            :title="t('delete_row', 'Delete row')"
        >
            <i class="fa-regular fa-table-rows" aria-hidden="true" />
            <i class="fa-regular fa-minus text-[8px]" aria-hidden="true" />
        </button>
        <button
            type="button"
            @click.prevent="toggleHeaderRow"
            :class="buttonClass(false)"
            :title="t('toggle_header_row', 'Toggle header row')"
        >
            <i class="fa-regular fa-heading" aria-hidden="true" />
        </button>

        <span class="w-px h-4 bg-base-content/20 mx-1" />

        <button
            type="button"
            @click.prevent="toggleBorderless"
            :class="buttonClass(hasBorderless)"
            :aria-pressed="hasBorderless"
            :title="t('toggle_borderless', 'Toggle borderless')"
        >
            <i class="fa-regular fa-border-none" aria-hidden="true" />
        </button>
        <button
            type="button"
            @click.prevent="toggleStriped"
            :class="buttonClass(hasStriped)"
            :title="t('toggle_striped', 'Toggle striped')"
        >
            <i class="fa-regular fa-bars" aria-hidden="true" />
        </button>
        <button
            type="button"
            @click.prevent="toggleLeft"
            :class="buttonClass(hasLeft)"
            :title="t('align_left', 'Align left')"
        >
            <i class="fa-regular fa-align-left" aria-hidden="true" />
        </button>
        <button
            type="button"
            @click.prevent="toggleRight"
            :class="buttonClass(hasRight)"
            :title="t('align_right', 'Align right')"
        >
            <i class="fa-regular fa-align-right" aria-hidden="true" />
        </button>

        <span class="w-px h-4 bg-base-content/20 mx-1" />

        <button
            type="button"
            @click.prevent="deleteTable"
            class="hover:text-error-content px-2 py-1"
            :title="t('delete_table', 'Delete table')"
        >
            <i class="fa-regular fa-trash" aria-hidden="true" />
        </button>
    </div>
</template>
