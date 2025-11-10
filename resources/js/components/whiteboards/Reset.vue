<template>
    <dialog class="dialog rounded-2xl bg-base-100 text-base-content" id="reset-dialog" ref="dialog" aria-modal="true" aria-labelledby="modal-card-label">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans('reset-title')" class="text-lg font-normal"></h4>
            <button type="button" class="text-base-content" @click="closeDialog()" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">trans('close')</span>
            </button>
        </header>
        <article class="max-w-4xl p-4">
            {{ trans('reset-helper') }}
        </article>
        <div class="mt-5 flex gap-2 md:gap-5 text-left w-full justify-between p-4 md:p-6">
            <menu class="flex flex-wrap gap-3 ps-0 ms-0">
            </menu>
            <button class="btn2 btn-primary" @click="confirmReset()" v-html="trans('reset')"></button>
        </div>
    </dialog>
</template>

<script setup lang="ts">

import { ref, onMounted, watch} from 'vue';

const props = defineProps<{
    opened: boolean,
    i18n: undefined,
}>()

const emit = defineEmits(['closed'])

const dialog = ref();


watch(() => props.opened, () => {
    open()
})

const open = () => {
    dialog.value.showModal()

    dialog.value.addEventListener('click', function (event) {
        let rect = this.getBoundingClientRect()
        let isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
            rect.left <= event.clientX && event.clientX <= rect.left + rect.width)
        if (!isInDialog && event.target.tagName === 'DIALOG') {
            closeDialog()
        }
    });
}

const trans = (key: string) => {
    return props.i18n[key] || key
}

const confirmReset = () => {
    closeDialog()
    emit('closed')
}

const closeDialog = () => {
    dialog.value.close()
}
</script>
