<template>
    <div class="flex flex-wrap gap-3 lg:gap-5 w-full">
        <!-- Back card when viewing children -->
        <a v-if="parent" :href="parent.urls.parent"
           class="entity w-[47%] xs:w-[25%] sm:w-48 overflow-hidden rounded flex flex-col shadow-xs hover:shadow-md text-link"
           @click.prevent="$emit('back')">
            <div class="flex items-center justify-center grow text-6xl">
                <i class="fa-regular fa-arrow-left" aria-hidden="true"></i>
            </div>
            <div class="block text-center p-4 h-12 bg-box">
                <span v-html="parent.links.back"></span>
            </div>
        </a>

        <template v-for="(entity, idx) in entities" :key="entity.id">
            <EntityCard
                :entity="entity"
                :selecting="selecting"
                :nested="nested"
                :i18n="i18n"
                @navigate="(id, url) => $emit('navigate', id, url)"
                @start-selecting="(id) => $emit('startSelecting', id)"
            />
            <EntityAdSlot
                v-if="ads.enabled && (idx + 1) % ads.frequency === 0"
                :idx="idx"
            />
        </template>
    </div>
</template>

<script setup lang="ts">
import EntityCard from './EntityCard.vue'
import EntityAdSlot from './EntityAdSlot.vue'

defineProps<{
    entities: any[]
    parent: any
    selecting: boolean
    nested: boolean
    i18n: any
    ads: { enabled: boolean; frequency: number }
}>()

defineEmits<{
    navigate: [entityId: number, childrenUrl: string]
    back: []
    startSelecting: [entityId: number]
}>()
</script>
