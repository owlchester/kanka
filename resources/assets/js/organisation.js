$(document).ready(function() {
    $.each($('.form-members'), function (index) {

        $(this).select2({
            tags: true,
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                quietMillis: 500,
                delay: 500,
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
            },
            createTag: function(params) {
                return undefined;
            }
        });
    });
});
