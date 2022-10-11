$(document).ready(function() {
    /** Leap year toggler **/
    $('input[name="has_leap_year"]').on('click', function() {
        $('#calendar-leap-year').toggle();
    });
});

