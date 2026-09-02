import 'leaflet/dist/leaflet.css'
import '../../../public/vendor/leaflet/leaflet.layerstree.css'
import 'leaflet.markercluster/dist/MarkerCluster.css'
import 'leaflet.markercluster/dist/MarkerCluster.Default.css'
import '../leaflet/layerTreePlugin.js'
import { createApp } from 'vue'
import MapPreview from '../components/maps/MapPreview.vue'

export function mountMapPreviews(nodes) {
    nodes.forEach((el) => {
        createApp(MapPreview, {
            api: el.dataset.api,
            exploreUrl: el.dataset.exploreUrl,
            loadingText: el.dataset.loading,
            errorText: el.dataset.error,
        }).mount(el)
    })
}
