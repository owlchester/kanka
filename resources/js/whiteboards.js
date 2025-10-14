import { createApp } from 'vue';
import Whiteboard from './components/whiteboards/Whiteboard.vue';
import VueKonva from 'vue-konva';

const app = createApp({});
app.use(VueKonva);
app.component('whiteboard', Whiteboard);
app.mount('#whiteboard');
