import { createApp } from 'vue';
import Manager from './Participants.vue';

export const mountParticipants = () => {
    document.querySelectorAll('.js-event-participants:not([data-mounted])').forEach((node) => {
        node.dataset.mounted = 'true';
        const config = JSON.parse(node.querySelector('.js-participant-config').textContent);
        createApp(Manager, config).mount(node.querySelector('.js-participant-app'));
    });
};
