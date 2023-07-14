$(document).ready(function () {
    initPostLayoutsForm();
});

function initPostLayoutsForm() {
    let selector = $('#post-layout-selector');
    if (selector.length === 0) {
        return false;
    }
    selector.change(function (e) {
        e.preventDefault();
        let selected = $(this).find(":selected").val();

        if (selected == '') {
            $('#field-entry').show();
            $('#field-location').show();
            $('#field-display').show();
            $('#post-layout-subform').hide();

        } else {
            $('#field-entry').hide();
            $('#field-location').hide();
            $('#field-display').hide();

            $('#post-layout-subform').show();
        }
    });
}

