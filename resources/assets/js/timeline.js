var validTimelineForm = false;
var eraForm;

$(document).ready(function () {
    initTimelineForms();

    $(document).on('shown.bs.modal shown.bs.popover', function() {
        initTimelineForms();
    });
});


/**
 *
 */
function initTimelineForms() {
    eraForm = $('#timeline-era-form');
    if (eraForm.length === 0) {
        return;
    }

    eraForm.on('submit', function(e) {
        if (validTimelineForm) {
            return true;
        }

        window.entityFormHasUnsavedChanges = false;
        e.preventDefault();

        let submitBtn = $(this)
            .find('.btn-success');
        submitBtn.data('reset', submitBtn.html())
            .html('<i class="fa fa-spinner fa-spin"></i>')
            .prop('disabled', true);

        // Allow ajax requests to use the X_CSRF_TOKEN for deletes
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function (res) {
            // If the validation succeeded, we can really submit the form
            validTimelineForm = true;
            eraForm.submit();
            return true;
        }).fail(function (err) {
            //console.log('error', err);
            // Reset any error fields
            eraForm.find('.input-error').removeClass('input-error');
            eraForm.find('.text-danger').remove();

            // If we have a 503 error status, let's assume it's from cloudflare and help the user
            // properly save their data.
            if (err.status === 503) {
                $('#entity-form-503-error').show();
                resetFormSubmitAnimation();
            }

            // If it's 403, the session is gone
            if (err.status === 403) {
                $('#entity-form-403-error').show();
                resetFormSubmitAnimation();
            }

            // Loop through the errors to add the class and error message
            let errors = err.responseJSON.errors;

            let errorKeys = Object.keys(errors);
            let foundAllErrors = true;
            errorKeys.forEach(function (i) {
                let errorSelector = $('[name="' + i + '"]');
                //console.log('error field', '[name="' + i + '"]');
                if (errorSelector.length > 0) {
                    eraForm.find('[name="' + i + '"]').addClass('input-error')
                        .parent()
                        .append('<div class="text-danger">' + errors[i][0] + '</div>');
                } else {
                    foundAllErrors = false;
                }
            });

            let firstItem = Object.keys(errors)[0];
            let firstItemDom = eraForm.find('[name="' + firstItem + '"]');

            // If we can actually find the first element, switch to it and the correct tab.
            if (firstItemDom.length > 0) {
                firstItemDom.focus();
            }

            // Reset submit buttons
            resetFormSubmitAnimation();
        });
    });
}

/**
 *
 */
function resetFormSubmitAnimation()
{
    let submitBtn = eraForm.find('.btn-success');
    if (submitBtn.length > 0) {
        $.each(submitBtn, function () {
            $(this).removeAttr('disabled');
            if ($(this).data('reset')) {
                $(this).html($(this).data('reset'));
            }
        });
    }
}
