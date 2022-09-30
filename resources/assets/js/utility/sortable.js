import Sortable from 'sortablejs';

window.initSortable = function() {
    var dragndropArea = document.querySelectorAll('.sortable-elements'), i;
    if (dragndropArea.length === 0) {
        return;
    }
    for (i = 0; i < dragndropArea.length; ++i) {
        //console.log('re-init', dragndropArea[i]);
        Sortable.create(dragndropArea[i]);
    }
}

$(document).ready(() => {
    window.initSortable();
});

