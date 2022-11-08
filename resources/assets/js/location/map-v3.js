import deleteConfirm from "../components/delete-confirm";

//require ('leaflet.markercluster/dist/leaflet.markercluster');
//require ('leaflet.markercluster.layersupport');

var mapPageBody;
var sidebarMap, sidebarMarker;
var markerModal, markerModalContent, markerModalTitle;

// Polygon layout style
var eraseTempPolygonBtn;
var polygonStrokeWeight, polygonStrokeColour, polygonStrokeOpacity, polygonColour, polygonOpacity;

$(document).ready(function() {

    window.map.invalidateSize();
    //deleteConfirm();

    window.map.on('popupopen', function (ev) {
        deleteConfirm();
    });

    // Event fired when clicking on an existing map point

    $('a[href="#marker-pin"]').click(function (e) {
        $('input[name="shape_id"]').val(1);
        $('#map-marker-bg-colour').show();
        showMainFields();
    });
    $('a[href="#marker-label"]').click(function (e) {
        $('input[name="shape_id"]').val(2);
        $('#map-marker-bg-colour').hide();
        showMainFields();
    });
    $('a[href="#marker-circle"]').click(function (e) {
        $('input[name="shape_id"]').val(3);
        $('#map-marker-bg-colour').show();
        showMainFields();
    });
    $('a[href="#marker-poly"]').click(function (e) {
        $('input[name="shape_id"]').val(5);
        $('#map-marker-bg-colour').show();
        showMainFields();
    });
    $('a[href="#presets"]').click(function (e) {
        loadPresets($(this).data('presets'));
    });
    $('a[href="#form-markers"]').click(function (e) {
        window.map.invalidateSize();
    });

    initMapExplore();
    initMapForms();
    initMapEntryClick();
    initPolygonDrawing();
    registerModes();
});

/**
 *
 */
function initMapExplore()
{
    //console.log('initMapExplore', '');
    mapPageBody = $('#map-body');
    if (mapPageBody.length === 0) {
        //console.log('initMapExplore', 'no explore mode');
        return;
    }
    sidebarMap = $('#sidebar-map');
    sidebarMarker = $('#sidebar-marker');
    markerModal = $('#map-marker-modal');
    markerModalTitle = $('#map-marker-modal-title');
    markerModalContent = $('#map-marker-modal-content');

    window.markerDetails = function(url) {
        showSidebar();
        if (window.kankaIsMobile.matches) {
            url = url + '?mobile=1';
        }
        $.ajax({
            url: url,
            type: 'GET',
            async: true,
            success: function (result) {
                if (result) {
                    if (window.kankaIsMobile.matches) {
                        markerModalTitle.html(result.name);
                        markerModalContent.find('.content').html(result.body).show();
                        markerModalContent.find('.spinner').hide();
                    } else {
                        sidebarMarker.html(result.body).show()
                            .parent().find('.spinner').hide();

                        handleCloseMarker();
                        mapPageBody.addClass('sidebar-open');
                    }
                    deleteConfirm();
                }
            }
        });
    };

    initLegend();
}

/**
 * When submitting the layer or marker form from the map modal, disable the map form unsaved changed
 * alert.
 */
function initMapForms()
{
    $('select[name="size_id"]').change(function (e) {
        if (this.value == 6) {
            $('.map-marker-circle-helper').hide();
            $('.map-marker-circle-radius').show();
        } else {
            $('.map-marker-circle-radius').hide();
            $('.map-marker-circle-helper').show();
        }
    });

    /**
     * Strip HTML from fontAwesome or RPGAwesome and just keep the class to make people's lives
     * easier.
     */
    $('input[name="custom_icon"]').on('paste', function(e) {
        e.preventDefault();
        let text;
        if (e.clipboardData || e.originalEvent.clipboardData) {
            text = (e.originalEvent || e).clipboardData.getData('text/plain');
        } else if (window.clipboardData) {
            text = window.clipboardData.getData('Text');
        }
        if (text.startsWith('<i class="fa') || text.startsWith('<i class="ra')) {
            let className = $(text).attr('class');
            if (className) {
                $(this).val(className);
                return;
            }
        }
        $(this).val(text);
    });

    //console.info('mapsv3', 'initMapForms');
    let markerForm = $('#map-marker-form');
    if ($('#entity-form').length === 0 && $('.map-marker-edit-form').length === 0) {
        //console.info('initMapForms empty');
        return;
    }

    markerForm.unbind('submit').on('submit', function() {
        window.entityFormHasUnsavedChanges = false;
    });


    initLegend();
}

function showSidebar()
{
    // On mobile use the modal instead of the sidebar
    if (window.kankaIsMobile.matches) {
        markerModalContent.find('.spinner').show();
        markerModalContent.find('.content').hide();
        markerModal.modal('toggle');
        return;
    }

    //window.map.invalidateSize();
    mapPageBody.removeClass('sidebar-collapse').addClass('sidebar-open');
    sidebarMap.hide();
    sidebarMarker.html('').show();
    sidebarMarker.parent().find('.spinner').show();
    invalidateMapOnSidebar();
}

function handleCloseMarker()
{
    $('.marker-close').click(function (ev) {
        sidebarMarker.hide();
        sidebarMap.show();
    });
}

