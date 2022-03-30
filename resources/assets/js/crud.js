/**
 * Crud
 */

import ajaxModal from "./components/ajax-modal";

// Character
var characterAddPersonality, characterTemplatePersonality;
var characterAddAppearance, characterTemplateAppearance;
var characterSortPersonality, characterSortAppearance;
var entityFormActions;
var characterAddOrganisation, characterTemplateOrganisation, characterOrganisations;


var multiEditingModal;

// Entity Calendar
var entityCalendarAdd, entityCalendarForm, entityCalendarField;
var entityCalendarMonthField, entityCalendarYearField, entityCalendarDayField;
var entityCalendarCancel, entityCalendarLoading, entityCalendarSubForm;
var entityCalendarModalForm;

var entityName;

var toggablePanels;

var validEntityForm = false, validRelationForm = false;

// Keep alive when editing
var keepAliveTimer = 300 * 1000; // 5 minutes
var keepAliveUrl;
var keepAliveEnabled = true;

$(document).ready(function () {

    characterSortPersonality = $('.character-personality');
    characterSortAppearance = $('.character-appearance');
    characterOrganisations = $('.character-organisations');

    characterAddPersonality = $('#add_personality');
    if (characterAddPersonality.length === 1) {
        initCharacterPersonality();
    }
    characterAddAppearance = $('#add_appearance');
    if (characterAddAppearance.length === 1) {
        initCharacterAppearance();
    }
    characterAddOrganisation = $('#add_organisation');
    if (characterAddOrganisation.length === 1) {
        initCharacterOrganisation();
    }

    ajaxModal();

    entityFormActions = $('.form-submit-actions');
    if (entityFormActions.length > 0) {
        registerEntityFormActions();
        registerUnsavedChanges();
    }

    entityName = $('#form-entry input[name="name"]');
    if (entityName.length === 1) {
        registerEntityNameCheck();
    }

    registerFormSubmitAnimation();
    registerEntityCalendarForm();
    registerToggablePanels();
    registerEntityFormSubmit();
    registerEntityCalendarModal();
    registerModalLoad();
    registerDatagridSorter();
    registerPermissionToggler();
    registerEntityNotePerms();
    registerStoryActions();
    registerStoryLoadMore();
    registerSidebarActions();
    registerEditWarning();
    registerEditKeepAlive();
});

/**
 * Re-register any events that need to be binded when a modal is loaded
 */
function registerModalLoad() {
    $(document).on('shown.bs.modal shown.bs.popover', function () {
        registerRelationFormSubmit();
        registerEntityCalendarModal();
    });
}

function registerEntityNameCheck() {
    if (entityName.data('live-disabled')) {
        return;
    }
    entityName.focusout(function (e) {
        // Don't bother if the user didn't set any value
        if (!$(this).val()) {
            return;
        }
        var entityCreatorDuplicateWarning = $('.duplicate-entity-warning');
        let currentEntityID = $(this).data('id');
        let url = $(this).data('live') +
            '?q=' + encodeURIComponent($(this).val()) +
            '&type=' + $(this).data('type') +
            '&exclude=' + $(this).data('id');

        entityCreatorDuplicateWarning.hide();
        // Check if an entity of the same type already exists, and warn when it does.
        $.ajax(
            url
        ).done(function (res) {
            if (res.length > 0) {
                let entities = Object.keys(res)
                    // Filter out what isn't itself
                    .filter(function (k) { return !currentEntityID || currentEntityID != res[k].id })
                    .map(function (k) { return '<a href="' + res[k].url + '">' + res[k].name + '</a>' })


                if (entities.length > 0) {
                    $('#duplicate-entities').html(entities.join(', '));
                    entityCreatorDuplicateWarning.fadeIn();
                }
            } else {
                entityCreatorDuplicateWarning.hide();
            }
        });
    });
}

/**
 *
 */
