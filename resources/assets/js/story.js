$(document).ready(function () {
    let selector = $('.entity-notes-reorder');
    selector.sortable();
    //selector.disableSelection();

    $('.fa-arrow-up').click(function (e) {
        let $current = $(this).closest('div.story')
        let $previous = $current.prev('div.story');
        if ($previous.length !== 0) {
            $current.insertBefore($previous);
        }
        return false;
    });
    $('.fa-arrow-down').click(function (e) {
        let $current = $(this).closest('div.story')
        let $previous = $current.next('div.story');
        if ($previous.length !== 0) {
            $current.insertAfter($previous);
        }
        return false;
    });
});
