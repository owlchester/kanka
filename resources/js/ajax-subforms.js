/**
 * Contains standard ajax process for forms.
 *
 * Wartning /!\ : This will replace submit events on the form itself!
 * Usage: <form> tag must have class : 'ajax-subforms'
 *        Submit button or button group must be enclosed in a <div> that has the class : 'submit-group'
 */
$(document).ready(function () {
    initSubforms();
    $(document).on('shown.bs.modal shown.bs.popover', function () {
        initSubforms();
    });
});

function initSubforms() {
    let subForms = $('.ajax-subform');
    if (subForms.length === 0) {
        return;
    }
    //remove current submit event just in case it isn't clear
    subForms.off('submit');
    subForms.on('submit', function (e) {
        // If the form is valid, submit it for real this time (ajax submit worked)
        let formIsValid = $(this).attr('is-valid');
        if (formIsValid) {
            return true;
        }

        // Disable global alert when redirection occurs
        window.entityFormHasUnsavedChanges = false;
        e.preventDefault();
        startAnimation($(this));

        let formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            context: this,
        }).done(function () {
            // If the validation succeeded, confirm its validity
            $(this).attr('is-valid', true);
            $(this).off('submit');
            //console.log('form is valid?', currentAjaxForm, currentAjaxForm.attr('is-valid'));
            // resubmit the form
            $(this).submit();
        }).fail(function (err) {
            displayErrors($(this), err);
        });
    });
}

const displayErrors = (form, error) => {
    //console.debug('error', err);
    // Reset any error fields
    form.find('.input-error').removeClass('input-error');
    form.find('.text-error').remove();

    // If we have a 503 error status, let's assume it's from cloudflare and help the user
    // properly save their data.
    if (error.status === 503) {
        window.showToast(error.responseJSON.message, 'toast-error');
        stopAnimation(form);
        return;
    }

    // If it's 403, the session is gone
    if (error.status === 403) {
        $('#entity-form-403-error').show();
        stopAnimation(form);
    }

    // Loop through the errors to add the class and error message
    let errors = error.responseJSON.errors;

    let errorKeys = Object.keys(errors);
    let foundAllErrors = true;
    errorKeys.forEach(function (i) {
        let errorSelector = $('[name="' + i + '"]');
        //console.log('error field', '[name="' + i + '"]');
        if (errorSelector.length > 0) {
            form.find('[name="' + i + '"]').addClass('input-error')
                .parent()
                .append('<div class="text-error">' + errors[i][0] + '</div>');
        } else {
            foundAllErrors = false;
        }
    });

    let firstItem = Object.keys(errors)[0];
    let firstItemDom = form.find('[name="' + firstItem + '"]');

    // If we can actually find the first element, switch to it and the correct tab.
    if (firstItemDom.length > 0) {
        firstItemDom.focus();
    }

    // If some of the errors couldn't be found in the form, alert the user with a toast error
    if (!foundAllErrors) {
        errorKeys.forEach(function (i) {
            window.showToast(errors[i][0], 'toast-error');
        });
    }

    // Reset submit buttons
    stopAnimation(form);
} ;

const startAnimation = (form) => {
    form.find('.submit-group').find('.btn2').addClass('btn-disabled');
    form.find('.submit-group').find('.btn2:first').addClass('loading');
};

/**
 * Reset the "loading" animation that disables the submit buttons
 * @param form
 */
const stopAnimation = (form) => {
    form.find('.submit-group').find('.btn2').removeClass('btn-disabled');
    form.find('.submit-group').find('.btn2:first').removeClass('loading');
};
