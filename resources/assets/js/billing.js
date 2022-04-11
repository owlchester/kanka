import BillingManagement from './components/subscription/BillingManagement';
import * as uiv from 'uiv';

window.Vue = require('vue');

Vue.component('billing-management', BillingManagement);

// Boostrap
Vue.use(uiv);

const app = new Vue({
    el: '#billing',
});
