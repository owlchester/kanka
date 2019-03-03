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
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/attributes.js":
/***/ (function(module, exports) {

$(document).ready(function () {
    if ($('#add_attribute_target').length > 0) {
        initAttributeUI();
    }
});

/**
 * Initiate on click handles for attribute interface
 */
function initAttributeUI() {
    var target = $('#add_attribute_target');

    initAttributeHandlers();

    $('#attribute_add').on('click', function (e) {
        e.preventDefault();

        $('#attribute_template').clone().removeClass('hidden').removeAttr('id').insertBefore(target);
        initAttributeHandlers();

        return false;
    });

    $('#block_add').click(function (e) {
        e.preventDefault();
        $('#block_template').clone().removeClass('hidden').removeAttr('id').insertBefore(target);
        initAttributeHandlers();
        return false;
    });

    $('#text_add').click(function (e) {
        e.preventDefault();
        $('#text_template').clone().removeClass('hidden').removeAttr('id').insertBefore(target);
        initAttributeHandlers();
        return false;
    });

    $('#checkbox_add').click(function (e) {
        e.preventDefault();
        $('#checkbox_template').clone().removeClass('hidden').removeAttr('id').insertBefore(target);
        initAttributeHandlers();
        return false;
    });

    $.each($('[data-toggle="private"]'), function () {
        // Add the title first
        if ($(this).hasClass('fa-lock')) {
            $(this).prop('title', $(this).data('private'));
        } else {
            $(this).prop('title', $(this).data('public'));
        }
    });
}

/**
 * This function rebinds the delete on all buttons
 */
function initAttributeHandlers() {

    $('.entity-attributes').sortable();

    $.each($('.attribute_delete'), function () {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function () {
            $(this).parent().parent().parent().remove();
        });
    });

    $.each($('[data-toggle="private"]'), function () {
        // On click toggle
        $(this).click(function (e) {
            if ($(this).hasClass('fa-lock')) {
                // Unlock
                $(this).removeClass('fa-lock').addClass('fa-unlock-alt').prop('title', $(this).data('public'));
                $(this).parent().find('input:hidden').val("0");
            } else {
                // Lock
                $(this).removeClass('fa-unlock-alt').addClass('fa-lock').prop('title', $(this).data('private'));
                $(this).parent().find('input:hidden').val("1");
            }
        });
    });
}

/***/ }),

/***/ 7:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/attributes.js");


/***/ })

/******/ });