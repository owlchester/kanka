<script setup lang="ts">
import { computed } from 'vue'
import type { Editor } from '@tiptap/core'
import { buttonClass } from '../utils'

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
const hasBordered = computed(() => hasClass('table-bordered'))
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
    const classList = getClassList()

    // Remove any classes that should be removed
    const filtered = classList.filter(c => !removeClasses.includes(c))

    if (classList.includes(className)) {
        // Remove the class
        updateTableClass(filtered.filter(c => c !== className))
    } else {
        // Add the class
        updateTableClass([...filtered, className])
    }
}

const toggleBordered = () => toggleClass('table-bordered')
const toggleStriped = () => toggleClass('table-striped')
const toggleLeft = () => toggleClass('table-left', ['table-right'])
const toggleRight = () => toggleClass('table-right', ['table-left'])

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
            <i class="fa-regular fa-table-columns" aria-hidden="true" />
            <i class="fa-regular fa-plus text-[8px]" aria-hidden="true" />
        </button>
        <button
            @click.prevent="addRowAfter"
            :class="buttonClass(false)"
            title="Add row"
        >
            <i class="fa-regular fa-table-rows" aria-hidden="true" />
            <i class="fa-regular fa-plus text-[8px]" aria-hidden="true" />
        </button>
        <button
            @click.prevent="deleteColumn"
            :class="buttonClass(false)"
            title="Delete column"
        >
            <i class="fa-regular fa-table-columns" aria-hidden="true" />
            <i class="fa-regular fa-minus text-[8px]" aria-hidden="true" />
        </button>
        <button
            @click.prevent="deleteRow"
            :class="buttonClass(false)"
            title="Delete row"
        >
            <i class="fa-regular fa-table-rows" aria-hidden="true" />
            <i class="fa-regular fa-minus text-[8px]" aria-hidden="true" />
        </button>
        <button
            @click.prevent="toggleHeaderRow"
            :class="buttonClass(false)"
            title="Toggle header row"
        >
            <i class="fa-regular fa-heading" aria-hidden="true" />
        </button>

        <span class="w-px h-4 bg-base-content/20 mx-1" />

        <button
            @click.prevent="toggleBordered"
            :class="buttonClass(hasBordered)"
            title="Toggle bordered"
        >
            <i class="fa-regular fa-border-all" aria-hidden="true" />
        </button>
        <button
            @click.prevent="toggleStriped"
            :class="buttonClass(hasStriped)"
            title="Toggle striped"
        >
            <i class="fa-regular fa-bars" aria-hidden="true" />
        </button>
        <button
            @click.prevent="toggleLeft"
            :class="buttonClass(hasLeft)"
            title="Align left"
        >
            <i class="fa-regular fa-align-left" aria-hidden="true" />
        </button>
        <button
            @click.prevent="toggleRight"
            :class="buttonClass(hasRight)"
            title="Align right"
        >
            <i class="fa-regular fa-align-right" aria-hidden="true" />
        </button>

        <span class="w-px h-4 bg-base-content/20 mx-1" />

        <button
            @click.prevent="deleteTable"
            class="hover:text-error px-2 py-1"
            title="Delete table"
        >
            <i class="fa-regular fa-trash" aria-hidden="true" />
        </button>
    </div>
</template>
