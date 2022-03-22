
function initBannerPromoDismiss()
{
    $('#banner-notification-dismiss').click(function (e) {
        e.preventDefault();
        $('.banner-notification').fadeOut();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post({
            url: $(this).data('url'),
            method: 'POST',
        }).done(function(data) {
        });
    });
}
