$(document).ready(function () {
    initAdManager();
});

function initAdManager()
{
    return;

    let ads = $('.nativead-manager');
    if (ads.lenght === 0) {
        return;
    }

    $.each(ads, function () {
        // This ad
       /*console.log('found an ad', $(this));
        let ad = $(this);
        let url = $(this).data('url');

        console.log('wat', $(this).data('src'));
        let video = document.createElement('video');
        video.id = 'webmvid';
        video.source.src = $(this).data('src');
        video.type = 'video/webm';
        video.control = false
        video.removeAttribute("poster");
        video.appendTo($(this));
        console.log(video);*/
    });
}
