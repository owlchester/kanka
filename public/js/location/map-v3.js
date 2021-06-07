/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/components/delete-confirm.js":
/*!**********************************************************!*\
  !*** ./resources/assets/js/components/delete-confirm.js ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return deleteConfirm; });
function deleteConfirm() {
  // Delete confirm dialog
  $.each($('.delete-confirm'), function () {
    $(this).click(function (e) {
      var name = $(this).data('name');
      var text = $(this).data('text');
      var target = $(this).data('delete-target');
      var confirm = $(this).data('confirm-target');
      var reset = $(this).data('reset');

      if (!confirm) {
        confirm = '#delete-confirm-name';
      }

      if (text) {
        $('#delete-confirm-text').text(text);
      } else {
        $(confirm).text(name);
      }

      if ($(this).data('mirrored')) {
        $('#delete-confirm-mirror').show();
      } else {
        $('#delete-confirm-mirror').hide();
      }

      if (target) {
        $('.delete-confirm-submit').data('target', target);
      }

      if (reset) {
        $('.delete-button-label').hide();
        $('.remove-button-label').show();
      } else {
        $('.delete-button-label').show();
        $('.remove-button-label').hide();
      }
    });
  }); // Submit modal form

  $.each($('.delete-confirm-submit'), function (index) {
    $(this).unbind('click');
    $(this).click(function (e) {
      //console.log('clicky submit');
      var target = $(this).data('target');

      if (target) {
        $('#' + target + ' input[name=remove_mirrored]').val($('#delete-confirm-mirror-chexkbox').is(':checked') ? 1 : 0); //console.log('target', target, $('#' + target));

        $('#' + target).submit();
      } else {
        $('#delete-confirm-form').submit();
      }
    });
  }); // Delete confirm dialog

  $.each($('.click-confirm'), function (index) {
    $(this).click(function (e) {
      var name = $(this).data('message');
      $('#click-confirm-text').text(name);
      $('#click-confirm-url').attr('href', $(this).data('url'));
    });
  });
}

/***/ }),

/***/ "./resources/assets/js/location/map-v3.js":
/*!************************************************!*\
  !*** ./resources/assets/js/location/map-v3.js ***!
  \************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_delete_confirm__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/delete-confirm */ "./resources/assets/js/components/delete-confirm.js");

var mapPageBody;
var sidebarMap, sidebarMarker;
var markerModal, markerModalContent, markerModalTitle;
var validEntityForm = false;
var validSubform = false;
var subForm;
var currentAjaxForm;
$(document).ready(function () {
  window.map.invalidateSize(); //deleteConfirm();

  window.map.on('popupopen', function (ev) {
    Object(_components_delete_confirm__WEBPACK_IMPORTED_MODULE_0__["default"])();
  }); // Event fired when clicking on an existing map point

  $('a[href="#marker-pin"]').click(function (e) {
    $('input[name="shape_id"]').val(1);
  });
  $('a[href="#marker-label"]').click(function (e) {
    $('input[name="shape_id"]').val(2);
  });
  $('a[href="#marker-circle"]').click(function (e) {
    $('input[name="shape_id"]').val(3);
  });
  $('a[href="#marker-poly"]').click(function (e) {
    $('input[name="shape_id"]').val(5);
  });
  $('a[href="#form-markers"]').click(function (e) {
    window.map.invalidateSize();
  });
  initMapExplore();
  initMapForms(); // Limit the size of custom svg icons to not overblow the marker size
  // $('.map .custom-icon svg').each(function (e) {
  //     $(this).attr("height", 32).attr("width", 32).css('margin-top', '4px');
  // });
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
            markerModalContent.html(result.body);
          } else {
            sidebarMarker.html(result.body);
            handleCloseMarker();
            mapPageBody.addClass('sidebar-open');
          }

          Object(_components_delete_confirm__WEBPACK_IMPORTED_MODULE_0__["default"])();
        }
      }
    });
  };

  initLegend();
  initMapEntryClick();
  $(document).one('shown.bs.modal shown.bs.popover', function () {
    //console.warn('modal show or popover');
    initSubforms();
  });
}
/**
 * When submitting the layer or marker form from the map modal, disable the map form unsaved changed
 * alert.
 */


