$(document).ready(function () {
    initWebhooksForm();
});

function initWebhooksForm() {
    let selector = $('#webhook-selector');
    if (selector.length === 0) {
        return false;
    }
    selector.change(function (e) {
        e.preventDefault();
        let selected = $(this).find(":selected");

        $('.webhook-subform').addClass('hidden');

        let target = selected.data('target');
        $(target).removeClass('hidden');
    });
}
