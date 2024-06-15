import { createApp } from 'vue'
import Manager from "./components/attributes/Manager.vue";
import Form from "./components/attributes/Form.vue";
import Attribute from "./components/attributes/Attribute.vue";
import { VueDraggableNext } from 'vue-draggable-next'
import vClickOutside from "click-outside-vue3"


const app = createApp({})
app.component('attributes-manager', Manager)
app.component('attributes-manager-form', Form)
app.component('attributes-manager-attribute', Attribute)
app.component('draggable', VueDraggableNext)
app.use(vClickOutside)
app.mount('#attributes-manager');
