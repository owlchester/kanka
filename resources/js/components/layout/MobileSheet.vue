<template>
    <Teleport to="body">
        <dialog ref="dialog" class="mobile-sheet rounded-t-2xl bg-base-100 text-base-content w-full max-w-full! md:max-w-lg!" :aria-label="title" @close="emit('update:modelValue', false)" @click="onBackdropClick">
            <MobilePanelHeader v-if="backLabel" :title="title" :back-label="backLabel" @back="emit('back')" />
            <header v-else class="flex items-center justify-between gap-3 px-5 py-3">
                <h2 class="m-0 text-lg font-semibold">{{ title }}</h2>
                <button type="button" class="flex size-11 shrink-0 items-center justify-center rounded-xl hover:bg-base-200" :aria-label="closeLabel" @click="dialog?.close()">
                    <i class="fa-regular fa-times" aria-hidden="true"></i>
                </button>
            </header>
            <article class="px-5 pb-6"><slot /></article>
        </dialog>
    </Teleport>
</template>

<script setup lang="ts">
import { onBeforeUnmount, ref, watch } from 'vue'
import MobilePanelHeader from './MobilePanelHeader.vue'

const props = defineProps<{ modelValue: boolean; title: string; closeLabel: string; backLabel?: string }>()
const emit = defineEmits<{ 'update:modelValue': [value: boolean]; back: [] }>()
const dialog = ref<HTMLDialogElement>()

watch(() => props.modelValue, (open) => {
    if (open && !dialog.value?.open) dialog.value?.showModal()
    else if (!open && dialog.value?.open) dialog.value.close()
}, { flush: 'post' })

const onBackdropClick = (event: MouseEvent) => {
    if (event.target !== dialog.value) return
    const rect = dialog.value.getBoundingClientRect()
    if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) dialog.value.close()
}

onBeforeUnmount(() => dialog.value?.close())
</script>
