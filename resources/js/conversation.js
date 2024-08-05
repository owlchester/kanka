import { createApp } from 'vue'
import Conversation from "./components/conversation/Conversation.vue";

const app = createApp({})
app.component('conversation', Conversation)
app.mount('#conversation');
