import { createApp } from 'vue'
import vClickOutside from "click-outside-vue3"
import Selection from "./Selection.vue";

const app = createApp({})
app.component('gallery-selection', Selection)
app.use(vClickOutside)
app.mount('#gallery-selection');
