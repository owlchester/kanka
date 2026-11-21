import { createApp } from 'vue'
import Conversation from './components/conversation/Conversation.vue'

const element = document.getElementById('conversation')

if (element) {
    const { conversationId, api, target, targets, disabled, send, trans } = element.dataset

    createApp(Conversation, {
        id: conversationId,
        api,
        target,
        targets: JSON.parse(targets),
        disabled: disabled === '1',
        send,
        trans: JSON.parse(trans),
    }).mount(element)
}
