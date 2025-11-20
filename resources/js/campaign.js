import Sortable from "sortablejs";

/**
 * Register Modules change for campaign settings
 */
const registerModules = () => {
    const modulePage = document.getElementById('campaign-modules');
    if (!modulePage) {
        return;
    }
    const fields = document.querySelectorAll('input[name="enabled"]');
    fields.forEach(function (field) {
        registerModuleChange(field);
    });
};

const registerModuleChange = (field) => {
    field.addEventListener('change', function (event) {
        event.preventDefault();
        field.closest('.toggle').classList.add('!hidden');
        field.closest('.box-module').querySelector('.action-loading').classList.remove('hidden');

        axios
            .post(field.dataset.url)
            .then(response => {
                field.closest('.toggle').classList.remove('!hidden');
                field.closest('.box-module').querySelector('.action-loading').classList.add('hidden');
                if (!response.data.success) {
                    return;
                }
                if (response.data.status) {
                    field.closest('.box-module').classList.add('module-enabled');
                } else {
                    field.closest('.box-module').classList.remove('module-enabled');
                }
                window.showToast(response.data.toast);
            });
    });
};

/** Toggling an action on a permission **/
const registerRoles = () =>  {
    let elements = document.querySelectorAll('.public-permission');
    elements.forEach(el => {
        el.addEventListener('click', togglePublicRole);
    });
};

const togglePublicRole = (e) => {
    e.preventDefault();
    let target = e.currentTarget;
    target.querySelector('.module-icon').classList.add('hidden');
    target.querySelector('.loading-animation').classList.remove('hidden');

    axios.post(target.dataset.url)
        .then(res => {
            target.querySelector('.module-icon').classList.remove('hidden');
            target.querySelector('.loading-animation').classList.add('hidden');
            if (res.data.success) {
                if (res.data.status) {
                    target.classList.add('enabled');
                } else {
                    target.classList.remove('enabled');
                }
                window.showToast(res.data.toast);
            }
        });
};

/**
 * Initiate codemirror editor in the theming section
 */
const registerCodeMirror = () => {
    const editors = document.querySelectorAll('.codemirror');
    editors.forEach(function (editor) {
        CodeMirror.fromTextArea(document.getElementById(editor.id), {
            extraKeys: {"Ctrl-Space": "autocomplete"},
            lineNumbers: true,
            lineWrapping: true,
            theme: 'dracula',
        });
    });
};

const registerSidebarSetup = () => {
    let nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'));

    // Loop through each nested sortable element
    for (let i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            group: 'nested',
            handle: '.dnd-handle',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,

            // Attempt to drag a filtered element
            onMove: function (/**Event*/evt, /**Event*/originalEvent) {
                let self = evt.dragged;
                let target = evt.related;
                let targetParentIsFixed = target.parentNode.closest('.fixed-position') != null;
                if (self.classList.contains('fixed-position') && targetParentIsFixed) {
                    return false;
                }
                return true;
            },
        });
    }
};


/**
 * Register events for campaign themes, notably the max size of a css field
 */
const registerCampaignThemes = () => {
    const form = document.querySelector('form#campaign-style');
    if (!form) {
        return;
    }

    form.addEventListener('submit', function (e) {
        let error = document.querySelector(form.dataset.error);
        const content = document.querySelector('textarea[name="content"]');
        let length = content.value.length;
        if (length < form.dataset.maxContent) {
            error.classList.add('hidden');
            return true;
        }

        // Show a custom error message to the user
        error.classList.remove('hidden');
        e.preventDefault();
        return false;
    });
};

const registerVanityUrl = () => {
    const vanityField = document.querySelector('input[name="vanity"]');
    if (!vanityField) {
        return;
    }
    vanityField.addEventListener('focusout', function (e) {
        let vanity = this.value;
        let errBlock = document.getElementById('vanity-error');
        let successBlock = document.getElementById('vanity-success');
        let loading = document.getElementById('vanity-loading');
        errBlock.innerHTML = '';
        errBlock.classList.add('hidden');
        successBlock.classList.add('hidden');
        if (!vanity) {
            return;
        }

        successBlock.classList.remove('hidden');
        let data = {};
        data.vanity = vanity;

        axios
            .post(this.dataset.url, data)
            .then(res => {
                vanityField.value = res.data.vanity;
                successBlock.querySelector('code').innerHTML = res.data.vanity;
                errBlock.classList.add('hidden');
                loading.classList.add('hidden');
                successBlock.classList.remove('hidden');
            })
            .catch((err) => {
                let errorString = '';
                err.response.data.errors.vanity.forEach(error => errorString += error + ' ');
                errBlock.innerHTML = errorString;
                errBlock.classList.remove('hidden');
                successBlock.classList.add('hidden');
                loading.classList.add('hidden');
            });
    });
};


const registerPermissionToggleAll = () => {
    const togglers = document.querySelectorAll('.permission-toggle');
    togglers.forEach(toggler => {
        toggler.addEventListener('click', function (e) {
            e.preventDefault();
            let action = this.dataset.action;
            let selector = document.querySelectorAll('input[data-action="' + action + '"]');
            let checked = this.dataset.checked === "1" ? false : true;
            this.dataset.checked = checked ? 1 : 0;
            selector.forEach(checkbox => {
                if (checked) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });
        })

    });
};


registerModules();
registerCodeMirror();
registerSidebarSetup();
registerRoles();
registerCampaignThemes();
registerVanityUrl();
registerPermissionToggleAll();
