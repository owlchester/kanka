import { createApp } from 'vue';
import SidebarEditor from '../components/sidebar/SidebarEditor.vue';

const element = document.getElementById('sidebar-v2-editor');
if (element) {
    createApp(SidebarEditor, { config: JSON.parse(element.dataset.config) }).mount(element);

    document.querySelectorAll('.submenu-switcher').forEach(select => {
        const initialIndex = select.selectedIndex;
        select.addEventListener('change', () => {
            const route = select.selectedOptions[0]?.dataset.route;
            select.selectedIndex = initialIndex;
            if (route) window.location.assign(route);
        });
    });
}

document.querySelectorAll('[data-sidebar-confirm]').forEach(button => {
    button.addEventListener('click', event => {
        if (!window.confirm(button.dataset.sidebarConfirm)) event.preventDefault();
    });
});
