const initCharacterOrganisation = () => {
    const editor = document.querySelector('[data-character-memberships]');
    if (!editor) {
        return;
    }

    const organisations = editor.querySelector('.character-organisations');
    const template = editor.querySelector('#template_organisation');
    const announcement = editor.querySelector('[data-membership-announcement]');
    let nextKey = 0;

    const updateEmptyState = () => {
        const hasMemberships = !!organisations.querySelector('[data-membership-fields]:not(:disabled)');
        editor.querySelector('[data-membership-empty]').classList.toggle('hidden', hasMemberships);
        editor.querySelector('[data-membership-bottom-add]').classList.toggle('hidden', !hasMemberships);
    };

    const updateSummary = (row) => {
        const pin = row.querySelector('[data-membership-pin]');
        const privacy = row.querySelector('[data-membership-private]');
        const summary = [];
        if (privacy?.checked) {
            summary.push(privacy.closest('label').textContent.trim());
        }
        if (Number(pin.value) > 0) {
            summary.push(pin.selectedOptions[0].textContent);
        }
        row.querySelector('[data-membership-summary]').textContent = summary.length ? ` · ${summary.join(' · ')}` : '';
    };

    organisations.querySelectorAll('[data-membership-row]').forEach(updateSummary);

    editor.addEventListener('click', (event) => {
        if (event.target.closest('[data-add-organisation]')) {
            let key;
            do {
                key = `new_${nextKey++}`;
            } while (document.getElementById(`membership-organisation-${key}`));

            const fragment = template.content.cloneNode(true);
            fragment.querySelectorAll('[name], [id], [for]').forEach((element) => {
                ['name', 'id', 'for'].forEach((attribute) => {
                    if (element.hasAttribute(attribute)) {
                        element.setAttribute(attribute, element.getAttribute(attribute).replaceAll('__MEMBERSHIP__', key));
                    }
                });
            });
            const select = fragment.querySelector('.tmp-org');
            select.classList.replace('tmp-org', 'select2');
            organisations.append(fragment);
            window.initForeignSelect();
            updateEmptyState();
            select.tomselect?.focus();
            if (!select.tomselect) {
                select.focus();
            }
            return;
        }

        const remove = event.target.closest('[data-remove-membership]');
        const undo = event.target.closest('[data-undo-membership]');
        if (!remove && !undo) {
            return;
        }
        const row = event.target.closest('[data-membership-row]');
        const fields = row.querySelector('[data-membership-fields]');
        const removed = row.querySelector('[data-membership-removed]');
        fields.disabled = !!remove;
        fields.classList.toggle('hidden', !!remove);
        removed.classList.toggle('hidden', !remove);
        removed.classList.toggle('flex', !!remove);
        updateEmptyState();
        if (remove) {
            row.querySelector('[data-undo-membership]').focus();
        } else {
            const select = row.querySelector('select');
            select.tomselect?.focus();
            if (!select.tomselect) {
                select.focus();
            }
            announcement.textContent = undo.textContent;
        }
    });

    editor.addEventListener('change', (event) => {
        const row = event.target.closest('[data-membership-row]');
        if (row) {
            updateSummary(row);
        }
    });
};

window.onReady(initCharacterOrganisation);
