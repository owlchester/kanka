import { createApp } from 'vue'
import mitt from 'mitt'
import Abilities from "./components/abilities/Abilities.vue";

const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.component('abilities', Abilities)
app.mount('#abilities');
