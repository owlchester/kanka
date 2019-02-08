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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/components/summernote.js":
/***/ (function(module, exports) {

$(document).ready(function () {
    $('.html-editor').summernote({
        height: 180,
        hint: [{
            match: /\B@(\w*)$/,
            mentions: function mentions(keyword, callback) {
                $.ajax({
                    url: $('#mention-route-entities').val() + '?q=' + keyword,
                    type: 'get',
                    async: true
                }).done(callback);
            },
            search: function search(keyword, callback) {
                this.mentions(keyword, callback);
            },
            content: function content(item) {
                if (item.url) {
                    if (item.tooltip) {
                        var str = '<a href="' + item.url + '" title="' + item.tooltip.replace(/["]/g, '\'') + '" data-toggle="tooltip" data-html="true" >' + item.fullname + '</a>';
                        return $(str)[0];
                    }
                    return $('<a href="' + item.url + '">' + item.fullname + '</a>')[0];
                }
                return item.fullname;
            },
            template: function template(item) {
                return '<div class="summernote-hint-option">' + (item.image ? item.image : '') + item.fullname + ' (' + item.type + ')</div>';
            }
        }, {
            match: /\B#(\w*)$/,
            mentions: function mentions(keyword, callback) {
                $.ajax({
                    url: $('#mention-route-months').val() + '?q=' + keyword,
                    type: 'get',
                    async: true
                }).done(callback);
            },
            search: function search(keyword, callback) {
                this.mentions(keyword, callback);
            },
            content: function content(item) {
                return item.fullname;
            },
            template: function template(item) {
                return item.fullname;
            }
        }]

    });
});

/***/ }),

/***/ 10:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/components/summernote.js");


/***/ })

/******/ });