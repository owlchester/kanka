<template>
    <div ref="mapEl" class="w-full h-screen"></div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'
import 'leaflet-editable'
import 'leaflet.path.drag'
import '../../leaflet/ruler.js'

const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
    editingPin: { type: Object, default: null },
    previewCenter: { type: Array, default: null },
    canEdit: { type: Boolean, default: false },
    remoteCursors: { type: Object, default: () => ({}) },
    legacyPins: { type: Boolean, default: false },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})

const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish', 'measure-change', 'pin-moved', 'cursor-move', 'draft-move', 'edit-move', 'edit-polygon-change', 'edit-circle-change', 'edit-path-change'])

const mapEl = ref(null)
let leafletMap = null
let pinLayer = null
let draftMarker = null
let draftPolygon = null
let polygonEditing = false
let draftCircle = null
let circleEditing = false
let draftPath = null
let pathEditing = false
let rulerControl = null
let gridLayer = null
let editMarker = null
let editCircle = null
let editPolygon = null
let editPath = null

function buildGrid() {
    if (gridLayer) {
        leafletMap.removeLayer(gridLayer)
        gridLayer = null
    }

    const grid = props.map.settings?.grid
    if (! grid) {
        return
    }

    gridLayer = L.layerGroup()

    // Same colour-resolution gotcha as buildRuler(): Leaflet's SVG renderer sets
    // stroke via a raw attribute, so a var(--custom-property) reference isn't
    // reliably resolved there — resolve it to a literal first.
    const gridColor = resolveCssColor('hsl(var(--pc) / 1)')
    const style = { color: gridColor, weight: 1, opacity: 0.2 }

    const verticalLines = []
    for (let i = grid; i <= props.map.height; i += grid) {
        verticalLines.push([[i, 0], [i, props.map.width]])
    }

    const horizontalLines = []
    for (let i = grid; i <= props.map.width; i += grid) {
        horizontalLines.push([[0, i], [props.map.height, i]])
    }

    L.polyline(verticalLines, style).addTo(gridLayer)
    L.polyline(horizontalLines, style).addTo(gridLayer)

    gridLayer.addTo(leafletMap)
}

let cursorLayer = null

function cursorIcon(colour) {
    return L.divIcon({
        html: `<svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
            <polygon points="1,1 1,15 5,11.5 7.5,17 10,16 7.5,10.5 13,10.5" fill="${colour}" stroke="white" stroke-width="1.5" stroke-linejoin="round" />
        </svg>`,
        iconSize: [18, 18],
        iconAnchor: [1, 1],
        className: 'remote-cursor-icon',
    })
}

function buildCursors() {
    if (cursorLayer) {
        leafletMap.removeLayer(cursorLayer)
    }

    cursorLayer = L.layerGroup()

    Object.values(props.remoteCursors).forEach((cursor) => {
        L.marker([cursor.lat, cursor.lng], {
            icon: cursorIcon(cursor.colour),
            interactive: false,
        }).addTo(cursorLayer)
    })

    cursorLayer.addTo(leafletMap)
}

// Leaflet's SVG renderer sets path colours via path.setAttribute('stroke', ...)
// (a raw SVG presentation attribute), not a CSS style property — a
// var(--custom-property) reference placed there is not reliably resolved by
// the browser the way it would be in an actual CSS declaration. Resolve the
// custom property to a concrete computed colour (e.g. "rgb(...)") by applying
// it to a real CSS property on a throwaway element first, then hand Leaflet
// that literal value instead.
function resolveCssColor(value) {
    const probe = document.createElement('span')
    probe.style.color = value
    document.body.appendChild(probe)
    const resolved = getComputedStyle(probe).color
    document.body.removeChild(probe)

    return resolved
}

