import { createApp } from 'vue'
import Recovery from "./Recovery.vue"
import vClickOutside from "click-outside-vue3"

const element = document.getElementById('recovery')

if (element) {
    createApp(Recovery, { api: element.dataset.api })
        .use(vClickOutside)
        .mount(element)
}
