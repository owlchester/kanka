$(document).ready(function () {
    initQuickLinksForm();
    showFilterField();
});

function initQuickLinksForm() {
    let selector = $('#quick-link-selector');
    if (selector.length === 0) {
        return false;
    }
    selector.change(function (e) {
        e.preventDefault();
        let selected = $(this).find(":selected");

        $('.quick-link-subform').hide();

        let target = selected.data('target');
        $(target).show();
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
