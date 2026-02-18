<template>
    <div v-if="entities.length > 0" class="flex items-start gap-1.5 text-warning-content text-xs">
        <i class="fa-regular fa-triangle-exclamation mt-0.5 flex-none" aria-hidden="true" />
        <span>
            {{ label }}
            <span class="flex flex-wrap gap-1 mt-0.5">
                <a
                    v-for="entity in entities"
                    :key="entity.url"
                    :href="entity.url"
                    target="_blank"
                    class="text-link underline"
                >{{ entity.name }}</a>
            </span>
        </span>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    entities: Array<{ name: string; url: string }>,
    label: string,
}>()
</script>
