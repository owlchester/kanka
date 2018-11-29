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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/dashboard.js":
/***/ (function(module, exports) {

/**
 * Dashboard
 */
var newWidget, newWidgetPreview, newWidgetCalendar, newWidgetRecent;
var btnWidgetPreview, btnWidgetCalendar, btnWidgetRecent;

var btnAddWidget;
var modalContentButtons, modalContentTarget, modalContentSpinner;

$(document).ready(function () {

    $.each($('[data-toggle="preview"]'), function (i) {
        // If we are exactly the height of 200, some content is hidden
        if ($(this).height() === 200) {
            $('[data-toggle="preview"]').click(function (e) {
                if ($(this).hasClass('preview')) {
                    $(this).removeClass('preview').addClass('full');
                } else {
                    $(this).removeClass('full').addClass('preview');
                }
            });
        } else {
            $(this).removeClass('pinned-entity preview');
        }
    });

    if ($('.campaign-dashboard-widgets').length === 1) {
        initDashboardAdminUI();
    }
});

function initDashboardAdminUI() {
    console.log('init dashboard admin ui');

    newWidget = $('#new-widget');
    newWidgetPreview = $('#new-widget-preview');
    newWidgetCalendar = $('#new-widget-calendar');
    newWidgetRecent = $('#new-widget-recent');

    btnWidgetPreview = $('#btn-widget-preview');
    btnWidgetCalendar = $('#btn-widget-calendar');
    btnWidgetRecent = $('#btn-widget-recent');

    btnAddWidget = $('#add-widget');
    modalContentButtons = $('#modal-content-buttons');
    modalContentTarget = $('#modal-content-target');
    modalContentSpinner = $('#modal-content-spinner');

    btnWidgetPreview.click(function (e) {
        console.log('click widget preview');
        loadModalForm($(this).data('url'));
    });

    btnWidgetCalendar.click(function (e) {
        console.log('click widget calendar');
        loadModalForm($(this).data('url'));
    });

    // Reset the modal
    btnAddWidget.click(function (e) {
        modalContentSpinner.hide();
        modalContentTarget.html('');
        modalContentButtons.show();
    });
}

/**
 * Load widget subform in modal
 * @param url
 */
function loadModalForm(url) {
    modalContentButtons.fadeOut(400, function () {
        modalContentSpinner.fadeIn();
    });

    $.ajax(url).done(function (data) {
        modalContentSpinner.hide();
        modalContentTarget.html(data);

        window.initSelect2();
    });
}

/***/ }),

/***/ 9:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/dashboard.js");


/***/ })

/******/ });