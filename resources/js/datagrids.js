/**
 * Register button handling for bulk actions
 */
const registerBulkActions = () => {
    const actions = document.querySelectorAll('[data-bulk-action]');
    actions?.forEach(action => {
        // These fields are in tippy, and duplicated in the dom when clicked
        action.addEventListener('click', (e) => {
            e.preventDefault();
            setBulkModels(action.dataset.bulkAction);
        });
    });
    const prints = document.querySelectorAll('.bulk-print');
    prints?.forEach(print => {
        print.addEventListener('click', (e) => {
            e.preventDefault();
            const form = print.closest('form');
            form.requestSubmit();
        });
    });
};

/**
 * Register the handler for checking the bulk-delete checkboxes
 */
const registerBulkDelete = () => {
    registerDeleteAllToggler();

    const checkboxes = document.querySelectorAll("input[name='model[]']");
    checkboxes?.forEach(checkbox => {
        if (checkbox.dataset.initiated === '1') {
            return;
        }
        checkbox.dataset.initiated = '1';
        checkbox.addEventListener('change', (e) => {
            console.log('change');
            e.preventDefault();
            toggleCrudMultiDelete();
        });
    });
};

const registerDeleteAllToggler = () => {
    const field = document.querySelector('#datagrid-select-all');
    if (!field) {
        return;
    }
    if (field.dataset.loaded === '1') {
        return;
    }
    field.dataset.loaded = '1';
    field.addEventListener('click', function (e) {
        const checkboxes = document.querySelectorAll("input[name='model[]']");
        if (field.checked) {
            checkboxes?.forEach(checkbox => {
                checkbox.checked = true;
            });
        } else {
            checkboxes?.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
        toggleCrudMultiDelete();
    });
};

/**
 * Set the datagrid bulk models
 * @param modelField
 */
const setBulkModels = (modelField) => {
    let values = [];
    const checkboxes = document.querySelectorAll("input[name='model[]']");
    checkboxes?.forEach(element => {
        if (element.checked) {
            values.push(element.value);
        }
    });

    if (modelField === 'ajax') {
        window.onEvent(function() {
            document.querySelector('#primary-dialog input[name="models"]').value = values.toString();
        });
    } else {
        document.querySelector('#datagrid-bulk-' + modelField + '-models').value = values.toString();
    }
};


/**
 *
 */
const toggleCrudMultiDelete = () => {
    let hide = true;

    const checkboxes = document.querySelectorAll("input[name='model[]']");
    checkboxes?.forEach(checkbox => {
        if (checkbox.checked) {
            hide = false;
        }
    });

    const btn = document.querySelectorAll('.datagrid-bulk-actions .btn2');
    btn?.forEach(btn => {
        if (hide) {
            btn.disabled = true;
            btn.classList.add('btn-disabled');
        } else {
            btn.disabled = false;
            btn.classList.remove('btn-disabled', 'disabled');
        }
    });
};

/**
 * Go through table trs to add on click support
 */
const treeViewInit = () => {
    const treeViewLoader = document.querySelector('.list-treeview');
    if (!treeViewLoader) {
        return;
    }

    let link = treeViewLoader.dataset.url;

    const rows = document.querySelectorAll('.table-nested > tbody > tr');
    rows.forEach(function (row) {
        let children = row.dataset.children;
        if (parseInt(children) > 0) {
            row.classList.add('tr-hover');
            row.classList.add('cursor-pointer');
            row.addEventListener('click', function (event) {
                const target = event.target;
                // Don't trigger the click on the checkbox (used for bulk actions)
                //console.log('click tr', target);
                if (event.target.type !== 'checkbox' && target.dataset.tree !== 'escape') {
                    window.location = link + '?parent_id=' + row.dataset.id + '&m=table';
                }
            });
        }
    });
};


registerBulkDelete();
registerBulkActions();
toggleCrudMultiDelete();
treeViewInit();

window.onEvent(function() {
    registerBulkActions();
    registerBulkDelete();
});
