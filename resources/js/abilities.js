import { createApp } from 'vue'
import Abilities from "./components/abilities/Abilities.vue";

const element = document.getElementById('abilities')

if (element) {
    createApp(Abilities, {
        id: Number(element.dataset.entityId),
        api: element.dataset.api,
        permission: element.dataset.permission === '1',
    }).mount(element)
}
