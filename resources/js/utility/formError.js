
window.formErrorHandler = function(err, form) {
    $('.input-error').removeClass('input-error');
    $('.text-danger').remove();

    // Re-enable the submit button
    $(form).find('.btn-success')
        .prop('disabled', false)
        .removeClass('loading');

    // If we have a 503 error status, let's assume it's from cloudflare and help the user
    // properly save their data.
    if (err.status === 503) {
        window.showToast(err.responseJSON.message, 'toast-error');
        return;
    }

    // If it's 403, the session is gone
    if (err.status === 403) {
        $('#entity-form-403-error').show();
        return;
    }

    // Loop through the errors to add the class and error message
    let errors = err.responseJSON.errors;
    let logs = [];

    let errorKeys = Object.keys(errors);
    let foundAllErrors = true;
    errorKeys.forEach(function (i) {
        let errorSelector = $('[name="' + i + '"]');
        if (errorSelector.length > 0) {
            errorSelector.addClass('input-error').parent().append('<div class="text-danger">' + errors[i][0] + '</div>');
        } else {
            foundAllErrors = false;
            logs.push(errors[i][0]);
        }
    });

    // If not all error fields could be found, show a generic error message on top of the form.
    if (!foundAllErrors) {
        let genericError = $('#entity-form-generic-error .error-logs');
        genericError.html('');
        logs.forEach(function (i) {
            let msg = i + "<br />";
            genericError.append(msg);
        });
        $('#entity-form-generic-error').show();
    }

    // No tabs? Try no further
    if ($(this).find('.tab-content').length === 0) {
        return;
    }

    let firstItem = Object.keys(errors)[0];
    let firstItemDom = document.getElementsByName(firstItem);

    // If we can actually find the first element, switch to it and the correct tab.
    if (!firstItemDom[0]) {
        return;
    }
    firstItemDom[0].scrollIntoView({ behavior: 'smooth' });
    $('.tab-content .active').removeClass('active');
    $('.nav-tabs li.active').removeClass('active');
    let firstPane = $('[name="' + firstItem + '"').closest('.tab-pane');
    firstPane.addClass('active');
    $('a[href="#' + firstPane.attr('id') + '"]').closest('li').addClass('active');
}
