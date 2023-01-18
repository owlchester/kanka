/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/js/community-votes.js":
/*!************************************************!*\
  !*** ./resources/assets/js/community-votes.js ***!
  \************************************************/
/***/ (() => {

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

$(document).ready(function () {
  initCommunityVotes();
});
var ajaxUrl;
var options;
var selected;

function initCommunityVotes() {
  ajaxUrl = $("#community-vote-url");

  if (ajaxUrl.length === 0) {
    return;
  } // Allow ajax requests to use the X_CSRF_TOKEN for deletes


  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  options = $('.vote-body');
  options.click(function () {
    var option = $(this).data('option');

    if ($(this).hasClass('vote-selected')) {
      // Remove vote
      vote();
    } else {
      vote(option);
    }
  });
}

function vote(element) {
  options.each(function () {
    $(this).removeClass('vote-selected');
  });
  var data = {
    vote: element
  };
  selected = element;
  $.post(ajaxUrl.val(), data).done(function (result) {
    if (element) {
      $(".vote-body[data-option='" + selected + "']").addClass('vote-selected');
    }

    if (result.data) {
      updateStats(result.data);
    }
  }).fail(function () {// console.log('map point error', result);
  });
}

function updateStats(results) {
  for (var _i = 0, _Object$entries = Object.entries(results); _i < _Object$entries.length; _i++) {
    var _Object$entries$_i = _slicedToArray(_Object$entries[_i], 2),
        key = _Object$entries$_i[0],
        value = _Object$entries$_i[1];

    $(".vote-progress[data-width='" + key + "']").width(value + '%');
    $(".vote-result[data-result='" + key + "']").html(value + '%');
  }
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!**************************************!*\
  !*** ./resources/assets/js/front.js ***!
  \**************************************/
$(document).ready(function (e) {
  var video_wrapper = $('.youtube-placeholder'); //  Check to see if youtube wrapper exists

  if (video_wrapper.length) {
    // If user clicks on the video wrapper load the video.
    $('.youtube-placeholder').on('click', function () {
      /* Dynamically inject the iframe on demand of the user.
       Pull the youtube url from the data attribute on the wrapper element. */
      var html = '<div class="embed-responsive embed-responsive-16by9">' + '<div class="youtube-video embed-responsive-item" data-src="' + $(this).data('yt-url') + '">' + '<iframe class="embed-responsive-item" src="' + $(this).data('yt-url') + '" data-src="' + $(this).data('yt-url') + '" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' + '</div>' + '</div>'; //console.log('html', html);

      $(this).hide().after(html);
    });
  }
  /*$('[data-toggle="dropdown"]').on('click', function(e) {
      e.preventDefault();
      let sub = $(this).next('.dropdown-menu');
      if (sub.hasClass('show')) {
          sub.removeClass('show');
      } else {
          sub.addClass('show');
      }
  })*/


  initKBScroller();
  initTestimonialSlider();
  $('.faq-dynamic').click(function () {
    $($(this).data('target')).collapse();
  });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
  initPricingToggle();
});
/**
 * Automatically open a kb answer if it's in the anchor
 */

function initKBScroller() {
  if ($('.faq-categories').length === 0) {
    return;
  }

  var hash = window.location.hash;

  if (!hash) {
    return;
  }

  $(hash + '-answer').collapse();
}

function initTestimonialSlider() {
  if ($('#testimonials').length === 0) {
    return;
  }

  return;
  $('#testimonials .items').slick({
    dots: true,
    infinite: true,
    autoplay: false,
    speed: 800
  });
}

function initPricingToggle() {
  $('[data-pricing]').click(function (e) {
    var toggle = $(this).data('pricing'); // Click in the middle

    if (toggle === 'toggle') {
      if ($(this).hasClass('pricing-monthly')) {
        pricingToYearly();
      } else {
        pricingToMonthly();
      }
    } else if (toggle === 'monthly') {
      pricingToMonthly();
    } else {
      pricingToYearly();
    }
  });
}

function pricingToYearly() {
  $('[data-pricing="monthly"]').removeClass('text-bold');
  $('[data-pricing="yearly"]').addClass('text-bold');
  $('[data-pricing="toggle"]').removeClass('pricing-monthly').addClass('pricing-yearly');
  $('div.pricing').removeClass('pricing-monthly').addClass('pricing-yearly');
}

function pricingToMonthly() {
  $('[data-pricing="monthly"]').addClass('text-bold');
  $('[data-pricing="yearly"]').removeClass('text-bold');
  $('[data-pricing="toggle"]').removeClass('pricing-yearly').addClass('pricing-monthly');
  $('div.pricing').removeClass('pricing-yearly').addClass('pricing-monthly');
}

__webpack_require__(/*! ./community-votes */ "./resources/assets/js/community-votes.js");
})();

/******/ })()
;
//# sourceMappingURL=front.js.map