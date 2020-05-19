var campaignField = $('input[name="campaign"]');
var submit = $('input[type="submit"]');

$(document).ready(function () {
    $('[data-campaign]').on('click', function (e) {
        $('[data-campaign]').removeClass('selected');
        $(this).addClass('selected');
        campaignField.val($(this).data('campaign'));
        submit.removeAttr('disabled');
    });
});
