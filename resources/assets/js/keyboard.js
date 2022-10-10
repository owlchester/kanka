$(document).ready(function() {
    // Look for a form to save
    $.each($('form'), function() {
        if ($(this).data('shortcut')) {
            initSaveKeyboardShortcut(this);
        }
    });
    initKeyboardShortcuts();
});

function initKeyboardShortcuts() {
    $(document).bind('keydown', function(e) {
        let target = $(e.target);
        let entityModal = $('#entity-modal');
        let quickCreatorButton = $('.quick-creator-button');
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
        } else if (e.key === 'n' && quickCreatorButton.length > 0) {
            // n for quick creator. Don't re-open if already opened
            if (isInputField(target) || (entityModal.data('bs.modal') || {}).isShown) {
                return;
            }
            quickCreatorButton[0].click();
        } else if (e.key === 'Escape') {
            // ESC to close quick creator selection modal
            if (entityModal.has('.entity-creator').length === 1) {
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
        if ((e.ctrlKey || e.metaKey) && e.which === 83) {
            window.entityFormHasUnsavedChanges = false;

            // Shift? save and update
            if (e.shiftKey) {
                let entityFormDefaultAction = $('#form-submit-main');
                if (entityFormDefaultAction) {
                    entityFormDefaultAction
                        .attr('name', 'submit-update');
                }
            }
            $(form).submit();
            return false;
        }
    });
}