function initLegend()
{
    $('.map-legend-marker').click(function (ev) {
        ev.preventDefault();
        window.map.panTo(L.latLng($(this).data('lat'), $(this).data('lng')));
        window[$(this).data('id')].openPopup();
    });

    $('a.sidebar-toggle').click(function () {
        invalidateMapOnSidebar();
    });
}
function invalidateMapOnSidebar() {
    setTimeout(() => {
        // Invalidate the map size when the sidebar is rendered/hidden
        window.map.invalidateSize();
    }, 500);
}
function initMapEntryClick() {
    $('.map-marker-entry-click').click(function (e) {
        e.preventDefault();
        $(this).parent().hide();
        $('.map-marker-entry-entry').show();
    });
}

/**
 * Register switching in and out of edit mode
 */
function registerModes() {
    $('.btn-mode-enable').click(function (e) {
        e.preventDefault();
        window.exploreEditMode = true;
        $('body').addClass('map-edit-mode');
    });
    $('.btn-mode-disable').click(function (e) {
        e.preventDefault();
        window.exploreEditMode = false;
        $('body').removeClass('map-edit-mode');
    });
    $('.btn-mode-drawing').click(function (e) {
        e.preventDefault();
        window.drawingPolygon = false;
        $('body').removeClass('map-drawing-mode');
        $('#marker-modal').modal('show');
    });


}

function initPolygonDrawing() {

    $('#start-drawing-polygon').on('click', function (e) {
        e.preventDefault();
        window.drawingPolygon = true;
        window.showToast($(this).data('toast'));
        $('body').addClass('map-drawing-mode');
        $('#marker-modal').modal('hide');
    });

    eraseTempPolygonBtn = $('#reset-polygon');
    eraseTempPolygonBtn.click(function (e) {
        e.preventDefault();
        if (window.polygon) {
            window.map.removeLayer(window.polygon);
        }
        $('textarea[name="custom_shape"]').val('');
        eraseTempPolygonBtn.hide();
    });
}

window.addPolygonPosition = function(lat, lng) {
    let shape = $('textarea[name="custom_shape"]');
    let current = shape.val();
    if (current.length > 0) {
        current += ' ';
    }
    shape.val(current + lat + ',' + lng);

    // Redraw the polygon
    let coords = shape.val();
    let blocks = coords.trim(" ").split(" ");
    let coordsData = [];

    blocks.forEach((block) => {
        let segments = block.split(',');
        coordsData.push([segments[0], segments[1]]);
    }, coordsData);

    // Remove previous polygon if it was already drawn
    if (window.polygon) {
        window.map.removeLayer(window.polygon);
    }

    // Background colour as defined by the user if they are so far?
    getPolygonStyle();

    window.polygon = L.polygon(coordsData, {
        weight: polygonStrokeWeight,
        color: polygonStrokeColour,
        opacity: polygonStrokeOpacity,
        fillColor: polygonColour,
        fillOpacity: polygonOpacity,
        linecap: 'round',
        linejoin: 'round',
    });
    window.polygon.addTo(window.map);
    eraseTempPolygonBtn.show();
}

function getPolygonStyle() {
    polygonStrokeColour = $('input[name="polygon_style[stroke]"]').val();
    if (!polygonStrokeColour || polygonStrokeColour.length < 7) {
        polygonStrokeColour = 'red';
    }

    polygonStrokeOpacity = $('input[name="polygon_style[stroke-opacity]"]').val();
    if (isNaN(polygonStrokeOpacity) || !polygonStrokeOpacity) {
        polygonStrokeOpacity = 1;
    } else {
        polygonStrokeOpacity = polygonStrokeOpacity / 100;
    }

    polygonColour = $('input[name="colour"]').val();
    if (!polygonColour || polygonColour.length < 7) {
        polygonColour = 'red';
    }

    polygonOpacity = $('input[name="opacity"]').val();
    if (isNaN(polygonOpacity)) {
        polygonOpacity = 0.5;
    } else {
        polygonOpacity = polygonOpacity / 100;
    }

    polygonStrokeWeight = $('input[name="polygon_style[stroke-width]"]').val();
    if (isNaN(polygonStrokeWeight) || !polygonStrokeWeight) {
        polygonStrokeWeight = 1;
    }
}

function showMainFields() {
    $('#marker-main-fields').show();
    $('#marker-footer').show();
}

function loadPresets(url) {
    $('#marker-main-fields').hide();
    $('#marker-footer').hide();

    // If presets have already been loaded, skip loading/rendering of the list
    if ($('.marker-preset-list .fa-spinner').length === 0) {
        return;
    }

    console.log('load from', url);
    $.ajax({
        url: url
    }).done(function (data) {
        $('.marker-preset-list').html(data);
        handlePresetClick();
    });
}

function handlePresetClick() {
    $('.preset-use').on('click', function (e) {
        e.preventDefault();

        let url = $(this).data('url');
        console.log('url', url);

        $(this).find('.fa-spin').show();

        $.ajax({
            url: url,
            context: this,
        }).done(function (result) {
            // Switch stuff around
            console.log('result', result.preset);
            $(this).find('.fa-spin').hide();

            Object.keys(result.preset).forEach(key => {
                let val = result.preset[key];
                console.log('config', key, val);

                if (key.endsWith('colour')) {
                    $('[name="' + key + '"]').spectrum("set", val);
                } else {
                    $('[name="' + key + '"]').val(val);
                }
            });
            $('a[href="#marker-pin"]').click();
        });
    });
}
