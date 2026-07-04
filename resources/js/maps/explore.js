import 'leaflet/dist/leaflet.css'
import 'leaflet.markercluster/dist/MarkerCluster.css'
import 'leaflet.markercluster/dist/MarkerCluster.Default.css'
import { createApp } from 'vue'
import MapExplorer from '../components/maps/MapExplorer.vue'

const app = createApp({})
app.component('map-explorer', MapExplorer)
app.mount('#map-explorer')
