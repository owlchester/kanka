import Vue from 'vue'

Vue.component('conversation', require('./components/conversation/Conversation.vue').default);
Vue.component('conversation-messages', require('./components/conversation/Messages.vue').default);
Vue.component('conversation-message', require('./components/conversation/Message.vue').default);
Vue.component('conversation-form', require('./components/conversation/Form.vue').default);

// Translations
const app = new Vue({
    el: '#conversation',
});
