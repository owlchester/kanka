import { createApp } from 'vue'
import Abilities from "./components/abilities/Abilities.vue";

const app = createApp({})
app.component('abilities', Abilities)
app.mount('#abilities');
