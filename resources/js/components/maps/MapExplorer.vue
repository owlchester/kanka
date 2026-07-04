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

    <LeafletCanvas
        v-else
        :map="data.map"
        :layers="data.layers"
        :pins="data.pins"
        @pin-click="selectPin"
    />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import LeafletCanvas from './LeafletCanvas.vue'

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
