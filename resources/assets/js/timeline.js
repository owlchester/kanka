$(document).ready(function () {
    initTimelineForms();

    $(document).on('shown.bs.modal shown.bs.popover', function() {
        initTimelineForms();
    });
});


/**
 *
 */
function initTimelineForms() {
    let eraForm = $('#timeline-era-form');
    if (eraForm.length === 0) {
        return;
    }

    eraForm.on('submit', function() {
        window.entityFormHasUnsavedChanges = false;
    });
}
