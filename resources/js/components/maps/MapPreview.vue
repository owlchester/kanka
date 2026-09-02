<template>
    <div class="w-full h-full flex items-center justify-center" v-if="loading || error">
        <div class="flex items-center gap-2" v-if="loading && !error">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ loadingText }}</span>
        </div>
        <div class="flex flex-col items-center gap-2 text-error-content" v-else-if="error">
            <span>{{ error }}</span>
        </div>
    </div>

    <LeafletCanvas
        v-else
        embedded
        :map="data.map"
        :layers="data.layers"
        :show-layer-control="true"
        :base-layer-name="data.i18n.layers_base"
        :groups-label="data.i18n.groups_label"
        :groups="data.groups"
        :pins="data.pins"
        :legacy-pins="data.map.settings?.legacy_pins"
        @pin-click="goToPin"
    />
</template>

<script setup>
import { ref, onMounted } from "vue";
import LeafletCanvas from "./LeafletCanvas.vue";

const props = defineProps({
    api: { type: String, required: true },
    exploreUrl: { type: String, required: true },
    loadingText: { type: String, required: true },
    errorText: { type: String, required: true },
});

const loading = ref(true);
const error = ref(null);
const data = ref({ map: {}, layers: [], groups: [], pins: [] });

function goToPin(pin) {
    const separator = props.exploreUrl.includes("?") ? "&" : "?";

    window.location.href = props.exploreUrl + separator + "focus=" + pin.id;
}

onMounted(async () => {
    try {
        const res = await axios.get(props.api);
        data.value = res.data;
    } catch (e) {
        error.value = props.errorText;
    } finally {
        loading.value = false;
    }
});
</script>
