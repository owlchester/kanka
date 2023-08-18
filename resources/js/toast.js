$(document).ready(function () {
    registerToastDismiss();
});

/** Handle closing of a toast **/
function registerToastDismiss() {
    $('.toast-container [data-toggle="dismiss"]').unbind('click').on('click', function (e) {
        e.preventDefault();
        $(this).parent().parent().fadeOut();
    });
}

/** Show an expiring message at the bottom right of the page **/
window.showToast = function(message, css) {
    css = css || 'toast-success';
    let $container = $('<div class="' + css + ' mt-2 text-right">');
    $container.html('<span class="toast-message inline-block p-3">' + message + '<i class="fa-solid fa-times cursor-pointer ml-1" data-toggle="dismiss"></i></span');

    $('.toast-container').append($container);
    setTimeout(function() {
        $container.fadeOut();
    }, 3000);
    registerToastDismiss();
};


window.handleExploreMapClick = function (ev) {
    if (!window.exploreEditMode) {
        return;
    }
    // return false;
    let position = ev.latlng;

    let lat = position.lat.toFixed(3);
    let lng = position.lng.toFixed(3);
    if (window.drawingPolygon) {
        window.addPolygonPosition(lat, lng);
        return;
    }
    //console.log('Click', 'lat', position.lat, 'lng', position.lng);
    // AJAX request
    //console.log('do', "$('#marker-latitude').val(" + position.lat.toFixed(3) + ");");
    $('#marker-latitude').val(lat);
    $('#marker-longitude').val(lng);
    $('#marker-modal').modal('show');
};
