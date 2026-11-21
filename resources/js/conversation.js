import { createApp } from 'vue'
import Conversation from './components/conversation/Conversation.vue'

const element = document.getElementById('conversation')

if (element) {
    const { api, target, speakers, closed, canManage, participants, send, trans } = element.dataset

    createApp(Conversation, {
        api,
        target,
        speakers: JSON.parse(speakers),
        closed: closed === '1',
        canManage: canManage === '1',
        participants,
        send,
        trans: JSON.parse(trans),
    }).mount(element)
}
