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
