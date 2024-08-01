<template>
    <div :class="backgroundClass(notification)" v-if="notification.url && !is_dismissed" :data-id="notification.id">
        <div class="flex-none p-2">
            <i :class="iconClass(notification)" aria-hidden="true"></i>
        </div>
        <a class="flex-grow p-2 break-all " v-html="notification.text" v-bind:href="notification.url" ></a>

        <div class="flex-none p-2 cursor-pointer dismissable" v-on:click="dismiss(notification)" v-if="!is_loading" :title="notification.dismiss_text">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </div>
        <div class="flex-none p-2" v-else>
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>
    </div>
    <div :class="backgroundClass(notification)" :data-id="notification.id" v-else-if="!is_dismissed">
        <div class="flex-none p-2">
            <i :class="iconClass(notification)" aria-hidden="true"></i>
        </div>
        <div class="flex-grow p-2" v-html="notification.text"></div>

        <div class="flex-none p-2 cursor-pointer dismissable" v-on:click="dismiss(notification)" v-if="!is_loading" :title="notification.dismiss_text">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </div>
        <div class="flex-none p-2" v-else>
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>
    </div>
</template>


<script setup lang="ts">

const emit = defineEmits(['read'])

import {ref} from 'vue'

const props = defineProps<{
    notification: undefined
}>()

const is_dismissed = ref(false)
const is_loading = ref(false)

const backgroundClass = (notification) => {
    let css = 'notification bg-base-200 flex justify-center items-center p-2 rounded-md';
    if (notification.is_read) {
        return css;
    }
    return css + ' unread';
};
const iconClass = (notification) => {
    return 'fa-solid fa-' + notification.icon;
};
const dismiss = (notification) => {
    is_loading.value = true;
    axios.post(notification.dismiss)
        .then(() => {
            is_dismissed.value = true;
            emit('read', notification);
        });
};
</script>
