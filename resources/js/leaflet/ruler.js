import L from 'leaflet'

L.Control.Ruler = L.Control.extend({
    options: {
        position: 'topright',
        circleMarker: {
            color: 'red',
            radius: 2,
        },
        lineStyle: {
            color: 'red',
            dashArray: '1,6',
        },
        lengthUnit: {
            display: 'km',
            decimal: 2,
            factor: null,
        },
        angleUnit: {
            display: '&deg;',
            decimal: 2,
            factor: null,
        },
        onToggle: null,
    },
    onAdd(map) {
        this._map = map
        this._container = L.DomUtil.create('div', 'leaflet-bar')
        this._container.classList.add('leaflet-ruler')
        L.DomEvent.disableClickPropagation(this._container)
        L.DomEvent.on(this._container, 'click', this._toggleMeasure, this)
        this._choice = false
        this._defaultCursor = this._map._container.style.cursor
        this._allLayers = L.layerGroup()
        this._maxZoom = this._map.getMaxZoom()

        return this._container
    },
    onRemove() {
        L.DomEvent.off(this._container, 'click', this._toggleMeasure, this)
    },
    enable() {
        if (! this._choice) {
            this._toggleMeasure()
        }
    },
    disable() {
        if (this._choice) {
            this._toggleMeasure()
        }
    },
    _toggleMeasure() {
        this._choice = ! this._choice
        this._clickedLatLong = null
        this._clickedPoints = []
        this._totalLength = 0

        if (typeof this.options.onToggle === 'function') {
            this.options.onToggle(this._choice)
        }

        if (this._choice) {
            this._map.doubleClickZoom.disable()
            L.DomEvent.on(this._map._container, 'keydown', this._escape, this)
            L.DomEvent.on(this._map._container, 'dblclick', this._closePath, this)
            this._container.classList.add('leaflet-ruler-clicked')
            this._clickCount = 0
            this._tempLine = L.featureGroup().addTo(this._allLayers)
            this._tempPoint = L.featureGroup().addTo(this._allLayers)
            this._pointLayer = L.featureGroup().addTo(this._allLayers)
            this._polylineLayer = L.featureGroup().addTo(this._allLayers)
            this._allLayers.addTo(this._map)
            this._map._container.style.cursor = 'crosshair'
            this._map.on('click', this._clicked, this)
            this._map.on('mousemove', this._moving, this)
        } else {
            this._map.doubleClickZoom.enable()
            L.DomEvent.off(this._map._container, 'keydown', this._escape, this)
            L.DomEvent.off(this._map._container, 'dblclick', this._closePath, this)
            this._container.classList.remove('leaflet-ruler-clicked')
            this._map.removeLayer(this._allLayers)
            this._allLayers = L.layerGroup()
            this._map._container.style.cursor = this._defaultCursor
            this._map.off('click', this._clicked, this)
            this._map.off('mousemove', this._moving, this)
        }
    },
    _clicked(e) {
        this._clickedLatLong = e.latlng
        this._clickedPoints.push(this._clickedLatLong)
        L.circleMarker(this._clickedLatLong, this.options.circleMarker).addTo(this._pointLayer)

        if (this._clickCount > 0 && ! e.latlng.equals(this._clickedPoints[this._clickedPoints.length - 2])) {
            if (this._movingLatLong) {
                L.polyline([this._clickedPoints[this._clickCount - 1], this._movingLatLong], this.options.lineStyle).addTo(this._polylineLayer)
            }

            let text
            this._totalLength += this._result.Distance

            if (this._clickCount > 1) {
                text = '' + this._totalLength.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display
            } else {
                text = '' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display
            }

            L.circleMarker(this._clickedLatLong, this.options.circleMarker).bindTooltip(text, { permanent: true, className: 'result-tooltip', direction: 'top' }).addTo(this._pointLayer).openTooltip()
        }

        this._clickCount++
    },
    _moving(e) {
        if (! this._clickedLatLong) {
            return
        }

        this._movingLatLong = e.latlng

        if (this._tempLine) {
            this._map.removeLayer(this._tempLine)
            this._map.removeLayer(this._tempPoint)
        }

        let text
        this._addedLength = 0
        this._tempLine = L.featureGroup()
        this._tempPoint = L.featureGroup()
        this._tempLine.addTo(this._map)
        this._tempPoint.addTo(this._map)
        this._calculateBearingAndDistance()
        this._addedLength = this._result.Distance + this._totalLength
        L.polyline([this._clickedLatLong, this._movingLatLong], this.options.lineStyle).addTo(this._tempLine)

        if (this._clickCount > 1) {
            text = '<b>Distance:</b>&nbsp;' + this._addedLength.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display + '<br><div class="plus-length">(+' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display + ')</div>'
        } else {
            text = '<b>Distance:</b>&nbsp;' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display
        }

        L.circleMarker(this._movingLatLong, this.options.circleMarker).bindTooltip(text, { sticky: true, className: 'moving-tooltip', direction: 'top' }).addTo(this._tempPoint).openTooltip()
    },
    _escape(e) {
        if (e.keyCode !== 27) {
            return
        }

        if (this._clickCount > 0) {
            this._closePath()
        } else {
            this._choice = true
            this._toggleMeasure()
        }
    },
    _calculateBearingAndDistance() {
        const f1 = this._clickedLatLong.lat
        const l1 = this._clickedLatLong.lng
        const f2 = this._movingLatLong.lat
        const l2 = this._movingLatLong.lng
        const toRadian = Math.PI / 180

        // haversine formula - bearing
        const y = Math.sin((l2 - l1) * toRadian) * Math.cos(f2 * toRadian)
        const x = Math.cos(f1 * toRadian) * Math.sin(f2 * toRadian) - Math.sin(f1 * toRadian) * Math.cos(f2 * toRadian) * Math.cos((l2 - l1) * toRadian)
        let brng = Math.atan2(y, x) * ((this.options.angleUnit.factor ? this.options.angleUnit.factor / 2 : 180) / Math.PI)
        brng += brng < 0 ? (this.options.angleUnit.factor ? this.options.angleUnit.factor : 360) : 0

        // Distance is computed in whatever CRS the map itself uses (CRS.Simple for
        // fantasy/image maps, EPSG3857 by default for real-world maps) so it always
        // matches the map's own projection, instead of the two near-duplicate legacy
        // vendor files (one hardcoded to each CRS).
        const crs = this._map.options.crs || L.CRS.EPSG3857
        const pt1 = crs.latLngToPoint(this._clickedLatLong, this._maxZoom)
        const pt2 = crs.latLngToPoint(this._movingLatLong, this._maxZoom)
        const distance = pt1.distanceTo(pt2) * (this.options.lengthUnit.factor ? this.options.lengthUnit.factor : 1) / this._maxZoom

        this._result = {
            Bearing: brng,
            Distance: distance,
        }
    },
    _closePath() {
        this._map.removeLayer(this._tempLine)
        this._map.removeLayer(this._tempPoint)
        this._choice = false
        L.DomEvent.on(this._container, 'click', this._toggleMeasure, this)
        this._toggleMeasure()
    },
})

L.control.ruler = function (options) {
    return new L.Control.Ruler(options)
}
