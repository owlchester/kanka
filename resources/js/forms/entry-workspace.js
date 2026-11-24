import '../../css/entry-workspace.css';
import { initEntryDate } from './entry-dates.js';

window.onReady(() => {
    document.querySelectorAll('.entry-workspace').forEach(workspace => {
        const target = workspace.dataset.workspaceTab;
        workspace.querySelectorAll('.tab-pane').forEach(pane => pane.classList.toggle('active', pane.id === `form-${target}`));
        workspace.querySelectorAll('.nav-tabs > li').forEach(tab => tab.classList.toggle('active', tab.classList.contains(`tab-${target}`)));

        if (workspace.querySelector('.tiptap-editor')) {
            // Use the document position so scrolling doesn't resize the writing panel.
            const updateHeight = () => {
                const top = workspace.getBoundingClientRect().top + window.scrollY;
                workspace.style.setProperty('--workspace-top', `${top}px`);
            };
            updateHeight();
            window.addEventListener('resize', updateHeight);
            const observer = new ResizeObserver(updateHeight);
            observer.observe(document.querySelector('.content-wrapper'));
        }
    });

    document.querySelectorAll('.entry-workspace-inspector-toggle').forEach(toggle => {
        const workspace = toggle.closest('.entry-workspace');
        const inspector = workspace?.querySelector('.entry-workspace-inspector');
        const content = inspector?.querySelector('.entry-workspace-inspector-content');
        if (!workspace || !inspector || !content) return;

        const storageKey = 'entry-workspace-inspector-collapsed';
        const update = collapsed => {
            workspace.classList.toggle('inspector-collapsed', collapsed);
            toggle.setAttribute('aria-expanded', String(!collapsed));
            const label = collapsed ? toggle.dataset.collapsedLabel : toggle.dataset.expandedLabel;
            toggle.setAttribute('aria-label', label);
            toggle.setAttribute('data-title', label);
            toggle._tippy?.setContent(label);
        };

        update(localStorage.getItem(storageKey) === 'true');
        toggle.addEventListener('click', () => {
            const collapsed = !workspace.classList.contains('inspector-collapsed');
            localStorage.setItem(storageKey, String(collapsed));
            update(collapsed);
        });
    });

    document.querySelectorAll('[data-entry-date]').forEach(initEntryDate);
});
