
function initBannerPromoDismiss()
{
    $('#banner-notification-dismiss').click(function (e) {
        e.preventDefault();
        $('.banner-notification').fadeOut();

        $.post({
            url: $(this).data('url'),
            method: 'POST',
        }).done(function() {
        });
    });
}
