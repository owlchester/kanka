import { createApp } from 'vue'
import VueTippy from 'vue-tippy'
import EntityListing from './EntityListing.vue'

const app = createApp({})
app.use(VueTippy, { theme: 'kanka' })
app.component('entities-explorer', EntityListing)
app.mount('#entities-explorer')
