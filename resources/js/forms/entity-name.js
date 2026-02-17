import { createApp } from 'vue'
import VueTippy from 'vue-tippy'
import EntityName from "../components/fields/EntityName.vue"


const loadWidget = () => {

    const elements = document.querySelectorAll('.field-entity-name')
    elements.forEach(el => {
        // Don't re-mount if already mounted
        if (el.dataset.init === '1') {
            return
        }
        el.dataset.init = '1'
        const app = createApp({})
        app.use(VueTippy, { defaultProps: { interactive: true } })
        app.component('entity-name', EntityName)
        app.mount(el)
    })
};

loadWidget();

window.onEvent(function() {
    loadWidget();
});
