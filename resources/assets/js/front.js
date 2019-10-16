
import Dropdown from './components/Dropdown.vue';


/**
 * Vue is only used on the API token generation, because enabling it in the whole app opens us
 * to {{ }} constructor injections.
 */
window.Vue = require('vue');

Vue.component(
    'dropdown-link',
    Dropdown
);

var nav = new Vue({
    el: '#nav'
});
