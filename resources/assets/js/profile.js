var api;

$(document).ready(function() {
    if ($('#newsletter-api').length === 1) {
        init();
    }
});

function init()
{
    api = $('#newsletter-api').val();
    handle($('input[name="mail_release"]'));
}

function handle(element) {

    $(element).change(function () {
        let name = this.name;
        let data = {};
        data[name] = this.checked ? 1 : 0;

        $.post(api, data).done(function (res) {
            window.showToast(res.message);
        });
    });
}
