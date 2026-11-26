import { createApp } from 'vue';
import FamilyTree from './components/families/FamilyTree.vue';

const element = document.getElementById('family-tree');

if (element) {
    const {
        api,
        saveApi,
        entityApi,
        promoteApi,
        searchApi,
        subscribeUrl,
        familyName,
        focusEntity,
        permission,
    } = element.dataset;

    const app = createApp(FamilyTree, {
        api,
        save_api: saveApi,
        entity_api: entityApi,
        promote_api: promoteApi,
        search_api: searchApi,
        subscribe_url: subscribeUrl,
        family_name: familyName,
        focus_entity: focusEntity,
        permission: permission === '1',
    });

    app.mount(element);
}
