window.initSelect2 = function() {
    if ($('.select2').length > 0) {
        $.each($('.select2'), function (index) {

            $(this).select2({
//            data: newOptions,
                placeholder: $(this).attr('data-placeholder'),
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
                }
            });
        });
    }
};
/**
 * Get the entity's tooltip via ajax
 */
var cachedTooltips = Array();

function entityTooltip() {
    var element = $(this);

    var id = element.data('id');

    if (id in cachedTooltips){
        return cachedTooltips[id];
    }

    var title = '<div class="center"><i class="fa fa-spinner fa-spin"></i></div>';

    $.ajax({
        url: $(this).data('url'),
        method: "GET",
        async: false,
        success:function(data)
        {
            title = data;
        }
    });

    cachedTooltips[id] = title;

    return title;

}

window.crudInitAjaxModal = function() {
    $.each($('[data-toggle="ajax-modal"]'), function () {
        $(this).click(function (e) {
            $(this).unbind('click');
            e.preventDefault();
            var ajaxModalTarget = $(this).attr('data-target');
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

window.ajaxTooltip = function() {

    // New tooltips with ajax call
    // $('[data-toggle="tooltip-ajax"]').on('mouseenter', function(e) {
    //     var self = $(this);
    //     console.log('mention-loaded?', self.data('mention-loaded'));
    //     if (self.data('mention-loaded')) {
    //         return;
    //     }
    //
    //     e.preventDefault();
    //     setTimeout(function() {
    //         $.ajax({
    //             url: self.data('mention-url'),
    //             async: true
    //         })
    //         .done(function(data) {
    //             console.log('data from request', data[0]);
    //             self.data('original-title', data[0]);
    //             //self.prop('title', data[0]);
    //             self.data('mention-loaded', true);
    //             console.log('finished setting data', self.data('mention-loaded'));
    //         });
    //     }, 5);
    // });
    $('[data-toggle="tooltip-ajax"]').tooltip({
        title: entityTooltip,
        delay: 750,
        trigger: 'hover',
        placement: 'auto',
        template: '<div class="tooltip" role="tooltip">' +
            '<div class="tooltip-arrow"></div>' +
            '<div class="tooltip-inner tooltip-ajax"></div>' +
            '</div>',
        html: true,
        sanitize: false
    });

    $('[data-toggle="tooltip-ajax"]').click(function (e) {
        $(this).tooltip('hide');
    });
};