function buildRuler() {
    if (rulerControl) {
        leafletMap.removeControl(rulerControl)
        rulerControl = null
    }

    if (! props.map.has_distance_unit) {
        return
    }

    const rulerColor = resolveCssColor('var(--map-ruler-color)')

    rulerControl = L.control.ruler({
        // Leaflet's control default is 'topright', which sits directly under
        // DetailPanel/MarkerPanel (fixed top-4 right-4 bottom-4) and becomes
        // fully hidden and unclickable whenever a pin is selected or a draft
        // is open. 'bottomleft' keeps it reachable, stacked with the zoom
        // control which was placed there for the same reason.
        position: 'bottomleft',
        circleMarker: {
            color: rulerColor,
            radius: 2,
        },
        lineStyle: {
            color: rulerColor,
            dashArray: '1,6',
        },
        lengthUnit: {
            factor: props.map.distance_measure,
            display: props.map.distance_name,
            decimal: 2,
        },
        onToggle: (active) => emit('measure-change', active),
    }).addTo(leafletMap)
}

function bounds() {
    return [[0, 0], [props.map.height, props.map.width]]
}

function buildBaseLayer() {
    if (props.map.is_real) {
        L.tileLayer(props.map.tile_url, {
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(leafletMap)

        return
    }

    if (props.map.is_tiled) {
        L.tileLayer(props.map.tiles_url, {
            attribution: '&copy; Kanka',
            errorTileUrl: '/images/map_chunks/transparent.png',
        }).addTo(leafletMap)

        return
    }

    L.imageOverlay(props.map.image, bounds()).addTo(leafletMap)
}

const renderedLayerIds = new Set()

function buildLayers() {
    props.layers.forEach((layer) => {
        L.imageOverlay(layer.image, bounds()).addTo(leafletMap)
        renderedLayerIds.add(layer.id)
    })
}

watch(
    () => props.layers,
    (layers) => {
        layers.forEach((layer) => {
            if (renderedLayerIds.has(layer.id)) {
                return
            }
            L.imageOverlay(layer.image, bounds()).addTo(leafletMap)
            renderedLayerIds.add(layer.id)
        })
    },
)

function relativeLuminance(hex) {
    const value = hex.replace('#', '')
    const channels = [0, 2, 4].map((i) => parseInt(value.substring(i, i + 2), 16) / 255)
    const [r, g, b] = channels.map((c) => (c <= 0.03928 ? c / 12.92 : ((c + 0.055) / 1.055) ** 2.4))

    return 0.2126 * r + 0.7152 * g + 0.0722 * b
}

function contrastTextColour(hex) {
    return relativeLuminance(hex) > 0.179 ? '#000' : '#fff'
}

const DEFAULT_MARKER_SIZE = 24
const LEGACY_MARKER_SIZE = 40
const DEFAULT_PIN_ICON = 'fa-solid fa-map-pin'

function markerSize(pin) {
    const configured = pin.pin_size || LEGACY_MARKER_SIZE

    return Math.round(configured * (DEFAULT_MARKER_SIZE / LEGACY_MARKER_SIZE))
}

function isDefaultPinIcon(icon) {
    return !icon || (icon.type === 'fa' && icon.value === DEFAULT_PIN_ICON)
}

function legacyPinIcon(pin) {
    const size = pin.pin_size || LEGACY_MARKER_SIZE
    let inner = `<i class="${DEFAULT_PIN_ICON}"></i>`
    let style = `--pin-size: ${size}px; background-color: ${pin.colour || '#ccc'};`

    if (pin.icon?.type === 'fa') {
        inner = `<i class="${pin.icon.value}" aria-hidden="true"></i>`
    } else if (pin.icon?.type === 'html' || pin.icon?.type === 'svg') {
        inner = pin.icon.value
    } else if (pin.icon?.type === 'avatar') {
        inner = ''
        // The avatar image is painted on ::after (counter-rotated), not this div (rotated -45deg),
        // so the image itself renders upright instead of tilted.
        style = `--pin-size: ${size}px; --pin-avatar: url('${pin.icon.value}');`
    }

    return L.divIcon({
        html: `<div class="marker-pin" style="${style}"></div>${inner}`,
        iconSize: [size, size],
        iconAnchor: [size / 2, size + size / 4],
        popupAnchor: [0, -(size + size / 4)],
        className: `marker marker-${pin.id}`,
    })
}

function modernPinIcon(pin) {
    const size = markerSize(pin)
    const colour = pin.colour || '#ccc'
    const icon = pin.icon

    if (icon?.type === 'avatar') {
        return L.divIcon({
            html: `<img src="${icon.value}" class="marker-avatar" style="width: ${size}px; height: ${size}px; --pin-colour: ${colour};" />`,
            iconSize: [size, size],
            iconAnchor: [size / 2, size / 2],
            popupAnchor: [0, -(size / 2)],
            className: `marker marker-${pin.id}`,
        })
    }

    if (icon?.type === 'svg') {
        return L.divIcon({
            html: `<img src="${icon.value}" class="marker-image" style="width: ${size}px; height: ${size}px; --pin-colour: ${colour};" />`,
            iconSize: [size, size],
            iconAnchor: [size / 2, size / 2],
            popupAnchor: [0, -(size / 2)],
            className: `marker marker-${pin.id}`,
        })
    }

    const isPin = isDefaultPinIcon(icon)
    const inner = icon?.type === 'html'
        ? icon.value
        : `<i class="${isPin ? 'fa-solid fa-location-pin' : (icon?.value || 'fa-solid fa-location-pin')}" aria-hidden="true"></i>`

    // The default pin keeps its tip anchored to the point, like a map pin; every
    // other shape/custom icon is anchored on its center, like a generic marker.
    const anchor = isPin ? size : size / 2

    return L.divIcon({
        html: `<div class="marker-icon" style="--pin-colour: ${colour}; color: ${colour}; font-size: ${size}px;">${inner}</div>`,
        iconSize: [size, size],
        iconAnchor: [size / 2, anchor],
        popupAnchor: [0, -anchor],
        className: `marker marker-${pin.id}`,
    })
}

function pinIcon(pin) {
    return props.legacyPins ? legacyPinIcon(pin) : modernPinIcon(pin)
}

function movePinTo(pin, layer) {
    const { lat, lng } = layer.getLatLng()

    axios.post(pin.move_url, { latitude: lat, longitude: lng })
        .then(() => {
            emit('pin-moved', { id: pin.id, latitude: lat, longitude: lng })
        })
        .catch(() => {
            layer.setLatLng([pin.latitude, pin.longitude])
        })
}

function buildPin(pin) {
    if (pin.shape === 'poly') {
        const latlngs = pin.custom_shape || pin.customShape || []
        const style = pin.polygon_style || pin.polygonStyle || {}

        return L.polygon(latlngs, {
            color: style.stroke || pin.colour || '#ccc',
            weight: style['stroke-width'] || 1,
            fillColor: pin.colour || '#ccc',
            fillOpacity: (pin.opacity || 100) / 100,
        })
    }

    if (pin.shape === 'path') {
        const latlngs = pin.custom_shape || pin.customShape || []
        const style = pin.polygon_style || pin.polygonStyle || {}

        return L.polyline(latlngs, {
            color: pin.colour || '#ccc',
            weight: style['stroke-width'] || 1,
            opacity: (pin.opacity || 100) / 100,
        })
    }

    if (pin.shape === 'circle') {
        const draggable = props.canEdit && pin.is_draggable
        const circle = L.circle([pin.latitude, pin.longitude], {
            radius: pin.circle_radius || 50,
            fillColor: pin.colour || '#ccc',
            stroke: false,
            fillOpacity: (pin.opacity || 100) / 100,
            draggable,
        })

        if (draggable) {
            circle.on('dragend', (e) => movePinTo(pin, e.target))
        }

        return circle
    }

    if (pin.shape === 'label') {
        const marker = L.marker([pin.latitude, pin.longitude], { opacity: 0 })
            .bindTooltip(pin.name, { permanent: true, direction: 'center', className: 'map-label' })

        marker.on('tooltipopen', () => {
            const el = marker.getTooltip()?.getElement()
            if (!el) {
                return
            }

            el.style.opacity = (pin.opacity ?? 100) / 100

            if (pin.colour) {
                el.style.setProperty('--label-colour', pin.colour)
                el.style.setProperty('--label-text-colour', contrastTextColour(pin.colour))
            }
        })

        return marker
    }

    const draggable = props.canEdit && pin.is_draggable
    const marker = L.marker([pin.latitude, pin.longitude], {
        icon: pinIcon(pin),
        opacity: (pin.opacity || 100) / 100,
        draggable,
    })

    if (draggable) {
        marker.on('dragend', (e) => movePinTo(pin, e.target))
    }

    return marker
}

function buildPins() {
    if (pinLayer) {
        leafletMap.removeLayer(pinLayer)
    }

    pinLayer = props.map.has_clustering ? L.markerClusterGroup() : L.layerGroup()

    props.pins
        .filter((pin) => pin.id !== props.editingPin?.id)
        .forEach((pin) => {
            const marker = buildPin(pin)
            marker.on('click', (e) => {
                L.DomEvent.stopPropagation(e)
                emit('pin-click', pin)
            })
            pinLayer.addLayer(marker)
        })

    pinLayer.addTo(leafletMap)
}

function buildDraftMarker() {
    if (draftMarker) {
        leafletMap.removeLayer(draftMarker)
        draftMarker = null
    }

    if (! props.draftPin || props.draftPin.shape === 'poly' || props.draftPin.shape === 'circle' || props.draftPin.shape === 'path') {
        return
    }

    draftMarker = buildPin({ ...props.draftPin, id: 'draft' })
    draftMarker.addTo(leafletMap)

    if (props.canEdit) {
        draftMarker.dragging?.enable()
        draftMarker.on('dragend', (e) => {
            const { lat, lng } = e.target.getLatLng()
            emit('draft-move', { lat, lng })
        })
    }
}

function clearEditLayer() {
    if (editMarker) {
        leafletMap.removeLayer(editMarker)
        editMarker = null
    }

    if (editCircle) {
        editCircle.disableEdit()
        leafletMap.removeLayer(editCircle)
        editCircle = null
    }

    if (editPolygon) {
        editPolygon.disableEdit()
        leafletMap.removeLayer(editPolygon)
        editPolygon = null
    }

    if (editPath) {
        editPath.disableEdit()
        leafletMap.removeLayer(editPath)
        editPath = null
    }
}

// Rebuilds the whole live-editable layer for props.editingPin from scratch on every change
// (a geometry drag or a plain field edit alike), mirroring how buildDraftMarker() already
// tears down and recreates its marker on every draftPin change. Each vertex/handle drag
// completes (dragend) before this runs, so recreating the layer — and re-attaching a fresh
// Leaflet.Editable editor via enableEdit() — between drags is safe.
// Shape -> the toolbar activeMode that actively draws it from scratch via startPolygonDraft()
// et al. Used by buildEditLayer() to tell a duplicated draft pin's already-complete shape
// (render it here) apart from one still being freshly drawn (leave that to draftPolygon/etc).
const DRAWING_MODE_FOR_SHAPE = { poly: 'area', path: 'path', circle: 'circle' }

function buildEditLayer() {
    clearEditLayer()

    // Also renders a duplicated draft pin's pre-filled shape (poly/path/circle) as an
    // immediately draggable/editable layer — buildDraftMarker() only handles point shapes,
    // and startPolygonDraft()/etc only ever start empty, neither of which fit a duplicate
    // that already has a complete customShape/circleRadius. Skip it while the matching
    // toolbar mode is still actively drawing this same draft from scratch.
    const draftShapeMode = props.draftPin && DRAWING_MODE_FOR_SHAPE[props.draftPin.shape]
    const draftIsPrefilledShape = draftShapeMode && props.activeMode !== draftShapeMode
    const pin = props.editingPin ?? (draftIsPrefilledShape ? props.draftPin : null)
    if (! pin) {
        return
    }

    if (pin.shape === 'poly') {
        editPolygon = L.polygon(pin.customShape || [], {
            color: pin.polygonStyle?.stroke || pin.colour || '#ccc',
            weight: pin.polygonStyle?.['stroke-width'] || 1,
            fillColor: pin.colour || '#ccc',
            fillOpacity: (pin.opacity ?? 100) / 100,
        }).addTo(leafletMap)
        editPolygon.enableEdit()
        editPolygon.on('editable:vertex:new editable:vertex:dragend editable:dragend editable:vertex:deleted', () => {
            const rings = editPolygon.getLatLngs()
            emit('edit-polygon-change', (rings[0] || []).map((point) => [point.lat, point.lng]))
        })

        return
    }

    if (pin.shape === 'path') {
        editPath = L.polyline(pin.customShape || [], {
            color: pin.colour || '#ccc',
            weight: pin.polygonStyle?.['stroke-width'] || 1,
            opacity: (pin.opacity ?? 100) / 100,
        }).addTo(leafletMap)
        editPath.enableEdit()
        editPath.on('editable:vertex:new editable:vertex:dragend editable:dragend editable:vertex:deleted', () => {
            emit('edit-path-change', editPath.getLatLngs().map((point) => [point.lat, point.lng]))
        })

        return
    }

    if (pin.shape === 'circle') {
        editCircle = L.circle([pin.latitude, pin.longitude], {
            radius: pin.circleRadius || 50,
            fillColor: pin.colour || '#ccc',
            stroke: false,
            fillOpacity: (pin.opacity ?? 100) / 100,
        }).addTo(leafletMap)
        editCircle.enableEdit()
        editCircle.on('editable:vertex:dragend editable:dragend', () => {
            const center = editCircle.getLatLng()
            emit('edit-circle-change', { lat: center.lat, lng: center.lng, radius: editCircle.getRadius() })
        })

        return
    }

    editMarker = buildPin({ ...pin, id: 'editing' })
    editMarker.addTo(leafletMap)
    editMarker.dragging?.enable()
    editMarker.on('dragend', (e) => {
        const { lat, lng } = e.target.getLatLng()
        emit('edit-move', { lat, lng })
    })
}

function polygonLatLngs() {
    if (! draftPolygon) {
        return []
    }

    const rings = draftPolygon.getLatLngs()

    return (rings[0] || []).map((point) => [point.lat, point.lng])
}

function styleDraftPolygon() {
    if (! draftPolygon || ! props.draftPin) {
        return
    }

    const style = props.draftPin.polygonStyle || {}

    draftPolygon.setStyle({
        color: style.stroke || props.draftPin.colour || '#ccc',
        weight: style['stroke-width'] || 1,
        fillColor: props.draftPin.colour || '#ccc',
        fillOpacity: (props.draftPin.opacity ?? 100) / 100,
    })
}

function startPolygonDraft() {
    const style = props.defaultPolygonStyle

    draftPolygon = leafletMap.editTools.startPolygon(undefined, {
        color: style.stroke,
        weight: style['stroke-width'],
        fillColor: style.colour,
        fillOpacity: style.opacity / 100,
    })
    polygonEditing = false

    leafletMap.doubleClickZoom.disable()

    draftPolygon.on('editable:vertex:new editable:vertex:dragend editable:dragend editable:vertex:deleted', () => {
        emit('polygon-change', polygonLatLngs())
    })

    draftPolygon.on('editable:drawing:commit', () => {
        polygonEditing = true
        emit('polygon-finish', polygonLatLngs())
    })
}

function stopPolygonDraft() {
    if (! draftPolygon) {
        return
    }

    draftPolygon.disableEdit()
    leafletMap.removeLayer(draftPolygon)
    draftPolygon = null
    polygonEditing = false
    leafletMap.doubleClickZoom.enable()
}

function circleLatLngRadius() {
    if (! draftCircle) {
        return null
    }

    const center = draftCircle.getLatLng()

    return { lat: center.lat, lng: center.lng, radius: draftCircle.getRadius() }
}

function styleDraftCircle() {
    if (! draftCircle || ! props.draftPin) {
        return
    }

    draftCircle.setStyle({
        fillColor: props.draftPin.colour || '#ccc',
        fillOpacity: (props.draftPin.opacity ?? 100) / 100,
    })
}

function startCircleDraft() {
    const style = props.defaultPolygonStyle

    draftCircle = leafletMap.editTools.startCircle(undefined, {
        fillColor: style.colour,
        fillOpacity: style.opacity / 100,
        stroke: false,
    })
    circleEditing = false

    draftCircle.on('editable:vertex:dragend editable:dragend', () => {
        emit('circle-change', circleLatLngRadius())
    })

    draftCircle.on('editable:drawing:commit', () => {
        circleEditing = true
        emit('circle-finish', circleLatLngRadius())
    })
}

function stopCircleDraft() {
    if (! draftCircle) {
        return
    }

    draftCircle.disableEdit()
    leafletMap.removeLayer(draftCircle)
    draftCircle = null
    circleEditing = false
}

function pathLatLngs() {
    if (! draftPath) {
        return []
    }

    return draftPath.getLatLngs().map((point) => [point.lat, point.lng])
}

function styleDraftPath() {
    if (! draftPath || ! props.draftPin) {
        return
    }

    const style = props.draftPin.polygonStyle || {}

    draftPath.setStyle({
        color: props.draftPin.colour || '#ccc',
        weight: style['stroke-width'] || 1,
        opacity: (props.draftPin.opacity ?? 100) / 100,
    })
}

function startPathDraft() {
    const style = props.defaultPolygonStyle

    draftPath = leafletMap.editTools.startPolyline(undefined, {
        color: style.stroke,
        weight: style['stroke-width'],
        opacity: style.opacity / 100,
    })
    pathEditing = false

    leafletMap.doubleClickZoom.disable()

    draftPath.on('editable:vertex:new editable:vertex:dragend editable:dragend editable:vertex:deleted', () => {
        emit('path-change', pathLatLngs())
    })

    draftPath.on('editable:drawing:commit', () => {
        pathEditing = true
        emit('path-finish', pathLatLngs())
    })
}

function stopPathDraft() {
    if (! draftPath) {
        return
    }

    draftPath.disableEdit()
    leafletMap.removeLayer(draftPath)
    draftPath = null
    pathEditing = false
    leafletMap.doubleClickZoom.enable()
}

function handlePolygonKeydown(e) {
    if (props.activeMode !== 'area' || ! draftPolygon || polygonEditing) {
        return
    }

    // Escape is handled by MapExplorer's global keydown handler, which cancels the whole
    // draft (sets activeMode to null) rather than just restarting the vertex list.
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'z') {
        e.preventDefault()
        draftPolygon.editor.pop()
        emit('polygon-change', polygonLatLngs())
    }
}

watch(() => props.centerNonce, () => {
    if (props.centerPin && leafletMap) {
        leafletMap.setView([props.centerPin.latitude, props.centerPin.longitude])
    }
})

watch(() => props.pins, () => {
    if (leafletMap) {
        buildPins()
    }
})

watch(() => props.legacyPins, () => {
    if (leafletMap) {
        buildPins()
    }
})

watch(() => props.map.settings?.grid, () => {
    if (leafletMap) {
        buildGrid()
    }
})

watch(() => props.remoteCursors, () => {
    if (leafletMap) {
        buildCursors()
    }
})

watch(() => [props.map.min_zoom, props.map.max_zoom], ([min, max]) => {
    if (leafletMap) {
        leafletMap.setMinZoom(min)
        leafletMap.setMaxZoom(max)
    }
})

watch(() => props.previewCenter, (center) => {
    if (leafletMap && center) {
        leafletMap.setView(center)
    }
})

watch(() => [props.map.has_distance_unit, props.map.distance_measure, props.map.distance_name], () => {
    if (leafletMap) {
        buildRuler()
    }
})

watch(() => props.draftPin, (pin) => {
    if (! leafletMap) {
        return
    }

    buildDraftMarker()

    if (pin?.shape === 'poly') {
        styleDraftPolygon()
    }

    if (pin?.shape === 'circle') {
        styleDraftCircle()
    }

    if (pin?.shape === 'path') {
        styleDraftPath()
    }
})

watch(() => props.editingPin?.id, () => {
    if (leafletMap) {
        buildPins()
    }
})

watch(() => [props.editingPin, props.draftPin, props.activeMode], () => {
    if (leafletMap) {
        buildEditLayer()
    }
})

watch(() => [props.activeMode, props.draftPin], () => {
    if (! leafletMap) {
        return
    }

    if (props.activeMode !== 'area') {
        stopPolygonDraft()

        return
    }

    if (! props.draftPin && polygonEditing) {
        stopPolygonDraft()
        startPolygonDraft()

        return
    }

    if (! draftPolygon) {
        startPolygonDraft()
    }
})

watch(() => [props.activeMode, props.draftPin], () => {
    if (! leafletMap) {
        return
    }

    if (props.activeMode !== 'circle') {
        stopCircleDraft()

        return
    }

    if (! props.draftPin && circleEditing) {
        stopCircleDraft()
        startCircleDraft()

        return
    }

    if (! draftCircle) {
        startCircleDraft()
    }
})

watch(() => [props.activeMode, props.draftPin], () => {
    if (! leafletMap) {
        return
    }

    if (props.activeMode !== 'path') {
        stopPathDraft()

        return
    }

    if (! props.draftPin && pathEditing) {
        stopPathDraft()
        startPathDraft()

        return
    }

    if (! draftPath) {
        startPathDraft()
    }
})

watch(() => props.activeMode, (mode) => {
    if (mode && rulerControl) {
        rulerControl.disable()
    }

    if (leafletMap) {
        leafletMap.getContainer().style.cursor = mode === 'center-pick' ? 'crosshair' : ''
    }
})

onMounted(() => {
    const options = {
        zoom: props.map.initial_zoom,
        minZoom: props.map.min_zoom,
        maxZoom: props.map.max_zoom,
        center: props.map.center,
        attributionControl: false,
        zoomControl: false,
        editable: true,
    }

    if (! props.map.is_real) {
        options.crs = L.CRS.Simple

        // Tiled maps use a Leaflet tile-layer pyramid under CRS.Simple, where zoom and world
        // coordinates are linked (point = latlng * 2^zoom) — the raw full-resolution pixel
        // bounds this app computes for plain image overlays don't correctly constrain a tile
        // pyramid's viewport, and can push the visible content outside the forced bounds for
        // large images. Skip bounds-forcing for tiled maps until that's properly reworked;
        // plain (non-tiled) custom maps are unaffected and keep the existing behavior.
        if (! props.map.is_tiled) {
            options.maxBounds = bounds()
        }
    }

    leafletMap = L.map(mapEl.value, options)

    L.control.zoom({ position: 'bottomleft' }).addTo(leafletMap)

    leafletMap.on('click', (e) => {
        if (props.activeMode === 'pin' || props.activeMode === 'text' || props.activeMode === 'center-pick') {
            emit('map-click', { lat: e.latlng.lat, lng: e.latlng.lng })
        }
    })

    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()
    buildEditLayer()
    buildGrid()
    buildRuler()
    buildCursors()

    let lastCursorSentAt = 0
    leafletMap.on('mousemove', (e) => {
        const now = Date.now()
        if (now - lastCursorSentAt < 100) {
            return
        }
        lastCursorSentAt = now
        emit('cursor-move', { lat: e.latlng.lat, lng: e.latlng.lng })
    })

    document.addEventListener('keydown', handlePolygonKeydown)
})

onBeforeUnmount(() => {
    document.removeEventListener('keydown', handlePolygonKeydown)
    rulerControl = null
    leafletMap?.remove()
})

defineExpose({
    // Offsets a lat/lng by a fixed amount of screen pixels at the map's current zoom, rather
    // than a fixed lat/lng delta — the latter would be imperceptible on a real (EPSG3857,
    // degree-scale) map and enormous on a large image (pixel-scale) map. A pixel offset looks
    // like the same small, sensible gap regardless of the map's CRS or current zoom level.
    offsetLatLng(lat, lng, dx, dy) {
        if (! leafletMap) {
            return { lat, lng }
        }

        const point = leafletMap.latLngToContainerPoint([lat, lng])
        const offsetPoint = L.point(point.x + dx, point.y + dy)
        const offsetLatLng = leafletMap.containerPointToLatLng(offsetPoint)

        return { lat: offsetLatLng.lat, lng: offsetLatLng.lng }
    },
})
</script>

<style>
/* This component's page (mounted via explore.js/layouts.rich) never loads
   resources/css/maps/maps.css, where the legacy map view defines this same
   variable — define it here too so ruler/tooltip colouring doesn't silently
   fall back to the inherited body text colour. */
:root {
    --map-ruler-color: hsl(var(--p)/1);
}

.marker {
    color: white;
    background-color: unset;
    text-align: center;
}

.marker-pin {
    width: var(--pin-size, 40px);
    height: var(--pin-size, 40px);
    border-radius: 50% 50% 50% 0;
    position: absolute;
    transform: rotate(-45deg);
    left: 50%;
    top: 50%;
    margin: calc(var(--pin-size, 40px) / -2) 0 0 calc(var(--pin-size, 40px) / -2);
    box-shadow: 0 6px 6px rgba(50, 50, 93, 0.31), 0 1px 3px rgba(0, 0, 0, 0.08);
}

.marker-pin::after {
    content: '';
    width: calc(var(--pin-size, 40px) - 4px);
    height: calc(var(--pin-size, 40px) - 4px);
    margin: 2px 0 0 calc((var(--pin-size, 40px) - 4px) / -2);
    position: absolute;
    border-radius: 50%;
    background-image: var(--pin-avatar, none);
    background-position: 50% 50%;
    background-size: cover;
    background-repeat: no-repeat;
    transform: rotate(45deg);
}

.marker > i {
    font-size: 1.25rem;
    margin: 0;
    position: absolute !important;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.marker-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    line-height: 1;
    -webkit-text-stroke: 1px hsl(var(--bc));
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.35));
}

