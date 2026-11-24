import { createApp } from 'vue';
import vClickOutside from "click-outside-vue3"
import Web from "../components/connections/Web.vue";

const element = document.getElementById('web');

if (element) {
    const { api, premium, creator } = element.dataset;

    createApp(Web, {
        api,
        premium: premium === '1',
        creator: creator === '1',
    }).use(vClickOutside).mount(element);
}
