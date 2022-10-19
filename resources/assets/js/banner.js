$(window).ready(function () {
    initBannerPromoDismiss();
});


function initBannerPromoDismiss()
{
    $('.banner-notification-dismiss').click(function (e) {
        e.preventDefault();
        console.log('click');
        //$('.banner-notification').fadeOut();

        $.post({
            url: $(this).data('url'),
            method: 'POST',
        }).done(function() {
        });
    });
}
