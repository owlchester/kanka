/*
  Leaflet.ZoomCSS
  Adding a css class on the map div element, so other elements, such as markers can be automatically styled based on the zoom level using css instead of javascript
  Copyright (c) 2014, Dag Jomar Mersland, dagjomar@gmail.com, @dagjomar
  https://github.com/dagjomar/Leaflet.ZoomCSS
*/


L.Map.mergeOptions({
    zoomCss: true
  });

  L.Map.ZoomCSS = L.Handler.extend({
    addHooks: function () {
      this._zoomCSS();
      this._map.on('zoomend', this._zoomCSS, this);
    },

    removeHooks: function () {
      this._map.off('zoomend', this._zoomCSS, this);
    },

    _zoomCSS: function (e) {
      const zoomCssPrefix = 'z';

      var map = this._map,
        zoom = map.getZoom(),
        container = map.getContainer();

      for ( let i = -5; i < 24; i++ ) {
          let base = zoomCssPrefix + String(i);
          container.classList.remove(base);
          container.classList.remove(base + ".25");
          container.classList.remove(base + ".5");
          container.classList.remove(base + ".75");
      }
      if (zoom) {
          let base = zoomCssPrefix + String(zoom);
          container.classList.add(base);
      }
    }


  });

  L.Map.addInitHook('addHandler', 'zoomCss', L.Map.ZoomCSS);
