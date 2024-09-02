import { createApp } from 'vue'
import Recovery from "./Recovery.vue"
import vClickOutside from "click-outside-vue3"

const app = createApp({})
app.component('recovery', Recovery)
app.use(vClickOutside)

app.mount('#recovery');
