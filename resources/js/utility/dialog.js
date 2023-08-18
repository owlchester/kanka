const initDialogs = () => {
    document.querySelectorAll('[data-toggle="dialog"]').forEach(el => {
        el.addEventListener('click', openDialog, false);
    });

    document.querySelectorAll('[data-toggle="dialog-ajax"]').forEach(el => {
        el.addEventListener('click', openDialog, false);
    });
};

function openDialog(e) {
    e.preventDefault();
    let target = this.dataset.target;
    if (!target) {
        return;
    }
    target = document.getElementById(target);
    target.removeAttribute('open');
    target.showModal();

    target.addEventListener('click', function (event) {
        let rect = target.getBoundingClientRect();
        let isInDialog=(rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
            rect.left <= event.clientX && event.clientX <= rect.left + rect.width);
        if (!isInDialog && event.target.tagName === 'DIALOG') {
            target.close();
        }
    });

    let url = this.dataset.url;
    if (url) {
        loadDialogContent(url, target);
    }
};

const loadDialogContent = (url, target) => {
    $.ajax({
        url: url
    }).done(function (success) {
        $(target).html(success).show();
        $(document).trigger('shown.bs.modal'); // Get tooltips to re-generate

        $('.btn-manage-perm').click(function (e) {
            e.preventDefault();
            target.close();
            let permTarget = $(this).data('target');
            $(permTarget).click();
        });
    });
};

window.initDialogs = initDialogs;
