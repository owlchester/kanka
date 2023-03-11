import { createApp } from 'vue'
import mitt from 'mitt'

const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.component('family-tree', require('./components/families/FamilyTree.vue').default)
app.component('FamilyNode', require('./components/families/FamilyNode.vue').default)
app.component('FamilyEntity', require('./components/families/FamilyEntity.vue').default)
app.component('FamilyRelations', require('./components/families/FamilyRelations.vue').default)
app.component('FamilyRelation', require('./components/families/FamilyRelation.vue').default)
app.component('FamilyChildren', require('./components/families/FamilyChildren.vue').default)
app.mount('#family-tree');
