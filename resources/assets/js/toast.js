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
    let $container = $('<div class="' + css + '">');
    $container.html('<span class="toast-message">' + message + '<i class="fa fa-times" data-toggle="dismiss"></i></span');


    $('.toast-container').append($container);
    setTimeout(function() {
        $container.fadeOut();
    }, 3000);
    registerToastDismiss();
}
