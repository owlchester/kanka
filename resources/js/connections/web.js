import { createApp } from 'vue';
import vClickOutside from "click-outside-vue3"
import Web from "../components/connections/Web.vue";

const app = createApp({});
app.use(vClickOutside);
app.component('connections-web', Web);
app.mount('#web');
