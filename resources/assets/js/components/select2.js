export default function select2() {
    if ($('select.select2').length > 0) {
        $.each($('select.select2'), function (index) {
            // Check it isn't the select2-icon
            $(this).select2({
                //data: newOptions,
                placeholder: $(this).data('placeholder'),
                allowClear: true,
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
