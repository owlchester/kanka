import { createApp } from 'vue';
import mitt from 'mitt';

const emitter = mitt();
const app = createApp({});
app.config.globalProperties.emitter = emitter;
app.component('nav-switcher', require('./components/layout/NavSwitcher.vue').default);
app.mount('#nav-switcher');
