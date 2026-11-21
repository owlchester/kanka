import Sortable from 'sortablejs';

const MAX_STATUSES = 10;
const ICON_PATTERN = /^(?:(?:fa-regular|fa-solid|fa-light|fa-thin|fa-duotone|fa-brands) )?fa-[a-z0-9-]+$/;

const toggleClass = (el, className, force) => {
    if (!el || !el.classList) return;
    el.classList.toggle(className, force);
};

export function initCategoryStatuses(form, deps = {}) {
    const editor = form?.querySelector('[data-category-statuses]');
    const rows = editor?.querySelector('[data-status-rows]');
    if (!form || !editor || !rows) return null;

    const addButtons = [...editor.querySelectorAll('[data-status-add]')];
    const countBadge = editor.querySelector('[data-status-count]');
    const emptyState = editor.querySelector('[data-status-empty]');
    const footer = editor.querySelector('[data-status-footer]');
    const limitHint = editor.querySelector('[data-status-limit-hint]');
    const template = editor.querySelector('[data-status-template]');
    const SortableImpl = deps.Sortable ?? Sortable;
    const win = deps.window ?? (typeof window !== 'undefined' ? window : null);

    let dirty = false;

    const setRowDefault = (targetRow, value) => {
        const items = [...rows.children];
        items.forEach(item => {
            const input = item.querySelector('[data-status-field="is_default"]');
            if (input) {
                input.value = item === targetRow && value ? '1' : '0';
            }
        });
    };

    const appendRow = ({ label = '', icon = '', is_default: isDefault = false } = {}) => {
        if (!template || rows.children.length >= MAX_STATUSES) return null;
        rows.append(template.content.cloneNode(true));
        const added = rows.lastElementChild;
        const labelInput = added.querySelector('[data-status-field="label"]');
        const iconInput = added.querySelector('[data-status-field="icon"]');
        if (labelInput) labelInput.value = label;
        if (iconInput) iconInput.value = icon;
        if (isDefault) setRowDefault(added, true);
        return added;
    };

    const refresh = () => {
        const items = [...rows.children];
        const labelCounts = new Map();

        items.forEach(row => {
            const label = (row.querySelector('[data-status-field="label"]')?.value ?? '').trim().toLowerCase();
            if (label !== '') {
                labelCounts.set(label, (labelCounts.get(label) ?? 0) + 1);
            }
        });

        items.forEach((row, index) => {
            row.querySelectorAll('[data-status-field]').forEach(input => {
                input.name = `statuses[${index}][${input.dataset.statusField}]`;
            });

            const isDefault = row.querySelector('[data-status-field="is_default"]')?.value === '1';
            const defaultButton = row.querySelector('[data-status-default]');
            const defaultIcon = row.querySelector('[data-status-default-icon]');
            if (defaultButton) {
                defaultButton.setAttribute('aria-pressed', isDefault ? 'true' : 'false');
                toggleClass(defaultButton, 'btn-primary', isDefault);
                toggleClass(defaultButton, 'btn-ghost', !isDefault);
            }
            if (defaultIcon) {
                defaultIcon.className = isDefault ? 'fa-solid fa-star' : 'fa-regular fa-star';
            }

            const up = row.querySelector('[data-status-up]');
            const down = row.querySelector('[data-status-down]');
            if (up) up.disabled = index === 0;
            if (down) down.disabled = index === items.length - 1;

            const labelValue = (row.querySelector('[data-status-field="label"]')?.value ?? '').trim().toLowerCase();
            const isDuplicate = labelValue !== '' && (labelCounts.get(labelValue) ?? 0) > 1;
            toggleClass(row.querySelector('[data-status-label-error]'), 'hidden', !isDuplicate);

            const icon = (row.querySelector('[data-status-field="icon"]')?.value ?? '').trim();
            const preview = row.querySelector('[data-status-preview]');
            const previewBox = row.querySelector('[data-status-preview-box]');
            const iconError = row.querySelector('[data-status-icon-error]');

            if (icon === '') {
                if (preview) preview.className = 'fa-regular fa-icons opacity-30';
                toggleClass(previewBox, 'border-error', false);
                toggleClass(iconError, 'hidden', true);
            } else if (ICON_PATTERN.test(icon)) {
                if (preview) preview.className = icon.includes(' ') ? icon : `fa-regular ${icon}`;
                toggleClass(previewBox, 'border-error', false);
                toggleClass(iconError, 'hidden', true);
            } else {
                if (preview) preview.className = 'fa-solid fa-triangle-exclamation text-error';
                toggleClass(previewBox, 'border-error', true);
                toggleClass(iconError, 'hidden', false);
            }
        });

        const atLimit = items.length >= MAX_STATUSES;
        addButtons.forEach(btn => { btn.disabled = atLimit; });
        if (countBadge) countBadge.textContent = `${items.length} / ${MAX_STATUSES}`;
        toggleClass(emptyState, 'hidden', items.length > 0);
        toggleClass(footer, 'hidden', items.length === 0);
        toggleClass(limitHint, 'hidden', !atLimit);
    };

    if (SortableImpl && typeof SortableImpl.create === 'function') {
        SortableImpl.create(rows, {
            handle: '[data-status-handle]',
            animation: 150,
            ghostClass: 'opacity-50',
            onEnd: () => {
                dirty = true;
                refresh();
            },
        });
    }

    form.addEventListener('input', () => { dirty = true; refresh(); });
    form.addEventListener('change', () => { dirty = true; refresh(); });

    editor.addEventListener('paste', event => {
        const input = event.target.closest('input[data-paste="fontawesome"]');
        if (!input) return;
        const pasteData = (event.clipboardData || win?.clipboardData)?.getData('text') ?? '';
        const match = pasteData.trim().match(/^<i\b[^>]*\bclass=["']((?:fa|ra)[^"']*)["']/i);
        if (!match) return;
        event.preventDefault();
        input.value = match[1].trim();
        dirty = true;
        refresh();
    });

    editor.addEventListener('click', event => {
        const button = event.target.closest('button');
        if (!button) return;
        const row = button.closest('[data-status-row]');

        if (button.hasAttribute('data-status-add') && rows.children.length < MAX_STATUSES) {
            const added = appendRow();
            added?.querySelector('[data-status-field="label"]')?.focus();
        } else if (button.hasAttribute('data-status-preset')) {
            const raw = button.dataset?.statusPreset ?? button.getAttribute('data-status-preset') ?? '[]';
            let items = [];
            try { items = JSON.parse(raw); } catch { items = []; }
            const hasDefault = [...rows.children].some(r => r.querySelector('[data-status-field="is_default"]')?.value === '1');
            items.forEach(item => {
                appendRow({ ...item, is_default: Boolean(item.is_default) && !hasDefault });
            });
            rows.firstElementChild?.querySelector('[data-status-field="label"]')?.focus();
        } else if (button.hasAttribute('data-status-default') && row) {
            const currentlyDefault = row.querySelector('[data-status-field="is_default"]')?.value === '1';
            setRowDefault(row, !currentlyDefault);
        } else if (button.hasAttribute('data-status-remove') && row) {
            row.remove();
        } else if (button.hasAttribute('data-status-up') && row?.previousElementSibling) {
            rows.insertBefore(row, row.previousElementSibling);
        } else if (button.hasAttribute('data-status-down') && row?.nextElementSibling) {
            rows.insertBefore(row.nextElementSibling, row);
        } else {
            return;
        }

        dirty = true;
        refresh();
    });

    if (win) {
        win.addEventListener('beforeunload', event => {
            if (dirty) { event.preventDefault(); event.returnValue = ''; }
        });
    }

    form.addEventListener('submit', () => {
        refresh();
        if (!form.hasAttribute('data-maintenance')) dirty = false;
    });
    form.addEventListener('maintenance:validated', () => { dirty = false; });

    refresh();

    return { refresh };
}

if (typeof document !== 'undefined') {
    const form = document.querySelector('[data-category-form]');
    if (form) {
        initCategoryStatuses(form);
    }
}
