<template>
    <a :class="campaignClass()" v-bind:href="campaign.url" :style="{backgroundImage: backgroundImage()}" :title="campaign.name">
        <div class="absolute top-2 right-2 text-sm text-boost" v-if="campaign.is_boosted">
            <i class="fa-regular fa-gem" aria-label="Premium campaign"></i>
        </div>
        <div class="flex items-end justify-center name w-full text-xs p-2 pt-6 text-center" v-html="campaign.name">
        </div>
    </a>
</template>


<script setup lang="ts">

const props = defineProps<{
    campaign: Object,
}>()
const backgroundImage = () => {
    return props.campaign.image ? 'url(' + props.campaign.image + ')' : '';
}
const campaignClass = () => {
    return 'campaign flex items-end border border-solid rounded-lg cover-background relative h-24 overflow-hidden text-break shadow-xs hover:shadow-md border-0'
}
</script>
