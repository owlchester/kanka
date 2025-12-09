let quickCreatorSubmitBtns;

let loadingArticle, selectionArticle, formArticle;


/**
 * Quick Entity Creator UI
 */
const quickCreatorUI = () => {
    loadingArticle = document.querySelector('#qq-modal-loading');
    selectionArticle = document.querySelector('#qq-modal-selection');
    formArticle = document.querySelector('#qq-modal-form');
    document.querySelectorAll('[data-toggle="entity-creator"]').forEach(element => {
        element.addEventListener('click', buildEntityForm);
    });
};

const buildEntityForm = (event) => {
    event.preventDefault();
    const element = event.currentTarget;

    const type = element.dataset.type;
    if (type === 'inline') {
        document.querySelector('.quick-creator-body').classList.add('hidden');
        document.querySelector('.quick-creator-footer')?.classList.add('hidden');
        document.querySelector('.quick-creator-loading').classList.remove('hidden!');
    } else {
        quickCreatorLoadingModal();
    }

    axios.get(element.dataset.url)
        .then(res => {
            loadingArticle.classList.add('hidden!');
            selectionArticle.classList.add('hidden!');
            formArticle.innerHTML = res.data;
            formArticle.classList.remove('hidden!');

            quickCreatorSubformHandler();
            quickCreatorToggles();
            window.triggerEvent();
        });

    return false;
};

const quickCreatorDuplicateName = () => {
    const field = document.querySelector('#qq-name-field');
    if (!field || field.dataset.init === '1') {
        return;
    }
    field.dataset.init = '1';
    field.addEventListener('focusout', function () {
        // Don't bother if the user didn't set any value
        if (!this.value) {
            return;
        }

        const warning = this.parentNode.querySelector('.duplicate-entity-warning');
        if (!warning) {
            return;
        }
        warning.classList.add('hidden');
        // Check if an entity of the same type already exists, and warn when it does.
        const url = this.dataset.live + '?q=' + this.value + '&type=' + this.dataset.type;
        axios.get(url)
            .then(res => {
            if (res.data.length === 0) {
                warning.classList.add('hidden');
                return;
            }
            const entities = Object.keys(res.data)
                .map(function (k) { return '<a href="' + res.data[k].url + '" class="text-link">' + res.data[k].name + '</a>'; })
                .join(', ');
            field.parentNode.querySelector('.duplicate-entities').innerHTML = entities;
            warning.classList.remove('hidden');
        });
    });
};

const quickCreatorLoadingModal = () => {
    document.querySelector('#qq-modal-form').classList.add('hidden!');
    document.querySelector('#qq-modal-selection').classList.add('hidden!');
    document.querySelector('#qq-modal-loading').classList.remove('hidden!');
};

/**
 *
 */
const quickCreatorSubformHandler = () => {

    quickCreatorSubmitBtns = document.querySelectorAll('.quick-creator-submit');
    if (quickCreatorSubmitBtns.length === 0) {
        return;
    }

    quickCreatorDuplicateName();
    quickCreatorToggles();

    // If we click on edit, we want to be redirected afterwards. This is because the form's onsubmit re-casts the
    // form as a formdata object
    quickCreatorSubmitBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            let action = this.value;
            if (!action) {
                return true;
            }

            document.querySelector('#entity-creator-form [name="action"]').value = action;
            return true;
        });
    });

    document.getElementById('entity-creator-form').onsubmit = function (e) {

        const form = e.target;
        e.preventDefault();
        quickCreatorSubmitBtns.forEach(btn => btn.classList.add('btn-disabled', 'loading'));

        const errors = document.querySelectorAll('div.text-error');
        errors.forEach(error => error.remove());

        const data = new FormData(form);
        axios.post(form.getAttribute('action'), data)
            .then(res => {
                // New entity was created, let's follow that redirect
                //console.log('result', result);
                if (typeof res.data === 'object') {
                    if (res.data.redirect) {
                        window.location.replace(res.data.redirect);
                        return;
                    }
                    let option = new Option(res.data._name, res.data._id, true, true);
                    let field = document.querySelector('#' + res.data._target);
                    field.appendChild(option);
                    field.dispatchEvent(new Event('change'));

                    const form = document.querySelector('#qq-modal-form');
                    if (form) {
                        form.innerHTML = '';
                        form.classList.remove('hidden!');
                    }

                    document.querySelector('#qq-modal-loading')?.classList.add('hidden!');
                    document.querySelector('#qq-modal-selection')?.classList.remove('hidden!');

                    const target = document.getElementById('primary-dialog');
                    target.close();

                    quickCreatorHandleEvents();

                    return;
                }

                let target = document.getElementById('qq-modal-form');
                target.innerHTML = res.data;
                window.triggerEvent();

                quickCreatorUI();
                quickCreatorHandleEvents();
            })
            .catch(err => {
                if (err.response) {
                    window.formErrorHandler(err.response, form);
                }
                quickCreatorSubmitBtns.forEach(btn => btn.classList.remove('btn-disabled', 'loading'));
                document.querySelector('#entity-creator-form [name="action"]').value = '';
            })
        ;
    };
};

const quickCreatorToggles = () => {
    document.querySelectorAll('.qq-mode-toggle').forEach(element => {
        element.addEventListener('click', function (e) {
            e.preventDefault();

            if (this.classList.contains('active')) {
                return;
            }

            document.querySelector('.qq-mode-toggle').classList.remove('active');
            this.classList.add('active');

            document.querySelector('.quick-creator-body').classList.add('hidden');
            document.querySelector('.quick-creator-footer')?.classList.add('hidden');
            document.querySelector('.quick-creator-loading').classList.remove('hidden!');

            axios.get(this.dataset.url)
                .then(res => {
                    formArticle.innerHTML = res.data;
                    formArticle.classList.remove('hidden!');
                    quickCreatorHandleEvents();
                    window.triggerEvent();
                })
            ;
        });
    });

    document.querySelector('.qq-action-more')?.addEventListener('click', function (e) {
        e.preventDefault();
        this.classList.add('hidden');
        document.querySelector('.qq-more-fields').classList.remove('hidden');
    });

    quickCreatorUI();
};

const quickCreatorHandleEvents = () => {
    quickCreatorToggles();
    quickCreatorDuplicateName();
    quickCreatorSubformHandler();
};

const initQuickCreatorFromField = () => {
    const btns = document.querySelectorAll('.quick-creator-subform');
    btns.forEach(btn => {
        btn.addEventListener('click',  e => {
            window.openDialog('primary-dialog', btn.dataset.url);
        });
    });
};

window.onEvent(function() {
    quickCreatorUI();
    quickCreatorSubformHandler();
});
initQuickCreatorFromField();
