import { createApp } from 'vue'
import Selection from "./Selection.vue"
import { mountOnce } from '../utility/mountOnce'

const loadGalleryWidget = () => {
    document.querySelectorAll('.gallery-selection').forEach(element => {
        mountOnce(element, () => createApp({}).component('gallery-selection', Selection))
    })
}

loadGalleryWidget()

window.onEvent(loadGalleryWidget)
