/**
 * Map
 */
var mapModal, mapAdmin, mapImg, locationInput;
var mapPositionX, mapPositionY;

$(document).ready(function() {
    // Look for a form to save
    mapAdmin = $('#location-map-admin');
    mapModal = $('#point-location');
    mapImg = $('#location-map-admin img');
    locationInput = $('#location_id');

    if (mapAdmin.length === 1) {
        initMapAdmin();
    }
});

/**
 * Init Clicking on the Map
 */
function initMapAdmin() {
    mapImg.on('click', function (e) {

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
