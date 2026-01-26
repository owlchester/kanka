import { createApp } from 'vue'
import Tiptap from "./Tiptap.vue"


const loadWidget = () => {

    const elements = document.querySelectorAll('.tiptap-editor')
    elements.forEach(el => {
        // Don't re-mount if already mounted
        if (el.dataset.init === '1') {
            return
        }
        el.dataset.init = '1'
        const app = createApp({})
        app.component('tiptap', Tiptap)
        app.mount(el)
    })
};

loadWidget();

window.onEvent(function() {
    loadWidget();
});

