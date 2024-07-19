import { createApp } from 'vue'
import Selection from "./Selection.vue"
import Browser from "./Browser.vue"

const app = createApp({})
app.component('gallery-selection', Selection)
app.component('gallery-browser', Browser)
app.mount('#app')
