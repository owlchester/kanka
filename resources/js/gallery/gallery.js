import { createApp } from 'vue'
import Gallery from "./Gallery.vue"
import vClickOutside from "click-outside-vue3"

const element = document.getElementById('gallery')

if (element) {
    createApp(Gallery, { api: element.dataset.api })
        .use(vClickOutside)
        .mount(element)
}
