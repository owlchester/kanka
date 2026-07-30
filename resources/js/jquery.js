import jQuery from 'jquery'
import { configureJQuery } from './jquerySetup.js'

const token = document.head.querySelector('meta[name="csrf-token"]')
const assets = document.querySelector('[data-summernote-assets]')

configureJQuery(window, jQuery, token?.content)
window.dispatchEvent(new CustomEvent('jquery:ready'))

const loadScript = (source) => new Promise((resolve, reject) => {
    const script = document.createElement('script')
    script.src = source
    script.onload = resolve
    script.onerror = () => reject(new Error(`Unable to load ${source}`))
    document.head.append(script)
})

if (assets) {
    await import('bootstrap/dist/js/npm.js')

    for (const script of assets.querySelectorAll('[data-script-source]')) {
        await loadScript(script.dataset.scriptSource)
    }

    await import('./editors/summernote.js')
}
