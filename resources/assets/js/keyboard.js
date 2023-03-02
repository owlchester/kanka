$(document).ready(function() {
    // Look for a form to save
    $.each($('form'), function() {
        if ($(this).data('shortcut')) {
            initSaveKeyboardShortcut(this);
        }
    });
    initKeyboardShortcuts();
    initPasting();
});

function initKeyboardShortcuts() {
    $(document).bind('keydown', function(e) {
        let target = $(e.target);
        let entityModal = $('#entity-modal');
        let quickCreatorButton = $('.quick-creator-button');
        let kbEditTarget = $('[data-keyboard="edit"]');
        //console.log('which', e.which);
        if (e.key === ']') {
            // ] to toggle sidebar
            if (isInputField(target)) {
                return;
            }
            $('.sidebar-toggle').click().blur();
        } else if (e.key === 'k') {
            // k for search
            if (isInputField(target)) {
                return;
            }
            $('#live-search').focus();
            return false; // don't add the k to the search field
        } else if (e.key === 'n' && !(e.ctrlKey || e.metaKey) && !e.altKey && quickCreatorButton.length > 0) {
            // n for quick creator. Don't re-open if already opened
            if (isInputField(target) || (entityModal.data('bs.modal') || {}).isShown) {
                return;
            }
            quickCreatorButton[0].click();
        } else if (e.key === 'e' && !(e.ctrlKey || e.metaKey) && kbEditTarget.length === 1) {
            //console.log('click edit link', kbEditTarget.first());
            if (isInputField(target) || (entityModal.data('bs.modal') || {}).isShown) {
                return;
            }
            kbEditTarget[0].click();
        } else if (e.key === 'Escape') {
            //console.log('escape', entityModal.has('.qq-modal-selection').length);
            // ESC to close quick creator selection modal
            if (entityModal.has('.qq-modal-selection').length === 1) {
                entityModal.modal('hide');
            }
        }
    });
}

function isInputField(ele) {
    if (ele.length === 0) {
        return false;
    }
    return ele.is('input') || ele.is('select') || ele.is('textarea') ||
        ele.attr('contentEditable') === 'true' || ele.hasClass('CodeMirror');
}

/**
 * Handle saving form
 * @param form
 */
function initSaveKeyboardShortcut(form) {
    $(document).bind('keydown', function(e) {
        //console.log((e.ctrlKey || e.metaKey), e.key.toLowerCase(), e.key.toLowerCase() === 's', e.shiftKey);
        // Need to check on lowercase key, because shirt will uppercase it
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
            window.entityFormHasUnsavedChanges = false;

            if (e.shiftKey) {
                setFormAction('submit-update');
            } else if (e.altKey) {
                setFormAction('submit-new');
            }
            $(form).submit();
            return false;
        }
        // Save & Copy
        if ((e.ctrlKey || e.metaKey) && e.altKey && e.key === 'c') {
            window.entityFormHasUnsavedChanges = false;
            setFormAction('submit-copy');
            $(form).submit();
            return false;
        }
    });
}

/**
 * Change the default action to follow after the form submission
 * @param action
 */
function setFormAction(action) {
    let entityFormDefaultAction = $('#form-submit-main');
    if (!entityFormDefaultAction) {
        return;
    }
    entityFormDefaultAction
        .attr('name', action);
}

/**
 * Strip HTML from fontAwesome or RPGAwesome and just keep the class to make people's lives
 * easier.
 */
function initPasting() {
    $('input[data-paste="fontawesome"]').on('paste', function(e) {
        e.preventDefault();
        let text;
        if (e.clipboardData || e.originalEvent.clipboardData) {
            text = (e.originalEvent || e).clipboardData.getData('text/plain');
        } else if (window.clipboardData) {
            text = window.clipboardData.getData('Text');
        }
        if (text.startsWith('<i class="fa') || text.startsWith('<i class="ra')) {
            let className = $(text).attr('class');
            if (className) {
                $(this).val(className);
                return;
            }
        }
        $(this).val(text);
    });
}
