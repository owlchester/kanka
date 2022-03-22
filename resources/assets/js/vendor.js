$(document).ready(function () {
    registerVendorEvents();
});


// Select2 open focus bugfix with newer jquery versions
$(document).on('select2:open', () => {
    let allFound = document.querySelectorAll('.select2-container--open .select2-search__field');
    allFound[allFound.length - 1].focus();
});

function registerVendorEvents()
{
    // Datetime picker (admin)
    $.each($('.datetime-picker'), function (index) {
        $(this).datetimepicker({
            sideBySide: true,
            format: 'YYYY-MM-DD HH:mm:00'
        });
    });

    // Date picker
    $.each($('.date-picker'), function (index) {
        // instance, using default configuration.
        $(this).datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });
    });

    // Open select2 dropdowns on focus. Don't add this in
    // initSelect2 since we only need this binded once.
    $(document).on('focus', '.select2.select2-container', function (e) {
        // only open on original attempt - close focus event should not fire open
        if (e.originalEvent && $(this).find(".select2-selection--single").length > 0) {
            $(this).siblings('select').select2('open');
        }
    });
}
