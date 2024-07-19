import { createApp } from 'vue'
import Selection from "./Selection.vue"

const loadGalleryWidget = () => {

    const elements = document.querySelectorAll('.gallery-selection')
    elements.forEach(el => {
        const app = createApp({})
        app.component('gallery-selection', Selection)
        app.mount(el)
    })
};

loadGalleryWidget();

window.onEvent(function() {
    loadGalleryWidget();
});
