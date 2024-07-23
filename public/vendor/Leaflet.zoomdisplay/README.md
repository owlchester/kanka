Leaflet.zoomdisplay
===================

Leaflet.zoomdisplay is a plugin that displays the current zoom level of the map.

[See a demo](https://easymountain.github.io/Leaflet.zoomdisplay/)

## Usage

  1. Add a `<script>` tag to your map page referencing the javascript.
  2. Add a `<link>` tag to your map page referencing the stylesheet.
  3. Call `LControlZoomDisplay` before instanciating `L.Map`

```js
LControlZoomDisplay.default(L, {
  position: 'bottomleft',
  prefix: 'Zoom : ',
});
 ```
