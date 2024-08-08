<template>
    <a class="flex justify-center gap-2 cursor-pointer w-full" :href="page.url">
        <div class="flex-none h-4 w-4">
            <i class="fa-solid fa-angles-right" aria-hidden="true" />
        </div>
        <div class="flex-grow truncate">
            <div class="entity-name truncate" :title="page.name" v-html="page.name">
            </div>
        </div>
    </a>
</template>

<script setup lang="ts">

const props = defineProps<{
    page: undefined
}>()
</script>
