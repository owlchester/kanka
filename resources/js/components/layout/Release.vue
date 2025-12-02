<template>
    <div :class="backgroundClass(release)" v-if="!is_dismissed" :data-id="release.id">
        <div class="grow p-2">
            <a v-html="release.title" class="font-bold cursor-pointer block w-full" v-bind:href="release.url" target="_blank"></a>
            <p v-html="release.text"></p>
        </div>
        <div class="flex-none p-2 cursor-pointer dismissable" v-on:click="dismiss(release)" v-if="!is_loading" :title="release.dismiss_text">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </div>
        <div class="flex-none p-2" v-else>
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>

    </div>
</template>


<script setup lang="ts">

import {ref} from "vue";

const emit = defineEmits(['read'])

const props = defineProps<{
    release: undefined
}>()

const is_dismissed = ref(false)
const is_loading = ref(false)

const backgroundClass = (release) => {
    let css = 'release bg-base-200 flex justify-center items-center p-2  rounded-md';
    return css;
};
const dismiss = (release) => {
    is_loading.value = true;
    axios.post(release.dismiss)
        .then(() => {
            is_dismissed.value = true;
            emit('read', release);
        });
};
</script>
