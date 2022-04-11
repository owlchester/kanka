var calendarAddMonth, calendarAddWeekday, calendarAddYear, calendarTemplateMonth, calendarTemplateWeekday, calendarTemplateYear, calendarLeapYear;
var calendarAddMoon, calendarTemplateMoon;
var calendarAddSeason, calendarTemplateSeason;
var calendarWeek, calendarTemplateWeek;
var calendarAddEpoch, calendarTemplateEpoch;
var calendarAddIntercalary, calendarTemplateIntercalary, calendarSortIntercalary;
var calendarYearSwitcher, calendarYearSwitcherField, calendarEventModal;
var calendarSortMonths, calendarSortWeekdays, calendarSortYears, calendarSortMoons, calendarSortSeasons, calendarSortEpochs;
var reminderFormValid = false, reminderForm;
$(document).ready(function() {
    // Form
    calendarAddMonth = $('#add_month');
    if (calendarAddMonth.length === 1) {
        calendarAddWeekday = $('#add_weekday');
        calendarAddYear = $('#add_year');
        calendarAddMoon = $('#add_moon');
        calendarAddSeason = $('#add_season');
        calendarAddEpoch = $('#add_epoch');
        calendarAddIntercalary = $('#add_intercalary');
        calendarAddWeek = $('#add_week');
        calendarTemplateMonth = $('#template_month');
        calendarTemplateWeekday = $('#template_weekday');
        calendarTemplateYear = $('#template_year');
        calendarTemplateMoon = $('#template_moon');
        calendarTemplateSeason = $('#template_season');
        calendarTemplateEpoch = $('#template_epoch');
        calendarTemplateIntercalary = $('#template_intercalary');
        calendarTemplateWeek = $('#template_week');
        calendarLeapYear = $('input[name="has_leap_year"]');

        calendarSortMonths = $(".calendar-months");
        calendarSortWeekdays = $(".calendar-weekdays");
        calendarSortYears = $(".calendar-years");
        calendarSortMoons = $(".calendar-moons");
        calendarSortSeasons = $(".calendar-seasons");
        calendarSortEpochs = $(".calendar-epochs");
        calendarSortIntercalary = $(".calendar-intercalaries");

        initCalendarForm();
    }

    // View
    calendarYearSwitcher = $('#calendar-year-switcher');
    if (calendarYearSwitcher.length === 1) {
        calendarYearSwitcherField = $('#calendar-year-switcher-field');
        calendarEventModal = $('#add-calendar-event');

        initCalendarEventBlock();
    }


    $(document).on('shown.bs.modal', function() {
        initCalendarEventModal();
    });
    if ($('select[name="recurring_periodicity"]').length === 1) {
        initCalendarEventModal();
    }
});

/**
 * Initialize the calendar
 */
function initCalendarForm() {
    calendarAddMonth.on('click', function(e) {
        e.preventDefault();

        $(this).before('<div class="form-group">' +
            calendarTemplateMonth.html() +
        '</div>');

        // Handle deleting already loaded blocks
        calendarDeleteRowHandler();

        return false;
    });

    calendarAddWeekday.on('click', function(e) {
        e.preventDefault();

        $(this).before('<div class="form-group">' +
            calendarTemplateWeekday.html() +
            '</div>');


        // Handle deleting already loaded blocks
        calendarDeleteRowHandler();

        return false;
    });

    calendarAddYear.on('click', function(e) {
        e.preventDefault();

        $(this).before('<div class="form-group">' +
            calendarTemplateYear.html() +
            '</div>');


        // Handle deleting already loaded blocks
        calendarDeleteRowHandler();

        return false;
    });

    calendarLeapYear.on('click', function() {
        $('#calendar-leap-year').toggle();
    });

    calendarAddMoon.on('click', function(e) {
        e.preventDefault();

        $(this).before('<div class="form-group">' +
            calendarTemplateMoon.html() +
            '</div>');

        // Handle deleting already loaded blocks
        calendarDeleteRowHandler();

        return false;
    });


    calendarAddSeason.on('click', function(e) {
        e.preventDefault();

        $(this).before('<div class="form-group">' +
            calendarTemplateSeason.html() +
            '</div>');

        // Handle deleting already loaded blocks
        calendarDeleteRowHandler();

        return false;
    });

    calendarAddIntercalary.on('click', function(e) {
        e.preventDefault();

        $(this).before('<div class="form-group">' +
            calendarTemplateIntercalary.html() +
            '</div>');

        // Handle deleting already loaded blocks
        calendarDeleteRowHandler();

        return false;
    });

    calendarAddWeek.on('click', function(e) {
        e.preventDefault();

        $(this).before('<div class="form-group">' +
            calendarTemplateWeek.html() +
            '</div>');

        // Handle deleting already loaded blocks
        calendarDeleteRowHandler();

        return false;
    });


    // Handle deleting already loaded points
    calendarDeleteRowHandler();
}

