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

