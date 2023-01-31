/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/assets/js/story.js ***!
  \**************************************/
$(document).ready(function () {
  initImageFocus();
});

function initImageFocus() {
  var target = $('.focus-image');

  if (target.length === 0) {
    return;
  }

  target.on('click', function (e) {
    var elm = $(this);
    var posX = e.pageX - elm.offset().left;
    var posY = e.pageY - elm.offset().top; //console.log('where click', posX, posY);

    $('.focus').css('top', posY - 22).css('left', posX - 22).show();
    $('input[name="focus_x"]').val(parseInt(posX));
    $('input[name="focus_y"]').val(parseInt(posY));
  });
  $('.focus').click(function () {
    $('.focus').hide();
    $('input[name="focus_x"]').val();
    $('input[name="focus_y"]').val();
  });
}
/******/ })()
;
//# sourceMappingURL=story.js.map