import { createApp, defineAsyncComponent } from 'vue'

import mitt from 'mitt'
import NavToggler from "./components/layout/NavToggler.vue"
import NavSearch from "./components/layout/NavSearch.vue"
import NavSwitcher from "./components/layout/NavSwitcher.vue"
import Selection from "./gallery/Selection.vue"


const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.component('nav-toggler', NavToggler)
app.component('nav-search', NavSearch)
app.component('nav-switcher', NavSwitcher)
app.component('gallery-selection', Selection)
app.mount('#app')

