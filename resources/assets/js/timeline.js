import Sortable from "sortablejs";

$(document).ready(function() {
    registerTimelineEvents();
});

/**
 * Timeline toggle support
 */
function registerTimelineEvents() {

    $('.timeline-era-reorder').on('click', function(e) {
        e.preventDefault();
        let eraId = $(this).data('era-id');

        let el = document.querySelector('#era-items-' + eraId);
        Sortable.create(el);

        $(this).parent().hide();
        $('#era-items-' + eraId + '-save-reorder').show();
    });
}
