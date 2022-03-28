import Conversation from "./components/conversation/Conversation"
import Message from "./components/conversation/Message"
import Messages from "./components/conversation/Messages"
import Form from "./components/conversation/Form"
import * as uiv from 'uiv'

window.Vue = require('vue');

Vue.component('conversation', Conversation);
Vue.component('conversation-messages', Messages);
Vue.component('conversation-message', Message);
Vue.component('conversation-form', Form);

// Boostrap
Vue.use(uiv);

// Translations
const app = new Vue({
    el: '#conversation',
});
