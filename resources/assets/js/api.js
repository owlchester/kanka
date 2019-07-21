
import Clients from './components/passport/Clients.vue';
import AuthorizedClients from './components/passport/AuthorizedClients.vue';
import PersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';

/**
 * Vue is only used on the API token generation, because enabling it in the whole app opens us
 * to {{ }} constructor injections.
 */
window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component(
    'passport-clients',
    Clients
);

Vue.component(
    'passport-authorized-clients',
    AuthorizedClients
);

Vue.component(
    'passport-personal-access-tokens',
    PersonalAccessTokens
);

const app = new Vue({
    el: '#app'
});

