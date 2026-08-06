import { createApp } from 'vue'
import FamilyTree from './components/families/FamilyTree.vue'

createApp({})
    .component('family-tree', FamilyTree)
    .mount('#family-tree')
