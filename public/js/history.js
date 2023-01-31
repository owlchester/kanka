/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/assets/js/history.js ***!
  \****************************************/
$(document).ready(function () {
  initHistoryFilters();
});

function initHistoryFilters() {
  var form = $('form.history-filters');
  var filters = $('.history-filters select');
  filters.on('change', function () {
    $('.filters-loading').show();
    console.log('changed');
    form.submit();
    filters.prop('disabled', true);
  });
}
/******/ })()
;
//# sourceMappingURL=history.js.map