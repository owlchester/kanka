import Conversation from "./components/conversation/Conversation"
import Message from "./components/conversation/Message"
import Messages from "./components/conversation/Messages"
import Form from "./components/conversation/Form"
import VueInternationalization from 'vue-i18n'
import Locale from "./vue-i18n-locales.generated"
import * as uiv from 'uiv'

window.Vue = require('vue');

Vue.component('conversation', Conversation);
Vue.component('conversation-messages', Messages);
Vue.component('conversation-message', Message);
Vue.component('conversation-form', Form);

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
    el: '#conversation',
    i18n
});
