$(window).ready(function () {
    initBannerPromoDismiss();
});


function initBannerPromoDismiss()
{
    $('.banner-notification-dismiss').click(function (e) {
        e.preventDefault();
        $.post({
            url: $(this).data('url'),
            method: 'POST',
            context: this,
        }).done(function() {
            // We can either have bootstrap handle the dismiss, or do it ourselves
            let target = $(this).data('dismiss');
            if (!target) {
                return;
            }
            $(this).closest('.' + target).fadeOut();
        });
    });
}
