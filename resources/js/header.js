import { createApp } from 'vue';
import mitt from 'mitt';
import NavToggler from "./components/layout/NavToggler.vue";
import NavSearch from "./components/layout/NavSearch.vue";
import NavSwitcher from "./components/layout/NavSwitcher.vue";


const emitter = mitt();
const app = createApp({});
app.config.globalProperties.emitter = emitter;
app.component('nav-toggler', NavToggler);
app.component('nav-search', NavSearch);
app.component('nav-switcher', NavSwitcher);
app.mount('#header');
