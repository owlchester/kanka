import { createApp } from 'vue';
import EntityShareModal from './utility/EntityShareModal.vue';
import CampaignShareModal from './utility/CampaignShareModal.vue';
import { mountOnce } from './utility/mountOnce';

const mountShareModals = () => {
    const entityContainer = document.getElementById('entity-share-container');
    if (entityContainer) {
        mountOnce(entityContainer, () => {
            const { initialCampaignVisibility, initialEntityPrivate, url, saveEndpoint, canChangeVisibility, trans } = entityContainer.dataset;

            return createApp(EntityShareModal, {
                initialCampaignVisibility,
                initialEntityPrivate: initialEntityPrivate === '1',
                url,
                saveEndpoint,
                canChangeVisibility: canChangeVisibility === '1',
                trans: JSON.parse(trans),
            });
        });
    }

    const campaignContainer = document.getElementById('campaign-share-container');
    if (campaignContainer) {
        mountOnce(campaignContainer, () => {
            const { initialVisibility, url, saveEndpoint, settingsUrl, canChangeVisibility, trans } = campaignContainer.dataset;

            return createApp(CampaignShareModal, {
                initialVisibility,
                url,
                saveEndpoint,
                settingsUrl,
                canChangeVisibility: canChangeVisibility === '1',
                trans: JSON.parse(trans),
            });
        });
    }
};

document.addEventListener('dialog.loaded', mountShareModals);
