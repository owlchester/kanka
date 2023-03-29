import { createApp } from 'vue';
import mitt from 'mitt';
import NavSwitcher from "./components/layout/NavSwitcher";

const emitter = mitt();
const app = createApp({});
app.config.globalProperties.emitter = emitter;
app.component('nav-switcher', NavSwitcher);
app.mount('#nav-switcher');
