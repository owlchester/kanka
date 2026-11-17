<template>
    <header class="mobile-panel-header flex shrink-0 items-center justify-between gap-3 px-5 py-3">
        <button type="button" class="mobile-panel-back flex min-h-11 shrink-0 items-center gap-2 text-sm text-neutral-content" @click="$emit('back')">
            <i class="fa-regular fa-angle-left" aria-hidden="true"></i>
            <span>{{ backLabel }}</span>
        </button>
        <h2 class="mobile-panel-title m-0 min-w-0 text-right text-lg font-semibold">{{ title }}</h2>
    </header>
</template>

<script setup lang="ts">
defineProps<{ title: string; backLabel: string }>()
defineEmits<{ back: [] }>()
</script>
