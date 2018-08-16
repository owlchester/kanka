var calendarAddMonth, calendarAddWeekday, calendarAddYear, calendarTemplateMonth, calendarTemplateWeekday, calendarTemplateYear, calendarLeapYear;
var calendarYearSwitcher, calendarEventModal;
var calendarSortMonths, calendarSortWeekdays, calendarSortYears;

$(document).ready(function() {
    calendarAddMonth = $('#add_month');
    calendarAddWeekday = $('#add_weekday');
    calendarAddYear = $('#add_year');
    calendarTemplateMonth = $('#template_month');
    calendarTemplateWeekday = $('#template_weekday');
    calendarTemplateYear = $('#template_year');
    calendarLeapYear = $('input[name="has_leap_year"]');
    calendarYearSwitcher = $('#calendar-year-switcher');
    calendarEventModal = $('#add-calendar-event');

    calendarSortMonths = $(".calendar-months");
    calendarSortWeekdays = $(".calendar-weekdays");
    calendarSortYears = $(".calendar-years");

    if (calendarAddMonth.length === 1) {
        initCalendar();
    }

    if (calendarYearSwitcher.length === 1) {
        initCalendarYearSwitcher();
        initCalendarEventModal();
    }
});

/**
 * Initialize the calendar
 */
function initCalendar() {
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


    // Handle deleting already loaded points
    calendarDeleteRowHandler();
}

function calendarDeleteRowHandler() {
    $.each($('.month-delete'), function (index) {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function(e) {
            $(this).parent().parent().remove();
            e.preventDefault();
        });
    });

    calendarSortMonths.sortable();
    calendarSortWeekdays.sortable();
    calendarSortYears.sortable();
}

function initCalendarYearSwitcher() {
    calendarYearSwitcher.on('change', function() {
        var option = $(this).find(':selected').val();
        if (option) {
            window.location = option;
        }
    });
}

function initCalendarEventModal() {
    $.each($('.add'), function() {
        $(this).on('click', function(e) {
            e.preventDefault();
            calendarEventModal.modal();

            // Prepare date field
            $('#date').val($(this).attr('data-date'));
        });
    });

    $('input[name="is_recurring"]').on('click', function(e) {
        $('#add_event_recurring_until').toggle();
    })
}