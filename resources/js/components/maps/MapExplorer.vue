<template>
    <div class="w-full h-screen flex items-center justify-center text-2xl" v-if="loading || error">
        <div class="flex items-center gap-2" v-if="loading && !error">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>loading....</span>
        </div>
        <div class="flex flex-col items-center gap-2 text-error-content" v-else-if="error">
            <span>{{ error }}</span>
        </div>
    </div>

    <template v-else>
        <button
            class="legend-toggle fixed top-4 left-4 z-40 btn2 btn-default"
            @click="legendOpen = !legendOpen"
        >
            <i class="fa-solid fa-list" aria-hidden="true" />
        </button>

        <LegendPanel :open="legendOpen" :groups="data.groups" :pins="data.pins" @select="selectPin" />

        <LeafletCanvas :map="data.map" :layers="data.layers" :pins="data.pins" @pin-click="selectPin" />

        <DetailPanel :pin="selectedPin" @close="selectedPin = null" />
    </template>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import DetailPanel from './DetailPanel.vue'
import LeafletCanvas from './LeafletCanvas.vue'
import LegendPanel from './LegendPanel.vue'

const props = defineProps({
    api: { type: String, required: true },
})

const loading = ref(true)
const error = ref(null)
const data = ref({ map: {}, layers: [], groups: [], pins: [] })
const legendOpen = ref(false)
const selectedPin = ref(null)

function selectPin(pin) {
    selectedPin.value = pin
}

onMounted(async () => {
    try {
        const res = await axios.get(props.api)
        data.value = res.data
    } catch (e) {
        error.value = 'Unable to load this map.'
    } finally {
        loading.value = false
    }
})
</script>
