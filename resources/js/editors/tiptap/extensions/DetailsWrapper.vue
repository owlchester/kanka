<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { NodeViewWrapper, NodeViewContent } from '@tiptap/vue-3'

const props = defineProps<{
    editor: any
    node: any
    getPos: () => number
    updateAttributes: (attrs: Record<string, any>) => void
}>()

const detailsRef = ref<InstanceType<typeof NodeViewWrapper> | null>(null)

const isOpen = computed(() => props.node.attrs.open)

const onToggle = (event: Event) => {
    const details = event.target as HTMLDetailsElement
    props.updateAttributes({ open: details.open })
}

onMounted(() => {
    const el = detailsRef.value?.$el as HTMLDetailsElement
    el?.addEventListener('toggle', onToggle)
})

onBeforeUnmount(() => {
    const el = detailsRef.value?.$el as HTMLDetailsElement
    el?.removeEventListener('toggle', onToggle)
})
</script>

<template>
    <NodeViewWrapper
        ref="detailsRef"
        as="details"
        :open="isOpen || undefined"
        :class="node.attrs.class"
        :style="node.attrs.style"
    >
        <NodeViewContent />
    </NodeViewWrapper>
</template>
