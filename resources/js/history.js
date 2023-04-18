$(document).ready(function () {
    initHistoryFilters();
});

function initHistoryFilters()
{
    let form = $('form.history-filters');
    let filters = $('.history-filters select');
    filters.on('change', function () {
        $('.filters-loading').show();
        console.log('changed');
        form.submit();
        filters.prop('disabled', true);
    });
}