function initMapForms() {
  //console.info('mapsv3', 'initMapForms');
  var layerForm = $('#map-layer-form');
  var markerForm = $('#map-marker-form');
  var groupForm = $('#map-group-form');

  if ($('#entity-form').length === 0) {
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
  $('select[name="size_id"]').change(function (e) {
    if (this.value == 6) {
      $('.map-marker-circle-helper').hide();
      $('.map-marker-circle-radius').show();
    } else {
      $('.map-marker-circle-radius').hide();
      $('.map-marker-circle-helper').show();
    }
  });
  $(document).on('shown.bs.modal shown.bs.popover', function (e) {
    //console.warn('modal show or popover');
    initSubforms();
    e.stopPropagation();
  });
  initLegend();
  initMapEntryClick();
}

function initSubforms() {
  //console.info('initSubforms');
  subForm = $('.ajax-subform');

  if (subForm.length === 0) {
    //console.info('not ajax subforms');
    return;
  }

  subForm.one('submit', function (e) {
    //console.info('ajax-subform submit');
    if (validSubform) {
      //console.info('ajax-subform real submit');
      return true;
    }

    currentAjaxForm = $(this);
    window.entityFormHasUnsavedChanges = false;
    e.preventDefault();
    $(this).find('.form-submit-main span').hide();
    $(this).find('.form-submit-main i.fa').show(); // Allow ajax requests to use the X_CSRF_TOKEN for deletes

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var formData = new FormData(this);
    $.ajax({
      url: $(this).attr('action'),
      method: $(this).attr('method'),
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function (res) {
      // If the validation succeeded, we can really submit the form
      validSubform = true;
      currentAjaxForm.submit();
      return true;
    }).fail(function (err) {
      //console.log('error', err);
      // Reset any error fields
      currentAjaxForm.find('.input-error').removeClass('input-error');
      currentAjaxForm.find('.text-danger').remove(); // If we have a 503 error status, let's assume it's from cloudflare and help the user
      // properly save their data.

      if (err.status === 503) {
        $('#entity-form-503-error').show();
        resetSubformSubmitAnimation();
      } // If it's 403, the session is gone


      if (err.status === 403) {
        $('#entity-form-403-error').show();
        resetSubformSubmitAnimation();
      } // Loop through the errors to add the class and error message


      var errors = err.responseJSON.errors;
      var errorKeys = Object.keys(errors);
      var foundAllErrors = true;
      errorKeys.forEach(function (i) {
        var errorSelector = $('[name="' + i + '"]'); //console.log('error field', '[name="' + i + '"]');

        if (errorSelector.length > 0) {
          currentAjaxForm.find('[name="' + i + '"]').addClass('input-error').parent().append('<div class="text-danger">' + errors[i][0] + '</div>');
        } else {
          foundAllErrors = false;
        }
      });
      var firstItem = Object.keys(errors)[0];
      var firstItemDom = subForm.find('[name="' + firstItem + '"]'); // If we can actually find the first element, switch to it and the correct tab.

      if (firstItemDom.length > 0) {
        firstItemDom.focus();
      } // Reset submit buttons


      resetSubformSubmitAnimation(); //console.log('reset stuff');

      currentAjaxForm.find('.form-submit-main i.fa').hide();
      currentAjaxForm.find('.form-submit-main span').show();
    });
  });
}

function resetSubformSubmitAnimation() {
  var submitBtn = subForm.find('.btn-success');

  if (submitBtn.length > 0) {
    $.each(submitBtn, function () {
      $(this).removeAttr('disabled');

      if ($(this).data('reset')) {
        $(this).html($(this).data('reset'));
      }
    });
  }
}

function showSidebar() {
  var spinner = '<div class="text-center"><i class="fa fa-spin fa-spinner fa-2x"></i></div>'; // On mobile use the modal instead of the sidebar

  if (window.kankaIsMobile.matches) {
    markerModalContent.html(spinner);
    markerModal.modal('toggle');
    return;
  } //window.map.invalidateSize();


  mapPageBody.removeClass('sidebar-collapse').addClass('sidebar-open');
  sidebarMap.hide();
  sidebarMarker.show().html(spinner);
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
}

function initMapEntryClick() {
  $('.map-marker-entry-click').click(function (e) {
    e.preventDefault();
    $(this).parent().hide();
    $('.map-marker-entry-entry').show();
  });
}

/***/ }),

/***/ 4:
/*!******************************************************!*\
  !*** multi ./resources/assets/js/location/map-v3.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/jay/Documents/GitHub/miscellany/resources/assets/js/location/map-v3.js */"./resources/assets/js/location/map-v3.js");


/***/ })

/******/ });