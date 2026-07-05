<template>
    <div ref="mapEl" class="w-full h-screen"></div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'
import 'leaflet-editable'

const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})

const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish'])

const mapEl = ref(null)
let leafletMap = null
let pinLayer = null
let draftMarker = null
let draftPolygon = null
let polygonEditing = false
let draftCircle = null
let circleEditing = false

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

    if (props.map.is_chunked) {
        L.tileLayer(props.map.chunks_url, { attribution: '&copy; Kanka' }).addTo(leafletMap)

        return
    }

    L.imageOverlay(props.map.image, bounds()).addTo(leafletMap)
}

function buildLayers() {
    props.layers.forEach((layer) => {
        L.imageOverlay(layer.image, bounds()).addTo(leafletMap)
    })
}

function relativeLuminance(hex) {
    const value = hex.replace('#', '')
    const channels = [0, 2, 4].map((i) => parseInt(value.substring(i, i + 2), 16) / 255)
    const [r, g, b] = channels.map((c) => (c <= 0.03928 ? c / 12.92 : ((c + 0.055) / 1.055) ** 2.4))

    return 0.2126 * r + 0.7152 * g + 0.0722 * b
}

function contrastTextColour(hex) {
    return relativeLuminance(hex) > 0.179 ? '#000' : '#fff'
}

function pinIcon(pin) {
    const size = pin.pin_size || 40
    let inner = '<i class="fa-solid fa-map-pin"></i>'
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

    if (pin.shape === 'circle') {
        return L.circle([pin.latitude, pin.longitude], {
            radius: pin.circle_radius || 50,
            fillColor: pin.colour || '#ccc',
            stroke: false,
            fillOpacity: (pin.opacity || 100) / 100,
        })
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

    return L.marker([pin.latitude, pin.longitude], {
        icon: pinIcon(pin),
        opacity: (pin.opacity || 100) / 100,
    })
}

function buildPins() {
    if (pinLayer) {
        leafletMap.removeLayer(pinLayer)
    }

    pinLayer = props.map.has_clustering ? L.markerClusterGroup() : L.layerGroup()

    props.pins.forEach((pin) => {
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

    if (! props.draftPin || props.draftPin.shape === 'poly' || props.draftPin.shape === 'circle') {
        return
    }

    draftMarker = buildPin({ ...props.draftPin, id: 'draft' })
    draftMarker.addTo(leafletMap)
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

    draftCircle.on('editable:vertex:dragend', () => {
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

function handlePolygonKeydown(e) {
    if (props.activeMode !== 'area' || ! draftPolygon || polygonEditing) {
        return
    }

    if (e.key === 'Escape') {
        e.preventDefault()
        stopPolygonDraft()
        startPolygonDraft()

        return
    }

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
        options.maxBounds = bounds()
    }

    leafletMap = L.map(mapEl.value, options)

    L.control.zoom({ position: 'bottomleft' }).addTo(leafletMap)

    leafletMap.on('click', (e) => {
        if (props.activeMode === 'pin' || props.activeMode === 'text') {
            emit('map-click', { lat: e.latlng.lat, lng: e.latlng.lng })
        }
    })

    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()

    document.addEventListener('keydown', handlePolygonKeydown)
})

onBeforeUnmount(() => {
    document.removeEventListener('keydown', handlePolygonKeydown)
    leafletMap?.remove()
})
</script>

<style>
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

.marker i {
    font-size: 1.25rem;
    margin: 0;
    position: absolute !important;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.map-label {
    background-color: var(--label-colour, #fff);
    border-color: var(--label-colour, #fff);
    color: var(--label-text-colour, #222);
}

.marker-draft .marker-pin {
    outline: 2px dashed white;
    outline-offset: 2px;
}
</style>
