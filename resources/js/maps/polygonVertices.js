export function centroid(vertices) {
    const count = vertices.length
    const totals = vertices.reduce(
        ([totalLat, totalLng], [lat, lng]) => [totalLat + lat, totalLng + lng],
        [0, 0]
    )

    return [totals[0] / count, totals[1] / count]
}

export function serializeVertices(vertices) {
    return vertices.map(([lat, lng]) => `${lat.toFixed(3)},${lng.toFixed(3)}`).join(' ')
}
