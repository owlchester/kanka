import { createApp } from 'vue'
import Map from './components/relations/Map.vue'

const app = createApp({})
app.component('relations-map', Map)
app.mount('#relations-map')