function initCharacterPersonality() {
    characterTemplatePersonality = $('#template_personality');
    characterAddPersonality.on('click', function (e) {
        e.preventDefault();

        $(characterSortPersonality).append('<div class="form-group">' +
            characterTemplatePersonality.html() +
            '</div>');

        // Handle deleting already loaded blocks
        characterDeleteRowHandler();

        return false;
    });

    characterDeleteRowHandler();
}

/**
 *
 */
function initCharacterAppearance() {
    characterTemplateAppearance = $('#template_appearance');
    characterAddAppearance.on('click', function (e) {
        e.preventDefault();

        $(characterSortAppearance).append('<div class="form-group">' +
            characterTemplateAppearance.html() +
            '</div>');

        // Handle deleting already loaded blocks
        characterDeleteRowHandler();

        return false;
    });

    characterDeleteRowHandler();
}

/**
 *
 */
function initCharacterOrganisation() {
    characterTemplateOrganisation = $('#template_organisation');
    characterAddOrganisation.on('click', function (e) {
        e.preventDefault();

        $(characterOrganisations).append('<div class="form-group">' +
            characterTemplateOrganisation.html() +
            '</div>');

        // Replace the temp class with the real class. We need this to avoid having two select2 fields
        characterOrganisations.find('.tmp-org').removeClass('tmp-org').addClass('select2');

        // Handle deleting already loaded blocks
        characterDeleteRowHandler();
        registerPrivateCheckboxes();

        return false;
    });

    characterDeleteRowHandler();
}

/**
 *
 */
function characterDeleteRowHandler() {
    $.each($('.personality-delete'), function () {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function (e) {
            e.preventDefault();
            $(this).closest('.parent-delete-row').remove();
        });
    });

    $.each($('.member-delete'), function () {
        $(this).unbind('click');
        $(this).on('click', function (e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });
    });

    // Always re-calc the sortable traits
    characterSortPersonality.sortable();
    characterSortAppearance.sortable();
    window.initForeignSelect();
}

/**
 *
 */
function registerPrivateCheckboxes() {
    $.each($('[data-toggle="private"]'), function () {
        // Add the title first
        if ($(this).hasClass('fa-lock')) {
            $(this).prop('title', $(this).data('private'));
        } else {
            $(this).prop('title', $(this).data('public'));
        }

        // On click toggle
        $(this).click(function (e) {
            if ($(this).hasClass('fa-lock')) {
                // Unlock
                $(this).removeClass('fa-lock').addClass('fa-unlock-alt').prop('title', $(this).data('public'));
                $(this).parent().find('input:hidden').val("0");
            } else {
                // Lock
                $(this).removeClass('fa-unlock-alt').addClass('fa-lock').prop('title', $(this).data('private'));
                $(this).parent().find('input:hidden').val("1");
            }
        });
    });
}
/**
 *
 */
function registerEntityFormActions() {
    var entityFormMainButton = $('#form-submit-main')
    var entityFormSubmitMode = $('#submit-mode');
    if (entityFormSubmitMode == undefined) {
        throw new Error("No submit mode hidden input found");
    }

    // Register click on each sub action
    $.each(entityFormActions, function () {
        $(this).on('click', function () {

            //console.log('setting the submit name to ' + $(this).data('action'));

            entityFormSubmitMode.attr('name', $(this).data('action'));

            entityFormMainButton.trigger("click");

            return false;
        });
    });
}

/**
 * On all forms, we want to animate the submit button when it's clicked.
 */
function registerFormSubmitAnimation() {
    $.each($('form'), function () {
        $(this).on('submit', function () {
            // Saving, skip alert.
            window.entityFormHasUnsavedChanges = false;

            // Find the main button
            var submit = $(this).find('.btn-success');
            if (submit.length > 0) {
                $.each(submit, function () {
                    if ($(this).hasClass('dropdown-toggle')) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this)
                            .data('reset', $(this).html())
                            .html('<i class="fa fa-spinner fa-spin"></i>')
                            .prop('disabled', true);
                    }
                });

                // Inject the selected option for the "workflow" (submit-action)
                $(this).append('<input type="hidden" name="' + $('#form-submit-main').attr('name') + '" />');
            }

            return true;
        })
    });
}

