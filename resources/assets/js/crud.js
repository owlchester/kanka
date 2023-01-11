/**
 * Crud
 */

import ajaxModal from "./components/ajax-modal";

var entityFormActions;

// Entity Calendar
var entityCalendarAdd, entityCalendarForm, entityCalendarField;
var entityCalendarMonthField, entityCalendarYearField, entityCalendarDayField;
var entityCalendarCancel, entityCalendarLoading, entityCalendarSubForm;
var entityCalendarModalForm;

var entityName;

var validEntityForm = false, validRelationForm = false;

$(document).ready(function () {

    registerDynamicRows();

    ajaxModal();

    registerEntityFormActions();
    registerUnsavedChanges();

    entityName = $('#form-entry input[name="name"]');
    if (entityName.length === 1) {
        registerEntityNameCheck();
    }

    registerFormSubmitAnimation();
    registerEntityCalendarForm();
    registerEntityFormSubmit();
    registerEntityCalendarModal();
    registerModalLoad();
    registerDatagridSorter();
    registerPermissionToggler();
    registerStoryActions();
    registerStoryLoadMore();
    registerSidebarActions();
    registerTrustDomain();
    registerPrivacyToggle();
});

/**
 * Re-register any events that need to be binded when a modal is loaded
 */
function registerModalLoad() {
    $(document).on('shown.bs.modal shown.bs.popover', function () {
        registerRelationFormSubmit();
        registerEntityCalendarModal();
        registerEntityFormActions();
    });
}

