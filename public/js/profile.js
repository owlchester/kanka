/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/assets/js/profile.js ***!
  \****************************************/
var api;
$(document).ready(function () {
  if ($('#newsletter-api').length === 1) {
    init();
  }
});

function init() {
  api = $('#newsletter-api').val();
  handle($('input[name="mail_release"]'));
}

function handle(element) {
  $(element).change(function () {
    var name = this.name;
    var data = {};
    data[name] = this.checked ? 1 : 0;
    $.post(api, data).done(function (res) {
      window.showToast(res.message);
    });
  });
}
/******/ })()
;
//# sourceMappingURL=profile.js.map