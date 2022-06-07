/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/assets/js/story.js ***!
  \**************************************/
$(document).ready(function () {
  var selector = $('.element-live-reorder');
  selector.sortable(); //selector.disableSelection();

  $('.fa-arrow-up').click(function (e) {
    var $current = $(this).closest('div.element');
    var $previous = $current.prev('div.element');

    if ($previous.length !== 0) {
      $current.insertBefore($previous);
    }

    return false;
  });
  $('.fa-arrow-down').click(function (e) {
    var $current = $(this).closest('div.element');
    var $previous = $current.next('div.element');

    if ($previous.length !== 0) {
      $current.insertAfter($previous);
    }

    return false;
  });
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
  $('.focus').click(function (e) {
    $('.focus').hide();
    $('input[name="focus_x"]').val();
    $('input[name="focus_y"]').val();
  });
}
/******/ })()
;