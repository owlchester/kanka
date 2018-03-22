/**
 * Crud
 */
$(document).ready(function() {
    var filters = $('#crud-filters');
    if (filters.length === 1) {
        initCrudFilters();
    }
});

/**
 * Filters
 */
var previousFilterInputValue = '';
function initCrudFilters() {

    $('#crud-filters .element').on('click', function(e) {
        $(this).children('.value').hide();
        $(this).children('.input').show();

        // Show the field and focus at the end of it
        var input = $(this).children('.input').children('.input-field');
        input.focus();
        var tmp = input.val();
        input.val('');
        input.val(tmp);
        previousFilterInputValue = tmp;
    });

    $('#crud-filters .element input').on('focusout', function(e) {
        // Only submit on change
        e.preventDefault();
        filterSubmit($(this), false);
    });

    $('#crud-filters select.select2').on('change', function(e) {
        $('#crud-filters-form').submit();
    });

    // Reset button
    $('#crud-filters .end').on('click', function(e) {
        // Redirect to page without params
        window.location = window.location.href.split("?")[0];
    });

    $('#crud-filters .input-field').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            filterSubmit($(this), true);
        }
    });
}

function filterSubmit(field, force) {
    var element = field.parent().parent();
    var input = element.children('.input');
    input.hide();
    element.children('.value').html(field.val());
    element.children('.value').show();

    if (force || field.val() !== previousFilterInputValue) {
        $('#crud-filters-form').submit();
    }
}