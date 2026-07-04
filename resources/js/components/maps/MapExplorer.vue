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
        <div class="fixed top-4 left-4 z-[1200] flex items-start gap-4">
            <button class="legend-toggle btn2 btn-default" @click="legendOpen = !legendOpen">
                <i class="fa-regular fa-list" aria-hidden="true" />
            </button>
            <div>
                <h1 class="text-lg font-semibold leading-tight">{{ data.map.name }}</h1>
                <p class="text-sm opacity-75">{{ data.pins.length }} markers</p>
            </div>
        </div>

        <LegendPanel :open="legendOpen" :groups="data.groups" :pins="data.pins" @select="selectPin" />

        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            @pin-click="selectPin"
        />

        <DetailPanel :pin="selectedPin" @close="selectedPin = null" @center="centerNonce++" @deleted="removePin" />
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
const centerNonce = ref(0)

function selectPin(pin) {
    selectedPin.value = pin
}

function removePin(pin) {
    data.value.pins = data.value.pins.filter((p) => p.id !== pin.id)
    selectedPin.value = null
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
