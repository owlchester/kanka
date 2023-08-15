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
}

/**
 * Register keyboard shortcuts for previous/next view
 */
function registerKeyboardShortcuts() {
    if ($('[data-shortcut="previous"]').length === 0) {
        return;
    }
    $(document).bind('keydown', function(e) {
        // Ctrl + <- for previous, Ctrl + -> for next
        if ((e.ctrlKey || e.metaKey) && e.which === 37) {
            $('[data-shortcut="previous"]').addClass('loading')[0].click();
        } else if ((e.ctrlKey || e.metaKey) && e.which === 39) {
            $('[data-shortcut="next"]').addClass('loading')[0].click();
        }

    });

}
