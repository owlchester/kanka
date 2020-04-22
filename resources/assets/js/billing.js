import BillingManagement from './components/subscription/BillingManagement';
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';
import * as uiv from 'uiv';

window.Vue = require('vue');

Vue.component('billing-management', BillingManagement);

// Boostrap
Vue.use(uiv);

// Translations
Vue.use(VueInternationalization);
const lang = document.documentElement.lang.substr(0, 2);

console.log('lang', lang);

const i18n = new VueInternationalization({
    locale: lang,
    fallbackLocale: 'en',
    messages: Locale
});

const app = new Vue({
    el: '#billing',
    i18n
});
