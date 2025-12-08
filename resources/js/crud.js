/**
 * Re-register any events that need to be bound when a modal is loaded
 */
function registerModalLoad() {
    window.onEvent(function() {
        registerDropdownFormActions();
    });
}

function registerEntityNameCheck() {
    const field = document.querySelector('#form-entry input[name="name"]');
    if (!field) {
        return;
    }
    if (field.dataset.liveDisabled) {
        return;
    }

    let lastCheckedValue = '';
    field.addEventListener('focusout', function (event) {
        // Don't bother if the user didn't set any value or value hasn't changed
        if (!field.value || field.value === lastCheckedValue) {
            return;
        }
        lastCheckedValue = field.value;

        const block = this.dataset.duplicate;
        const entityCreatorDuplicateWarning = document.querySelector(block);
        if (!entityCreatorDuplicateWarning) {
            return;
        }
        const url = this.dataset.live +
            '?q=' + encodeURIComponent(this.value) +
            '&exclude=' + this.dataset.id;
        entityCreatorDuplicateWarning.classList.add('hidden');
        const duplicates = entityCreatorDuplicateWarning.querySelector('.duplicates');

        // Check if an entity of the same type already exists, and warn when it does.
        fetch(url)
            .then((response) => response.json())
            .then((res) => {
                duplicates.innerHTML = '';
                res.forEach(entity => {
                    const link = document.createElement('a');
                    link.href = entity.url;
                    link.text = entity.name;
                    duplicates.appendChild(link);
                });
                if (res.length > 0) {
                    entityCreatorDuplicateWarning.classList.remove('hidden');
                }
            });
    });
}

/**
 * Forms have dropdown actions to select which submit is being
 * done. Instead of using submit buttons like normal people,
 * we use links that set the main action's name.
 */
const registerDropdownFormActions = () => {
    // Return early if there are no elements in the page to be handled
    const entityFormActions = document.querySelectorAll('.form-submit-actions');
    if (entityFormActions.length === 0) {
        return;
    }
    let entityFormMainButton = document.getElementById('form-submit-main');
    let entityFormSubmitMode = document.getElementById('submit-mode');
    if (entityFormSubmitMode === undefined) {
        throw new Error("No submit mode hidden input found");
    }

    // Register click on each sub action
    entityFormActions.forEach(action => {
        // if(action.dataset.loaded === '1') {
        //     return;
        // }
        // action.dataset.loaded = '1';
        action.addEventListener('click', function (event) {
            event.preventDefault();
            entityFormSubmitMode.name = action.dataset.action;
            entityFormMainButton.click();
            return false;
        });
    });
};


/**
 * If we change something on a form, avoid losing data when going away.
 */
function registerUnsavedChanges() {
    // Return early if we have no elements to handle
    const forms = document.querySelectorAll('form[data-unload="1"]');
    if (forms.length === 0) {
        return;
    }
    const save = document.querySelector('#form-submit-main');

    // Save every input change
    const inputs = document.querySelectorAll('form[data-unload="1"] input, form[data-unload="1"] select, form[data-unload="1"] textarea');
    inputs.forEach(input => {
        // Skip based on a data property, of it its old bootstrap fields (summernote)
        if (input.dataset.skipUnsaved || input.classList.contains('form-control')) {
            return;
        }
        // Standard input fields are simple
        input.addEventListener('change', function () {
            window.entityFormHasUnsavedChanges = true;
        });
        // For select2 fields, we need to listen to onchange directly, because jquery won't trigger the change event
        if (input.classList.contains('select2')) {
            if (typeof $ !== 'undefined') {
                $(input).on('change', () => {
                    window.entityFormHasUnsavedChanges = true;
                });
            } else {
                // Fallback if jQuery isn't global, but use addEventListener, not .onchange
                input.addEventListener('change', () => {
                    window.entityFormHasUnsavedChanges = true;
                });
            }
        }
    });

    if (!save) {
        return;
    }
    // Another way to bind the event
    window.addEventListener('beforeunload', function (e) {
        if (window.entityFormHasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = 'Unsaved data warning';
        }
    });
}

/**
 * Register a listened to add dynamic rows in the forms
 * Used in the calendar forms extensively
 */
const registerDynamicRows = () => {
    const rows = document.querySelectorAll('.dynamic-row-add');
    rows.forEach(row => {
        row.addEventListener('click', function (e) {
            e.preventDefault();

            const target = row.dataset.target;
            const template = row.dataset.template;
            const child = document.createElement('div');
            child.innerHTML = document.querySelector('#' + template).innerHTML;
            document.querySelector('.' + target).append(child);

            registerDynamicRowDelete();
            window.triggerEvent();
            return false;
        });
    });
    registerDynamicRowDelete();
};

/**
 * Register a listener to delete a dynamically added row in the forms
 */
const registerDynamicRowDelete = () => {
    const rows = document.querySelectorAll('.dynamic-row-delete');
    rows.forEach(row => {
        if (row.dataset.init === 1) {
            return;
        }
        row.dataset.init = 1;
        row.addEventListener('click', function (e) {
            e.preventDefault();
            row.closest('.parent-delete-row').remove();
        });
        row.addEventListener('keydown', function (e) {
            // Support for pressing enter on a span
            if (e.key !== 'Enter') {
                return;
            }
            row.click();
        });
    });
};


registerDynamicRows();
registerDropdownFormActions();
registerUnsavedChanges();
registerModalLoad();
registerEntityNameCheck();
