$(document).ready(function () {
    registerToastDismiss();
});

/** Handle closing of a toast **/
function registerToastDismiss() {
    $('.toast-container [data-toggle="dismiss"]').unbind('click').on('click', function (e) {
        e.preventDefault();
        let target= $(this).closest('.toast-message');
        target.removeClass('opacity-100').addClass('opacity-0');

        setTimeout(function () {
            target.remove();
        }, 150);
    });
}

/** Show an expiring message at the bottom right of the page **/
window.showToast = function(message, css) {
    css = css || 'bg-success text-success-content';
    if (css === 'error') {
        css = 'bg-error text-error-content';
    }
    let $container = $('<div class="' + css + ' opacity-100 duration-150 transition-opacity rounded">');
    $container.html('<div class="toast-message p-2 flex gap-2 items-center">'
        + '<span class="grow"> ' + message + '</span>'
        + '<span class="flex-none"><i class="fa-regular fa-circle-xmark cursor-pointer " data-toggle="dismiss"></i></span>'
        + '</div');

    $('.toast-container').append($container);
    setTimeout(function() {
        $container.removeClass('opacity-100').addClass('opacity-0');
        setTimeout(function () {
            $container.remove();
        }, 150);
    }, 3000);
    registerToastDismiss();
};

