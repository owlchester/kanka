import Sortable from 'sortablejs';

window.initSortable = function() {
    var dragndropArea = document.querySelectorAll('.sortable-elements'), i;
    if (dragndropArea.length === 0) {
        return;
    }
    for (i = 0; i < dragndropArea.length; ++i) {
        let options = {};

        // Handle?
        let handle = dragndropArea[i].getAttribute('data-handle');
        if (handle) {
            options.handle = handle;
        }

        //console.log('re-init', dragndropArea[i]);
        Sortable.create(dragndropArea[i], options);
    }
}

$(document).ready(() => {
    window.initSortable();
});

