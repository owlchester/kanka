export default function deleteConfirm() {
    // Delete confirm dialog
    $.each($('.delete-confirm'), function () {
        $(this).click(function (e) {
            let name = $(this).data('name');
            let text = $(this).data('text');
            let target = $(this).data('delete-target');
            let confirm = $(this).data('confirm-target');
            let reset = $(this).data('reset');

            if (!confirm) {
                confirm = '#delete-confirm-name';
            }

            if (text) {
                $('#delete-confirm-text').text(text);
            } else {
                $(confirm).text(name);
            }

            if ($(this).data('mirrored')) {
                $('#delete-confirm-mirror').show();
            } else {
                $('#delete-confirm-mirror').hide();
            }

            if (target) {
                $('.delete-confirm-submit').data('target', target);
            }

            if (reset) {
                $('.delete-button-label').hide();
                $('.remove-button-label').show();
            } else {
                $('.delete-button-label').show();
                $('.remove-button-label').hide();
            }
        });
    });


    // Submit modal form
    $.each($('.delete-confirm-submit'), function (index) {
        $(this).unbind('click');
        $(this).click(function (e) {
            //console.log('clicky submit');
            var target = $(this).data('target');
            if (target) {
                $('#' + target + ' input[name=remove_mirrored]').val(
                    $('#delete-confirm-mirror-chexkbox').is(':checked') ? 1 : 0
                );
                //console.log('target', target, $('#' + target));
                $('#' + target).submit();
            } else {
                $('#delete-confirm-form').submit();
            }
        })
    });

    // Delete confirm dialog
    $.each($('.click-confirm'), function (index) {
        $(this).click(function (e) {
            var name = $(this).data('message');
            $('#click-confirm-text').text(name);
            $('#click-confirm-url').attr('href', $(this).data('url'));
        });
    });
}
