$(document).ready(function () {
    initQuickLinksForm();
    showFilterField();
});

function initQuickLinksForm() {
    let selector = $('#quick-link-selector');
    if (selector.length === 0) {
        return false;
    }

    $('#quick-link-selector .btn-app').each(function (i) {
        $(this).click(function () {
            // Hide the others and activate this one
            $('.quick-link-subform').hide();
            $('#quick-link-selector .btn-app').removeClass('btn-active');

            let target = $(this).data('type');
            $(this).addClass('btn-active');
            $('#quick-link-' + target).show();
        });
    });
}

function showFilterField() {
    let selector = $('#entity-selector');
    if (selector.length === 0) {
        return false;
    } else if (selector.val() != '') {
        $('#filter-subform').show();
    }
    selector.change(function () {
        if (selector.val() == '') {
            $('#filter-subform').hide();
            console.log(selector.val());
        } else {
            $('#filter-subform').show();
        }
    });
}