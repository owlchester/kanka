import SubscriptionManagement from './components/subscription/SubscriptionManagement';
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';
import * as uiv from 'uiv';

window.Vue = require('vue');

Vue.component('subscription-management', SubscriptionManagement);

// Boostrap
Vue.use(uiv);

// Translations
Vue.use(VueInternationalization);
const lang = document.documentElement.lang.substr(0, 2);

const i18n = new VueInternationalization({
    locale: lang,
    fallbackLocale: 'en',
    messages: Locale
});

const app = new Vue({
    el: '#subscription',
    i18n
});
