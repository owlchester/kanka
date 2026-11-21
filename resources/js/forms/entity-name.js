import { createApp } from 'vue'
import VueTippy from 'vue-tippy'
import EntityName from "../components/fields/EntityName.vue"
import { mountOnce } from '../utility/mountOnce'

const loadWidget = () => {
    document.querySelectorAll('.field-entity-name').forEach(element => {
        mountOnce(element, () => createApp({})
            .use(VueTippy, { defaultProps: { interactive: true } })
            .component('entity-name', EntityName))
    })
}

loadWidget()

window.onEvent(loadWidget)
