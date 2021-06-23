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


    initImageFocus();
});

function initImageFocus() {
    let target = $('.focus-image');
    if (target.length === 0) {
        return;
    }

    target.on('click', function (e) {
        let elm = $(this);
        let posX = e.pageX - elm.offset().left;
        let posY = e.pageY - elm.offset().top;
        //console.log('where click', posX, posY);

        $('.focus').css('top', posY - 10).css('left', posX - 10).show();
        $('input[name="focus_x"]').val(posX);
        $('input[name="focus_y"]').val(posY);
    });

    $('.focus').click(function (e) {
        $('.focus').hide();
        $('input[name="focus_x"]').val();
        $('input[name="focus_y"]').val();
    });
}