function registerEntityCalendarForm() {
    entityCalendarAdd = $('#entity-calendar-form-add');
    entityCalendarField = $('[name="calendar_id"]');
    entityCalendarModalForm = $('.entity-calendar-modal-form');
    entityCalendarSubForm = $('.entity-calendar-subform');
    entityCalendarCancel = $('#entity-calendar-form-cancel');
    entityCalendarForm = $('.entity-calendar-form');
    entityCalendarYearField = $('input[name="calendar_year"]');
    entityCalendarMonthField = $('select[name="calendar_month"]');
    entityCalendarDayField = $('input[name="calendar_day"]');
    entityCalendarLoading = $('.entity-calendar-loading');

    if (entityCalendarAdd.length === 1) {
        entityCalendarAdd.on('click', function (e) {
            e.preventDefault();

            entityCalendarAdd.hide();
            entityCalendarForm.show();

            var defaultCalendarId = entityCalendarAdd.data('default-calendar');
            if (defaultCalendarId) {
                entityCalendarField.val(defaultCalendarId);
                entityCalendarCancel.show();
                entityCalendarSubForm.fadeIn();
                loadCalendarDates(defaultCalendarId);
            }
            return false;
        });

        entityCalendarCancel.on('click', function (e) {
            e.preventDefault();
            entityCalendarField.val(null);
            entityCalendarCancel.hide();
            calendarHideSubform();
        });
    }

    if (entityCalendarField.length === 1) {
        entityCalendarField.on('change', function () {
            entityCalendarSubForm.hide();
            // No new calendar selected? hide everything again
            if (!entityCalendarField.val()) {
                calendarHideSubform();
                return;
            }
            // Load month list
            entityCalendarYearField = $('input[name="calendar_year"]');
            entityCalendarDayField = $('input[name="calendar_day"]');
            entityCalendarMonthField = $('select[name="calendar_month"]');

            if (entityCalendarYearField.length === 0 && $('input[name="year"]').length === 1) {
                entityCalendarYearField = $('input[name="year"]');
                entityCalendarMonthField = $('select[name="month"]');
                entityCalendarDayField = $('input[name="day"]');
            }
            loadCalendarDates(entityCalendarField.val());
        });
    }
}

function registerEntityCalendarModal() {
    if ($('#entity-calendar-modal-add').length === 0) {
        return;
    }
    entityCalendarAdd = $('input[name=calendar-data-url]');
    entityCalendarField = $('select[name="calendar_id"]');
    entityCalendarYearField = $('input[name="year"]');
    entityCalendarMonthField = $('select[name="month"]');
    entityCalendarDayField = $('input[name="day"]');
    entityCalendarLoading = $('.entity-calendar-loading');
    entityCalendarSubForm = $('.entity-calendar-subform');

    entityCalendarField.on('change', function () {
        entityCalendarSubForm.hide();
        // No new calendar selected? hide everything again
        if (!entityCalendarField.val()) {
            calendarHideSubform();
            return;
        }
        // Load month list
        loadCalendarDates(entityCalendarField.val());
    });

    var defaultCalendarId = entityCalendarAdd.data('default-calendar');
    if (entityCalendarField.val()) {
        entityCalendarCancel.show();
        entityCalendarSubForm.fadeIn();
        loadCalendarDates(entityCalendarField.val());
    }
}

/**
 *
 * @param calendarID
 */
