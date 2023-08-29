/**
 * Handler for copying content to the clipboard
 */
const initCopyToClipboard = () => {
    const elements = document.querySelectorAll('[data-clipboard]');
    elements.forEach((el) => {
        /*if (el.dataset.loaded == 1) {
            return;
        }
        el.dataset.loaded = 1;*/
        el.addEventListener('click', clickToastHandler, false);
    });
};

function clickToastHandler (e) {
    e.preventDefault();
    copyToClipboard(this.dataset.clipboard, this);

    let toast = this.dataset.toast;
    if (toast) {
        window.showToast(toast);
        return false;
    }
    return false;
}

async function copyToClipboard(textToCopy, el) {
    // Navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
        await navigator.clipboard.writeText(textToCopy);
    } else {
        // Use the 'out of viewport hidden text area' trick
        const textArea = document.createElement("textarea");
        textArea.value = textToCopy;

        // Move textarea out of the viewport so it's not visible
        textArea.style.position = "absolute";
        textArea.style.left = "-999999px";

        el.append(textArea);
        //document.body.prepend(textArea);
        textArea.select();

        try {
            document.execCommand('copy');
        } catch (error) {
            console.error(error);
        } finally {
            textArea.remove();
        }
    }
}

initCopyToClipboard();
$(document).on('shown.bs.modal', function (e) {
    initCopyToClipboard();
});
