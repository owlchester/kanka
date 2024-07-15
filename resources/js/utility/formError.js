
window.formErrorHandler = function(err, form) {
    // Remove any existing errors from the form
    const existingErrors = document.querySelectorAll('.input-error');
    existingErrors.forEach(field => {
        field.classList.remove('input-error');
    });
    const textError = document.querySelector('.text-error');
    if (textError) {
        textError.remove();
    }

    // Re-enable the submit button
    const submitBtn = form.querySelector('.btn-primary');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('loading');
    }

    // If we have a 503 error status, let's assume it's from cloudflare and help the user
    // properly save their data.
    if (err.status === 503) {
        window.showToast(err.data.message, 'error');
        return;
    }

    // If it's 403, the session is gone
    if (err.status === 403) {
        document.querySelector('#entity-form-403-error').classList.remove('hidden');
        return;
    }

    // No errors? Probably a backend error
    if (!err.data.errors) {
        window.showToast('Backend error', 'error');
        return;
    }
    // Loop through the errors to add the class and error message
    const errors = err.data.errors;
    let logs = [];

    const errorKeys = Object.keys(errors);
    let foundAllErrors = true;
    errorKeys.forEach(function (i) {
        let errorSelector = document.querySelector('[name="' + i + '"]');
        if (errorSelector) {
            errorSelector.classList.add('input-error');
            const errorElement = document.createElement('div');
            errorElement.classList.add('text-error');
            errorElement.innerHTML = errors[i][0];
            errorSelector.parentNode.append(errorElement);
        } else {
            foundAllErrors = false;
            logs.push(errors[i][0]);
        }

        window.showToast(errors[i][0], 'error');
    });

    // If not all error fields could be found, show a generic error message on top of the form.
    if (!foundAllErrors) {
        const genericError = document.querySelector('#entity-form-generic-error .error-logs');
        genericError.innerHTML = '';
        logs.forEach(function (i) {
            genericError.append(i);
        });
        document.querySelector('#entity-form-generic-error').classList.remove('hidden');
    }

    jumpToError(form, errors);
};

const jumpToError = (form, errors) => {
    // Find the first error and if it has an associated field
    const firstErrorName = Object.keys(errors)[0];
    const firstErrorField = form.querySelector('[name="' + firstErrorName + '"]');
    // It's a generic error unrelated to a field? End it here
    if (!firstErrorField) {
        return;
    }

    // No tabs? Try and focus on the field directly
    if (!form.querySelector('.tab-content')) {
        focusOnField(firstErrorField);
        return;
    }

    // If we can actually find the first element, switch to it and the correct tab.
    document.querySelector('.tab-content .active').classList.remove('active');
    document.querySelector('.nav-tabs li.active').classList.remove('active');
    const firstPane = document.querySelector('[name="' + firstErrorName + '"').closest('.tab-pane');
    if (firstPane) {
        firstPane.classList.add('active');
        document.querySelector('a[href="#' + firstPane.id + '"]').closest('li').classList.add('active');
    }

    focusOnField(firstErrorField);
};

const focusOnField = (field) => {
    field.focus();
    field.scrollIntoView({ behavior: 'smooth' });
};
