import { createApp } from 'vue'
import mitt from 'mitt'
import Conversation from "./components/conversation/Conversation.vue";

const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.component('conversation', Conversation)
app.mount('#conversation');
