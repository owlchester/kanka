import { createApp } from 'vue'
import Explorer from "./Explorer.vue";
import Entity from "./Entity.vue";


const app = createApp({})
app.component('entities-explorer', Explorer)
app.component('entities-entity', Entity)
app.mount('#entities-explorer');
