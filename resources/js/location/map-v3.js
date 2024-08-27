const mapPageBody = document.querySelector('#map-body');

const sidebarMap = document.querySelector('#sidebar-map');
const sidebarMarker = document.querySelector('#sidebar-marker');
const markerModal = document.querySelector('#map-marker-modal');

// Polygon layout style
let eraseTempPolygonBtn;
let polygonStrokeWeight, polygonStrokeColour, polygonStrokeOpacity, polygonColour, polygonOpacity;

let tickerTimeout, tickerUrl, tickerTs;

const isMobile = window.matchMedia("only screen and (max-width: 760px)");

const shapeField = document.querySelector('input[name="shape_id"]');

const initTabs = () => {
    const pin = document.querySelector('a[href="#marker-pin"]');
    if (!pin) {
        return;
    }
    pin.addEventListener('click', function () {
        shapeField.value = 1;
        document.querySelector('#map-marker-bg-colour').classList.remove('hidden');
        showMainFields();
    });
    document.querySelector('a[href="#marker-label"]').addEventListener('click', function () {
        shapeField.value = 2;
        document.querySelector('#map-marker-bg-colour').classList.add('hidden');
        showMainFields();
    });
    document.querySelector('a[href="#marker-circle"]').addEventListener('click', function () {
        shapeField.value = 3;
        document.querySelector('#map-marker-bg-colour').classList.remove('hidden');
        showMainFields();
    });
    document.querySelector('a[href="#marker-poly"]').addEventListener('click', function () {
        shapeField.value = 5;
        document.querySelector('#map-marker-bg-colour').classList.remove('hidden');
        showMainFields();
    });
    document.querySelector('a[href="#presets"]')?.addEventListener('click', function (e) {
        let target = e.currentTarget;
        loadPresets(target.dataset.presets);
    });
    document.querySelector('a[href="#form-markers"]')?.addEventListener('click', function () {
        window.map.invalidateSize();
    });
};

/**
 *
 */
const initMapExplore = () => {
    //console.log('initMapExplore', '');
    if (!mapPageBody) {
        //console.log('initMapExplore', 'no explore mode');
        return;
    }

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
                sidebarMarker.innerHTML = result.body;
                sidebarMarker.classList.remove('hidden');
                sidebarMarker.parentNode.querySelector('.spinner').classList.add('hidden');

                handleCloseMarker();
                mapPageBody.classList.add('sidebar-open');

                window.triggerEvent();
            });
    };

    initTicker();
    initLegend();
    initZoom();

    // When the sidebar gets triggers, we need to tell the map that its bounds have changed
    $(document).on('expanded.pushMenu collapsed.pushMenu', function () {
        window.map.invalidateSize();
    });
};

/**
 * When submitting the layer or marker form from the map modal, disable the map form unsaved changed
 * alert.
 */
const initForms = () => {
    initTabs();
    initCircle();
    initPolygonDrawing();

    //console.info('mapsv3', 'initMapForms');
    const markerForm = document.querySelector('#map-marker-form');
    const markerEditForm = document.querySelector('.map-marker-edit-form');
    if (!markerForm && !markerEditForm) {
        //console.info('initMapForms empty');
        return;
    }

    markerForm.onsubmit = function() {
        window.entityFormHasUnsavedChanges = false;
    };

    initLegend();
};

const initCircle = () => {
    const size = document.querySelector('select[name="size_id"]');
    if (!size) {
        return;
    }
    size.addEventListener('change', function (e) {
        if (size.value == 6) {
            document.querySelector('.map-marker-circle-helper').classList.add('hidden');
            document.querySelector('.map-marker-circle-radius').classList.remove('hidden');
        } else {
            document.querySelector('.map-marker-circle-radius').classList.add('hidden');
            document.querySelector('.map-marker-circle-helper').classList.remove('hidden');
        }
    });
};

