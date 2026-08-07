import { createApp } from 'vue'
import mitt from 'mitt'
import FamilyTree from './components/families/FamilyTree.vue'

const app = createApp({})
app.config.globalProperties.emitter = mitt()
app.component('family-tree', FamilyTree)
app.mount('#family-tree')
