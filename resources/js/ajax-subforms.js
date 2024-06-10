/**
 * Contains standard ajax process for forms.
 *
 * Warning /!\ : This will replace submit events on the form itself!
 * Usage: <form> tag must have class : 'ajax-subforms'
 *        Submit button or button group must be enclosed in a <div> that has the class : 'submit-group'
 */
$(document).ready(function () {
    initSubforms();
    $(document).on('shown.bs.modal', function () {
        initSubforms();
    });
});

const initSubforms = () => {
    let subForms = document.querySelectorAll('.ajax-subform');
    subForms.forEach(function(subform) {
        //subform.removeEventListener('submit');
        subform.onsubmit = function(e) {
            // If the form is valid, submit it for real this time (ajax submit worked)
            // let formIsValid = subform.getAttribute('is-valid');
            // if (formIsValid) {
            //     return true;
            // }

            // Disable global alert when redirection occurs
            window.entityFormHasUnsavedChanges = false;
            e.preventDefault();
            startAnimation($(subform));

            let formData = new FormData(subform);
            $.ajax({
                url: subform.getAttribute('action'),
                method: subform.getAttribute('method'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                context: subform,
            }).done(function () {
                // If the validation succeeded, confirm its validity
                // subform.setAttribute('is-valid', 'true');
                subform.submit();
                // return true;
            }).fail(function (err) {
                displayErrors($(this), err);
            });
        };
    });
    //remove current submit event just in case it isn't clear

};

const displayErrors = (form, error) => {
    //console.debug('error', err);
    // Reset any error fields
    form.find('.input-error').removeClass('input-error');
    form.find('.text-error').remove();

    // If we have a 503 error status, let's assume it's from cloudflare and help the user
    // properly save their data.
    if (error.status === 503) {
        window.showToast(error.responseJSON.message, 'error');
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
    //console.log('errorKeys', errorKeys);
    let foundAllErrors = true;
    errorKeys.forEach(function (i) {
        // This doesn't work for select2 tag fields
        let errorSelector = form.find('[name="' + i + '"]');
        //console.log('error field', '[name="' + i + '"]', errorSelector);
        if (errorSelector.length > 0) {
            errorSelector.addClass('input-error')
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
            window.showToast(errors[i][0], 'error');
        });
    }

    // Reset submit buttons
    stopAnimation(form);
};

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
