import { createApp } from 'vue'
import Manager from './components/attributes/Manager.vue'
import vClickOutside from 'click-outside-vue3'

const element = document.getElementById('attributes-manager')

if (element) {
    createApp(Manager, { api: element.dataset.api })
        .use(vClickOutside)
        .mount(element)
}
