let mapPageBody;
let sidebarMap, sidebarMarker;
let markerModal, markerModalContent, markerModalTitle;

// Polygon layout style
let eraseTempPolygonBtn;
let polygonStrokeWeight, polygonStrokeColour, polygonStrokeOpacity, polygonColour, polygonOpacity;

let tickerTimeout, tickerUrl, tickerTs;

const isMobile = window.matchMedia("only screen and (max-width: 760px)");

$(document).ready(function() {

    window.map.invalidateSize();

    window.map.on('popupopen', function (ev) {
        window.initDialogs();
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
        if (isMobile.matches) {
            url = url + '?mobile=1';
            window.openDialog('map-marker-modal', url);
            return;
        }

        fetch(url)
            .then((response) => response.json())
            .then((result) => {
                sidebarMarker.html(result.body).show()
                    .parent().find('.spinner').hide();

                handleCloseMarker();
                mapPageBody.addClass('sidebar-open');

                $(document).trigger('shown.bs.modal');
            });
    };

    initTicker();
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
    if (isMobile.matches) {
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

const initTicker = () => {
    let config = document.getElementById('ticker-config');
    tickerTimeout = config.dataset.timeout;
    tickerUrl = config.dataset.url;
    tickerTs = config.dataset.ts;
    setTimeout(mapTicker, tickerTimeout);
};

const mapTicker = () => {
    fetch(tickerUrl + '?ts=' + tickerTs)
        .then(response => response.json())
        .then(data => {
            tickerTs = data.ts;
            for (let id in data.markers) {
                let changedMarker = data.markers[id];
                //console.log('moving', 'marker' + changedMarker.id, changedMarker);
                if (!window['marker' + changedMarker.id]) {
                    continue;
                }
                window['marker' + changedMarker.id].setLatLng({
                    lon: changedMarker.longitude,
                    lat: changedMarker.latitude
                });
            }
            setTimeout(mapTicker, tickerTimeout);
        });
};

const initLegend = () => {
    $('.map-legend-marker').click(function (ev) {
        ev.preventDefault();
        window.map.panTo(L.latLng($(this).data('lat'), $(this).data('lng')));
        window[$(this).data('id')].openPopup();
    });

    $('a.sidebar-toggle').click(function () {
        invalidateMapOnSidebar();
    });
};

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
        if (window.polygon) {
            window.map.removeLayer(window.polygon);
        }
    });
    $('.btn-mode-drawing').click(function (e) {
        e.preventDefault();
        endDrawing();
    });
}

function endDrawing() {
    window.drawingPolygon = false;
    $('body').removeClass('map-drawing-mode');
    window.openDialog('marker-modal');
}
function initPolygonDrawing() {

    $('#start-drawing-polygon').on('click', function (e) {
        e.preventDefault();
        window.exploreEditMode = false;
        window.startNewPolygon();
        window.showToast($(this).data('toast'));
        $('body').addClass('map-drawing-mode');

        window.closeDialog('marker-modal');
    });

    eraseTempPolygonBtn = $('#reset-polygon');
    eraseTempPolygonBtn.click(function (e) {
        e.preventDefault();
        if (window.polygon) {
            window.map.removeLayer(window.polygon);
        }
        $('textarea[name="custom_shape"]').val('');
        eraseTempPolygonBtn.hide();

        window.startNewPolygon();
    });

    window.map.on('editable:editing', function (e) {
        if (!isPolygon()) {
            return;
        }
        getPolygonStyle();
        e.layer.setStyle({
            weight: polygonStrokeWeight,
            color: polygonStrokeColour,
            opacity: polygonStrokeOpacity,
            fillColor: polygonColour,
            fillOpacity: polygonOpacity,
        });
    });
}

window.startNewPolygon = function () {
    window.polygon = window.map.editTools.startPolygon();
    let drawing = true;
    window.polygon.on('editable:dragend', window.markerUpdateHandler);
    window.polygon.on('editable:vertex:new', window.markerUpdateHandler);
    window.polygon.on('editable:vertex:dragend', window.markerUpdateHandler);
    window.polygon.on('editable:vertex:dragend', window.markerUpdateHandler);
    window.polygon.on('editable:drawing:end', function (e) {
        drawing = false;
    });
    // Open the modal when clicking on
    window.polygon.on('click', function (e) {
        if (drawing) {
            return;
        }
        endDrawing();
    });
};

window.setPolygonPosition = function (coords) {
    let shape = $('textarea[name="custom_shape"]');
    shape.val(coords);
};


window.markerUpdateHandler = function (data) {
    if (isPolygon()) {
        updatePolygon(data);
    }
    else if (isLabel()) {
        updateLabel(data);
    }
};

const updatePolygon = (data) => {
    //console.log('polygon updated', data);
    let points = data.target.getLatLngs();
    if (points.length === 0) {
        return;
    }

    let coords = [];
    points[0].forEach((i) => {
        coords.push(i.lat.toFixed(3) + ',' + i.lng.toFixed(3));
    });
    window.setPolygonPosition(coords.join(' '));
};

const updateLabel = (data) => {
    //console.log('label updated', data);
    let points = data.target._latlng;
    if (!points) {
        return;
    }
    $('#marker-latitude').val(points.lat.toFixed(3));
    $('#marker-longitude').val(points.lng.toFixed(3));
};

const isPolygon = () => {
    let shape = document.getElementsByName('shape_id');
    return Number(shape[0].value) === 5;
};
const isLabel = () => {
    let shape = document.getElementsByName('shape_id');
    return Number(shape[0].value) === 2;
};

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
};

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

    //console.log('load from', url);
    fetch(url)
        .then(response => response.text())
        .then(response => {
            $('.marker-preset-list').html(response);
            handlePresetClick();
        });
}

function handlePresetClick() {
    $('.preset-use').on('click', function (e) {
        e.preventDefault();

        let url = $(this).data('url');
        $(this).find('.fa-spin').show();

        $.ajax({
            url: url,
            context: this,
        }).done(function (result) {
            // Switch stuff around
            $(this).find('.fa-spin').hide();

            Object.keys(result.preset).forEach(key => {
                let val = result.preset[key];

                let field = $('[name="' + key + '"]');
                if (field.length === 0) {
                    //console.info('markerPreset', 'unknown field', key);
                    return;
                }
                if (key.endsWith('colour')) {
                    field.val(val);
                    document.querySelector('[name="' + key + '"]').dispatchEvent(new Event('input', ));
                } else {
                    field.val(val);
                }
            });
            $('a[href="#marker-pin"]').click();
        });
    });
}

/**
 * Why is this here?
 */
const handleExploreMapClick = (ev) => {
    if (!window.exploreEditMode) {
        return;
    }
    // return false;
    let position = ev.latlng;

    let lat = position.lat.toFixed(3);
    let lng = position.lng.toFixed(3);
    if (window.drawingPolygon) {
        window.addPolygonPosition(lat, lng);
        return;
    }
    //console.log('Click', 'lat', position.lat, 'lng', position.lng);
    // AJAX request
    //console.log('do', "$('#marker-latitude').val(" + position.lat.toFixed(3) + ");");
    $('#marker-latitude').val(lat);
    $('#marker-longitude').val(lng);
    window.openDialog('marker-modal');
};

window.handleExploreMapClick = handleExploreMapClick;
