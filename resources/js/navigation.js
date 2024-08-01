import { createApp } from 'vue';
import NavSwitcher from "./components/layout/NavSwitcher";

const app = createApp({});
app.component('nav-switcher', NavSwitcher);
app.mount('#nav-switcher');