function loadCalendarDates(calendarID) {
    entityCalendarLoading.show();

    calendarID = parseInt(calendarID);
    var url = $('input[name="calendar-data-url"]').data('url').replace('/0/', '/' + calendarID + '/');
    $.ajax(url)
        .done(function (data) {
            entityCalendarYearField.html('');
            entityCalendarMonthField.html('');
            entityCalendarDayField.html('');
            let id = 1;
            $.each(data.months, function () {
                var selected = id == data.current.month ? ' selected="selected"' : '';
                entityCalendarMonthField.append('<option value="' + id + '"' + selected + '>' + this.name + '</option>');
                id++;
            });
            entityCalendarLoading.hide();
            entityCalendarSubForm.show();

            entityCalendarDayField.val(data.current.day);
            entityCalendarYearField.val(data.current.year);

            $('select[name="recurring_periodicity"] option').remove();
            $.each(data.recurring, function (key, value) {
                //console.log('moon', key, value);
                $('select[name="recurring_periodicity"]').append('<option value="' + key + '">' + value + '</option>');
            });

            $('input[name="length"]').val(1);

            // However, if there is only one result, select id.
            if (data.length === 1) {
                entityCalendarMonthField.val(data[0].id);
            }

            initSpectrum();
        });
}

/**
 *
 */
function calendarHideSubform() {
    entityCalendarForm.hide();
    entityCalendarAdd.show();
    $('input[name="calendar_day"]').val(null);
    $('input[name="calendar_month"]').val(null);
    $('input[name="calendar_year"]').val(null);
}

/**
 * Some panels can have their body toggled
 */
function registerToggablePanels() {
    toggablePanels = $('.panel-toggable');
    $.each(toggablePanels, function () {
        $(this).on('click', function () {
            $(this).parent().children('.panel-body').fadeToggle();
            var i = $(this).find('i.fa');
            if (i.hasClass('fa-caret-down')) {
                i.removeClass('fa-caret-down').addClass('fa-caret-left');
            } else {
                i.removeClass('fa-caret-left').addClass('fa-caret-down');
            }
        });

    });
}

/**
 * If we change something on a form, avoid losing data when going away.
 */
function registerUnsavedChanges() {
    var save = $('#form-submit-main');

    // Save every input change
    $(document).on('change', ':input', function () {
        window.entityFormHasUnsavedChanges = true;
    });

    if (save.length === 1) {
        // Another way to bind the event
        $(window).bind('beforeunload', function (e) {
            if (window.entityFormHasUnsavedChanges) {
                var message = save.data('unsaved');
                e.returnValue = message;
                return message;
            }
        });
    }
}

/**
 * When the entity form is submitted, we want to ajax validate the request first
 */
function registerEntityFormSubmit() {
    $('#entity-form').submit(function (e) {
        if (validEntityForm) {
            return true;
        }

        e.preventDefault();

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
            //console.log('good?');
            // If the validation succeeded, we can really submit the form
            validEntityForm = true;
            $('#entity-form').submit();
            return true;
        }).fail(function (err) {
            //console.log('error', err);
            // Reset any error fields
            $('.input-error').removeClass('input-error');
            $('.text-danger').remove();

            // If we have a 503 error status, let's assume it's from cloudflare and help the user
            // properly save their data.
            if (err.status === 503) {
                window.showToast(err.responseJSON.message, 'toast-error');
                resetEntityFormSubmitAnimation();
                return;
            }

            // If it's 403, the session is gone
            if (err.status === 403) {
                $('#entity-form-403-error').show();
                resetEntityFormSubmitAnimation();
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

            let firstItem = Object.keys(errors)[0];
            let firstItemDom = document.getElementsByName(firstItem);

            // If we can actually find the first element, switch to it and the correct tab.
            if (firstItemDom[0]) {
                firstItemDom[0].scrollIntoView({ behavior: 'smooth' });

                // Switch tabs/pane
                $('.tab-content .active').removeClass('active');
                $('.nav-tabs li.active').removeClass('active');
                let firstPane = $('[name="' + firstItem + '"').closest('.tab-pane');
                firstPane.addClass('active');
                $('a[href="#' + firstPane.attr('id') + '"]').closest('li').addClass('active');
            }

            // Reset submit buttons
            resetEntityFormSubmitAnimation();
        });
    });
}

/**
 *
 */
