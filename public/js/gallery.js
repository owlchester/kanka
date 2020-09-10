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
/******/ 	return __webpack_require__(__webpack_require__.s = 21);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/gallery.js":
/*!****************************************!*\
  !*** ./resources/assets/js/gallery.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var loader, gallery, search;
var fileDrop, fileProgress, fileUploadField, fileError;
$(document).ready(function () {
  initGallery();
  initUploader();
  registerEvents();
});

function initGallery() {
  loader = $('#gallery-loader');
  gallery = $('#gallery-images');
  search = $('#gallery-search');
  fileDrop = $('.uploader');
  fileProgress = $('.progress');
  fileUploadField = $('#file-upload');
  fileError = $('.gallery-error');
  search.on('blur', function (e) {
    e.preventDefault();
    initSearch();
  }).on('submit', function (e) {
    e.preventDefault();
    initSearch();
  });
}

function loadGallery(url) {
  $.ajax({
    url: url,
    dataType: 'json'
  }).done(function (data) {
    console.log('data', data);
    gallery.html(data.content);
    loader.hide();
    gallery.show();
  });
}
/**
 *
 */


function initSearch() {
  gallery.hide();
  loader.show();
  console.log('searching');
  $.ajax({
    url: search.data('url') + '?q=' + search.val()
  }).done(function (data) {
    loader.hide();
    gallery.html(data).show();
    registerEvents();
  });
}
/**
 *
 */


function initUploader() {
  console.log('init uploader');
  fileDrop.unbind('drop dragover').bind('drop dragover', function (e) {
    e.preventDefault();
    fileProgress.show();
  });
  $('.file-upload-form').fileupload({
    dropZone: fileDrop,
    dataType: 'json',
    add: function add(e, data) {
      console.log('added file');
      fileError.hide();
      data.submit();
    },
    progressall: function progressall(e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      fileProgress.show();
      $('.progress .progress-bar').css('width', progress + '%');
    },
    done: function done(e, data) {
      console.log('file uploaded');
      fileProgress.hide(); //fileDrop.collapse('hide');

      console.log('result', data.result);

      if (data.result.success) {
        gallery.prepend(data.result.html);
        registerEvents();
      }
    },
    fail: function fail(e, data) {
      fileProgress.hide();

      if (data.jqXHR.responseJSON) {
        fileError.text(buildErrors(data.jqXHR.responseJSON.errors)).fadeToggle();
      }

      registerEvents();
    }
  });
}
/**
 *
 * @param data
 * @returns {string}
 */


function buildErrors(data) {
  var errors = '';

  for (var key in data) {
    // skip loop if the property is from prototype
    if (!data.hasOwnProperty(key)) continue;

    for (var e in data[key]) {
      errors += data[key][e] + "\n";
    }
  }

  return errors;
}

function registerEvents() {
  $('#gallery-images li').unbind('click').on('click', function (e) {
    $.ajax({
      url: $(this).data('url')
    }).done(function (data) {
      $('#large-modal-content').html(data);
      $('#large-modal').modal('show');
    });
  });
}

/***/ }),

/***/ 21:
/*!*******************************************!*\
  !*** multi ./resources/assets/js/gallery ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/jay/Documents/GitHub/miscellany/resources/assets/js/gallery */"./resources/assets/js/gallery.js");


/***/ })

/******/ });