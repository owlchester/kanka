import { createApp, h } from 'vue'
import Tiptap from "./Tiptap.vue"


const loadWidget = () => {

    const elements = document.querySelectorAll('.tiptap-editor')
    elements.forEach(el => {
        // Don't re-mount if already mounted
        if (el.dataset.init === '1') {
            return
        }
        el.dataset.init = '1'

        // Get content and field name from data attributes
        const content = el.dataset.content || ''
        const fieldName = el.dataset.fieldName || 'entry'

        // Get props from the tiptap element
        const tiptapEl = el.querySelector('tiptap')
        const props = {
            content,
            fieldName,
            mentions: tiptapEl?.getAttribute('mentions') || undefined,
            gallery: tiptapEl?.getAttribute('gallery') || undefined,
        }

        // Remove the placeholder tiptap element
        if (tiptapEl) {
            tiptapEl.remove()
        }

        const app = createApp({
            render() {
                return h(Tiptap, props)
            }
        })
        app.mount(el)
    })
};

loadWidget();

window.onEvent(function() {
    loadWidget();
});

