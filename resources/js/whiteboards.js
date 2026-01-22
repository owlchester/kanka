import { createApp } from 'vue';
import VueKonva from 'vue-konva';
import Whiteboard from './components/whiteboards/Whiteboard.vue';
import VueTippy from 'vue-tippy';

const app = createApp({});
app.use(VueKonva);
app.use(VueTippy, {
    defaultProps: {
        interactive: true,
        allowHTML: true,
    }
});
app.component('whiteboard', Whiteboard);
app.mount('#whiteboard');
