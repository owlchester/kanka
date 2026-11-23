<template>
    <div class="">
        <button type="button" class="sidebar-toggle btn2 btn-ghost btn-square size-9.5! min-h-9.5! text-center cursor-pointer hover:text-primary-focus" :aria-label="props.text" data-toggle="tooltip" :data-title="props.title" data-placement="right" data-html="true" data-shortcut="]" @click="toggleSidebar()">
            <svg class="hidden md:inline [body.sidebar-collapse_&]:inline md:[body.sidebar-collapse_&]:hidden h-5 w-5" data-sidebar="collapse" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="18" height="18" x="3" y="3" rx="2" />
                <path d="M9 3v18" />
                <path d="m16 15-3-3 3-3" />
            </svg>
            <svg class="inline md:hidden [body.sidebar-collapse_&]:hidden md:[body.sidebar-collapse_&]:inline h-5 w-5" data-sidebar="expand" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="18" height="18" x="3" y="3" rx="2" />
                <path d="M9 3v18" />
                <path d="m14 9 3 3-3 3" />
            </svg>
            <span class="sr-only">{{ props.text }}</span>
        </button>
    </div>
</template>

<script setup lang="ts">
import {onMounted, onBeforeUnmount} from 'vue'

const props = defineProps<{
    text: String,
    title: String
}>()

const toggleSidebar = () => {
    const  body = document.querySelector('body');
    if (isMobile()) {
        body.classList.toggle('sidebar-open');
        return;
    }
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


const isMobile = (): boolean => {
    return window.innerWidth < 768;
}

const loadFromCookie = () => {
    if (isMobile()) {
        return;
    }

    let re = new RegExp('toggleState' + "=([^;]+)");
    let value = re.exec(document.cookie);
    let toggleState = (value != null) ? decodeURI(value[1]) : null;
    if (toggleState === 'collapsed') {
        const  body = document.querySelector('body');
        body.classList.add('sidebar-collapse');
    }
}

const handleOutsideClick = (event: MouseEvent) => {
    if (!isMobile() || !document.body.classList.contains('sidebar-open')) return;
    const target = event.target as Element;
    if (!target.closest('.main-sidebar') && !target.closest('.sidebar-toggle')) {
        document.body.classList.remove('sidebar-open');
    }
}

const handleEscape = (event: KeyboardEvent) => {
    if (event.key === 'Escape') document.body.classList.remove('sidebar-open');
}

onMounted(() => {
    loadFromCookie();
    document.addEventListener('click', handleOutsideClick);
    document.addEventListener('keydown', handleEscape);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleOutsideClick);
    document.removeEventListener('keydown', handleEscape);
});
</script>
