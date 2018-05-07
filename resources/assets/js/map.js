/**
 * Map
 */
var mapModal, mapAdmin, mapAdminImg, locationInput, mapImage, mapImageOriginalWidth;
var mapPositionX, mapPositionY;
var mapZoomIn, mapZoomOut;
var mapToggleShow, mapToggleHide;
var mapZoomValue = 100, mapZoomIncrements = 0;
var mapPointModalBody;

$(document).ready(function() {
    // Look for a form to save
    mapAdmin = $('#location-map-admin');
    mapModal = $('#point-location');
    mapAdminImg = $('#location-map-admin img');
    locationInput = $('#location_id');

    mapImage = $('#location-map-image');
    mapZoomIn = $('#map-zoom-in');
    mapZoomOut = $('#map-zoom-out');
    mapToggleHide = $('#map-toggle-hide');
    mapToggleShow = $('#map-toggle-show');

    mapPointModalBody = $('#map-point-body');

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

        $.ajax({
            url: $(this).attr('data-url') + '?axis_y=' + parseInt(mapPositionY) + '&axis_x=' + parseInt(mapPositionX)
        }).done(function (result, textStatus, xhr) {
            if (result) {
                mapPointModalBody.html(result);
                initSelect2();
                mapModal.modal();
            }
        }).fail(function (result, textStatus, xhr) {
            console.log('map point error', result);
        });
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
    mapToggleHide.on('click', function(e) {
        e.preventDefault();
        mapTogglePoints(false);
    });
    mapToggleShow.on('click', function(e) {
        e.preventDefault();
        mapTogglePoints(true);
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
    var min = 25;
    var max = 175;

    if (!mapImageOriginalWidth) {
        mapImageOriginalWidth = mapImage.width();
    }
    // Min/Max
    var newZoom = mapZoomValue + change;
    if (newZoom > max || newZoom < min) {
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
        $(this).css('font-size', (24 * magnifier) + 'px');
    });

    if (mapZoomValue <= min) {
        mapZoomOut.attr('disabled', 'disabled');
    } else if (newZoom >= max) {
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
            $.ajax({
                url: $(this).attr('data-url')
            }).done(function (result, textStatus, xhr) {
                if (result) {
                    mapPointModalBody.html(result);
                    initSelect2();
                    mapModal.modal();
                }
            }).fail(function (result, textStatus, xhr) {
                console.log('map point error', result);
            });
        });
    });
}


/**
 * This is re-defined (copy-paste) from app.js, since the minify changes the original name
 */
function initSelect2() {
    if ($('.select2').length > 0) {
        $.each($('.select2'), function (index) {

            $(this).select2({
//            data: newOptions,
                placeholder: $(this).attr('data-placeholder'),
                allowClear: true,
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
}

/**
 * Toggle showing or hiding of points on the map
 * @param show
 */
function mapTogglePoints(show)
{
    if (show) {
        mapToggleHide.show();
        mapToggleShow.hide();

        $.each($('#map .point'), function() {
            $(this).show();
        });
    } else {
        mapToggleHide.hide();
        mapToggleShow.show();

        $.each($('#map .point'), function() {
            $(this).hide();
        });
    }
}
