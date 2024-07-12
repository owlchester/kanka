/**
 * To avoid users losing data while Kanka is in maintenance mode,
 * we force all forms to do an ajax request to the server first,
 * making sure the app is properly running. If an error comes
 * back, errors are displayed to the user.
 */

const initMaintenanceForms = () => {
    const subForms = document.querySelectorAll('form[data-maintenance="1"]');
    subForms.forEach(function(subform) {
        subform.addEventListener('submit', onMaintenanceFormSubmit);
    });
};

const onMaintenanceFormSubmit = (event) => {
    // Disable global alert when redirection occurs
    window.entityFormHasUnsavedChanges = false;
    event.preventDefault();
    const form = event.target;
    startAnimation(form);

    // This will put the summernote image file field in the form,
    // and the browser console logs will complain, but we can
    // ignore that error completely.
    let formData = new FormData(form);

    axios.post(form.getAttribute('action'), formData)
        .then(() => {
            // The check succeeded, submit the form for real. By doing .submit, it skips any event listeners on submit
            form.submit();
        })
        .catch(err => {
            // Result with a response, hopefully a 422 error
            if (err.response) {
                window.formErrorHandler(err.response, form);
            }
            stopAnimation(form);
        })
    ;
};


const startAnimation = (form) => {
    const btns = form.querySelectorAll('.btn-primary');
    btns.forEach((btn, index) => {
        if (index === 0) {
            btn.classList.add('loading');
        }
        btn.classList.add('btn-disabled');
    });
};

/**
 * Reset the "loading" animation that disables the submit buttons
 * @param form
 */
const stopAnimation = (form) => {
    const btns = form.querySelectorAll('.btn-primary');
    btns.forEach(btn => {
        btn.classList.remove('btn-disabled', 'loading');
    });
};

initMaintenanceForms();
window.onEvent(function() {
    initMaintenanceForms();
});
