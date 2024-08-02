import { createApp } from 'vue';
import NavToggler from "./components/layout/NavToggler.vue";
import NavSearch from "./components/layout/NavSearch.vue";
import NavSwitcher from "./components/layout/NavSwitcher.vue";

const app = createApp({});
app.component('nav-toggler', NavToggler);
app.component('nav-search', NavSearch);
app.component('nav-switcher', NavSwitcher);
app.mount('#header');
