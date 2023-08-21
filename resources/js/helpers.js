/**
 * Get the entity's tooltip via ajax
 */
var cachedTooltips = Array();

function entityTooltip() {
    let element = $(this);
    let id = element.data('id');

    if (id in cachedTooltips){
        return cachedTooltips[id];
    }

    var title = '<div class="center"><i class="fa-solid fa-spinner fa-spin"></i></div>';

    $.ajax({
        url: $(this).data('url'),
        method: 'GET',
        async: false,
        success:function(data)
        {
            title = data;
        }
    });

    cachedTooltips[id] = title;
    return title;
}

/*window.ajaxTooltip = function() {*/
    /*$('[data-toggle="tooltip-ajax"]').tooltip({
        title: entityTooltip,
        delay: 500,
        trigger: 'hover',
        placement: 'auto',
        template: '<div class="tooltip" role="tooltip">' +
            '<div class="tooltip-arrow"></div>' +
            '<div class="tooltip-inner tooltip-ajax text-left p-1"></div>' +
            '</div>',
        html: true,
        sanitize: false
    });

    $('[data-toggle="tooltip-ajax"]').click(function () {
        $(this).tooltip('hide');
    });*/
/*};*/
