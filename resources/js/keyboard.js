const initKeyboardSave = () => {
    let fields = document.querySelectorAll('form[data-shortcut]');
    fields.forEach(function (e) {
        initSaveKeyboardShortcut(e);
    });
};
const initKeyboardShortcuts = () => {
    document.addEventListener('keydown', function (event) {
        const target = event.target;
        const entityModal = document.getElementById('primary-dialog');
        const quickCreatorButton = document.querySelector('.quick-creator-button');
        let kbEditTarget = document.querySelector('[data-keyboard="edit"]');
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
            event.preventDefault();
            const sidebarToggle = document.getElementById('entity-lookup');
            sidebarToggle.focus();
        } else if (event.key === 'n' && !(event.ctrlKey || event.metaKey) && !event.altKey && quickCreatorButton) {
            // n for quick creator. Don't re-open if already opened
            if (isInputField(target) || entityModal?.open) {
                return;
            }
            quickCreatorButton.click();
        } else if (event.key === 'e' && !(event.ctrlKey || event.metaKey) && kbEditTarget) {
            //console.log('click edit link', kbEditTarget.first());
            if (isInputField(target) || entityModal?.open) {
                return;
            }
            kbEditTarget.click();
        } else if (event.key === 'Escape') {
            // ESC to close quick creator selection modal
            if (entityModal?.classList.contains('qq-modal-selection').length === 1) {
                window.closeDialog(entityModal);
            }
        }
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
    document.addEventListener('keydown', function(e) {
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
            console.log('requested tos ubmit', form);
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
    const entityFormDefaultAction = document.getElementById('form-submit-main');
    if (!entityFormDefaultAction) {
        return;
    }

    entityFormDefaultAction.name = action;
    document.getElementById('submit-mode').name = action;
};

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

initKeyboardSave();
initKeyboardShortcuts();
initPasting();

window.onEvent(function() {
    initPasting();
    initKeyboardShortcuts();
    initKeyboardSave();
});
