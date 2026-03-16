import { createApp } from 'vue'
import EntityListing from './EntityListing.vue'

const app = createApp({})
app.component('entities-explorer', EntityListing)
app.mount('#entities-explorer')
