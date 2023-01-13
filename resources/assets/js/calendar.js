var calendarYearSwitcher, calendarYearSwitcherField, calendarEventModal;
var reminderFormValid = false, reminderForm;
$(document).ready(function() {
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

    /*$('form.ajax-validation').unbind('submit').on('submit', function (e) {
        reminderForm = $(this);
        if (reminderFormValid) {
            return true;
        }

        e.preventDefault();

        $(this).find('.btn-success')
            .prop('disabled', true)
            .addClass('loading');

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            context: this,
        }).done(function () {
            // If the validation succeeded, we can really submit the form
            reminderFormValid = true;
            reminderForm.submit();
        }).fail(function (err) {
            window.formErrorHandler(err, this);
        });

        return false;
    });*/
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
