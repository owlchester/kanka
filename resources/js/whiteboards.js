import { createApp } from 'vue';
import VueKonva from 'vue-konva';
import Whiteboard from './components/whiteboards/Whiteboard.vue';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Make Pusher global for Echo
window.Pusher = Pusher;

// Create global Echo instance
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

const app = createApp({});
app.use(VueKonva);
app.component('whiteboard', Whiteboard);
app.mount('#whiteboard');
