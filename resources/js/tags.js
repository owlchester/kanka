$(document).ready(function() {
    window.initTags = function() {
        $.each($('.position-dropdown'), function () {
            if ($(this).hasClass("select2-hidden-accessible")) {
                return;
            }
            $(this).select2({
                tags: true,
                allowClear: true,
                dropdownParent: $(this).data('dropdown-parent') || '',
                placeholder: $(this).data('placeholder'),
                minimumInputLength: 0,
                createTag: function (params) {
                    let term = $.trim(params.term);
        
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true // add additional parameters
                    };
                },
                templateResult: function (item) {
                    let $span = $("<span class='block grow text-left'>" + item.text + "</span>");
                    if (item.colour) {
                        $span = $("<span class='flex gap-2 items-center text-left'>" +
                            "<span class='rounded-full flex-none w-6 h-6 " + item.colour + "' /></span>" +
                            "<span class='grow'>" + item.text + "</span>" +
                            "</span>");
                    }
                    return $span;
                },

            });
        });

        $.each($('.form-tags'), function () {
            if ($(this).hasClass("select2-hidden-accessible")) {
                return;
            }

            $(this).select2({
                tags: $(this).data('allow-new'),
                allowClear: $(this).data('allow-clear'),
                dropdownParent: $(this).data('dropdown-parent') || '',
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
                    let term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true // add additional parameters
                    };
                },
                templateResult: function (item) {
                    let $span = $("<span class='block grow text-left'>" + item.text + "</span>");
                    if (item.colour) {
                        $span = $("<span class='flex gap-2 items-center text-left'>" +
                            "<span class='rounded-full flex-none w-6 h-6 " + item.colour + "' /></span>" +
                            "<span class='grow'>" + item.text + "</span>" +
                            "</span>");
                    }
                    return $span;
                },
                templateSelection : function (state, container) {
                    if (state.newTag) {
                        return $('<span class="new-tag" title="' + $('#tags').data('new-tag') + '">' + state.text + ' <i class="fa-solid fa-plus-circle" aria-hidden="true"></i></span>');
                    }

                    let el = $(state.element);
                    if (state.colour) {
                        $(container).addClass(state.colour);
                    } else if(el.data('colour')) {
                        $(container).addClass(el.data('colour'));
                    }
                    $(container).addClass('text-left');
                    return state.text;
                },
            });
        });
    };

    window.initTags();
});
