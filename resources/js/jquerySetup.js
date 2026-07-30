export const configureJQuery = (target, jQuery, csrfToken) => {
    target.$ = jQuery
    target.jQuery = jQuery

    if (csrfToken) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        })
    }
}
