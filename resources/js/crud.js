/**
 * Crud
 */

import ajaxModal from "./components/ajax-modal";

var entityFormActions;

// Entity Calendar
var entityCalendarAdd, entityCalendarForm, entityCalendarField, entityCalendarHiddenField;
var entityCalendarMonthField, entityCalendarYearField, entityCalendarDayField;
var entityCalendarCancel, entityCalendarLoading, entityCalendarSubForm;
var entityCalendarModalForm;

var entityName;

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
    registerFormMaintenance();
    registerEntityCalendarModal();
    registerModalLoad();
    registerPermissionToggler();
    registerStoryActions();
    registerStoryLoadMore();
    registerTrustDomain();
    registerPrivacyToggle();
});

/**
 * Re-register any events that need to be binded when a modal is loaded
 */
function registerModalLoad() {
    $(document).on('shown.bs.modal shown.bs.popover', function () {
        registerEntityCalendarModal();
        registerEntityFormActions();
        registerFormMaintenance();
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
        let block = $(this).data('duplicate');
        let entityCreatorDuplicateWarning = $(block);
        let url = $(this).data('live') +
            '?q=' + encodeURIComponent($(this).val()) +
            '&type=' + $(this).data('type') +
            '&exclude=' + $(this).data('id');
        entityCreatorDuplicateWarning.hide();
        const field = entityCreatorDuplicateWarning.find('.duplicates');

        // Check if an entity of the same type already exists, and warn when it does.
        fetch(url)
            .then((response) => response.json())
            .then((res) => {
                field.innerHTML = '';
                res.forEach(entity => {
                    let link = document.createElement('a');
                    link.href = entity.url;
                    link.text = entity.name;
                    field.append(link);
                });
                if (res.length > 0) {
                    entityCreatorDuplicateWarning.show();
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
    let entityFormMainButton = $('#form-submit-main');
    let entityFormSubmitMode = $('#submit-mode');
    if (entityFormSubmitMode === undefined) {
        throw new Error("No submit mode hidden input found");
    }

    // Register click on each sub action
    $.each(entityFormActions, function () {
        if ($(this).data('loaded') === 1) {
            return;
        }
        $(this).data('loaded', 1);

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
            var submit = $(this).find('.btn-primary');
            if (submit.length > 0) {
                $.each(submit, function () {
                    if ($(this).parent().hasClass('dropdown') || $(this).hasClass('quick-creator-subform')) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this)
                            .prop('disabled', true)
                            .addClass('loading');
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
    entityCalendarField = $('select[name="calendar_id"]');
    entityCalendarHiddenField = $('input[name="calendar_id"]'); // Campaigns with a single calendar
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

            let defaultCalendarId = $(this).data('default-calendar');
            if (defaultCalendarId) {
                entityCalendarHiddenField.val(defaultCalendarId);
                entityCalendarCancel.show();
                entityCalendarSubForm.show();
                loadCalendarDates(defaultCalendarId);
            }
            return false;
        });

        entityCalendarCancel.on('click', function (e) {
            e.preventDefault();
            entityCalendarField.val(null);
            entityCalendarHiddenField.val(null);
            entityCalendarCancel.hide();
            calendarHideSubform();
        });
    }

    if (entityCalendarField.length === 1) {
        entityCalendarField.on('change', function () {
            entityCalendarSubForm.hide();
            // No new calendar selected? hide everything again
            if (!$(this).val()) {
                calendarHideSubform();
                return false;
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
        entityCalendarSubForm.show();
        loadCalendarDates(entityCalendarField.val());
    }

    $('.entity-calendar-subform input[name="length"]').focusout(function () {
        if (!$(this).val()) {
            return;
        }
        let url = $(this).data('url').replace('/0/', '/' + entityCalendarField.val() + '/')

        let params = {
            day: entityCalendarDayField.val(),
            month: entityCalendarMonthField.val(),
            year: entityCalendarYearField.val(),
            length: $(this).val(),
        }

        $.ajax(url, {data: params}).done(function (data) {
            if (data.overflow == true) {
                $('.length-warning').show();
            } else {
                $('.length-warning').hide();
            }
        });
    });
}




/**
 *
 * @param calendarID
 */
const loadCalendarDates = (calendarID) => {
    entityCalendarLoading.show();

    calendarID = parseInt(calendarID);
    var url = $('input[name="calendar-data-url"]').data('url').replace('/0/', '/' + calendarID + '/');
    fetch(url)
        .then((response) => response.json())
        .then(data => {
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

            // Put new options
            $('select.reminder-periodicity option').remove();
            $.each(data.recurring, function (key, value) {
                //console.log('moon', key, value);
                $('select.reminder-periodicity').append('<option value="' + key + '">' + value + '</option>');
            });

            $('input[name="length"]').val(1);

            // However, if there is only one result, select id.
            if (data.length === 1) {
                entityCalendarMonthField.val(data[0].id);
            }
        });
};


/**
 *
 */
function calendarHideSubform() {
    entityCalendarForm.hide();
    entityCalendarAdd.show();

    $('input[name="calendar_day"]').val(null);
    $('input[name="calendar_month"]').val(null);
    $('input[name="calendar_year"]').val(null);
    $('select[name="calendar_id"]').val(null);
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
    $('.btn-post-collapse').unbind('click').click(function () {
        let elements = document.querySelectorAll('.element-toggle');
        elements.forEach((e) => {
            e.classList.add('animate-collapsed');
            let target = document.querySelector(e.dataset.target);
            target.classList.add('hidden');
        });
        return false;
    });

    $('.btn-post-expand').unbind('click').click(function () {
        let elements = document.querySelectorAll('.element-toggle');
        elements.forEach((e) => {
            e.classList.remove('animate-collapsed');
            let target = document.querySelector(e.dataset.target);
            target.classList.remove('hidden');
        });
        return false;
    });
}

/*
 *
 */
function registerStoryLoadMore() {
    $('.story-load-more').click(function (e) {
        e.preventDefault();
        let btn = $(this);

        $(this).addClass('loading');

        fetchMorePosts($(this).data('url'))
            .then(result => {
                btn.parent().remove();
                $('.entity-posts').append(result);
                registerStoryLoadMore();
                registerStoryActions();
                $(document).trigger('shown.bs.modal');
            })
            .catch(() => {
                btn.removeClass('loading');
            });
        return false;
    });
}

async function fetchMorePosts(url) {
    const result = await fetch(url);
    return await result.text();
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
        $('.' + target).append('<div class="">' +
            $('#' + template).html() +
            '</div>');

        registerDynamicRowDelete();
        $(document).trigger('shown.bs.modal');
        return false;
    });
    registerDynamicRowDelete();
}

/**
 * Register a listener to delete a dynamically added row in the forms
 */
function registerDynamicRowDelete() {
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
