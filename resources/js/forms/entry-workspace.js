import '../../css/entry-workspace.css';
import { initEntryDate } from './entry-dates.js';

window.onReady(() => {
    document.querySelectorAll('.entry-workspace').forEach(workspace => {
        const target = workspace.dataset.workspaceTab;
        workspace.querySelectorAll('.tab-pane').forEach(pane => pane.classList.toggle('active', pane.id === `form-${target}`));
        workspace.querySelectorAll('.nav-tabs > li').forEach(tab => tab.classList.toggle('active', tab.classList.contains(`tab-${target}`)));
    });

    document.querySelectorAll('[data-entry-date]').forEach(initEntryDate);
});
