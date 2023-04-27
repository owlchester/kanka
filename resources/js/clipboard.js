$(document).ready(function () {
    initCopyToClipboard();

    $(document).on('shown.bs.modal shown.bs.popover', function() {
        initCopyToClipboard();
    });
});


/**
 * Handler for copying content to the clipboard
 */
function initCopyToClipboard() {
    if ($('[data-clipboard]').length === 0) {
        return;
    }

    $.each($('[data-clipboard]'), function (i) {
        let me = $(this);
        if (me.data('loaded') == 1) {
            return;
        }
        me.data('loaded', 1);
        me.click(function (e) {
            copyToClipboard($(this).data('clipboard'), $(this));

            let toast = $(this).data('toast');
            if (toast) {
                window.showToast(toast);
                return false;
            }
            return false;
        });
    });
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