const showSidebar = () =>
{
    // On mobile use the modal instead of the sidebar
    if (isMobile.matches) {
        return;
    }

    //window.map.invalidateSize();
    mapPageBody.classList.remove('sidebar-collapse');
    mapPageBody.classList.add('sidebar-open');
    sidebarMap.classList.add('hidden');
    sidebarMarker.innerHTML = '';
    sidebarMarker.classList.remove('hidden');
    sidebarMarker.parentNode.querySelector('.spinner').classList.remove('hidden');
    invalidateMapOnSidebar();
};

const handleCloseMarker = () =>
{
    document.querySelector('.marker-close')?.addEventListener('click', function () {
        sidebarMarker.classList.add('hidden');
        sidebarMap.classList.remove('hidden');
    });
};

const initTicker = () => {
    const config = document.getElementById('ticker-config');
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
    document.querySelectorAll('.map-legend-marker')?.forEach(el => {
        el.addEventListener('click', function (ev) {
            ev.preventDefault();
            window.map.panTo(L.latLng(el.dataset.lat, el.dataset.lng));
            window[el.dataset.id].openPopup();
        });
    });

    document.querySelector('a.sidebar-toggle')?.addEventListener('click', function () {
        invalidateMapOnSidebar();
    });
};

const invalidateMapOnSidebar = () => {
    setTimeout(() => {
        // Invalidate the map size when the sidebar is rendered/hidden
        window.map.invalidateSize();
    }, 500);
};

const initZoom = () => {
    LControlZoomDisplay.default(L, {
        position: 'bottomleft',
        prefix: 'Zoom : ',
    });
    L.control.zoomDisplay().addTo(window.map);
};
const initMapEntryClick = () => {
    document.querySelector('.map-marker-entry-click')?.addEventListener('click', function (e) {
        e.preventDefault();
        const el = e.target;
        el.parentNode.classList.add('hidden');
        document.querySelector('.map-marker-entry-entry').classList.remove('hidden');
    });
};

/**
 * Register switching in and out of edit mode
 */
const registerModes = () => {
    const enable = document.querySelector('.btn-mode-enable');
    enable?.addEventListener('click', function (e) {
        e.preventDefault();
        window.exploreEditMode = true;
        document.querySelector('body').classList.add('map-edit-mode');
    });
    document.querySelector('.btn-mode-disable')?.addEventListener('click', function (e) {
        e.preventDefault();
        window.exploreEditMode = false;
        document.querySelector('body').classList.remove('map-edit-mode');
        if (window.polygon) {
            window.map.removeLayer(window.polygon);
        }
    });
    document.querySelector('.btn-mode-drawing')?.addEventListener('click', function (e) {
        e.preventDefault();
        endDrawing();
    });
};

const endDrawing = () => {
    window.drawingPolygon = false;
    document.querySelector('body').classList.remove('map-drawing-mode');
    window.openDialog('marker-modal');
};

