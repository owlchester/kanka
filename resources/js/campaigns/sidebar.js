import { createApp } from 'vue';
import SidebarEditor from '../components/sidebar/SidebarEditor.vue';

const element = document.getElementById('sidebar-v2-editor');
if (element) {
    createApp(SidebarEditor, { config: JSON.parse(element.dataset.config) }).mount(element);
}
