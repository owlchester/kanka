const form = document.querySelector('[data-category-form]');

if (form) {
    const editor = form.querySelector('[data-category-statuses]');
    const rows = editor.querySelector('[data-status-rows]');
    const add = editor.querySelector('[data-status-add]');
    let dirty = false;

    const refresh = () => {
        const items = [...rows.children];
        items.forEach((row, index) => {
            row.querySelectorAll('[data-status-field]').forEach(input => {
                input.name = `statuses[${index}][${input.dataset.statusField}]`;
            });
            row.querySelector('[data-status-field="is_default"]').value = row.querySelector('[data-status-default]').checked ? '1' : '0';
            row.querySelector('[data-status-up]').disabled = index === 0;
            row.querySelector('[data-status-down]').disabled = index === items.length - 1;
            const icon = row.querySelector('[data-status-field="icon"]').value.trim();
            row.querySelector('[data-status-preview]').className = /^(?:(?:fa-regular|fa-solid|fa-light|fa-thin|fa-duotone|fa-brands) )?fa-[a-z0-9-]+$/.test(icon)
                ? (icon.includes(' ') ? icon : `fa-regular ${icon}`) : '';
        });
        add.disabled = items.length >= 10;
    };

    form.addEventListener('input', () => { dirty = true; refresh(); });
    form.addEventListener('change', () => { dirty = true; refresh(); });
    editor.addEventListener('click', event => {
        const button = event.target.closest('button');
        if (!button) return;
        const row = button.closest('[data-status-row]');
        if (button.hasAttribute('data-status-add') && rows.children.length < 10) {
            rows.append(editor.querySelector('[data-status-template]').content.cloneNode(true));
            rows.lastElementChild.querySelector('[data-status-field="label"]').focus();
        } else if (button.hasAttribute('data-status-remove')) {
            if (row.querySelector('[data-status-default]').checked) editor.querySelector('[data-status-default-none]').checked = true;
            row.remove();
        } else if (button.hasAttribute('data-status-up') && row.previousElementSibling) {
            rows.insertBefore(row, row.previousElementSibling);
        } else if (button.hasAttribute('data-status-down') && row.nextElementSibling) {
            rows.insertBefore(row.nextElementSibling, row);
        } else return;
        dirty = true;
        refresh();
    });
    let draggedRow = null;
    rows.addEventListener('dragstart', event => {
        draggedRow = event.target.closest('[data-status-row]');
        if (!draggedRow) return;
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/plain', 'status-row');
    });
    rows.addEventListener('dragover', event => {
        const target = event.target.closest('[data-status-row]');
        if (!draggedRow || !target || target === draggedRow) return;
        event.preventDefault();
        const bounds = target.getBoundingClientRect();
        rows.insertBefore(draggedRow, event.clientY < bounds.top + bounds.height / 2 ? target : target.nextElementSibling);
    });
    rows.addEventListener('drop', event => {
        if (draggedRow) {
            event.preventDefault();
            dirty = true;
            refresh();
        }
    });
    rows.addEventListener('dragend', () => { draggedRow = null; });
    window.addEventListener('beforeunload', event => {
        if (dirty) { event.preventDefault(); event.returnValue = ''; }
    });
    form.addEventListener('submit', () => {
        refresh();
        if (!form.hasAttribute('data-maintenance')) dirty = false;
    });
    form.addEventListener('maintenance:validated', () => { dirty = false; });
    refresh();
}
