import { createApp } from 'vue'
import Gallery from "./Gallery.vue"
import vClickOutside from "click-outside-vue3"

const app = createApp({})
app.component('gallery', Gallery)
app.use(vClickOutside)
app.mount('#gallery');
