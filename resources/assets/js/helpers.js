window.initSelect2 = function() {
    if ($('.select2').length > 0) {
        $.each($('.select2'), function (index) {

            $(this).select2({
//            data: newOptions,
                placeholder: $(this).attr('data-placeholder'),
                allowClear: true,
                minimumInputLength: 0,
                ajax: {
                    quietMillis: 200,
                    url: $(this).attr('data-url'),
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    }
};

window.crudInitAjaxModal = function() {
    $.each($('[data-toggle="ajax-modal"]'), function () {
        $(this).click(function (e) {
            $(this).unbind('click');
            e.preventDefault();
            ajaxModalTarget = $(this).attr('data-target');
            $.ajax({
                url: $(this).attr('data-url')
            }).done(function (result, textStatus, xhr) {
                if (result) {
                    $(ajaxModalTarget).find('.modal-content').html(result);
                    $(ajaxModalTarget).modal();

                    // Reset select2
                    window.initSelect2();
                }
            }).fail(function (result, textStatus, xhr) {
                //console.log('modal ajax error', result);
            });
            return false;
        });
    });
};