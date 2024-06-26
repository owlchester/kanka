$(document).ready(function() {
    // Look for a form to save
    initKeyboardSave();
    initKeyboardShortcuts();
    initPasting();

    $(document).on('shown.bs.modal', () => {
        initPasting();
        initKeyboardShortcuts();
        initKeyboardSave();
    });
});

const initKeyboardSave = () => {
    let fields = document.querySelectorAll('form[data-shortcut]');
    fields.forEach(function (e) {
        initSaveKeyboardShortcut(e);
    });
};
const initKeyboardShortcuts = () => {
    const quickCreatorButton = $('.quick-creator-button');
    let kbEditTarget = $('[data-keyboard="edit"]');
    document.addEventListener('keydown', function (event) {
        const target = event.target;
        if (event.key === ']') {
            // ] to toggle sidebar
            if (isInputField(target)) {
                return;
            }
            event.preventDefault();
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            sidebarToggle.click();
            sidebarToggle.blur();
        } else if (event.key === 'k') {
            // k for search
            if (isInputField(target)) {
                return;
            }
            const sidebarToggle = document.getElementById('entity-lookup');
            sidebarToggle.focus();
            event.preventDefault();
        } else if (event.key === 'n' && !(event.ctrlKey || event.metaKey) && !event.altKey && quickCreatorButton.length > 0) {
            // n for quick creator. Don't re-open if already opened
            if (isInputField(target) || (entityModal.data('bs.modal') || {}).isShown) {
                return;
            }
            quickCreatorButton[0].click();
        } else if (event.key === 'e' && !(event.ctrlKey || event.metaKey) && kbEditTarget.length === 1) {
            //console.log('click edit link', kbEditTarget.first());
            if (isInputField(target) || (entityModal.data('bs.modal') || {}).isShown) {
                return;
            }
            kbEditTarget[0].click();
        } else if (event.key === 'Escape') {
            //console.log('escape', entityModal.has('.qq-modal-selection').length);
            // ESC to close quick creator selection modal
            const entityModal = document.getElementById('entity-modal');
            if (entityModal.classList.contains('qq-modal-selection').length === 1) {
                entityModal.modal('hide');
            }
        }
    });
    $(document).bind('keydown', function(e) {
        let target = $(e.target);
        let entityModal = $('#entity-modal');
        let quickCreatorButton = $('.quick-creator-button');
        let kbEditTarget = $('[data-keyboard="edit"]');
        //console.log('which', e.which);
        // if (e.key === ']') {
        //     // ] to toggle sidebar
        //     if (isInputField(target)) {
        //         return;
        //     }
        //     $('.sidebar-toggle').click().blur();
        // } else
        // if (e.key === 'k') {
        //     // k for search
        //     if (isInputField(target)) {
        //         return;
        //     }
        //     $('#entity-lookup').focus();
        //     return false; // don't add the k to the search field
        // } else if (e.key === 'n' && !(e.ctrlKey || e.metaKey) && !e.altKey && quickCreatorButton.length > 0) {
        //     // n for quick creator. Don't re-open if already opened
        //     if (isInputField(target) || (entityModal.data('bs.modal') || {}).isShown) {
        //         return;
        //     }
        //     quickCreatorButton[0].click();
        // } else if (e.key === 'e' && !(e.ctrlKey || e.metaKey) && kbEditTarget.length === 1) {
        //     //console.log('click edit link', kbEditTarget.first());
        //     if (isInputField(target) || (entityModal.data('bs.modal') || {}).isShown) {
        //         return;
        //     }
        //     kbEditTarget[0].click();
        // } else if (e.key === 'Escape') {
        //     //console.log('escape', entityModal.has('.qq-modal-selection').length);
        //     // ESC to close quick creator selection modal
        //     if (entityModal.has('.qq-modal-selection').length === 1) {
        //         entityModal.modal('hide');
        //     }
        // }
    });
};

const isInputField = (target) => {
    if (!target || target.length === 0) {
        return false;
    }
    const tagNames = ['input', 'textarea', 'select'];
    if (tagNames.includes(target.tagName.toLowerCase())) {
        return true;
    }
    else if (target.getAttribute('contentEditable') === 'true') {
        return true;
    }
    else if (target.classList.contains('CodeMirror')) {
        return true;
    }
    return false;
};

/**
 * Handle saving form
 * @param form
 */
const initSaveKeyboardShortcut = (form) => {
    if (form.dataset.shortcutInit) {
        return;
    }
    form.dataset.shortcutInit = 1;
    form.addEventListener('keydown', function(e) {
        //console.log((e.ctrlKey || e.metaKey), e.key.toLowerCase(), e.key.toLowerCase() === 's', e.shiftKey);
        // Need to check on lowercase key, because shift will uppercase it
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
            e.preventDefault();
            if (form.dataset.unload) {
                window.entityFormHasUnsavedChanges = false;
            }

            if (e.shiftKey) {
                setFormAction('submit-update');
            } else if (e.altKey) {
                setFormAction('submit-new');
            }
            form.requestSubmit();
            return false;
        }
        // Save & Copy
        if ((e.ctrlKey || e.metaKey) && e.altKey && e.key === 'c') {
            if (form.dataset.unload) {
                window.entityFormHasUnsavedChanges = false;
            }
            setFormAction('submit-copy');
            form.submit();
            return false;
        }
    });
}

/**
 * Change the default action to follow after the form submission
 * @param action
 */
const setFormAction = (action) => {
    let entityFormDefaultAction = $('#form-submit-main');
    if (!entityFormDefaultAction) {
        return;
    }

    entityFormDefaultAction
        .attr('name', action);
    $('#submit-mode').attr('name', action);
}

/**
 * Strip HTML from fontAwesome or RPGAwesome and just keep the class to make people's lives
 * easier.
 */
const initPasting = () => {
    const fields = document.querySelectorAll('input[data-paste="fontawesome"]');
    fields.forEach(function (field) {
        field.addEventListener('paste', function (e) {
            e.preventDefault();
            // window.clipboardData is used for older browsers
            const pasteData = (e.clipboardData || window.clipboardData).getData('text');

            if (pasteData.startsWith('<i class="fa') || pasteData.startsWith('<i class="ra')) {
                // Create a temporary container to parse the HTML
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = pasteData;

                // Find the FontAwesome or RPGAwesome icon in the pasted HTML
                const icon = tempDiv.querySelector('i');

                let iconClass = icon.getAttribute('class');
                if (iconClass) {
                    field.value = iconClass;
                    return;
                }
            }
            field.value = pasteData;
        });
    });
};
