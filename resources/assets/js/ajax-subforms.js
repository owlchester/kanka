/**
 * Contains standard ajax process for forms.
 *
 * Wartning /!\ : This will replace submit events on the form itself!
 * Usage: <form> tag must have class : 'ajax-subforms'
 *        Submit button or button group must be enclosed in a <div> that has the class : 'submit-group'
 */
var currentAjaxForm;
$(document).ready(function () {
    initSubforms();

    $(document).on('shown.bs.modal shown.bs.popover', function () {
        initSubforms();
    });
});

function initSubforms() {
    //console.info('Init Ajax Subforms');

    let subForms = $('.ajax-subform');
    if (subForms.length === 0) {
        //console.info('not ajax subforms');
        return;
    }
    //remove current submit event just in case it isn't clear
    subForms.off('submit');
    subForms.on('submit', function (e) {
        //console.log('Ajax subform submitted', $(this));
        //Get the validity status of the form
        let formIsValid = $(this).attr('is-valid');
        //console.log("Form validity", formIsValid);
        if (formIsValid) {
            //console.log("Ajax subform already validated, sending", $(this));
            //do nothing and send form
            return true;
        }
        //else form is not confirmed valid

        //disable global alert when redirection occurs
        window.entityFormHasUnsavedChanges = false;
        e.preventDefault();

        //show button animation
        currentAjaxForm = $(this);
        currentAjaxForm.find('.submit-group').hide();
        currentAjaxForm.find('.submit-animation').show();

        // Allow ajax requests to use the X_CSRF_TOKEN for deletes
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //send request to server
        let formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            async: false
        }).done(function (res) {
            // If the validation succeeded, confirm its validity
            currentAjaxForm.attr('is-valid', true);
            currentAjaxForm.off('submit')
            //console.log('form is valid?', currentAjaxForm, currentAjaxForm.attr('is-valid'));
            // resubmit the form
            currentAjaxForm.submit();
        }).fail(function (err) {
            //console.log('error', err);
            // Reset any error fields
            currentAjaxForm.find('.input-error').removeClass('input-error');
            currentAjaxForm.find('.text-danger').remove();

            // /?\ how do the 503/403 error ids work ?
            // If we have a 503 error status, let's assume it's from cloudflare and help the user
            // properly save their data.
            if (err.status === 503) {
                window.showToast(err.responseJSON.message, 'toast-error');
                resetSubformSubmitAnimation(currentAjaxForm);
                return;
            }

            // If it's 403, the session is gone
            if (err.status === 403) {
                $('#entity-form-403-error').show();
                resetSubformSubmitAnimation(currentAjaxForm);
            }

            // Loop through the errors to add the class and error message
            let errors = err.responseJSON.errors;

            let errorKeys = Object.keys(errors);
            let foundAllErrors = true;
            errorKeys.forEach(function (i) {
                let errorSelector = $('[name="' + i + '"]');
                //console.log('error field', '[name="' + i + '"]');
                if (errorSelector.length > 0) {
                    currentAjaxForm.find('[name="' + i + '"]').addClass('input-error')
                        .parent()
                        .append('<div class="text-danger">' + errors[i][0] + '</div>');
                } else {
                    foundAllErrors = false;
                }
            });

            let firstItem = Object.keys(errors)[0];
            let firstItemDom = currentAjaxForm.find('[name="' + firstItem + '"]');

            // If we can actually find the first element, switch to it and the correct tab.
            if (firstItemDom.length > 0) {
                firstItemDom.focus();
            }

            // Reset submit buttons
            resetSubformSubmitAnimation(currentAjaxForm);
        });
    });
}

function resetSubformSubmitAnimation(form) {
    //console.log("Resetting ajax subform animation");
    //reset animation
    form.find('.submit-group').show();
    form.find('.submit-animation').hide();
}
