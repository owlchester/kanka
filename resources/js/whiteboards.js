import { createApp } from 'vue';
import VueKonva from 'vue-konva';
import Whiteboard from './components/whiteboards/Whiteboard.vue';

const app = createApp({});
app.use(VueKonva);
app.component('whiteboard', Whiteboard);
app.mount('#whiteboard');
