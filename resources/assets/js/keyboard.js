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
        console.log('which', e.which);
        if (e.which === 161) {
            // ] to toggle sidebar
            if (isInputField(target)) {
                return;
            }
            $('.sidebar-toggle').click();
        } else if (e.which === 75) {
            // k for search
            if (isInputField(target)) {
                return;
            }
            $('#live-search').focus();
            return false; // don't add the k to the search field
        } else if (e.which === 78) {
            // n for quick creator
            if (isInputField(target)) {
                return;
            }
            $('.quick-creator-button')[0].click();
            return false; // don't add the k to the search field
        }
    });
}

function isInputField(ele) {
    return ele.is('input') || ele.is('select') || ele.attr("contentEditable") == "true"
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
