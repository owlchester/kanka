(function(factory, window){
    "use strict";
    if (typeof define === 'function' && define.amd) {
        define(['leaflet'], factory);
    } else if (typeof exports === 'object') {
        module.exports = factory(require('leaflet'));
    }
    if (typeof window !== 'undefined' && window.L) {
        window.L.Ruler = factory(L);
    }
}(function (L) {
    "use strict";
    L.Control.Ruler = L.Control.extend({
        options: {
            position: 'topright',
            circleMarker: {
                color: 'red',
                radius: 2
            },
            lineStyle: {
                color: 'red',
                dashArray: '1,6'
            },
            lengthUnit: {
                display: 'km',
                decimal: 2,
                factor: null
            },
            angleUnit: {
                display: '&deg;',
                decimal: 2,
                factor: null
            }
        },
        onAdd: function(map) {
            this._map = map;
            this._container = L.DomUtil.create('div', 'leaflet-bar');
            this._container.classList.add('leaflet-ruler');
            L.DomEvent.disableClickPropagation(this._container);
            L.DomEvent.on(this._container, 'click', this._toggleMeasure, this);
            this._choice = false;
            this._defaultCursor = this._map._container.style.cursor;
            this._allLayers = L.layerGroup();
            this._maxZoom = this._map.getMaxZoom();
            return this._container;
        },
        onRemove: function() {
            L.DomEvent.off(this._container, 'click', this._toggleMeasure, this);
        },
        _toggleMeasure: function() {
            this._choice = !this._choice;
            this._clickedLatLong = null;
            this._clickedPoints = [];
            this._totalLength = 0;
            if (this._choice){
                this._map.doubleClickZoom.disable();
                L.DomEvent.on(this._map._container, 'keydown', this._escape, this);
                L.DomEvent.on(this._map._container, 'dblclick', this._closePath, this);
                this._container.classList.add("leaflet-ruler-clicked");
                this._clickCount = 0;
                this._tempLine = L.featureGroup().addTo(this._allLayers);
                this._tempPoint = L.featureGroup().addTo(this._allLayers);
                this._pointLayer = L.featureGroup().addTo(this._allLayers);
                this._polylineLayer = L.featureGroup().addTo(this._allLayers);
                this._allLayers.addTo(this._map);
                this._map._container.style.cursor = 'crosshair';
                this._map.on('click', this._clicked, this);
                this._map.on('mousemove', this._moving, this);
            }
            else {
                this._map.doubleClickZoom.enable();
                L.DomEvent.off(this._map._container, 'keydown', this._escape, this);
                L.DomEvent.off(this._map._container, 'dblclick', this._closePath, this);
                this._container.classList.remove("leaflet-ruler-clicked");
                this._map.removeLayer(this._allLayers);
                this._allLayers = L.layerGroup();
                this._map._container.style.cursor = this._defaultCursor;
                this._map.off('click', this._clicked, this);
                this._map.off('mousemove', this._moving, this);
            }
        },
        _clicked: function(e) {
            this._clickedLatLong = e.latlng;
            //console.log('Clicked', this._clickedLatLong);
            this._clickedPoints.push(this._clickedLatLong);
            L.circleMarker(this._clickedLatLong, this.options.circleMarker).addTo(this._pointLayer);
            if(this._clickCount > 0 && !e.latlng.equals(this._clickedPoints[this._clickedPoints.length - 2])){
                if (this._movingLatLong){
                    L.polyline([this._clickedPoints[this._clickCount-1], this._movingLatLong], this.options.lineStyle).addTo(this._polylineLayer);
                }
                var text;
                this._totalLength += this._result.Distance;
                if (this._clickCount > 1){
                    // Original with bearing - ja 05042018
                    // text = '<b>' + 'Bearing:' + '</b>&nbsp;' + this._result.Bearing.toFixed(this.options.angleUnit.decimal) + '&nbsp;' + this.options.angleUnit.display + '<br><b>' + 'Distance:' + '</b>&nbsp;' + this._totalLength.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' +  this.options.lengthUnit.display;
                    // Without Bearing
                    text = '' + this._totalLength.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' +  this.options.lengthUnit.display;
                }
                else {
                    // Original with bearing - ja 05042018
                    //   text = '<b>' + 'Bearing:' + '</b>&nbsp;' + this._result.Bearing.toFixed(this.options.angleUnit.decimal) + '&nbsp;' + this.options.angleUnit.display + '<br><b>' + 'Distance:' + '</b>&nbsp;' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' +  this.options.lengthUnit.display;
                    // Without Bearing
                    text = '' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' +  this.options.lengthUnit.display;

                }
                L.circleMarker(this._clickedLatLong, this.options.circleMarker).bindTooltip(text, {permanent: true, className: 'result-tooltip',direction: 'top'}).addTo(this._pointLayer).openTooltip();
            }
            this._clickCount++;
        },
        _moving: function(e) {
            if (this._clickedLatLong){
                L.DomEvent.off(this._container, 'click', this._toggleMeasure, this);
                this._movingLatLong = e.latlng;
                //console.log('New position', this._movingLatLong);
                if (this._tempLine){
                    this._map.removeLayer(this._tempLine);
                    this._map.removeLayer(this._tempPoint);
                }
                var text;
                this._addedLength = 0;
                this._tempLine = L.featureGroup();
                this._tempPoint = L.featureGroup();
                this._tempLine.addTo(this._map);
                this._tempPoint.addTo(this._map);
                this._calculateBearingAndDistance();
                this._addedLength = this._result.Distance + this._totalLength;
                L.polyline([this._clickedLatLong, this._movingLatLong], this.options.lineStyle).addTo(this._tempLine);
                if (this._clickCount > 1){
                    text = '<b>' + 'Distance:' + '</b>&nbsp;' + this._addedLength.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' +  this.options.lengthUnit.display + '<br><div class="plus-length">(+' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display +')</div>';
                }
                else {
                    text = '<b>' + 'Distance:' + '</b>&nbsp;' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' +  this.options.lengthUnit.display;
                }
                L.circleMarker(this._movingLatLong, this.options.circleMarker).bindTooltip(text, {sticky: true, className: 'moving-tooltip',direction: 'top'}).addTo(this._tempPoint).openTooltip();
            }
        },
        _escape: function(e) {
            if (e.keyCode === 27){
                if (this._clickCount > 0){
                    this._closePath();
                }
                else {
                    this._choice = true;
                    this._toggleMeasure();
                }
            }
        },
        _calculateBearingAndDistance: function() {
            var f1 = this._clickedLatLong.lat, l1 = this._clickedLatLong.lng, f2 = this._movingLatLong.lat, l2 = this._movingLatLong.lng;
            var toRadian = Math.PI / 180;
            // haversine formula
            // bearing
            var y = Math.sin((l2-l1)*toRadian) * Math.cos(f2*toRadian);
            var x = Math.cos(f1*toRadian)*Math.sin(f2*toRadian) - Math.sin(f1*toRadian)*Math.cos(f2*toRadian)*Math.cos((l2-l1)*toRadian);
            var brng = Math.atan2(y, x)*((this.options.angleUnit.factor ? this.options.angleUnit.factor/2 : 180)/Math.PI);
            brng += brng < 0 ? (this.options.angleUnit.factor ? this.options.angleUnit.factor : 360) : 0;

            // distance
            var R = this.options.lengthUnit.factor ? 6371 * this.options.lengthUnit.factor : 6371; // kilometres
            var deltaF = (f2 - f1)*toRadian;
            var deltaL = (l2 - l1)*toRadian;
            var a = Math.sin(deltaF/2) * Math.sin(deltaF/2) + Math.cos(f1*toRadian) * Math.cos(f2*toRadian) * Math.sin(deltaL/2) * Math.sin(deltaL/2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            var distance = R * c;

            // New calculations by mapping the Earth-based standard to the relative points of the default Map CRS system - cc 05032018
            var pt1 = L.CRS.Simple.latLngToPoint(this._clickedLatLong, this._maxZoom); // point 1 where clicked at max zoom level - cc 05032018
            var pt2 = L.CRS.Simple.latLngToPoint(this._movingLatLong, this._maxZoom); // point 2 where clicked at max zoom level - cc 05032018
            distance = pt1.distanceTo(pt2)*(this.options.lengthUnit.factor ? this.options.lengthUnit.factor : 1)/this._maxZoom;  // sets distance and multiplies based on factor in options  - cc 05032018
            //console.log('Points', pt1, pt2);
            //console.log('Lat', this._clickedLatLong.lat, 'now', this._movingLatLong.lat);
            //console.log('Long', this._clickedLatLong.lng, 'now', this._movingLatLong.lng);
            //console.log(pt1.y, pt2.y);
            //console.log('Distance between them', pt1.distanceTo(pt2));
            this._result = {
                Bearing: brng,
                Distance: distance
            };

            return;
            var f1 = this._clickedLatLong.lat, l1 = this._clickedLatLong.lng, f2 = this._movingLatLong.lat, l2 = this._movingLatLong.lng;
            var toRadian = Math.PI / 180;
            // haversine formula
            // bearing
            var deltaL = (l2 - l1)*toRadian;
            var deltaF = (f2 - f1)*toRadian;
            var y = Math.sin(deltaL) * Math.cos(f2*toRadian);
            var x = Math.cos(f1*toRadian)*Math.sin(f2*toRadian) - Math.sin(f1*toRadian)*Math.cos(f2*toRadian)*Math.cos((l2-l1)*toRadian);

            console.log('Map Ruler', y, x);
            var brng = Math.atan2(y, x)*((this.options.angleUnit.factor ? this.options.angleUnit.factor/2 : 180)/Math.PI);
            brng += brng < 0 ? (this.options.angleUnit.factor ? this.options.angleUnit.factor : 360) : 0;
            // distance
            // New calculations by mapping the Earth-based standard to the relative points of the default Map CRS system - cc 05032018
            var pt1 = L.CRS.EPSG3857.latLngToPoint(this._clickedLatLong, this._maxZoom); // point 1 where clicked at max zoom level - cc 05032018
            var pt2 = L.CRS.EPSG3857.latLngToPoint(this._movingLatLong, this._maxZoom); // point 2 where clicked at max zoom level - cc 05032018
            var distance = pt1.distanceTo(pt2)*(this.options.lengthUnit.factor ? this.options.lengthUnit.factor : 1)/this._maxZoom;  // sets distance and multiplies based on factor in options  - cc 05032018
            this._result = {
                Bearing: brng,
                Distance: distance
            };
        },
        _closePath: function() {
            this._map.removeLayer(this._tempLine);
            this._map.removeLayer(this._tempPoint);
            this._choice = false;
            L.DomEvent.on(this._container, 'click', this._toggleMeasure, this);
            this._toggleMeasure();
        }
    });
    L.control.ruler = function(options) {
        return new L.Control.Ruler(options);
    };
}, window));
