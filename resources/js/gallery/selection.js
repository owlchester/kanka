import { createApp } from 'vue'
import vClickOutside from "click-outside-vue3"
import Selection from "./Selection.vue";
import Browser from "./Browser.vue";

const app = createApp({})
app.component('gallery-selection', Selection)
app.component('gallery-browser', Browser)
app.use(vClickOutside)
app.mount('#gallery-selection')
