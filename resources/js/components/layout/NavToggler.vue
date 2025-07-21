<template>
    <div class="">
        <span role="button" class="sidebar-toggle text-center cursor-pointer fill-current hover:text-primary-focus" data-toggle="tooltip" :data-title="props.title" data-placement="right" data-html="true" tabindex="" @click="toggleSidebar()">
          <svg class="h-6 w-6 transition-all duration-150 hover:rotate-45" data-sidebar="collapse" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50">
<path d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z"></path>
</svg>
          <svg class="h-6 w-6 transition-all duration-150 hover:rotate-90" data-sidebar="expand" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50">
<path d="M 0 9 L 0 11 L 50 11 L 50 9 Z M 0 24 L 0 26 L 50 26 L 50 24 Z M 0 39 L 0 41 L 50 41 L 50 39 Z"></path>
</svg>
            <span class="sr-only">{{ props.text }}</span>
        </span>
    </div>
</template>

<script setup lang="ts">
import {onMounted} from 'vue'

const props = defineProps<{
    text: String,
    title: String
}>()

const toggleSidebar = () => {
    const  body = document.querySelector('body');
    if (body.classList.contains('sidebar-collapse')) {
        body.classList.remove('sidebar-collapse');
        saveToCookie(false);
    } else {
        body.classList.add('sidebar-collapse');
        saveToCookie(true);
    }
}

const saveToCookie = (collapsed: boolean) => {
    let date = new Date();
    const days = 90;
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    let expires = " expires=" + date.toGMTString();
    let secure = location.protocol === 'https:' ? 'secure; ' : '';
    document.cookie = "toggleState="+(collapsed ? 'collapsed' : 'open')+"; path=/; " + secure + "samesite=lax; " + expires;
}

const loadFromCookie = () => {
    let re = new RegExp('toggleState' + "=([^;]+)");
    let value = re.exec(document.cookie);
    let toggleState = (value != null) ? decodeURI(value[1]) : null;
    if (toggleState === 'collapsed') {
        const  body = document.querySelector('body');
        body.classList.add('sidebar-collapse');
    }
}

onMounted(() => {
    loadFromCookie();
});
</script>
