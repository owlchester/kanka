<script setup lang="ts">
import { ref } from 'vue'
import type { Editor } from '@tiptap/core'

const props = defineProps<{
    editor: Editor
}>()

const linkInputRef = ref<HTMLInputElement | null>(null)
const linkUrl = ref('')

const openLinkInput = () => {
    const previousUrl = props.editor.getAttributes('link').href || ''
    linkUrl.value = previousUrl

    setTimeout(() => {
        linkInputRef.value?.focus()
    }, 10)
}

defineExpose({ openLinkInput })

const setLink = () => {
    if (!linkUrl.value) {
        closeLinkInput()
        return
    }

    let url = linkUrl.value
    if (!/^https?:\/\//i.test(url)) {
        url = 'https://' + url
    }

    props.editor
        .chain()
        .focus()
        .extendMarkRange('link')
        .setLink({ href: url })
        .run()

    closeLinkInput()
}

const removeLink = () => {
    props.editor
        .chain()
        .focus()
        .extendMarkRange('link')
        .unsetLink()
        .run()

    closeLinkInput()
}

const closeLinkInput = () => {
    linkUrl.value = ''
    props.editor.commands.focus()
}

const handleLinkKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Enter') {
        event.preventDefault()
        setLink()
    } else if (event.key === 'Escape') {
        event.preventDefault()
        closeLinkInput()
    }
}
</script>

<template>
    <div class="flex gap-2 items-center text-xs text-neutral-content px-2">
        <input
            ref="linkInputRef"
            v-model="editor.getAttributes('link').href"
            type="text"
            placeholder="Enter URL..."
            class="p-0 px-1 rounded text-xs outline-none focus:ring-1 focus:ring-primary min-w-[200px]"
            @keydown="handleLinkKeydown"
        />
        <a
            v-if="editor.isActive('link')"
            :href="editor.getAttributes('link').href"
            target="_blank"
            class="hover:text-base-content"
            title="Open in a new window"
        >
            <i class="fa-regular fa-external-link-alt" />
        </a>
        <button
            v-if="editor.isActive('link')"
            @click.prevent="removeLink"
            class="hover:text-error"
            title="Remove link"
        >
            <i class="fa-regular fa-unlink" aria-label="Removal icon" />
        </button>
    </div>
</template>