function resetEntityFormSubmitAnimation() {
    var submit = $('#entity-form').find('.btn-success');
    if (submit.length > 0) {
        $.each(submit, function (su) {
            $(this).removeAttr('disabled');
            if ($(this).data('reset')) {
                $(this).html($(this).data('reset'));
            }
        });
    }
}

/**
 * When the relation form is submitted, we want to ajax validate the request first
 */
function registerRelationFormSubmit() {
    $('#relation-form').submit(function (e) {
        if (validRelationForm) {
            return true;
        }

        e.preventDefault();

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
            validRelationForm = true;
            $('#relation-form').submit();
            return true;
        }).fail(function (err) {
            // Reset any error fields
            $('.input-error').removeClass('input-error');
            $('.text-danger').remove();

            // If we have a 503 error status, let's assume it's from cloudflare and help the user
            // properly save their data.
            if (err.status === 503) {
                window.showToast(err.responseJSON.message);
                resetRelationFormSubmitAnimation();
                return;
            }

            // Loop through the errors to add the class and error message
            var errors = err.responseJSON.errors;

            var errorKeys = Object.keys(errors);
            var foundAllErrors = true;
            errorKeys.forEach(function (i) {
                var errorSelector = $('[name="' + i + '"]');
                if (errorSelector.length > 0) {
                    errorSelector.addClass('input-error').parent().append('<div class="text-danger">' + errors[i][0] + '</div>');
                } else {
                    foundAllErrors = false;
                }
            });

            // Reset submit buttons
            resetRelationFormSubmitAnimation();
        });
    });
}

/**
 *
 */
function resetRelationFormSubmitAnimation() {
    var submit = $('#relation-form').find('.btn-success');
    if (submit.length > 0) {
        $.each(submit, function (su) {
            $(this).removeAttr('disabled');
            if ($(this).data('reset')) {
                $(this).html($(this).data('reset'));
            }
        });
    }
}

/**
 * Datagrid Sorter field
 */
function registerDatagridSorter() {
    $('#datagrid-simple-sorter').change(function () {
        let options = '';
        if (this.value) {
            options = this.name + '=' + this.value;
        }
        let url = $(this).data('url');
        // Remove target
        let target = null;
        if (url.includes('#')) {
            target = '#' + url.split('#')[1];
            url = url.split('#')[0];
        }
        if ($(this).data('url').includes('?')) {
            url += '&' + options;
        } else {
            url += '?' + options;
        }

        url += target;
        window.location = url;
    });
}

function registerPermissionToggler() {
    $('.permission-toggle').change(function () {
        let action = $(this).data('action');
        let selector = "input[data-action=" + action + "]";
        if ($(this).prop('checked')) {
            $(selector).prop("checked", true);
        } else {
            $(selector).prop("checked", false);
        }
    });
}

/**
 *
 */
function registerEntityNotePerms() {
    let btn = $('.entity-note-perm-add');
    if (btn.length === 0) {
        return;
    }
    registerEntityNoteDeleteEvents();

    let perm = $('select[name="permission"]');

    btn.on('click', function (ev) {
        ev.preventDefault();
        let type = $(this).data('type');
        let selected = $('select[name="' + type + '"]');

        if (!selected || !selected.val()) {
            return false;
        }

        let selectedName = selected.find(':selected')[0];
        //console.log('selected name for ', type, selectedName.text);

        // Add a block
        let body = $('#entity-note-perm-' + type + '-template').clone().removeClass('hidden').removeAttr('id');
        let html = body.html()
            .replace(/\$SELECTEDID\$/g, selected.val())
            .replace(/\$SELECTEDNAME\$/g, selectedName.text);
        body.html(html).insertBefore($('#entity-note-perm-target'));

        $('#entity-note-new-' + type).modal('toggle');

        registerEntityNoteDeleteEvents();

        // Reset the value
        selected.val('').trigger('change');
        return false;
    });
}

