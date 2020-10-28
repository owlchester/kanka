/**
 * Crud
 */

import select2 from './components/select2.js';

// Character
var characterAddPersonality, characterTemplatePersonality;
var characterAddAppearance, characterTemplateAppearance;
var characterSortPersonality, characterSortAppearance;
var entityFormActions, entityFormDefaultAction;
var characterAddOrganisation, characterTemplateOrganisation, characterOrganisations;

var filtersActionsShow, filtersActionHide;

var ajaxModalTarget;
var entityFormHasUnsavedChanges = false;

// Entity Calendar
var entityCalendarAdd, entityCalendarForm, entityCalendarField;
var entityCalendarMonthField, entityCalendarYearField, entityCalendarDayField;
var entityCalendarCancel, entityCalendarLoading, entityCalendarSubForm;
var entityCalendarModalField, entityCalendarModalForm;

var entityName;

var toggablePanels;

var validEntityForm = false, validRelationForm = false;

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

    $.each($('[data-toggle="ajax-modal"]'), function () {
        $(this).click(function (e) {
            e.preventDefault();
            ajaxModalTarget = $(this).attr('data-target');
            $.ajax({
                url: $(this).attr('data-url')
            }).done(function (result, textStatus, xhr) {
                if (result) {
                    $(ajaxModalTarget).find('.modal-content').html(result);
                    $(ajaxModalTarget).modal();
                }
            }).fail(function (result, textStatus, xhr) {
                //console.log('modal ajax error', result);
            });
            return false;
        });
    });

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
});

/**
 * Re-register any events that need to be binded when a modal is loaded
 */
function registerModalLoad() {
    $(document).on('shown.bs.modal shown.bs.popover', function() {
        registerRelationFormSubmit();
        registerEntityCalendarModal();
    });
}

function registerEntityNameCheck() {
    entityName.focusout(function(e) {
        // Don't bother if the user didn't set any value
        if (!$(this).val()) {
            return;
        }
        var entityCreatorDuplicateWarning = $('.duplicate-entity-warning');
        let currentEntityID = $(this).data('id');
        entityCreatorDuplicateWarning.hide();
        // Check if an entity of the same type already exists, and warn when it does.
        $.ajax(
            $(this).data('live') + '?q=' + $(this).val() + '&type=' + $(this).data('type')
        ).done(function (res) {
            if (res.length > 0) {
                let entities = Object.keys(res)
                    // Filter out what isn't itself
                    .filter(function (k) { return !currentEntityID || currentEntityID != res[k].id })
                    .map(function (k) { return '<a href="' + res[k].url + '">' + res[k].name + '</a>'})


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
function initCharacterPersonality()
{
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
function initCharacterAppearance()
{
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
function initCharacterOrganisation()
{
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
function characterDeleteRowHandler()
{
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
    select2();
}

/**
 *
 */
function registerPrivateCheckboxes()
{
    $.each($('[data-toggle="private"]'), function () {
        // Add the title first
        if ($(this).hasClass('fa-lock')) {
            $(this).prop('title', $(this).data('private'));
        } else {
            $(this).prop('title', $(this).data('public'));
        }

        // On click toggle
        $(this).click(function(e) {
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
function registerEntityFormActions()
{
    entityFormDefaultAction = $('#form-submit-main');
    // Register click on each sub action
    $.each(entityFormActions, function () {
        $(this).on('click', function () {
            entityFormDefaultAction
                .attr('name', $(this).data('action'))
                .click();
                // .prop('disabled', true);

            return false;
        });
    });
}

/**
 * On all forms, we want to animate the submit button when it's clicked.
 */
function registerFormSubmitAnimation()
{
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

function registerEntityCalendarForm()
{
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

function registerEntityCalendarModal()
{
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
function loadCalendarDates(calendarID)
{
    entityCalendarLoading.show();

    calendarID = parseInt(calendarID);
    var url = $('input[name="calendar-data-url"]').data('url').replace('/0/', '/' + calendarID + '/');
    $.ajax(url)
    .done(function (data) {
        entityCalendarYearField.html('');
        entityCalendarMonthField.html('');
        entityCalendarDayField.html('');
        var id = 1;
        $.each(data.months, function () {
            var selected = id == data.current.month ? ' selected="selected"' : '';
            entityCalendarMonthField.append('<option value="' + id + '"' + selected + '>' + this.name + '</option>');
            id++;
        });
        entityCalendarLoading.hide();
        entityCalendarSubForm.show();

        entityCalendarDayField.val(data.current.day);
        entityCalendarYearField.val(data.current.year);
        $('input[name="length"]').val(1);

        // However, if there is only one result, select id.
        if (data.length === 1) {
            entityCalendarMonthField.val(data[0].id);
        }
    });
}

/**
 *
 */
function calendarHideSubform()
{
    entityCalendarForm.hide();
    entityCalendarAdd.show();
    $('input[name="calendar_day"]').val(null);
    $('input[name="calendar_month"]').val(null);
    $('input[name="calendar_year"]').val(null);
}

/**
 * Some panels can have their body toggled
 */
function registerToggablePanels()
{
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
function registerUnsavedChanges()
{
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
function registerEntityFormSubmit()
{
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
                $('#entity-form-503-error').show();
                resetEntityFormSubmitAnimation();
            }

            // If it's 403, the session is gone
            if (err.status === 403) {
                $('#entity-form-403-error').show();
                resetEntityFormSubmitAnimation();
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

            // If not all error fields could be found, show a generic error message on top of the form.
            if (!foundAllErrors) {
                $('#entity-form-generic-error').show();
            }

            var firstItem = Object.keys(errors)[0];
            var firstItemDom = document.getElementsByName(firstItem);

            // If we can actually find the first element, switch to it and the correct tab.
            if (firstItemDom[0]) {
                firstItemDom[0].scrollIntoView({behavior: 'smooth'});

                // Switch tabs/pane
                $('.tab-content .active').removeClass('active');
                $('.nav-tabs li.active').removeClass('active');
                var firstPane = $('[name="' + firstItem + '"').closest('.tab-pane');
                firstPane.addClass('active');
                $('a[href="#'+ firstPane.attr('id') + '"]').closest('li').addClass('active');
            }

            // Reset submit buttons
            resetEntityFormSubmitAnimation();
        });
    });
}

/**
 *
 */
function resetEntityFormSubmitAnimation()
{
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
function registerRelationFormSubmit()
{
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
                $('#entity-form-503-error').show();
                resetRelationFormSubmitAnimation();
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
function resetRelationFormSubmitAnimation()
{
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
        var options = '';
        if (this.value) {
            options = this.name + '=' + this.value;
        }
        window.location = $(this).data('url') + ($(this).data('url').includes('?') ? '&' : '?') + options;
    });
}

function registerPermissionToggler()
{
    $('.permission-toggle').change(function() {
        let action = $(this).data('action');
        let selector = "input[data-action=" + action + "]";
        if ($(this).prop('checked')) {
            $(selector).prop("checked", true);
        } else {
            $(selector).prop("checked", false);
        }
    });
}
