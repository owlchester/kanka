import { createApp } from 'vue';
import NavToggler from "./components/layout/NavToggler.vue";
import NavSearch from "./components/layout/NavSearch.vue";
import NavSwitcher from "./components/layout/NavSwitcher.vue";
import vClickOutside from "click-outside-vue3";

const app = createApp({});
app.component('nav-toggler', NavToggler);
app.component('nav-search', NavSearch);
app.component('nav-switcher', NavSwitcher);
app.use(vClickOutside);
app.mount('header');
