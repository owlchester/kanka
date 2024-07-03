/**
 * Heavily inspired by the amazing https://web.dev/building-a-dialog-component/
 */
const backdrop = document.getElementById('dialog-backdrop');
let loadingContent;

const initDialogs = () => {
    document.querySelectorAll('[data-toggle="dialog"]').forEach(el => {
        el.addEventListener('click', openingDialog);
    });

    document.querySelectorAll('[data-toggle="dialog-ajax"]').forEach(el => {
        el.addEventListener('click', openingDialog);
    });
};

const dialogLoadedEvent = new Event('dialog.loaded');

function openingDialog(e) {
    e.preventDefault();
    let target = this.dataset.target;
    if (!target) {
        return;
    }
    let url = this.dataset.url;
    let focus = this.dataset.focus;
    openDialog(target, url, focus);
}

const openDialog = (target, url, focus) => {
    target = document.getElementById(target);
    target.removeAttribute('open');
    target.show();

    backdrop.classList.remove('hidden');
    if (target.dataset.dismissible !== 'false') {
        backdrop.addEventListener('click', function (event) {
            target.close();
        });
    }

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
    } else if(focus) {
        let focusEle = document.querySelector(focus);
        if (!focusEle) {
            return;
        }
        focusEle.focus();
    }
};

const loadDialogContent = (url, target) => {
    // When re-opening the dialog, show again the loading animation
    if (!loadingContent) {
        loadingContent = target.innerHTML;
    } else {
        target.innerHTML = loadingContent;
    }

    fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(response => response.text())
        .then(response => {
            target.innerHTML = response;
            target.show();
            if (typeof $ === 'function') {
                window.triggerEvent();
            } else {
                document.dispatchEvent(dialogLoadedEvent);
            }
        });
};

const closeDialog = (target) => {
    let el = document.getElementById(target);
    el.close();
};

window.initDialogs = initDialogs;
window.openDialog = openDialog;
window.closeDialog = closeDialog;
