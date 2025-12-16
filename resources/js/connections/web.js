import { createApp } from 'vue';
import Web from "../components/connections/Web.vue";

const app = createApp({});
app.component('connections-web', Web);
app.mount('#web');
