$(document).ready(function() {
    window.initTags = function() {
        //console.log('form-tags loop');
        $.each($('.form-tags'), function (index) {

            let dropdownParent = $(this).data('dropdown-parent');


            if ($(this).hasClass("select2-hidden-accessible")) {
                return;
            }

//            console.log('generate', $(this).data('dropdown-parent'));
            $(this).select2({
                tags: $(this).data('allow-new'),
                allowClear: $(this).data('allow-clear'),
                dropdownParent: dropdownParent || '',
                minimumInputLength: 0,
                ajax: {
                    quietMillis: 500,
                    delay: 500,
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
                createTag: function (params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true // add additional parameters
                    }
                },
                templateSelection : function (state, container) {
                    if (state.newTag) {
                        return $('<span class="new-tag" title="' + $('#tags').data('new-tag') + '">' + state.text + ' <i class="fa-solid fa-plus-circle"></i></span>');
                    }

                    let el = $(state.element);
                    if (state.colour) {
                        $(container).addClass(state.colour);
                    } else if(el.data('colour')) {
                        $(container).addClass(el.data('colour'));
                    }
                    return state.text;
                },
            });
        });
    };

    window.initTags();
});
