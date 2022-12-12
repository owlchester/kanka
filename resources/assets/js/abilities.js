import { createApp } from 'vue'
import mitt from 'mitt'

const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.component('abilities', require('./components/abilities/Abilities.vue').default)
app.mount('#abilities');
