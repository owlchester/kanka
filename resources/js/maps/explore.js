import 'leaflet/dist/leaflet.css'
import 'leaflet.markercluster/dist/MarkerCluster.css'
import 'leaflet.markercluster/dist/MarkerCluster.Default.css'
import { createApp } from 'vue'
import VueTippy from 'vue-tippy'
import MapExplorer from '../components/maps/MapExplorer.vue'

const app = createApp({})
app.use(VueTippy, { theme: 'kanka', defaultProps: { interactive: true, allowHTML: true } })
app.component('map-explorer', MapExplorer)
app.mount('#map-explorer')
