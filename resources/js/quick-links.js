$(document).ready(function () {
    initQuickLinksForm();
    showFilterField();
});

function initQuickLinksForm() {
    let selector = $('#bookmark-selector');
    if (selector.length === 0) {
        return false;
    }
    selector.change(function (e) {
        e.preventDefault();
        let selected = $(this).find(":selected");

        $('.bookmark-subform').addClass('hidden');

        let target = selected.data('target');
        $(target).removeClass('hidden');
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
