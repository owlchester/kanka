import Sortable from "sortablejs";

var calendarAddMonth, calendarLeapYear;
var calendarYearSwitcher, calendarYearSwitcherField, calendarEventModal;
var reminderFormValid = false, reminderForm;
$(document).ready(function() {
    // Form
    calendarLeapYear = $('input[name="has_leap_year"]');

    initCalendarForm();

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

    registerKeyboardShortcuts();
});

/**
 * Initialize the calendar
 */
function initCalendarForm() {
    $('.calendar-add-template').on('click', function(e) {
        console.log('what');
        e.preventDefault();

        let target = $(this).data('target');
        let template = $(this).data('template');
        $(target).append('<div class="form-group">' +
            $(template).html() +
        '</div>');

        // Handle deleting already loaded blocks
        calendarDeleteRowHandler();

        return false;
    });


    // Handle deleting already loaded points
    calendarDeleteRowHandler();
}

function calendarDeleteRowHandler() {
    $.each($('.month-delete'), function () {
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

    // Re-init the sortable elements
    window.initSortable();
}

function initCalendarEventBlock() {
    $('.calendar-event-block').each(function() {
        if ($(this).data('toggle') !== 'ajax-modal' && $(this).data('url')) {
            $(this).click(function () {
                window.location = $(this).data('url');
            });
        }
    });
}

function initCalendarEventModal() {
    $('select[name="recurring_periodicity"]').change(function () {
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
        }).done(function () {
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

/**
 * Register keyboard shortcuts for previous/next view
 */
function registerKeyboardShortcuts() {
    $(document).bind('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.which === 37) {
            $('[data-shortcut="previous"]').addClass('loading')[0].click();
        } else if ((e.ctrlKey || e.metaKey) && e.which === 39) {
            $('[data-shortcut="next"]').addClass('loading')[0].click();
        }

    });

}
