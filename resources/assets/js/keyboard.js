$(document).ready(function() {
    // Look for a form to save
    $.each($('form'), function() {
        if ($(this).data('shortcut')) {
            initSaveKeyboardShortcut(this);
        }
    });
});

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
