import { createApp } from 'vue'
import Explorer from "./Explorer.vue";
import Entity from "./Entity.vue";
import Dropdown from "../components/Dropdown.vue"
import vClickOutside from "click-outside-vue3"


const app = createApp({})
app.component('entities-explorer', Explorer)
app.component('entities-entity', Entity)
app.component('dropdown', Dropdown)
//app.component('draggable', VueDraggableNext)
app.use(vClickOutside)
app.mount('#entities-explorer');
