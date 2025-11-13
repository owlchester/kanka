import { createApp } from 'vue'
import Onboarding from "./Onboarding.vue"
import vClickOutside from "click-outside-vue3"

const app = createApp({})
app.component('onboarding-dialog', Onboarding)
app.use(vClickOutside)

app.mount('#onboarding');