function registerEntityNoteDeleteEvents() {
    $.each($('.entity-note-delete-perm'), function () {
        $(this).unbind('click');
        $(this).on('click', function () {
            $(this).parent().parent().parent().parent().remove();
        });
    });
}


function initSpectrum() {
    if (!$.isFunction($.fn.spectrum)) {
        return;
    }
    $(".spectrum").spectrum({
        preferredFormat: "hex",
        showInput: true,
        showPalette: true,
        allowEmpty: true
    });
}

/*
 *
 */
function registerStoryActions() {
    let posts = $('.entity-notes .entity-content');
    $('.btn-post-collapse').unbind('click').click(function (e) {
        posts.each(function (i) {
            if ($(this).hasClass('in')) {
                $(this).removeClass('in');
                $(this).prev().find('.fa-chevron-up').hide();
                $(this).prev().find('.fa-chevron-down').show();
            }
        });
        return false;
    });

    $('.btn-post-expand').unbind('click').click(function (e) {
        posts.each(function (i) {
            if (!$(this).hasClass('in')) {
                $(this).addClass('in');
                $(this).prev().find('.fa-chevron-up').show();
                $(this).prev().find('.fa-chevron-down').hide();
            }
        });
        return false;
    });
}

/**
 * Sidebars elements can be collapsed after the page has been loaded
 */
function registerSidebarActions() {
    $('.sidebar-section-title').click(function (e) {
        if ($(this).next().hasClass('in')) {
            $(this).find('.fa-chevron-down').hide();
            $(this).find('.fa-chevron-right').show();
        } else {
            $(this).find('.fa-chevron-right').hide();
            $(this).find('.fa-chevron-down').show();
        }
    });
}

/*
 *
 */
function registerStoryLoadMore() {
    $('.story-load-more').click(function (e) {
        let btn = $(this);

        e.preventDefault();

        $('#story-more-spinner').show();
        $(this).hide();

        $.ajax({
            url: $(this).data('url')
        }).done(function (result, textStatus, xhr) {
            btn.parent().remove();
            if (result) {
                $('.entity-notes').append(result);
                registerStoryLoadMore();
                registerStoryActions();
            }
        }).fail(function (result, textStatus, xhr) {
            //console.log('modal ajax error', result);
            $('#story-more-spinner').hide();
            btn.show();
        });

        return false;
    });
}

/**
 *
 */
function registerEditWarning() {
    multiEditingModal = $('#entity-edit-warning');
    if (multiEditingModal.length === 0) {
        return;
    }

    // Don't enable keep alive until the user has confirmed
    keepAliveEnabled = false;
    multiEditingModal.modal({
        backdrop: false
    });

    // Handle clicks
    $('#entity-edit-warning-ignore').click(function (e) {
        e.preventDefault();
        confirmEditWarningModal();
        keepAliveEnabled = true;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $(this).data('url'),
            type: 'POST',
            context: this
        }).done(function (result, textStatus, xhr) {
            multiEditingModal.modal('hide');
        });
    });

    $('#entity-edit-warning-back').click(function (e) {
        e.preventDefault();
        confirmEditWarningModal();
        window.location.href = $(this).data('url');
    });
}

function confirmEditWarningModal() {
    multiEditingModal.find('.modal-body').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>')
    multiEditingModal.find('.modal-footer').hide();
}

/**
 * Set up the keep alive pulse configuration
 */
function registerEditKeepAlive() {
    let field = $('#editing-keep-alive');
    if (field.length === 0) {
        return;
    }
    keepAliveUrl = field.data('url');

    //console.log('keeping alive set up');

    setTimeout(keepAlivePulse, keepAliveTimer);
}

/**
 * Send a pulse to the backend that the user is still editing the entity
 */
function keepAlivePulse() {
    if (!keepAliveEnabled) {
        setTimeout(keepAlivePulse, keepAliveTimer);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: keepAliveUrl,
        type: 'POST'
    })
    .done(function(result) {
        //console.log('kept alive');
        setTimeout(keepAlivePulse, keepAliveTimer);
    });
}
