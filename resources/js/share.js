import { createApp } from 'vue';
import EntityShareModal from './utility/EntityShareModal.vue';
import CampaignShareModal from './utility/CampaignShareModal.vue';

const mountShareModals = () => {
    const entityContainer = document.getElementById('entity-share-container');
    if (entityContainer && entityContainer.dataset.init !== '1') {
        entityContainer.dataset.init = '1';
        const app = createApp({});
        app.component('entity-share-modal', EntityShareModal);
        app.mount(entityContainer);
    }

    const campaignContainer = document.getElementById('campaign-share-container');
    if (campaignContainer && campaignContainer.dataset.init !== '1') {
        campaignContainer.dataset.init = '1';
        const app = createApp({});
        app.component('campaign-share-modal', CampaignShareModal);
        app.mount(campaignContainer);
    }
};

document.addEventListener('dialog.loaded', mountShareModals);
