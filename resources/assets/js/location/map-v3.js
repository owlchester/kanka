import deleteConfirm from "../components/delete-confirm";

var hasDeleteConfirm = false;
var mapPageBody;
var sidebarMap, sidebarMarker;

$(document).ready(function() {

    window.map.invalidateSize();
    deleteConfirm();

    window.map.on('popupopen', function (ev) {
        deleteConfirm();
    });

    // Event fired when clicking on an existing map point

    $('a[href="#marker-pin"]').click(function (e) {
        $('input[name="shape_id"]').val(1);
    });
    $('a[href="#marker-label"]').click(function (e) {
        $('input[name="shape_id"]').val(2);
    });
    $('a[href="#marker-circle"]').click(function (e) {
        $('input[name="shape_id"]').val(3);
    });
    $('a[href="#marker-poly"]').click(function (e) {
        $('input[name="shape_id"]').val(5);
    });

    initMapExplore();
});

function initMapExplore()
{
    mapPageBody = $('#map-body');
    sidebarMap = $('#sidebar-map');
    sidebarMarker = $('#sidebar-marker');

    window.markerDetails = function(url)
    {
        showSidebar();
        $.ajax({
            url: url,
            type: 'GET',
            async: true,
            success: function (result) {
                console.log('result');
                if (result) {
                    sidebarMarker.html(result);
                    handleCloseMarker();
                }
            }
        })
    }

    $('.map-legend-marker').click(function (ev) {
        ev.preventDefault();
        window.map.panTo(L.latLng($(this).data('lat'), $(this).data('lng')));
        window[$(this).data('id')].openPopup();
    });
}



function showSidebar()
{
    window.map.invalidateSize();
    mapPageBody.removeClass('sidebar-collapse');
    sidebarMap.hide();
    sidebarMarker.show().html('<div class="text-center"><i class="fa fa-spin fa-spinner fa-2x"></i></div>');
}

function handleCloseMarker()
{
    $('.marker-close').click(function (ev) {
        sidebarMarker.hide();
        sidebarMap.show();
    });
}
