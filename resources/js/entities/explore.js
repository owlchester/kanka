import { createApp } from 'vue'
import VueTippy from 'vue-tippy'
import EntityListing from './EntityListing.vue'

const element = document.getElementById('entities-explorer')

if (element) {
    const { api, mode, module } = element.dataset

    createApp(EntityListing, { api, mode, module })
        .use(VueTippy, { theme: 'kanka' })
        .mount(element)
}
