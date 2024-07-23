/*
 * L.Control.ZoomDisplay shows the current map zoom level
 */
export default function(L, options = {}) {
    options = Object.assign({
        position: options.position ?? 'topleft',
        prefix: 'Zoom : ',
    }, options);

	L.Control.ZoomDisplay = L.Control.extend({
		options: {
            position: options.position ?? 'topleft',
		},

		onAdd: function(map) {
			this._map = map;
			this._container = L.DomUtil.create(
				'div',
				'leaflet-control-zoom-display leaflet-bar-part leaflet-bar'
			);
			this.updateMapZoom(map.getZoom());
			map.on('zoomend', this.onMapZoomEnd, this);
			return this._container;
		},

		onRemove: function(map) {
			map.off('zoomend', this.onMapZoomEnd, this);
		},

		onMapZoomEnd: function(e) {
			this.updateMapZoom(this._map.getZoom());
		},

		updateMapZoom: function(zoom) {
			if (zoom === undefined) {
				zoom = '';
			}
			this._container.innerHTML = String(options.prefix) + zoom;
		}
	});

	L.Map.mergeOptions({
		zoomDisplayControl: true
	});

	L.Map.addInitHook(function() {
		if (this.options.zoomDisplayControl) {
			this.zoomDisplayControl = new L.Control.ZoomDisplay();
			this.addControl(this.zoomDisplayControl);
		}
	});

	// Factory
	L.control.zoomDisplay = function(options) {
		return new L.Control.ZoomDisplay(options);
	}

	return L.Control.ZoomDisplay;
}