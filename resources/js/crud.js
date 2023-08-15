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

var oldEra;

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
    registerEraForm();
    registerFormMaintenance();
    registerEntityCalendarModal();
    registerModalLoad();
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
        registerEntityCalendarModal();
        registerEntityFormActions();
        registerFormMaintenance();
    });

    $('#campaign-delete-confirm').on('shown.bs.modal', function () {
        $('#campaign-delete-form').focus();
    });
}
//this one
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
                    if ($(this).hasClass('dropdown-toggle')) {
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

            let defaultCalendarId = $(this).data('default-calendar');
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
            if (!$(this).val()) {
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


function registerEraForm() {
    if ($('#era-form-add').length === 0) {
        return;
    }
    entityCalendarAdd = $('#era-form-add');
    let eraField = $('[name="era_id"]');

    oldEra = eraField.val();
    if (entityCalendarField.val()) {
        loadTimelineEra(eraField.val());
    }

    if (eraField.length === 1) {
        eraField.on('change', function () {
            // Load era list
            let positionField = $('select[name="position"]');
            loadTimelineEra(eraField.val());
        });
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
 * @param calendarID
 */
function loadTimelineEra(eraID) {
    eraID = parseInt(eraID);
    var url = $('input[name="era-data-url"]').data('url').replace('/0/', '/' + eraID + '/');
    var oldPosition = $('input[name="oldPosition"]').data('url');
    $.ajax(url)
        .done(function (data) {
            let eraField = $('select[name="position"]');
            eraField.html('');
            let id = 1;
            $.each(data.positions, function (i) {
                let position = data.positions[i];
                let selected = ' selected="selected"';

                if (oldPosition && !i && (oldEra == eraID)) {
                    eraField.append('<option value="" data-length="' + position.length + '" ' + selected + '>' + position + '</option>');
                }
                if (i) {
                    eraField.append('<option value="' + id + '" data-length="' + position.length + '" ' + selected + '>' + position + '</option>');
                }
                id++;
            });
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
    $('input[name="calendar_id"]').val(null);
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
                window.ajaxTooltip();
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
        $('.' + target).append('<div class="">' +
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
