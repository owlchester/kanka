$(document).ready(function() {
    registerTimelineEvents();
});

/**
 * Timeline toggle support
 */
function registerTimelineEvents() {
    $('.timeline-toggle').on('click', function() {
        let id = $(this).data('short');
        $('#' + id + "-show").toggle();
        $('#' + id + "-hide").toggle();
    });

    $('.timeline-era-reorder').on('click', function(e) {
        e.preventDefault();
        let eraId = $(this).data('era-id');

        $('#era-items-' + eraId + '').sortable();

        $(this).parent().hide();
        $('#era-items-' + eraId + '-save-reorder').show();
    });
}
