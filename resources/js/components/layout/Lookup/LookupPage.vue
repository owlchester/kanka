<template>
    <a :class="boxCss()" :href="page.url" tabindex="0">
        <div class="flex-none h-4 w-4">
            <i class="fa-solid fa-angles-right" aria-hidden="true" />
        </div>
        <div class="grow truncate">
            <div class="entity-name truncate" :title="page.name" v-html="page.name">
            </div>
        </div>
    </a>
</template>

<script setup lang="ts">

const props = defineProps<{
    page: undefined,
}>()

const boxCss = () => {
    let css = 'flex justify-center gap-2 cursor-pointer w-full text-link';
    return css;
}
</script>
