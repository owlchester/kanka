<script setup lang="ts">
import type { Editor } from '@tiptap/core'
import { buttonClass } from '../utils'
import { t } from '../i18n.js'

const props = defineProps<{
    editor: Editor
}>()

const emit = defineEmits<{
    'edit-image': []
}>()

const setImageWidth = (width: string | null) => {
    props.editor.chain().focus().setImageWidth(width).run()
}

const setImageFloat = (float: 'left' | 'right' | null) => {
    props.editor.chain().focus().setImageFloat(float).run()
}

const deleteImage = () => {
    props.editor.chain().focus().deleteSelection().run()
}

const getImageWidth = (): string | null => {
    return props.editor.getAttributes('image').widthStyle || null
}

const getImageFloat = (): 'left' | 'right' | null => {
    return props.editor.getAttributes('image').floatStyle || null
}
</script>

<template>
    <div class="flex gap-1 items-center text-xs text-neutral-content px-2 flex-wrap" @mousedown.prevent>
        <!-- Width controls -->
        <div class="flex items-center gap-0.5 border-r border-base-300 pr-2 mr-1">
            <button
                type="button"
                @click.prevent="setImageWidth('25%')"
                :class="buttonClass(getImageWidth() === '25%')"
                :title="t('width_25', '25% width')"
            >
                25%
            </button>
            <button
                type="button"
                @click.prevent="setImageWidth('50%')"
                :class="buttonClass(getImageWidth() === '50%')"
                :title="t('width_50', '50% width')"
            >
                50%
            </button>
            <button
                type="button"
                @click.prevent="setImageWidth('75%')"
                :class="buttonClass(getImageWidth() === '75%')"
                :title="t('width_75', '75% width')"
            >
                75%
            </button>
            <button
                type="button"
                @click.prevent="setImageWidth('100%')"
                :class="buttonClass(getImageWidth() === '100%')"
                :title="t('width_100', '100% width')"
            >
                100%
            </button>
            <button
                type="button"
                @click.prevent="setImageWidth(null)"
                :class="buttonClass(getImageWidth() === null && editor.getAttributes('image').width == null)"
                :title="t('reset_width', 'Reset size')"
            >
                <i class="fa-regular fa-undo" aria-hidden="true" />
            </button>
        </div>
        <!-- Float controls -->
        <div class="flex items-center gap-0.5 border-r border-base-300 pr-2 mr-1">
            <button
                type="button"
                @click.prevent="setImageFloat('left')"
                :class="buttonClass(getImageFloat() === 'left')"
                :title="t('float_left', 'Float left')"
            >
                <i class="fa-regular fa-align-left" aria-hidden="true" />
            </button>
            <button
                type="button"
                @click.prevent="setImageFloat('right')"
                :class="buttonClass(getImageFloat() === 'right')"
                :title="t('float_right', 'Float right')"
            >
                <i class="fa-regular fa-align-right" aria-hidden="true" />
            </button>
            <button
                type="button"
                @click.prevent="setImageFloat(null)"
                :class="buttonClass(getImageFloat() === null)"
                :title="t('float_none', 'No float')"
            >
                <i class="fa-regular fa-align-justify" aria-hidden="true" />
            </button>
        </div>
        <!-- Edit attributes -->
        <button
            type="button"
            @click.prevent="emit('edit-image')"
            :class="buttonClass(false)"
            :title="t('edit_image', 'Edit image')"
        >
            <i class="fa-regular fa-pen-to-square" aria-hidden="true" />
        </button>
        <!-- Delete -->
        <button
            type="button"
            @click.prevent="deleteImage"
            class="hover:text-error-content px-2 py-1"
            :title="t('delete_image', 'Delete image')"
        >
            <i class="fa-regular fa-trash" aria-hidden="true" />
        </button>
    </div>
</template>
