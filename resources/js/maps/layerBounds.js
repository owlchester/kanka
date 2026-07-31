export function layerBounds(layer, map) {
    const height = layer.height || map.height
    const width = layer.width || map.width

    return [[0, 0], [height, width]]
}
