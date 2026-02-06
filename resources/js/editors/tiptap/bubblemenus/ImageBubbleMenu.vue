<script setup lang="ts">
import type { Editor } from '@tiptap/core'
import { buttonClass } from '../utils'

const props = defineProps<{
    editor: Editor
}>()

const setImageWidth = (width: string | null) => {
    props.editor.commands.setImageWidth(width)
}

const setImageFloat = (float: 'left' | 'right' | null) => {
    props.editor.commands.setImageFloat(float)
}

const deleteImage = () => {
    props.editor.chain().focus().deleteSelection().run()
}

const getImageWidth = () => {
    return props.editor.getAttributes('image').width || null
}

const getImageFloat = (): 'left' | 'right' | null => {
    const classes = props.editor.getAttributes('image').class || ''
    if (classes.includes('float-left') || classes.includes('note-float-left')) return 'left'
    if (classes.includes('float-right') || classes.includes('note-float-right')) return 'right'
    return null
}
</script>

<template>
    <div class="flex gap-1 items-center text-xs text-neutral-content px-2">
        <!-- Width controls -->
        <div class="flex items-center gap-0.5 border-r border-base-300 pr-2 mr-1">
            <button
                @click.prevent="setImageWidth('25%')"
                :class="buttonClass(getImageWidth() === '25%')"
                title="25% width"
            >
                25%
            </button>
            <button
                @click.prevent="setImageWidth('50%')"
                :class="buttonClass(getImageWidth() === '50%')"
                title="50% width"
            >
                50%
            </button>
            <button
                @click.prevent="setImageWidth('100%')"
                :class="buttonClass(getImageWidth() === '100%')"
                title="100% width"
            >
                100%
            </button>
            <button
                @click.prevent="setImageWidth(null)"
                :class="buttonClass(getImageWidth() === null)"
                title="Reset width"
            >
                <i class="fa-regular fa-undo" aria-hdasidden="true" />
            </button>
        </div>
        <!-- Float controls -->
        <div class="flex items-center gap-0.5 border-r border-base-300 pr-2 mr-1">
            <button
                @click.prevent="setImageFloat('left')"
                :class="buttonClass(getImageFloat() === 'left')"
                title="Float left"
            >
                <i class="fa-regular fa-align-left" aria-hidden="true" />
            </button>
            <button
                @click.prevent="setImageFloat('right')"
                :class="buttonClass(getImageFloat() === 'right')"
                title="Float right"
            >
                <i class="fa-regular fa-align-right" aria-hidden="true" />
            </button>
            <button
                @click.prevent="setImageFloat(null)"
                :class="buttonClass(getImageFloat() === null)"
                title="No float"
            >
                <i class="fa-regular fa-align-justify" aria-hidden="true" />
            </button>
        </div>
        <!-- Delete -->
        <button
            @click.prevent="deleteImage"
            class="hover:text-error px-2 py-1"
            title="Delete image"
        >
            <i class="fa-regular fa-trash" aria-hidden="true" />
        </button>
    </div>
</template>
