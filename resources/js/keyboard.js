/**
 * Parse a shortcut string like "ctrl+shift+delete" into a descriptor object.
 * Supports: ctrl, alt, shift, meta (or cmd) as modifiers + any key name.
 * Key names are matched against event.key (case-insensitive for letters).
 */
const parseShortcut = (shortcut) => {
    const parts = shortcut.toLowerCase().split('+').map(p => p.trim());
    return {
        ctrl: parts.includes('ctrl') || parts.includes('cmd') || parts.includes('meta'),
        alt: parts.includes('alt'),
        shift: parts.includes('shift'),
        key: parts.filter(p => !['ctrl', 'cmd', 'meta', 'alt', 'shift'].includes(p))[0] || null,
    };
};

/**
 * Check if a keyboard event matches a parsed shortcut descriptor.
 */
const matchesShortcut = (event, desc) => {
    if (!desc.key) {
        return false;
    }
    const ctrlMatch = desc.ctrl === (event.ctrlKey || event.metaKey);
    const altMatch = desc.alt === event.altKey;
    const shiftMatch = desc.shift === event.shiftKey;
    const keyMatch = event.key.toLowerCase() === desc.key;
    return ctrlMatch && altMatch && shiftMatch && keyMatch;
};

/**
 * Scan the DOM for elements with data-shortcut and register a single
 * keydown listener that dispatches clicks to matching elements.
 *
 * Format examples:
 *   data-shortcut="e"              → press E (no modifiers)
 *   data-shortcut="ctrl+delete"    → Ctrl+Delete
 *   data-shortcut="ctrl+shift+s"   → Ctrl+Shift+S
 *   data-shortcut="ctrl+alt+c"     → Ctrl+Alt+C
 */
const initKeyboardShortcuts = () => {
    document.addEventListener('keydown', function (event) {
        const target = event.target;
        const entityModal = document.getElementById('primary-dialog');

        // Escape to close quick creator selection modal
        if (event.key === 'Escape') {
            if (entityModal?.classList.contains('qq-modal-selection')) {
                window.closeDialog(entityModal);
            }
            return;
        }

        // Collect all shortcut elements currently in the DOM
        const elements = document.querySelectorAll('[data-shortcut]');
        for (const el of elements) {
            // Skip form elements — they use initKeyboardSave instead
            if (el.tagName.toLowerCase() === 'form') {
                continue;
            }

            const desc = parseShortcut(el.dataset.shortcut);
            if (!matchesShortcut(event, desc)) {
                continue;
            }

            // For shortcuts without modifiers, skip if user is typing in a field or modal is open
            if (!desc.ctrl && !desc.alt && !desc.shift) {
                if (isInputField(target) || entityModal?.open) {
                    return;
                }
            }

            event.preventDefault();

            // Focus for inputs, click for everything else
            if (el.dataset.shortcutAction === 'focus') {
                el.focus();
            } else {
                el.click();
                el.blur();
            }
            return;
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

const initKeyboardSave = () => {
    let fields = document.querySelectorAll('form[data-shortcut]');
    fields.forEach(function (e) {
        initSaveKeyboardShortcut(e);
    });
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
};

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
