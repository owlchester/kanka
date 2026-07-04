<template>
    <div ref="mapEl" class="w-full h-screen"></div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'

const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
})

const emit = defineEmits(['pin-click', 'map-click'])

const mapEl = ref(null)
let leafletMap = null
let pinLayer = null
let draftMarker = null

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

    // Polygon pins are out of scope for v1 (see design doc) — skip rather than mis-render at the wrong spot
    props.pins.filter((pin) => pin.shape !== 'poly').forEach((pin) => {
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

    if (! props.draftPin) {
        return
    }

    draftMarker = buildPin({ ...props.draftPin, id: 'draft' })
    draftMarker.addTo(leafletMap)
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

watch(() => props.draftPin, () => {
    if (leafletMap) {
        buildDraftMarker()
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
})

onBeforeUnmount(() => {
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
