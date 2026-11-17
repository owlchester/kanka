import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'

const source = readFileSync(new URL('../components/maps/LeafletCanvas.vue', import.meta.url), 'utf8')
const buildPinsSource = source.slice(source.indexOf('function buildPins() {'), source.indexOf('\nfunction buildDraftMarker()'))

function createMap({ clustering = false } = {}) {
    const activeLayers = new Set()
    const groupLayers = new Map()
    const props = { map: { has_clustering: clustering }, groups: [], pins: [] }
    const leafletMap = {
        hasLayer: (layer) => activeLayers.has(layer),
        removeLayer(layer) {
            activeLayers.delete(layer)
            layer?.groups?.forEach((group) => activeLayers.delete(group))
        },
    }
    function layerGroup() {
        return {
            groups: [],
            addLayer() {},
            checkIn(group) { this.groups.push(group) },
            addTo() { activeLayers.add(this) },
        }
    }
    const buildPins = new Function('props', 'leafletMap', 'groupLayers', 'L', `
        let pinLayer = null
        const renderedPins = new Map()
        const buildLayerControl = () => {}
        ${buildPinsSource}
        return buildPins
    `)(props, leafletMap, groupLayers, {
        layerGroup,
        markerClusterGroup: { layerSupport: layerGroup },
    })

    return {
        props,
        buildPins,
        show(id) { groupLayers.get(id).leafletLayer.addTo(leafletMap) },
        hide(id) { leafletMap.removeLayer(groupLayers.get(id).leafletLayer) },
        isShown(id) { return leafletMap.hasLayer(groupLayers.get(id).leafletLayer) },
    }
}

for (const clustering of [false, true]) {
    test(`preserves shown and hidden groups across pin rebuilds (clustering: ${clustering})`, () => {
        const map = createMap({ clustering })
        map.props.groups = [{ id: 1, is_shown: false }, { id: 2, is_shown: true }]
        map.buildPins()
        assert.equal(map.isShown(1), false)
        assert.equal(map.isShown(2), true)

        map.show(1)
        map.hide(2)

        // Opening the editor, saving, and closing it can each rebuild the layers.
        for (let rebuild = 0; rebuild < 3; rebuild++) {
            map.buildPins()
            assert.equal(map.isShown(1), true)
            assert.equal(map.isShown(2), false)
        }
    })
}

test('uses saved defaults only for newly encountered groups', () => {
    const map = createMap()
    map.props.groups = [{ id: 1, is_shown: false }]
    map.buildPins()
    map.show(1)

    map.props.groups = [
        { id: 1, is_shown: false },
        { id: 2, is_shown: true },
        { id: 3, is_shown: false },
    ]
    map.buildPins()

    assert.equal(map.isShown(1), true)
    assert.equal(map.isShown(2), true)
    assert.equal(map.isShown(3), false)
})
