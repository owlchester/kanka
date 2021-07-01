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
/******/ 	return __webpack_require__(__webpack_require__.s = 17);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/dashboard.js":
/*!******************************************!*\
  !*** ./resources/assets/js/dashboard.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Dashboard
 */
var newWidget, newWidgetPreview, newWidgetCalendar, newWidgetRecent;
var btnWidgetPreview, btnWidgetCalendar, btnWidgetRecent;
var btnAddWidget;
var modalContentButtons, modalContentTarget, modalContentSpinner;
$(document).ready(function () {
  $('.preview-switch').click(function (e) {
    e.preventDefault();
    var preview = $('#widget-preview-body-' + $(this).data('widget'));

    if (preview.hasClass('preview')) {
      preview.removeClass('preview').addClass('full');
      $(this).html('<i class="fa fa-chevron-up"></i>');
    } else {
      preview.removeClass('full').addClass('preview');
      $(this).html('<i class="fa fa-chevron-down"></i>');
    }
  });
  $.each($('[data-toggle="preview"]'), function (i) {
    // If we are exactly the max-height, some content is hidden
    // console.log('compare', $(this).height(), 'vs', $(this).css('max-height'));
    if ($(this).height() === parseInt($(this).css('max-height'))) {
      $(this).next().removeClass('hidden');
    } else {
      $(this).removeClass('pinned-entity preview');
    }
  });
  $.each($('[data-widget="remove"]'), function (i) {
    $(this).click(function (e) {
      $.post({
        url: $(this).data('url'),
        method: 'POST'
      }).done(function (data) {});
    });
  }); // Ajax requests

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if ($('.campaign-dashboard-widgets').length === 1) {
    initDashboardAdminUI();
  }

  initDashboardRecent();
  initDashboardCalendars();
  initFollow();
});
/**
 *
 */

function initDashboardAdminUI() {
  newWidget = $('#new-widget');
  newWidgetPreview = $('#new-widget-preview');
  newWidgetCalendar = $('#new-widget-calendar');
  newWidgetRecent = $('#new-widget-recent');
  btnWidgetPreview = $('#btn-widget-preview');
  btnWidgetCalendar = $('#btn-widget-calendar');
  btnWidgetRecent = $('#btn-widget-recent');
  btnAddWidget = $('#btn-add-widget');
  modalContentButtons = $('#modal-content-buttons');
  modalContentTarget = $('#modal-content-target');
  modalContentSpinner = $('#modal-content-spinner');
  $('.btn-lg').click(function (e) {
    loadModalForm($(this).data('url'));
  }); // Reset the modal

  btnAddWidget.click(function (e) {
    modalContentSpinner.hide();
    modalContentTarget.html('');
    modalContentButtons.show();
  });
  $('#widgets').sortable({
    items: '.widget-draggable',
    stop: function stop(event, ui) {
      // Allow ajax requests to use the X_CSRF_TOKEN for deletes
      $.post({
        url: $('#widgets').data('url'),
        dataType: 'json',
        data: $('input[name="widgets[]"]').serialize()
      }).done(function (data) {});
    }
  });
  $(document).on('shown.bs.modal shown.bs.popover', function () {
    var summernoteConfig = $('#summernote-config');

    if (summernoteConfig.length > 0) {
      window.initSummernote();
    }

    $.each($('.img-delete'), function () {
      $(this).click(function (e) {
        e.preventDefault();
        $('input[name=' + $(this).data('target') + ']')[0].value = 1;
        $(this).parent().parent().hide();
      });
    });
    initWidgetSubform();
  }); //$('#widgets').disableSelection();
}
/**
 * Load widget subform in modal
 * @param url
 */


function loadModalForm(url) {
  // Remove content from any edit widget already loaded (to avoid having multiple fields with the tag id
  $('#edit-widget .modal-content').html('');
  modalContentButtons.fadeOut(400, function () {
    modalContentSpinner.fadeIn();
  });
  $.ajax(url).done(function (data) {
    modalContentSpinner.hide();
    modalContentTarget.html(data);
    window.initSelect2();
    window.initCategories();
    console.log('sub');
    initWidgetSubform();
  });
}

function initWidgetSubform() {
  // Recent entities: filter field dynamic display
  $('.recent-entity-type').change(function (e) {
    if (this.value) {
      $('.recent-filters').show();
    } else {
      $('.recent-filters').hide();
    }
  });
}
/**
 *
 */


function initDashboardRecent() {
  $('.widget-recent-more').click(function (e) {
    e.preventDefault();
    $(this).html('<i class="fa fa-spin fa-spinner"></i>');
    $.ajax({
      url: $(this).data('url'),
      context: this
    }).done(function (data) {
      $(this).closest('.widget-recent-list').append(data);
      $(this).remove();
      initDashboardRecent();
      window.ajaxTooltip(); // Reload tooltips
      // Inject the isMobile variable into the window. We don't want ALL of the javascript
      // for mobiles, namely the tooltip tool.
      // window.kankaIsMobile = window.matchMedia("only screen and (max-width: 760px)");
      // if (!window.kankaIsMobile.matches) {
      //     $('[data-toggle="tooltip"]').tooltip();
      // }
    });
  });
}
/**
 *
 */


function initDashboardCalendars() {
  $('.widget-calendar-switch').click(function (e) {
    console.log('click calendar switch');
    var url = $(this).data('url'),
        widget = $(this).data('widget');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('#widget-date-' + widget).addClass('hidden');
    $('#widget-loading-' + widget).removeClass('hidden').siblings('.row').addClass('hidden');
    $.ajax({
      url: url,
      method: 'POST',
      context: this
    }).done(function (data) {
      if (data) {
        // Redirect page
        var widget = $(this).data('widget');
        $('#widget-body-' + widget).html(data);
        initDashboardCalendars();
      }
    });
  });
}
/**
 * Follow / Unfollow a campaign
 */


function initFollow() {
  var btn = $('#campaign-follow');
  var text = $('#campaign-follow-text');

  if (btn.length !== 1) {
    return;
  }

  var status = btn.data('following');

  if (status) {
    text.html(btn.data('unfollow'));
  } else {
    text.html(btn.data('follow'));
  }

  btn.show();
  btn.click(function (e) {
    e.preventDefault();
    $.post({
      url: $(this).data('url'),
      method: 'POST'
    }).done(function (data) {
      if (data.following) {
        text.html(btn.data('unfollow'));
      } else {
        text.html(btn.data('follow'));
      }
    });
  });
}

/***/ }),

/***/ 17:
/*!*********************************************!*\
  !*** multi ./resources/assets/js/dashboard ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /mnt/c/Users/yanni/Desktop/kanka/miscellany/resources/assets/js/dashboard */"./resources/assets/js/dashboard.js");


/***/ })

/******/ });