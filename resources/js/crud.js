/**
 * Crud
 */

let entityFormActions;


$(document).ready(function () {
    registerDynamicRows();
    registerDropdownFormActions();
    registerUnsavedChanges();
    registerModalLoad();
});

/**
 * Re-register any events that need to be binded when a modal is loaded
 */
function registerModalLoad() {
    $(document).on('shown.bs.modal', function () {
        registerDropdownFormActions();
    });
}

function registerEntityNameCheck() {
    const field = document.querySelector('#form-entry input[name="name"]');
    if (!field) {
        return;
    }
    if (field.dataset.liveDisabled) {
        return;
    }
    field.addEventListener('focusout', function (event) {
        // Don't bother if the user didn't set any value
        if (!field.value) {
            return;
        }
        const block = this.dataset.duplicate;
        const entityCreatorDuplicateWarning = document.querySelector(block);
        const url = this.dataset.live +
            '?q=' + encodeURIComponent(this.value) +
            '&type=' + this.dataset.type +
            '&exclude=' + this.dataset.id;
        entityCreatorDuplicateWarning.classList.add('hidden');
        const duplicates = entityCreatorDuplicateWarning.querySelector('.duplicates');

        // Check if an entity of the same type already exists, and warn when it does.
        fetch(url)
            .then((response) => response.json())
            .then((res) => {
                duplicates.innerHTML = '';
                res.forEach(entity => {
                    const link = document.createElement('a');
                    link.href = entity.url;
                    link.text = entity.name;
                    duplicates.appendChild(link);
                });
                if (res.length > 0) {
                    entityCreatorDuplicateWarning.classList.remove('hidden');
                }
            });
    });
}

/**
 * Forms have dropdown actions to select which submit is being
 * done. Instead of using submit buttons like normal people,
 * we use links that set the main action's name.
 */
const registerDropdownFormActions = () => {
    // Return early if there are no elements in the page to be handled
    entityFormActions = document.querySelectorAll('.form-submit-actions');
    if (entityFormActions.length === 0) {
        return;
    }
    let entityFormMainButton = document.getElementById('form-submit-main');
    let entityFormSubmitMode = document.getElementById('submit-mode');
    if (entityFormSubmitMode === undefined) {
        throw new Error("No submit mode hidden input found");
    }

    // Register click on each sub action
    entityFormActions.forEach(action => {
        if(action.dataset.loaded === '1') {
            return;
        }
        action.dataset.loaded = '1';
        action.addEventListener('click', function (event) {
            entityFormSubmitMode.name = action.dataset.action;
            entityFormMainButton.click();
            event.preventDefault();
            return false;
        });
    });
};


/**
 * If we change something on a form, avoid losing data when going away.
 */
function registerUnsavedChanges() {
    // Return early if we have no elements to handle
    entityFormActions = $('form[data-unload="1"]');
    if (entityFormActions.length === 0) {
        return;
    }
    let save = $('#form-submit-main');

    // Save every input change
    $(document).on('change', ':input', function () {
        if ($(this).data('skip-unsaved')) {
            return;
        }
        window.entityFormHasUnsavedChanges = true;
    });

    if (save.length === 1) {
        // Another way to bind the event
        $(window).bind('beforeunload', function (e) {
            if (window.entityFormHasUnsavedChanges) {
                return "Unsaved data warning";
            }
        });
    }
}

/**
 * When the entity form is submitted, we want to ajax validate the request first
 */
function registerFormMaintenance() {
    $('form[data-maintenance="1"]').each(function() {
        // Because we call this function again on each modal shown (for loading forms in modals), we need to
        // save on each form if the listener has already been added, to avoid having multiple onSubmits on
        // the same element for the same feature.
        if ($(this).data('with-maintenance') === true) {
            return;
        }
        $(this).data('with-maintenance', true);

        $(this).submit(function (e) {
            if ($(this).data('checked-maintenance') === true) {
                return true;
            }
            e.preventDefault();

            // If it's a form with images, we need to handle it a little bit differently
            let ajaxData = {
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                context: this,
            };
            // If the form has files (ignoring the summernote one), include it
            if ($(this).find('input[type="file"]').not('.note-image-input').length > 0) {
                let formData = new FormData(this);
                ajaxData = {
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    context: this,
                };
            }

            $.ajax(ajaxData).done(function () {
                // If the validation succeeded, we can really submit the form
                $(this)
                    .data('checked-maintenance', true)
                    .submit();
            }).fail(function (err) {
                window.formErrorHandler(err, this);
            });
        });
    });
}


/**
 * Register a listened to add dynamic rows in the forms
 * Used in the calendar forms extensively
 */
const registerDynamicRows = () => {
    $('.dynamic-row-add').on('click', function(e) {
        e.preventDefault();

        let target = $(this).data('target');
        let template = $(this).data('template');
        $('.' + target).append('<div class="">' +
            $('#' + template).html() +
            '</div>');

        registerDynamicRowDelete();
        $(document).trigger('shown.bs.modal');
        return false;
    });
    registerDynamicRowDelete();
};

/**
 * Register a listener to delete a dynamically added row in the forms
 */
const registerDynamicRowDelete = () => {
    $.each($('.dynamic-row-delete'), function () {
        if ($(this).data('init') === 1) {
            return;
        }
        $(this).data('init', 1).on('click', function (e) {
            e.preventDefault();
            $(this).closest('.parent-delete-row').remove();
        }).on('keydown', function (e) {
            // Support for pressing enter on a span
            if (e.key !== 'Enter') {
                return;
            }
            $(this).click();
        });
    });
};


registerEntityNameCheck();
