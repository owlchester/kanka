/**
 * Heavily inspired by the amazing https://web.dev/building-a-dialog-component/
 */
const backdrop = document.getElementById('dialog-backdrop');

const initDialogs = () => {
    document.querySelectorAll('[data-toggle="dialog"]').forEach(el => {
        el.addEventListener('click', openingDialog);
    });

    document.querySelectorAll('[data-toggle="dialog-ajax"]').forEach(el => {
        el.addEventListener('click', openingDialog);
    });
};

function openingDialog(e) {
    e.preventDefault();
    let target = this.dataset.target;
    if (!target) {
        return;
    }
    let url = this.dataset.url;
    //console.log('url', url);
    openDialog(target, url);
}

const openDialog = (target, url) => {
    target = document.getElementById(target);
    target.removeAttribute('open');
    target.show();

    backdrop.classList.remove('hidden');
    backdrop.addEventListener('click', function (event) {
        target.close();
    });

    target.addEventListener('click', function (event) {
        let rect = target.getBoundingClientRect();
        let isInDialog=(rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
            rect.left <= event.clientX && event.clientX <= rect.left + rect.width);
        if (!isInDialog && event.target.tagName === 'DIALOG') {
            target.close();
        }
    });
    target.addEventListener('close', function (event) {
        backdrop.classList.add('hidden');
    });

    if (url) {
        loadDialogContent(url, target);
    }
};

const loadDialogContent = (url, target) => {
    $.ajax({
        url: url
    }).done(function (success) {
        $(target).html(success).show();
        $(document).trigger('shown.bs.modal'); // Get tooltips, select2 and delete-confirmation to re-generate

        $('.btn-manage-perm').click(function (e) {
            e.preventDefault();
            target.close();
            let permTarget = $(this).data('target');
            $(permTarget).click();
        });
    });
};

window.initDialogs = initDialogs;
window.openDialog = openDialog;
