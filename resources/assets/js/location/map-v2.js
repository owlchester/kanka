
import Map from '../components/map/Map.vue';
import Point from '../components/map/Point.vue';

// Register dragscroll globally
import VueDragscroll from 'vue-dragscroll';

/**
 * Vue is only used on the API token generation, because enabling it in the whole app opens us
 * to {{ }} constructor injections.
 */
window.Vue = require('vue');

Vue.component(
    'location-map',
    Map
);

Vue.use(VueDragscroll);

const app = new Vue({
    el: '#location-map',
});