function registerEntityNameCheck() {
    if (entityName.data('live-disabled')) {
        return;
    }
    entityName.focusout(function () {
        // Don't bother if the user didn't set any value
        if (!$(this).val()) {
            return;
        }
        let entityCreatorDuplicateWarning = $('.duplicate-entity-warning');
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
                    .filter(function (k) { return !currentEntityID || currentEntityID != res[k].id; })
                    .map(function (k) { return '<a href="' + res[k].url + '">' + res[k].name + '</a>'; });

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
function registerEntityFormActions() {
    // Return early if there are no elements in the page to be handled
    entityFormActions = $('.form-submit-actions');
    if (entityFormActions.length === 0) {
        return;
    }
    //console.log('RegisterEntityFormActions', entityFormActions);
    let entityFormMainButton = $('#form-submit-main');
    let entityFormSubmitMode = $('#submit-mode');
    if (entityFormSubmitMode === undefined) {
        throw new Error("No submit mode hidden input found");
    }

    // Register click on each sub action
    $.each(entityFormActions, function () {
        $(this).unbind('click').on('click', function () {
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
                            .prop('disabled', true)
                            .data('reset', true)
                            .find('span').hide()
                            .parent().find('.spinner').show();
                    }
                });

                // Inject the selected option for the "workflow" (submit-action)
                $(this).append('<input type="hidden" name="' + $('#form-submit-main').attr('name') + '" />');
            }

            return true;
        });
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
    entityCalendarDayField = $('select[name="calendar_day"]');
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
            entityCalendarMonthField = $('select[name="calendar_month"]');
            entityCalendarDayField = $('select[name="calendar_day"]');

            if (entityCalendarYearField.length === 0 && $('input[name="year"]').length === 1) {
                entityCalendarYearField = $('input[name="year"]');
                entityCalendarMonthField = $('select[name="month"]');
                entityCalendarDayField = $('input[name="day"]');
            }
            loadCalendarDates(entityCalendarField.val());
        });
    }

    registerMonthChange();
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

    //var defaultCalendarId = entityCalendarAdd.data('default-calendar');
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
            let selectedDay = entityCalendarDayField.val();
            entityCalendarYearField.html('');
            entityCalendarMonthField.html('');
            entityCalendarDayField.html('');
            let id = 1;
            let monthLength = 1;
            if (!selectedDay) {
                selectedDay = data.current.day;
            }
            let currentMonth = parseInt(data.current.month);
            $.each(data.months, function (i) {
                let month = data.months[i];
                let selected = id === currentMonth ? ' selected="selected"' : '';
                entityCalendarMonthField.append('<option value="' + id + '" data-length="' + month.length + '" ' + selected + '>' + this.name + '</option>');

                if (id === currentMonth) {
                    monthLength = month.length;
                }
                id++;
            });

            for (let d = 1; d < monthLength; d++) {
                let selected = d == selectedDay ? ' selected="selected"' : '';
                entityCalendarDayField.append('<option value="' + d + '" ' + selected + '>' + d + '</option>');
            }
            entityCalendarLoading.hide();
            entityCalendarSubForm.show();

            //entityCalendarDayField.val(data.current.day);
            entityCalendarYearField.val(data.current.year);

            $('select[name="calendar_recurring_periodicity"] option').remove();
            $.each(data.recurring, function (key, value) {
                //console.log('moon', key, value);
                $('select[name="calendar_recurring_periodicity"]').append('<option value="' + key + '">' + value + '</option>');
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
function registerEntityFormSubmit() {
    $('form[data-maintenance="1"]').submit(function (e) {
        if (validEntityForm) {
            return true;
        }

        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function () {
            //console.log('good?');
            // If the validation succeeded, we can really submit the form
            validEntityForm = true;
            $('form[data-maintenance="1"]').submit();
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
    var submit = $('form[data-maintenance="1"]').find('.btn-success');
    if (submit.length > 0) {
        $.each(submit, function () {
            $(this).removeAttr('disabled');
            if ($(this).data('reset')) {
                $(this).find('.spinner').hide()
                    .parent().find('span').show();
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

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function () {
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
        $.each(submit, function () {
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

/**
 * Expand/Collapse all posts on the overview of an entity
 */
function registerStoryActions() {
    let posts = $('.entity-story-block .collapse');
    let togglers = $('.entity-story-block .element-toggle');
    $('.btn-post-collapse').unbind('click').click(function () {
        posts.collapse('hide');
        togglers.addClass('collapsed');
        return false;
    });

    $('.btn-post-expand').unbind('click').click(function () {
        posts.collapse('show');
        togglers.removeClass('collapsed');
        /*posts.each(function () {
            let body = $(this).find('.entity-content');
            if (!body.hasClass('in')) {
                body.addClass('in');
                body.prev().find('.fa-chevron-up').show();
                body.prev().find('.fa-chevron-down').hide();
                body.css('height', '');
            }
            let header = $(this).find('.post-toggle');
            if (header.hasClass('collapsed')) {
                header.removeClass('collapsed');
            }
        });*/
        return false;
    });
}

/**
 * Sidebars (right-side profile) elements can be collapsed after the page has been loaded
 */
function registerSidebarActions() {
    $('.sidebar-section-title').click(function () {
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
        }).done(function (result) {
            btn.parent().remove();
            if (result) {
                $('.entity-posts').append(result);
                registerStoryLoadMore();
                registerStoryActions();
            }
        }).fail(function () {
            //console.log('modal ajax error', result);
            $('#story-more-spinner').hide();
            btn.show();
        });

        return false;
    });
}



function registerTrustDomain() {
    $('.domain-trust').click(function () {
        let cookieName = 'kanka_trusted_domains';

        let keyValue = document.cookie.match('(^|;) ?' + cookieName + '=([^;]*)(;|$)');
        keyValue = keyValue ? keyValue[2] : '';

        // If not yet in it
        let newDomain = $(this).data('domain');
        if (!keyValue.includes(newDomain)) {
            if (keyValue) {
                keyValue += '|';
            }
            keyValue += newDomain;
        }

        let expires = new Date();
        expires.setTime(expires.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = cookieName + '=' + keyValue + ';expires=' + expires.toUTCString() + ';sameSite=Strict';
    });
}

/**
 * Register a listened to add dynamic rows in the forms
 * Used in the calendar forms extensivly
 */
function registerDynamicRows() {
    $('.dynamic-row-add').on('click', function(e) {
        e.preventDefault();

        let target = $(this).data('target');
        let template = $(this).data('template');
        //console.log('target', target, $('.' + target));
        //console.log('template', template, $('#' + template));
        $('.' + target).append('<div class="form-group">' +
            $('#' + template).html() +
            '</div>');

        registerDynamicRowDelete();
        return false;
    });
    registerDynamicRowDelete();
}

/**
 * Register a listener to delete a dynamically added row in the forms
 */
function registerDynamicRowDelete() {
    $.each($('.dynamic-row-delete'), function () {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function (e) {
            e.preventDefault();
            $(this).closest('.parent-delete-row').remove();
        });
    });
}

/**
 * Show a warning when the entity is set to private
 */
function registerPrivacyToggle() {
    $('input[data-toggle="entity-privacy"]').change(function () {
        let selector = $('#entity-is-private');
        if ($(this).prop('checked')) {
            selector.show();
        } else {
            selector.hide();
        }
    });
}

/**
 * Fire an event whenever the month field is changed
 */
function registerMonthChange() {
    $('select[name="calendar_month"]').change(function () {
        let length = $(this).find(':selected').data('length');
        rebuildCalendarDayList(length);
    });
}

/**
 * Rebuild the calendar day select, and select the current date
 * @param max
 */
function rebuildCalendarDayList(max) {
    let selectedDay = entityCalendarDayField.val();
    if (selectedDay > max) {
        selectedDay = max;
    }

    entityCalendarDayField.html('');
    for (let d = 1; d <= max; d++) {
        let selected = d == selectedDay ? ' selected="selected"' : '';
        entityCalendarDayField.append('<option value="' + d + '" ' + selected + '>' + d + '</option>');
    }
}
