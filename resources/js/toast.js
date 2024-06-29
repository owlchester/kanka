/** Handle closing of a toast **/
const registerToastDismiss = () => {
    const dismisses = document.querySelectorAll('.toast-container [data-toggle="dismiss"]');
    dismisses.forEach(element => {
        if (element.dataset.init === '1') {
            return;
        }
        element.dataset.init = '1';
        element.addEventListener('click', function (e) {
            e.preventDefault();
            let target= element.closest('.toast-message');
            target.classList.remove('opacity-100');
            target.classList.add('opacity-0');

            setTimeout(function () {
                target.remove();
            }, 150);
        });
    });
};

/** Show an expiring message at the bottom right of the page **/
window.showToast = function(message, css) {
    css = css || 'bg-success text-success-content';
    if (css === 'error') {
        css = 'bg-error text-error-content';
    }
    const container = document.createElement('div');
    container.classList.add('opacity-100', 'duration-150', 'transition-opacity', 'rounded');
    if (css) {
        const classes = css.split(' ');
        classes.forEach(cssClass => {
            container.classList.add(cssClass);
        })
    }
    container.innerHTML = '<div class="toast-message p-2 flex gap-2 items-center">'
        + '<span class="grow"> ' + message + '</span>'
        + '<span class="flex-none"><i class="fa-regular fa-circle-xmark cursor-pointer " data-toggle="dismiss"></i></span>'
        + '</div>';

    document.querySelector('.toast-container').appendChild(container);
    setTimeout(function() {
        container.classList.remove('opacity-100');
        container.classList.add('opacity-0');
        setTimeout(function () {
            container.remove();
        }, 150);
    }, 3000);
    registerToastDismiss();
};


registerToastDismiss();

