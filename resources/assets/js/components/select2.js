export default function select2() {
    if ($('select.select2').length > 0) {
        $.each($('select.select2'), function (index) {
            // Check it isn't the select2-icon
            let allowClear = $(this).data('allow-clear');
            let dropdownParent = $(this).data('dropdown-parent');
            console.log('select2', $(this).attr('name'), 'allow new', ($(this).data('allow-new') || false));
            $(this).select2({
                //data: newOptions,
                tags: false,
                placeholder: $(this).data('placeholder'),
                allowClear: allowClear || true,
                //tags: $(this).data('tags') || false,
                language: $(this).data('language'),
                minimumInputLength: 0,
                dropdownParent: dropdownParent || '',
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
                },
                createTag: function (data) {
                    return null;
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
