$(document).ready(function () {
    initCopyToClipboard();
});


/**
 * Handler for copying content to the clipboard
 */
function initCopyToClipboard() {
    if ($('[data-clipboard]').length === 0) {
        return;
    }

    $('[data-clipboard]').click(function (e) {
        e.preventDefault();
        let $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).data('clipboard')).select();
        document.execCommand("copy");
        $temp.remove();

        let post = $(this).data('success');
        let toast = $(this).data('toast');
        if (toast) {
            window.showToast(toast);
            return false;
        }
        if (post) {
            $(post).fadeIn();
            setTimeout(function() {
                $(post).fadeOut();
            }, 3000);
        } else
            return false;
    });
}
