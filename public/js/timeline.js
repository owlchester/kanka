/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/assets/js/timeline.js ***!
  \*****************************************/
$(document).ready(function () {
  registerTimelineEvents();
});
/**
 * Timeline toggle support
 */

function registerTimelineEvents() {
  $('.timeline-toggle').on('click', function () {
    var id = $(this).data('short');
    $('#' + id + "-show").toggle();
    $('#' + id + "-hide").toggle();
  });
  $('.timeline-era-reorder').on('click', function (e) {
    e.preventDefault();
    var eraId = $(this).data('era-id');
    $('#era-items-' + eraId + '').sortable();
    $(this).parent().hide();
    $('#era-items-' + eraId + '-save-reorder').show();
  });
}
/******/ })()
;