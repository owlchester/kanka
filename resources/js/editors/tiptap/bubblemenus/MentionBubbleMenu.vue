<script setup lang="ts">
import { ref } from 'vue'
import type { Editor } from '@tiptap/core'

const props = defineProps<{
    editor: Editor
    mentions: any[]
}>()

const mentionLabelInput = ref<HTMLInputElement | null>(null)
const editingMentionLabel = ref('')
const mentionConfigInput = ref<HTMLInputElement | null>(null)
const editingMentionConfig = ref('')
const showMentionConfig = ref(false)

// Sync label when selection changes
const syncLabel = () => {
    const mentionAttrs = props.editor.getAttributes('mention')
    if (mentionAttrs?.entity) {
        editingMentionLabel.value = mentionAttrs?.label || ''
    }
}

defineExpose({ syncLabel })

const deleteMention = () => {
    props.editor.chain().focus().deleteSelection().run()
}

const startEditingMentionLabel = () => {
    // Value is pre-filled by syncLabel, nothing to do here
}

const updateMentionLabel = () => {
    let trimmedLabel = editingMentionLabel.value.trim()
    const mentionAttrs = props.editor.getAttributes('mention')
    const entityId = mentionAttrs?.id

    // If the new name matches the entity's default name, clear the label
    const entity = props.mentions.find(e => e.id === parseInt(entityId))
    if (trimmedLabel === entity?.name) {
        trimmedLabel = ''
    }

    // Update the label (empty string will cause renderLabel to fall back to name)
    props.editor
        .chain()
        .focus()
        .updateAttributes('mention', {
            label: trimmedLabel
        })
        .run()

    editingMentionLabel.value = ''
}

const handleMentionLabelBlur = (event: FocusEvent) => {
    const relatedTarget = event.relatedTarget as HTMLElement
    if (relatedTarget && relatedTarget.closest('.bubble-menu')) {
        return
    }
    updateMentionLabel()
}

const handleMentionLabelKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Enter') {
        event.preventDefault()
        updateMentionLabel()
    } else if (event.key === 'Escape') {
        event.preventDefault()
        editingMentionLabel.value = ''
        props.editor.commands.focus()
    }
}

const openMentionConfig = () => {
    const mentionAttrs = props.editor.getAttributes('mention')
    editingMentionConfig.value = mentionAttrs?.config || ''
    showMentionConfig.value = true

    setTimeout(() => {
        mentionConfigInput.value?.focus()
        mentionConfigInput.value?.select()
    }, 10)
}

const updateMentionConfig = () => {
    const trimmedConfig = editingMentionConfig.value.trim()

    props.editor
        .chain()
        .focus()
        .updateAttributes('mention', {
            config: trimmedConfig || null
        })
        .run()

    showMentionConfig.value = false
    editingMentionConfig.value = ''
}

const handleMentionConfigBlur = (event: FocusEvent) => {
    const relatedTarget = event.relatedTarget as HTMLElement
    if (relatedTarget && relatedTarget.closest('.bubble-menu')) {
        return
    }
    updateMentionConfig()
}

const clearMentionConfig = () => {
    props.editor
        .chain()
        .focus()
        .updateAttributes('mention', {
            config: null
        })
        .run()

    showMentionConfig.value = false
    editingMentionConfig.value = ''
}

const handleMentionConfigKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Enter') {
        event.preventDefault()
        updateMentionConfig()
    } else if (event.key === 'Escape') {
        event.preventDefault()
        showMentionConfig.value = false
        editingMentionConfig.value = ''
        props.editor.commands.focus()
    }
}
</script>

<template>
    <div class="flex items-center gap-2 text-xs text-neutral-content px-2">
        <template v-if="showMentionConfig">
            <input
                ref="mentionConfigInput"
                v-model="editingMentionConfig"
                type="text"
                placeholder="page:abilities|anchor:#ability-1"
                class="p-0 px-1 rounded text-xs outline-none focus:ring-1 focus:ring-primary min-w-[250px]"
                @blur="handleMentionConfigBlur"
                @keydown="handleMentionConfigKeydown"
            />
            <button
                v-if="editor.getAttributes('mention').config"
                @click.prevent="clearMentionConfig"
                class="hover:text-warning"
                title="Clear config"
            >
                <i class="fa-regular fa-times" />
            </button>
        </template>
        <template v-else>
            <!-- Valid entity: show editable label and link -->
            <template v-if="editor.getAttributes('mention').entity">
                <input
                    ref="mentionLabelInput"
                    v-model="editingMentionLabel"
                    type="text"
                    :placeholder="editor.getAttributes('mention').entity.name"
                    class="p-0 px-1 rounded text-xs outline-none focus:ring-1 focus:ring-primary min-w-[150px]"
                    @focus="startEditingMentionLabel"
                    @blur="handleMentionLabelBlur"
                    @keydown="handleMentionLabelKeydown"
                />
                <a
                    v-if="editor.getAttributes('mention').url"
                    class="text-link"
                    :href="editor.getAttributes('mention').url"
                    title="Go to entity"
                >
                    <i class="fa-regular fa-external-link-alt" aria-hidden="true" />
                </a>
            </template>
            <!-- Unknown entity: show warning -->
            <template v-else>
                <span class="text-neutral-content flex items-center gap-1">
                    <i class="fa-regular fa-exclamation-triangle" aria-hidden="true" />
                    Unknown entity
                </span>
            </template>
            <button
                @click.prevent="openMentionConfig"
                class="hover:text-primary"
                :class="{ 'text-primary': editor.getAttributes('mention').config }"
                title="Customize mention"
            >
                <i class="fa-regular fa-cog" aria-hidden="true" />
            </button>
            <button
                @click.prevent="deleteMention"
                class="hover:text-error"
                title="Remove mention"
            >
                <i class="fa-regular fa-trash" aria-hidden="true" />
            </button>
        </template>
    </div>
</template>
