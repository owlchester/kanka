import Sortable from 'sortablejs';

window.initSortable = function() {
    let dragndropArea = document.querySelectorAll('.sortable-elements');
    if (dragndropArea.length === 0) {
        return;
    }
    dragndropArea.forEach((el) => {
        let options = {};

        // Handle?
        let handle = el.dataset.handle;
        if (handle) {
            options.handle = handle;
        }

        Sortable.create(el, options);
    });
};

window.initSortable();

