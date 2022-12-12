import { createApp } from 'vue'
import mitt from 'mitt'

const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.component('conversation', require('./components/conversation/Conversation.vue').default)
app.mount('#conversation');
