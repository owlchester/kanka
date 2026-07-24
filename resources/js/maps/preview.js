import 'leaflet/dist/leaflet.css'
import 'leaflet.markercluster/dist/MarkerCluster.css'
import 'leaflet.markercluster/dist/MarkerCluster.Default.css'
import { createApp } from 'vue'
import MapPreview from '../components/maps/MapPreview.vue'

document.querySelectorAll('.js-map-preview').forEach((el) => {
    createApp(MapPreview, {
        api: el.dataset.api,
        exploreUrl: el.dataset.exploreUrl,
        loadingText: el.dataset.loading,
        errorText: el.dataset.error,
    }).mount(el)
})
