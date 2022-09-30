/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/js/components/delete-confirm.js":
/*!**********************************************************!*\
  !*** ./resources/assets/js/components/delete-confirm.js ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ deleteConfirm)
/* harmony export */ });
function deleteConfirm() {
  // Delete confirm dialog
  $.each($('.delete-confirm'), function () {
    $(this).click(function (e) {
      var name = $(this).data('name');
      var target = $(this).data('delete-target');
      var targetModal = $(this).data('target');
      $(targetModal).find('.target-name').text(name);

      if ($(this).data('mirrored')) {
        $('#delete-confirm-mirror').show();
      } else {
        $('#delete-confirm-mirror').hide();
      }

      if ($(this).data('recoverable')) {
        $(targetModal).find('.permanent').hide();
        $(targetModal).find('.recoverable').show();
      } else {
        $(targetModal).find('.recoverable').hide();
        $(targetModal).find('.permanent').show();
      }

      if (target) {
        $('.delete-confirm-submit').data('target', target);
      }
    });
  }); // Submit modal form

  $.each($('.delete-confirm-submit'), function (index) {
    $(this).unbind('click');
    $(this).click(function (e) {
      var target = $(this).data('target'); //console.log('Submit delete confirmation', target);

      if (target) {
        $('#' + target + ' input[name=remove_mirrored]').val($('#delete-confirm-mirror-checkbox').is(':checked') ? 1 : 0); //console.log('target', target, $('#' + target));

        $('#' + target).submit();
      } else {
        $('#delete-confirm-form').submit();
      }
    });
  });
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
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!************************************************!*\
  !*** ./resources/assets/js/location/map-v3.js ***!
  \************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_delete_confirm__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/delete-confirm */ "./resources/assets/js/components/delete-confirm.js");
 //require ('leaflet.markercluster/dist/leaflet.markercluster');
//require ('leaflet.markercluster.layersupport');

var mapPageBody;
var sidebarMap, sidebarMarker;
var markerModal, markerModalContent, markerModalTitle;
$(document).ready(function () {
  window.map.invalidateSize(); //deleteConfirm();

  window.map.on('popupopen', function (ev) {
    (0,_components_delete_confirm__WEBPACK_IMPORTED_MODULE_0__["default"])();
  }); // Event fired when clicking on an existing map point

  $('a[href="#marker-pin"]').click(function (e) {
    $('input[name="shape_id"]').val(1);
    $('#map-marker-bg-colour').show();
  });
  $('a[href="#marker-label"]').click(function (e) {
    $('input[name="shape_id"]').val(2);
    $('#map-marker-bg-colour').hide();
  });
  $('a[href="#marker-circle"]').click(function (e) {
    $('input[name="shape_id"]').val(3);
    $('#map-marker-bg-colour').show();
  });
  $('a[href="#marker-poly"]').click(function (e) {
    $('input[name="shape_id"]').val(5);
    $('#map-marker-bg-colour').show();
  });
  $('a[href="#form-markers"]').click(function (e) {
    window.map.invalidateSize();
  });
  initMapExplore();
  initMapForms();
  initMapEntryClick();
});
/**
 *
 */

function initMapExplore() {
  //console.log('initMapExplore', '');
  mapPageBody = $('#map-body');

  if (mapPageBody.length === 0) {
    //console.log('initMapExplore', 'no explore mode');
    return;
  }

  sidebarMap = $('#sidebar-map');
  sidebarMarker = $('#sidebar-marker');
  markerModal = $('#map-marker-modal');
  markerModalTitle = $('#map-marker-modal-title');
  markerModalContent = $('#map-marker-modal-content'); // Allow ajax requests to use the X_CSRF_TOKEN for moves

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  window.markerDetails = function (url) {
    showSidebar();

    if (window.kankaIsMobile.matches) {
      url = url + '?mobile=1';
    }

    $.ajax({
      url: url,
      type: 'GET',
      async: true,
      success: function success(result) {
        if (result) {
          if (window.kankaIsMobile.matches) {
            markerModalTitle.html(result.name);
            markerModalContent.find('.content').html(result.body).show();
            markerModalContent.find('.spinner').hide();
          } else {
            sidebarMarker.html(result.body).show().parent().find('.spinner').hide();
            handleCloseMarker();
            mapPageBody.addClass('sidebar-open');
          }

          (0,_components_delete_confirm__WEBPACK_IMPORTED_MODULE_0__["default"])();
        }
      }
    });
  };

  initLegend();
  registerModes();
}
/**
 * When submitting the layer or marker form from the map modal, disable the map form unsaved changed
 * alert.
 */


function initMapForms() {
  $('select[name="size_id"]').change(function (e) {
    if (this.value == 6) {
      $('.map-marker-circle-helper').hide();
      $('.map-marker-circle-radius').show();
    } else {
      $('.map-marker-circle-radius').hide();
      $('.map-marker-circle-helper').show();
    }
  }); //console.info('mapsv3', 'initMapForms');

  var layerForm = $('#map-layer-form');
  var markerForm = $('#map-marker-form');
  var groupForm = $('#map-group-form');

  if ($('#entity-form').length === 0 && $('.map-marker-edit-form').length === 0) {
    //console.info('initMapForms empty');
    return;
  }

  layerForm.unbind('submit').on('submit', function () {
    window.entityFormHasUnsavedChanges = false;
  });
  markerForm.unbind('submit').on('submit', function () {
    window.entityFormHasUnsavedChanges = false;
  });
  groupForm.unbind('submit').on('submit', function () {
    window.entityFormHasUnsavedChanges = false;
  });
  initLegend();
}

function showSidebar() {
  // On mobile use the modal instead of the sidebar
  if (window.kankaIsMobile.matches) {
    markerModalContent.find('.spinner').show();
    markerModalContent.find('.content').hide();
    markerModal.modal('toggle');
    return;
  } //window.map.invalidateSize();


  mapPageBody.removeClass('sidebar-collapse').addClass('sidebar-open');
  sidebarMap.hide();
  sidebarMarker.html('').show();
  sidebarMarker.parent().find('.spinner').show();
  invalidateMapOnSidebar();
}

function handleCloseMarker() {
  $('.marker-close').click(function (ev) {
    sidebarMarker.hide();
    sidebarMap.show();
  });
}

function initLegend() {
  $('.map-legend-marker').click(function (ev) {
    ev.preventDefault();
    window.map.panTo(L.latLng($(this).data('lat'), $(this).data('lng')));
    window[$(this).data('id')].openPopup();
  });
  $('a.sidebar-toggle').click(function () {
    invalidateMapOnSidebar(); //console.log('wat');
  });
}

function invalidateMapOnSidebar() {
  setTimeout(function () {
    // Invalidate the map size when the sidebar is rendered/hidden
    window.map.invalidateSize();
  }, 500);
}

function initMapEntryClick() {
  $('.map-marker-entry-click').click(function (e) {
    e.preventDefault();
    $(this).parent().hide();
    $('.map-marker-entry-entry').show();
  });
}
/**
 * Register switching in and out of edit mode
 */


function registerModes() {
  $('.btn-mode-enable').click(function (e) {
    e.preventDefault();
    window.explodeEditMode = true;
    $('body').addClass('map-edit-mode');
  });
  $('.btn-mode-disable').click(function (e) {
    e.preventDefault();
    window.explodeEditMode = false;
    $('body').removeClass('map-edit-mode');
  });
}
})();

/******/ })()
;
//# sourceMappingURL=map-v3.js.map