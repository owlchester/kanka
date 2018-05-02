/**
 * Map
 */
var mapModal, mapAdmin, mapAdminImg, locationInput, mapImage, mapImageOriginalWidth;
var mapPositionX, mapPositionY;
var mapZoomIn, mapZoomOut;
var mapZoomValue = 100, mapZoomIncrements = 0;

$(document).ready(function() {
    // Look for a form to save
    mapAdmin = $('#location-map-admin');
    mapModal = $('#point-location');
    mapAdminImg = $('#location-map-admin img');
    locationInput = $('#location_id');

    mapImage = $('#location-map-image');
    mapZoomIn = $('#map-zoom-in');
    mapZoomOut = $('#map-zoom-out');

    if (mapAdmin.length === 1) {
        initMapAdmin();
    }

    if (mapZoomIn.length === 1) {
        initMapControls();
    }
});

/**
 * Init Clicking on the Map
 */
function initMapAdmin() {
    mapAdminImg.on('click', function (e) {

        // Reset select 2
         locationInput.val(null).trigger('change');

        var offset = $(this).offset();
        mapPositionX = e.pageX - offset.left - 25;
        mapPositionY = e.pageY - offset.top - 25;

        // Don't allow negative positions
        if (mapPositionX < 0) {
            mapPositionX = 0;
        }
        if (mapPositionY < 0) {
            mapPositionY = 0;
        }

        mapModal.modal();
    });

    var mapModalSubmit = $('#point-location-submit');
    mapModalSubmit.on('click', function(e) {
        // Check that a location was selected
        if (locationInput.val()) {
            mapAdmin.append(
                '<div class="point admin" style="top:' + mapPositionY + 'px;left:' + mapPositionX + 'px">' +
                '<input type="hidden" name="map_point[]" value="' + mapPositionX + '-' + mapPositionY + '-' + locationInput.val() + '" />' +
                '</div>'
            );
            mapModal.modal('toggle');

            // Reset delete on all points
            initPointDelete();
        } else {

        }
    });

    // Handle deleting already loaded points
    initPointDelete();
}

/**
 * Register click on the map zoom controls
 */
function initMapControls() {
    $('#draggable-map').draggable();
    mapZoomIn.on('click', function(e) {
        e.preventDefault();
        mapZoom(25);
    });
    mapZoomOut.on('click', function(e) {
        e.preventDefault();
        mapZoom(-25);
    });
}

/**
 * Zoom on the map
 * @param change
 * @returns {boolean}
 */
function mapZoom(change) {
    // Don't have the size yet? Calculate it. We don't calc on page load because if it's on a hidden tab,
    // it evaluates to 0
    if (!mapImageOriginalWidth) {
        mapImageOriginalWidth = mapImage.width();
    }
    // Min/Max
    var newZoom = mapZoomValue + change;
    if (newZoom > 150 || newZoom < 50) {
        return false;
    }

    mapZoomOut.removeAttr('disabled');
    mapZoomIn.removeAttr('disabled');
    mapZoomValue = newZoom;

    magnifier = (mapZoomValue / 100);
    mapImage.width(mapImageOriginalWidth * magnifier);

    if (change > 0) {
        mapZoomIncrements++;
    } else {
        mapZoomIncrements--;
    }

    $.each($('#map .point'), function() {
        $(this).css('top', ($(this).attr('data-top') * magnifier) + 'px');
        $(this).css('left', ($(this).attr('data-left') * magnifier)+ 'px');
        $(this).css('width', (50 * magnifier)+ 'px');
        $(this).css('height', (50 * magnifier)+ 'px');
        $(this).css('border-radius', (25 * magnifier)+ 'px');
    });

    if (mapZoomValue <= 50) {
        mapZoomOut.attr('disabled', 'disabled');
    } else if (newZoom >= 150) {
        mapZoomIn.attr('disabled', 'disabled');
    }
}

/**
 * Add delete click on all points
 */
function initPointDelete() {
    $.each($('.point'), function (index) {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function(e) {
            $(this).remove();
            e.preventDefault();
        });
    });
}
