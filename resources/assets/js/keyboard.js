$(document).ready(function() {
    // Look for a form to save
    $.each($('form'), function() {
        if ($(this).attr('data-shortcut')) {
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
        if ((event.ctrlKey || event.metaKey) && e.which === 83) {
            $(form).submit();
            return false;
        }
    });
}
