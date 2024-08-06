let datagrid2DeleteConfirm = false;
let form;

const datagridObserver = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting === true) {
            initDatagrid(entry.target);
        }
    });
}, { threshold: [0] });

const initDatagrids = () => {
    const datagrids = document.querySelectorAll('table[data-render="datagrid2"]');
    datagrids?.forEach(datagrid => {
        initDatagrid(datagrid);
    });
};

const initDatagrid = (datagrid) => {
    if (datagrid.dataset.initiated === '1') {
        return;
    }
    datagrid.dataset.initiayed = '1';
    registerHeaders(datagrid);
    registerBulk(datagrid);
    if (datagrid.dataset.url) {
        loadDatagrid(datagrid, datagrid);
    }
};

const registerHeaders = (datagrid) => {
    datagrid.querySelectorAll('thead a')?.forEach(ele => {
        if (ele.dataset.loaded === '1') {
            return;
        }
        ele.dataset.loaded = '1';
        ele.addEventListener('click', function (e) {
            e.preventDefault();
            loadDatagrid(ele, datagrid);
        });
    });
    // Pagination
    datagrid.parentNode
        .querySelectorAll('nav[role="navigation"] a')
        ?.forEach(ele => {
            if (ele.dataset.loaded === '1') {
                return;
            }
            ele.dataset.loaded = '1';
            ele.addEventListener('click', (e) => {
                e.preventDefault();
                loadDatagrid(ele, datagrid);
            });
        });
};


/**
 *
 */
const initOnloadDatagrids = () => {
    const datagrids = document.querySelectorAll('[data-render="datagrid2-onload"]');
    if (datagrids.length === 0) {
        return;
    }
    datagrids.forEach(datagrid => {
        datagridObserver.observe(datagrid);
    });
};

/**
 * When a datagrid header is clicked, reorder it
 */
const loadDatagrid = (element, datagrid) => {
    datagrid.querySelector('thead')?.classList.add('hidden');
    datagrid.querySelector('tbody')?.classList.add('hidden');
    datagrid.querySelector('tfoot')?.classList.remove('hidden');

    let url = element.getAttribute('href');
    if (element.dataset.url) {
        url = element.dataset.url;
    }

    // It's sometimes possible to have no parent node when the datagrid is already removed from the dom
    // but some user action is still referencing it.
    if (!datagrid.parentNode) {
        return;
    }


    axios.get(url)
        .then(res => {
            const target = datagrid.parentNode;
            if (res.data.html) {
                target.innerHTML = res.data.html;
            }
            if (res.data.deletes) {
                const forms = document.querySelector('#datagrid-delete-forms');
                if (forms) forms.innerHTML = res.data.deletes;
            }
            if (res.data.url) {
                window.history.pushState({}, "", res.data.url);
            }
            const newDatagrid = target.querySelector('[data-render="datagrid2"]');
            initDatagrid(newDatagrid);
            window.triggerEvent();
        })
        .catch(err => {
            //console.error('datagrid2 error', datagrid, datagrid.parentNode);
            //datagrid.querySelector('tfoot')?.classList.add('bg-danger');
        });
};

const registerBulk = (datagrid) => {
    // Bulk edit multiple models at the same time
    const parent = datagrid.parentNode;
    const bulks = parent.querySelectorAll('.datagrid-bulk');
    bulks?.forEach(bulk => {
        registerBulkClick(datagrid, bulk);
    });

    // Other bulk actions
    const submits = parent.querySelectorAll('.datagrid-submit');
    submits?.forEach(submit => {
        submit.addEventListener('click', function (e) {
            e.preventDefault();
            form = submit.closest('form');

            const action = form.querySelector('input[name="action"]');
            action.value = submit.dataset.action;

            if (submit.dataset.action === 'delete') {
                if (datagrid2DeleteConfirm === false) {
                    window.openDialog('datagrid-bulk-delete');
                    return false;
                }
            }

            // Disable the whole dropdown and replace it with a spinning wheel
            datagrid.parentNode.querySelectorAll('.datagrid-bulk-actions .btn2')?.forEach(ele => ele.classList.add('btn-disabled'));
            datagrid.parentNode.querySelector('.datagrid-bulk-actions .btn2').classList.add('loading');
            form.submit();
        });
    });

    document.querySelector('#datagrid-action-confirm')?.addEventListener('click', function () {
        window.closeDialog('datagrid-bulk-delete');
        form.submit();
    });
};

const registerBulkClick = (datagrid, element) => {
    if (element.dataset.loaded === '1') {
        return;
    }
    element.dataset.loaded = '1';
    element.addEventListener('click', function (e) {
        e.preventDefault();
        form = datagrid.closest('form');

        //console.log('models', models);
        axios.post(
            form.getAttribute('action') + '?action=edit',
            {model: checkedModels(datagrid)}
        )
        .done(res => {
            const target = document.getElementById('primary-dialog');
            target.innerHTML = res.data;
            window.openDialog('primary-dialog');
            window.triggerEvent();
        });
    });
};

const checkedModels = (datagrid) => {
    let models = [];
    const checkboxes = datagrid.querySelectorAll("input[name='model[]']");
    checkboxes?.forEach(element => {
        if (element.checked) {
            models.push(element.value);
        }
    });
    return models;
};

initOnloadDatagrids();
initDatagrids();

window.onEvent(function() {
    initDatagrids();
});
