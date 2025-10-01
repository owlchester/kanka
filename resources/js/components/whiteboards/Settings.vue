<template>
    <dialog class="dialog rounded-2xl bg-base-100 text-base-content" id="gallery-dialog" ref="dialog" aria-modal="true" aria-labelledby="modal-card-label">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans('Whiteboard settings')" class="text-lg font-normal"></h4>
            <button type="button" class="text-base-content" @click="closeDialog()" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">trans('close')</span>
            </button>
        </header>
        <article class="max-w-4xl p-4">

            <div class="flex gap-1 w-full">
                <div class="flex flex-col gap-1 grow">
                    <label v-html="trans('Name')"></label>
                    <input
                        type="text"
                        class="w-full"
                        v-model="localName"
                        @input="updateName"
                    />
                </div>
            </div>
        </article>
        <div class="mt-5 flex gap-2 md:gap-5 text-left w-full justify-between p-4 md:p-6 w-full">
            <menu class="flex flex-wrap gap-3 ps-0 ms-0">
            </menu>
            <button class="btn2 btn-primary" @click="closeDialog()" v-html="trans('Save')"></button>
        </div>
    </dialog>
</template>

<script setup lang="ts">

import { ref, onMounted, watch} from 'vue';

const props = defineProps<{
    name: String,
    opened: boolean,
}>()

const emit = defineEmits(['closed'])

const dialog = ref();
const localName = ref(props.name)


watch(() => props.opened, (newVal, oldVal) => {
    if (newVal) {
        open()
    }
})
watch(() => props.name, (newVal) => {
    localName.value = newVal;
});

const trans = (key) => {
    return key;
}

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

const closeDialog = () => {
    dialog.value.close()
    emit('closed', localName.value)
}
</script>