const initPolygonDrawing = () => {
    const start = document.querySelector('#start-drawing-polygon');
    if (!start) {
        return;
    }
    start.addEventListener('click', function (e) {
        e.preventDefault();
        window.exploreEditMode = false;
        window.startNewPolygon();
        window.showToast(e.currentTarget.dataset.toast);
        document.querySelector('body').classList.add('map-drawing-mode');

        window.closeDialog('marker-modal');
    });

    eraseTempPolygonBtn = document.querySelector('#reset-polygon');
    eraseTempPolygonBtn.addEventListener('click', function (e) {
        e.preventDefault();
        if (window.polygon) {
            window.map.removeLayer(window.polygon);
        }
        document.querySelector('textarea[name="custom_shape"]').value = '';
        eraseTempPolygonBtn.classList.add('hidden');

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
};

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
    let shape = document.querySelector('textarea[name="custom_shape"]');
    shape.value = coords;
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
    document.querySelector('#marker-latitude').value = points.lat.toFixed(3);
    document.querySelector('#marker-longitude').value = points.lng.toFixed(3);
};

const isPolygon = () => {
    return Number(shapeField.value) === 5;
};
const isLabel = () => {
    return Number(shapeField.value) === 2;
};

window.addPolygonPosition = function(lat, lng) {
    const shape = document.querySelector('textarea[name="custom_shape"]');
    let current = shape.value;
    if (current.length > 0) {
        current += ' ';
    }
    shape.value = current + lat + ',' + lng;

    // Redraw the polygon
    let coords = shape.value;
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
    eraseTempPolygonBtn.classList.remove('hidden');
};

const getPolygonStyle = () => {
    polygonStrokeColour = document.querySelector('input[name="polygon_style[stroke]"]')?.value;
    if (!polygonStrokeColour || polygonStrokeColour.length < 7) {
        polygonStrokeColour = 'red';
    }

    polygonStrokeOpacity = document.querySelector('input[name="polygon_style[stroke-opacity]"]').value;
    if (isNaN(polygonStrokeOpacity) || !polygonStrokeOpacity) {
        polygonStrokeOpacity = 1;
    } else {
        polygonStrokeOpacity = polygonStrokeOpacity / 100;
    }

    polygonColour = document.querySelector('input[name="colour"]').value;
    if (!polygonColour || polygonColour.length < 7) {
        polygonColour = 'red';
    }

    polygonOpacity = document.querySelector('input[name="opacity"]').value;
    if (isNaN(polygonOpacity)) {
        polygonOpacity = 0.5;
    } else {
        polygonOpacity = polygonOpacity / 100;
    }

    polygonStrokeWeight = document.querySelector('input[name="polygon_style[stroke-width]"]').value;
    if (isNaN(polygonStrokeWeight) || !polygonStrokeWeight) {
        polygonStrokeWeight = 1;
    }
};

const showMainFields = () => {
    document.querySelector('#marker-main-fields')?.classList.remove('hidden');
    document.querySelector('#marker-footer')?.classList.remove('hidden');
};

const loadPresets = (url) => {
    if (!url) {
        console.log('aaa');
        return;
    }
    document.querySelector('#marker-main-fields')?.classList.add('hidden');
    document.querySelector('#marker-footer')?.classList.add('hidden');

    // If presets have already been loaded, skip loading/rendering of the list
    const list = document.querySelector('.marker-preset-list');
    if (list.dataset.loaded === '1') {
        return;
    }
    list.dataset.loaded = '1';

    fetch(url)
        .then(response => response.text())
        .then(response => {
            list.innerHTML = response;
            handlePresetClick();
        });
};

const handlePresetClick = () => {
    document.querySelectorAll('.preset-use')?.forEach(preset => {
        preset.addEventListener('click', function (e) {
            e.preventDefault();

            let url =   preset.dataset.url;
            preset.classList.add('loading');

            axios.get(url).then(res => {
                // Switch stuff around
                preset.classList.remove('loading');

                Object.keys(res.data.preset).forEach(key => {
                    let val = res.data.preset[key];

                    let field = document.querySelector('[name="' + key + '"]');
                    if (!field) {
                        //console.info('markerPreset', 'unknown field', key);
                        return;
                    }
                    if (key.endsWith('colour')) {
                        field.value = val;
                        document.querySelector('[name="' + key + '"]').dispatchEvent(new Event('input',));
                    } else {
                        field.value = val;
                    }
                });
                document.querySelector('a[href="#marker-pin"]').click();
            });
        });
    });
};

/**
 * Why is this here?
 */
function handleExploreMapClick(ev) {
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
    document.querySelector('#marker-latitude').value = lat;
    document.querySelector('#marker-longitude').value = lng;
    window.openDialog('marker-modal');
}

window.handleExploreMapClick = handleExploreMapClick;

window.map.invalidateSize();

window.map.on('popupopen', function (ev) {
    window.initDialogs();
});

initMapExplore();
initForms();
initMapEntryClick();
registerModes();
