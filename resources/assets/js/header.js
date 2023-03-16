import { createApp } from 'vue';
import mitt from 'mitt';

const emitter = mitt();
const app = createApp({});
app.config.globalProperties.emitter = emitter;
app.component('nav-toggler', require('./components/layout/NavToggler.vue').default);
app.component('nav-search', require('./components/layout/NavSearch.vue').default);
app.component('nav-switcher', require('./components/layout/NavSwitcher.vue').default);
app.mount('#header');