.marker-avatar,
.marker-image {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    object-fit: cover;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.35));
}

.marker-avatar {
    border-radius: 50%;
    border: 2px solid hsl(var(--bc));
}

.map-label {
    background-color: var(--label-colour, hsl(var(--b1)/1));
    border-color: var(--label-colour, hsl(var(--b1)/1));
    color: var(--label-text-colour, hsl(var(--bc)/1));
}

.marker-draft .marker-icon,
.marker-draft .marker-avatar,
.marker-draft .marker-image {
    outline: 2px dashed var(--pin-colour, white);
    outline-offset: 3px;
    border-radius: 9999px;
}

.marker-draft .marker-pin {
    outline: 2px dashed hsl(var(--p)/1);
    outline-offset: 2px;
}

.remote-cursor-icon {
    background: transparent;
    border: none;
}

.result-tooltip {
    background-color: hsl(var(--b1)/1);
    border-width: medium;
    border-color: var(--map-ruler-color);
    color: hsl(var(--bc)/1);
    font-size: smaller;
}

.moving-tooltip {
    background-color: hsl(var(--b1)/0.7);
    background-clip: padding-box;
    opacity: 0.5;
    border: dotted;
    border-color: var(--map-ruler-color);
    color: hsl(var(--bc)/1);
    font-size: smaller;
}

.leaflet-touch .leaflet-bar {
    background-color: hsl(var(--b1)/1);
    color: hsl(var(--bc)/1);
}
.leaflet-bar {
    border-radius: var(--rounded-btn);
}
.leaflet-touch .leaflet-bar a, .leaflet-touch .leaflet-bar>i {
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: unset;
    color: hsl(var(--bc)/1);
}
.leaflet-bar a {
    border-bottom: 1px solid hsl(var(--bc)/1);
}
.leaflet-touch .leaflet-control-layers, .leaflet-touch .leaflet-bar {
    border: none;
    background-color: hsl(var(--b1)/1);
    color: hsl(var(--bc)/1);
    border-radius: var(--rounded-btn);
}

.plus-length {
    padding-left: 45px;
}
</style>
