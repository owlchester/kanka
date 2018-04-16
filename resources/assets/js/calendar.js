var calendarAddMonth, calendarAddWeekday, calendarAddYear, calendarTemplateMonth, calendarTemplateWeekday, calendarTemplateYear, calendarLeapYear;
var calendarYearSwitcher;

$(document).ready(function() {
    calendarAddMonth = $('#add_month');
    calendarAddWeekday = $('#add_weekday');
    calendarAddYear = $('#add_year');
    calendarTemplateMonth = $('#template_month');
    calendarTemplateWeekday = $('#template_weekday');
    calendarTemplateYear = $('#template_year');
    calendarLeapYear = $('input[name="has_leap_year"]');
    calendarYearSwitcher = $('#calendar-year-switcher');

    if (calendarAddMonth.length === 1) {
        initCalendar();
    }

    if (calendarYearSwitcher.length === 1) {
        initCalendarYearSwitcher();
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
}

function initCalendarYearSwitcher() {
    calendarYearSwitcher.on('change', function() {
        var option = $(this).find(':selected').val();
        if (option) {
            window.location = option;
        }
    });
}