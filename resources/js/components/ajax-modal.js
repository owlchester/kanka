export default function ajaxModal() {
    $('[data-toggle="ajax-modal"]')
        .unbind('click')
        .click(function (e) {
            e.preventDefault();
            ajaxModal = $(this);
            $.ajax({
                url: $(this).data('url')
            }).done(function (result, textStatus, xhr) {
                if (result) {
                    let params= {};
                    let target = $(ajaxModal).data('target');
                    let backdrop = $(ajaxModal).data('backdrop');
                    if (backdrop) {
                        params.backdrop = backdrop;
                    }
                    $(target).find('.modal-content').html(result);
                    $(target).modal(params);
                }
            }).fail(function (result, textStatus, xhr) {
                //console.log('modal ajax error', result);
            });
            return false;
        });
}
