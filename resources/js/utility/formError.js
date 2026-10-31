
window.formErrorHandler = function(err, form) {
    // Remove any existing errors from the form
    const existingErrors = form.querySelectorAll('.input-error');
    existingErrors.forEach(field => {
        field.classList.remove('input-error');
    });
    form.querySelectorAll('[data-form-error]').forEach(error => error.remove());

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
        form.querySelector('#entity-form-403-error')?.classList.remove('hidden');
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
        let errorSelector = form.querySelector('[name="' + i + '"]');
        if (errorSelector) {
            errorSelector.classList.add('input-error');
            const errorElement = document.createElement('div');
            errorElement.classList.add('text-error-content');
            errorElement.setAttribute('data-form-error', '');
            errorElement.textContent = errors[i][0];
            errorSelector.parentNode.append(errorElement);
        } else {
            foundAllErrors = false;
            logs.push(errors[i][0]);
        }

        window.showToast(errors[i][0], 'error');
    });

    // If not all error fields could be found, show a generic error message on top of the form.
    const genericError = form.querySelector('#entity-form-generic-error .error-logs');
    if (!foundAllErrors && genericError) {
        genericError.innerHTML = '';
        logs.forEach(function (i) {
            genericError.append(i);
        });
        form.querySelector('#entity-form-generic-error')?.classList.remove('hidden');
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
    const firstPane = firstErrorField.closest('.tab-pane');
    const tabs = firstPane?.closest('.nav-tabs-custom');
    const tab = tabs?.querySelector('a[href="#' + firstPane.id + '"]')?.closest('li');
    if (tab) {
        tabs.querySelector('.tab-pane.active')?.classList.remove('active');
        tabs.querySelector('.nav-tabs li.active')?.classList.remove('active');
        firstPane.classList.add('active');
        tab.classList.add('active');
    }

    focusOnField(firstErrorField);
};

const focusOnField = (field) => {
    field.focus();
    field.scrollIntoView({ behavior: 'smooth' });
};
