$(document).ready(function () {
    initAdManager();
});

const initAdManager = () => {
    return;

    const ads = document.querySelectorAll('.nativead-manager');
    if (ads.lenght === 0) {
        return;
    }

    ads.forEach(function (ad) {
        //console.log('found an ad', ad);
        let video = document.createElement('video');
        video.id = 'webmvid';
        video.source.src = ad.dataset.src;
        video.type = 'video/webm';
        video.control = false;
        video.removeAttribute("poster");
        ad.parentNode.insertBefore(video, ad.nextSibling);
    });
}
