export default function select2() {
    if ($('select.select2').length > 0) {
        $.each($('select.select2'), function (index) {
            // Check it isn't the select2-icon
            let allowClear = $(this).data('allow-clear');
            $(this).select2({
                //data: newOptions,
                placeholder: $(this).data('placeholder'),
                allowClear: allowClear || true,
                tags: $(this).is('[data-tags]'),
                language: $(this).data('language'),
                minimumInputLength: 0,
                ajax: {
                    delay: 500,
                    quietMillis: 500,
                    url: $(this).data('url'),
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
                },
                templateResult: function (item) {
                    var $span = '';
                    if (item.image) {
                        $span = $("<span><img src='" + item.image + "' width='40' height='40'/> " + item.text + "</span>");
                    } else {
                        $span = $("<span>" + item.text + "</span>");
                    }
                    return $span;
                }
            });
        });
    }

    // Select2 with local search
    $('select.select2-local').select2({
        placeholder: $(this).data('placeholder'),
        language: $(this).data('language'),
        allowClear: true
    });
}
