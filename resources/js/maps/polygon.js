import L from 'leaflet'

export { centroid, serializeVertices } from './polygonVertices.js'

function crsFor(map) {
    return map.is_real ? L.CRS.EPSG3857 : L.CRS.Simple
}

function toPoint(crs, maxZoom, [lat, lng]) {
    return crs.latLngToPoint(L.latLng(lat, lng), maxZoom)
}

// Mirrors the ruler tool's own formula (resources/js/leaflet/ruler.js) so the
// numbers shown here always agree with what the ruler measures on the same map.
export function pathLength(vertices, map) {
    const crs = crsFor(map)
    const maxZoom = map.max_zoom
    const factor = map.distance_measure || 1
    let total = 0

    for (let i = 1; i < vertices.length; i++) {
        total += toPoint(crs, maxZoom, vertices[i - 1]).distanceTo(toPoint(crs, maxZoom, vertices[i]))
    }

    return total * factor / maxZoom
}

// Shoelace formula on projected pixel coordinates. Length scales linearly by
// k = factor / maxZoom (see pathLength), so area scales by k^2.
export function polygonArea(vertices, map) {
    const crs = crsFor(map)
    const maxZoom = map.max_zoom
    const k = (map.distance_measure || 1) / maxZoom
    const points = vertices.map((vertex) => toPoint(crs, maxZoom, vertex))

    let sum = 0
    for (let i = 0; i < points.length; i++) {
        const p1 = points[i]
        const p2 = points[(i + 1) % points.length]
        sum += p1.x * p2.y - p2.x * p1.y
    }

    return Math.abs(sum) / 2 * k * k
}
