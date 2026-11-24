import { createApp } from 'vue';
import VueTippy from 'vue-tippy';
import Recovery from './Recovery.vue';

const element = document.getElementById('recovery');

if (element) {
    createApp(Recovery, { api: element.dataset.api })
        .use(VueTippy, { theme: 'kanka' })
        .mount(element);
}
