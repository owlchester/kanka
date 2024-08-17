import { createApp } from 'vue'
import Gallery from "./Gallery.vue"

const app = createApp({})
app.component('gallery', Gallery)
app.mount('#gallery');
