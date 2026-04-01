<template>
    <div
        :id="adId"
        class="w-[47%] xs:w-[25%] sm:w-48 aspect-square flex items-center justify-center overflow-hidden"
    ></div>
</template>

<script setup lang="ts">
import { onMounted, computed } from 'vue'

const props = defineProps<{
    idx: number
}>()

const adId = computed(() => `nitro-grid-${props.idx}`)

const isDemo = new URLSearchParams(window.location.search).has('nitro_demo')

onMounted(() => {
    if (!(window as any)['nitroAds']) {
        return
    }
    ;(window as any)['nitroAds'].createAd('grid-slot-' + adId.value, {
        sizes: [['180', '150']],
        report: {
            enabled: true,
            icon: true,
            wording: 'Report Ad',
            position: 'bottom-right',
        },
        demo: isDemo,
    })
})
</script>
