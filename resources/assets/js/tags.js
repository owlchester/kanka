$(document).ready(function() {
    window.initCategories = function() {
        $.each($('.form-tags'), function (index) {

            $(this).select2({
                tags: true,
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

    window.initCategories();
});