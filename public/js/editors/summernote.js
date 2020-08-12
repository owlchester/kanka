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
/******/ 	return __webpack_require__(__webpack_require__.s = 20);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/editors/summernote.js":
/*!***************************************************!*\
  !*** ./resources/assets/js/editors/summernote.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var summernoteConfig;
var advancedRequest = false;
$(document).ready(function () {
  summernoteConfig = $('#summernote-config');

  if (summernoteConfig.length > 0) {
    initSummernote();
  }
});
/**
 * Initialize summernote when available
 */

function initSummernote() {
  $(document).ready(function () {
    $('.html-editor').summernote({
      height: '300px',
      lang: editorLang(summernoteConfig.data('locale')),
      toolbar: [['style', ['style']], ['font', ['bold', 'underline', 'clear']], ['fontname', ['fontname']], ['color', ['color']], ['para', ['ul', 'ol', 'paragraph']], ['table', ['table']], ['insert', ['link', 'picture', 'video', 'hr']], ['view', ['fullscreen', 'codeview', 'help']]],
      hint: [{
        match: /\B@(\w*)$/,
        search: function search(keyword, callback) {
          return hintEntities(keyword, callback);
        },
        template: function template(item) {
          return hintTemplate(item);
        },
        content: function content(item) {
          advancedRequest = false;
          return hintContent(item);
        }
      }, {
        match: /\B\[(\w*)$/,
        search: function search(keyword, callback) {
          return hintEntities(keyword, callback);
        },
        template: function template(item) {
          return hintTemplate(item);
        },
        content: function content(item) {
          advancedRequest = true;
          return hintContent(item);
        }
      }, {
        match: /\B\#(\w*)$/,
        search: function search(keyword, callback) {
          return hintMonths(keyword, callback);
        },
        template: function template(item) {
          return hintTemplate(item);
        },
        content: function content(item) {
          advancedRequest = false;
          return hintContent(item);
        }
      }]
    });
  });
}
/**
 * Search for entities
 * @param keyword
 * @param callback
 */


function hintEntities(keyword, callback) {
  $.ajax({
    url: summernoteConfig.data('mention') + '?q=' + keyword,
    type: 'get',
    dataType: 'json',
    async: true
  }).done(callback);
}
/**
 * Search for months
 * @param keyword
 * @param callback
 */


function hintMonths(keyword, callback) {
  $.ajax({
    url: summernoteConfig.data('months') + '?q=' + keyword,
    type: 'get',
    dataType: 'json',
    async: true
  }).done(callback);
}
/**
 * Hint template (results displayed in dropdown)
 * @param item
 * @returns {string}
 */


function hintTemplate(item) {
  return (item.image ? item.image : '') + item.fullname + (item.type ? ' (' + item.type + ')' : '');
}
/**
 * Hint content that is injected in the editor
 * @param item
 * @returns {string|*}
 */


function hintContent(item) {
  console.log('item', item);

  if (item.id) {
    var mention = '[' + item.model_type + ':' + item.id + ']';

    if (summernoteConfig.data('advanced-mention')) {
      return mention;
    } else {
      if (advancedRequest) {
        return mention;
      }

      return $('<a>', {
        text: item.fullname,
        href: '#',
        "class": 'mention',
        'data-mention': mention
      })[0];
    }
  } else if (item.url) {
    if (item.tooltip) {
      return $('<a>', {
        text: item.fullname,
        href: item.url,
        title: item.tooltip.replace(/["]/g, '\''),
        'data-toggle': 'tooltip',
        'data-html': 'true'
      })[0];
    }

    return $('<a>', {
      text: item.fullname,
      href: item.url
    })[0];
  }

  return item.fullname;
}
/**
 * Editor locale
 * @param locale
 * @returns {string}
 */


function editorLang(locale) {
  if (!locale) {
    return 'en-US';
  }

  if (locale == 'he') {
    return 'he-IL';
  } else if (locale == 'en') {
    return 'en-US';
  } else {
    return locale + '-' + locale.toUpperCase();
  }
}

/***/ }),

/***/ 20:
/*!******************************************************!*\
  !*** multi ./resources/assets/js/editors/summernote ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\Payne\Php\kanka\resources\assets\js\editors\summernote */"./resources/assets/js/editors/summernote.js");


/***/ })

/******/ });