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
        // If we are exactly the height of 200, some content is hidden
        if ($(this).height() === 200) {
            $(this).next().removeClass('hidden');
        } else {
            $(this).removeClass('pinned-entity preview');
        }
    });

    $.each($('[data-dismiss="alert"]'), function (i) {
        $(this).click(function (e) {
            $.post({
                url: $(this).data('url'),
                method: 'POST'
            }).done(function (data) {});
        });
    });

    // Ajax requests
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
    });

    // Reset the modal
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
    //$('#widgets').disableSelection();
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
            $(this).closest('.widget-recent-body').append(data);
            $(this).remove();
            initDashboardRecent();

            // Reload tooltips
            // Inject the isMobile variable into the window. We don't want ALL of the javascript
            // for mobiles, namely the tooltip tool.
            window.kankaIsMobile = window.matchMedia("only screen and (max-width: 760px)");
            if (!window.kankaIsMobile.matches) {
                $('[data-toggle="tooltip"]').tooltip();
            }
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

/***/ }),

/***/ 9:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/dashboard.js");


/***/ })

/******/ });