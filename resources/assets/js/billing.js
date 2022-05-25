import Vue from 'vue'

Vue.component('billing-management', require('./components/subscription/BillingManagement.vue').default);

const app = new Vue({
    el: '#billing',
});