function calendarDeleteRowHandler() {
    $.each($('.month-delete'), function (index) {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function(e) {
            if ($(this).data('remove') === 4) {
                $(this).parent().parent().parent().parent().remove();
            } else {
                $(this).parent().parent().parent().remove();
            }
            e.preventDefault();
            return false;
        });
    });

    calendarSortMonths.sortable();
    calendarSortWeekdays.sortable();
    calendarSortYears.sortable();
    calendarSortMoons.sortable();
    calendarSortSeasons.sortable();
    calendarSortIntercalary.sortable();
    //calendarSortWeek.sortable();
}

function initCalendarEventBlock() {
    $('.calendar-event-block').each(function() {
        if ($(this).data('toggle') !== 'ajax-modal' && $(this).data('url')) {
            $(this).click(function (e) {
                window.location = $(this).data('url');
            });
        }
    });
}

function initCalendarEventModal() {
    $('select[name="recurring_periodicity"]').change(function (e) {
        if (this.value) {
            $('#add_event_recurring_until').show();
        } else {
            $('#add_event_recurring_until').hide();
        }
    });

    $('#calendar-action-existing').click(function(e) {
        e.preventDefault();
        $('#calendar-event-first').hide();
        $('.calendar-new-event-field').hide();
        $('#calendar-event-subform').fadeToggle();
        $('#calendar-event-submit').toggle();
    });

    $('#calendar-action-new').click(function(e) {
        e.preventDefault();
        $('#calendar-event-first').hide();
        $('.calendar-existing-event-field').hide();
        $('#calendar-event-subform').fadeToggle();
        $('#calendar-event-submit').toggle();
    });

    $('#calendar-event-switch').click(function(e) {
        e.preventDefault();
        $('#calendar-event-subform').hide();
        $('#calendar-event-first').fadeToggle();
        $('.calendar-existing-event-field').show();
        $('.calendar-new-event-field').show();

        $('#calendar-event-submit').toggle();

    });

    $('form.ajax-validation').unbind('submit').on('submit', function (e) {
        reminderForm = $(this);
        if (reminderFormValid) {
            return true;
        }

        e.preventDefault();

        $(this).find('.btn-success').prop('disabled', true);
        $(this).find('.btn-success span').hide();
        $(this).find('.btn-success i.fa').show();

        // Allow ajax requests to use the X_CSRF_TOKEN for deletes
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (res) {
            // If the validation succeeded, we can really submit the form
            reminderFormValid = true;
            reminderForm.submit();
        }).fail(function (err) {
            //console.log('error', err);
            // Reset any error fields
            reminderForm.find('.input-error').removeClass('input-error');
            reminderForm.find('.text-danger').remove();

            // If we have a 503 error status, let's assume it's from cloudflare and help the user
            // properly save their data.
            if (err.status === 503) {
                window.showToast(err.responseJSON.message, 'toast-error');
                resetReminderAnimation();
                return;
            }

            // If it's 403, the session is gone
            if (err.status === 403) {
                $('#entity-form-403-error').show();
                resetReminderAnimation();
            }

            // Loop through the errors to add the class and error message
            let errors = err.responseJSON.errors;

            let errorKeys = Object.keys(errors);
            let foundAllErrors = true;
            errorKeys.forEach(function (i) {
                let errorSelector = $('[name="' + i + '"]');
                //console.log('error field', '[name="' + i + '"]');
                if (errorSelector.length > 0) {
                    reminderForm.find('[name="' + i + '"]').addClass('input-error')
                        .parent()
                        .append('<div class="text-danger">' + errors[i][0] + '</div>');
                } else {
                    foundAllErrors = false;
                }
            });

            let firstItem = Object.keys(errors)[0];
            let firstItemDom = reminderForm.find('[name="' + firstItem + '"]');

            // If we can actually find the first element, switch to it and the correct tab.
            if (firstItemDom.length > 0) {
                firstItemDom.focus();
            }

            //console.log('reset stuff');
            resetReminderAnimation();
        });

        return false;
    });
}

function resetReminderAnimation() {
    reminderForm.find('.btn-success i.fa').hide();
    reminderForm.find('.btn-success span').show();
    reminderForm.find('.btn-success').prop('disabled', false);
}
