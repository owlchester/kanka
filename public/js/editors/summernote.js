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
/******/ 	return __webpack_require__(__webpack_require__.s = 23);
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
    window.initSummernote();
  }
});
/**
 * Initialize summernote when available
 */

window.initSummernote = function () {
  var $summernote = $('.html-editor').summernote({
    height: '300px',
    lang: editorLang(summernoteConfig.data('locale')),
    toolbar: [['style', ['style']], ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']], ['color', ['color']], ['para', ['ul', 'ol', 'kanka-indent', 'kanka-outdent', 'paragraph']], ['table', ['table', 'spoiler', 'tableofcontent']], ['insert', ['link', 'picture', 'video', 'embed', 'hr']], //['dir', ['ltr', 'rtl']],
    ['view', ['fullscreen', 'codeview', 'help']], summernoteConfig.data('gallery') !== '' ? ['extensions', ['gallery']] : null],
    popover: {
      table: [['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']], ['delete', ['deleteRow', 'deleteCol', 'deleteTable']], ['custom', ['tableHeaders']]]
    },
    callbacks: {
      onImageUpload: function onImageUpload(files) {
        uploadImage($summernote, files[0]);
      },
      onChange: function onChange() {
        window.entityFormHasUnsavedChanges = true;
      }
      /*onBlur: function() {
          console.log('blury');
      },*/

    },
    gallery: {
      source: {
        // data: [],
        url: summernoteConfig.data('gallery'),
        responseDataKey: 'data',
        nextPageKey: 'links.next'
      },
      modal: {
        loadOnScroll: true,
        maxHeight: 300,
        title: summernoteConfig.data('gallery-title'),
        close_text: summernoteConfig.data('gallery-close'),
        ok_text: summernoteConfig.data('gallery-add'),
        selectAll_text: summernoteConfig.data('gallery-select-all'),
        deselectAll_text: summernoteConfig.data('gallery-deselect-all'),
        noImageSelected_msg: summernoteConfig.data('gallery-error')
      }
    },
    hint: [{
      match: /\B@((\w|[\u00C0-\u00FF])*)$/,
      search: function search(keyword, callback) {
        if (keyword.length < 3) {
          return [];
        }

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
    }, {
      match: /\B{(\w*)$/,
      search: function search(keyword, callback) {
        return attributeSearch(keyword, callback);
      },
      template: function template(item) {
        return attributeTemplate(item);
      },
      content: function content(item) {
        return attributeContent(item);
      }
    }]
  });
};
/**
 * Search for entities
 * @param keyword
 * @param callback
 */


function hintEntities(keyword, callback) {
  $.ajax({
    url: summernoteConfig.data('mention') + '?q=' + keyword + '&new=1',
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
 * Search for attributes
 * @param keyword
 * @param callback
 */


function attributeSearch(keyword, callback) {
  if (!summernoteConfig.data('attributes')) {
    console.log('entity not yet created');
    return false;
  }

  $.ajax({
    url: summernoteConfig.data('attributes') + '?q=' + keyword,
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
 * Attribute template
 * @param item
 * @returns {string}
 */


function attributeTemplate(item) {
  return item.name + (item.value ? ' (' + item.value + ')' : '');
}
/**
 * Hint content that is injected in the editor
 * @param item
 * @returns {string|*}
 */


function hintContent(item) {
  if (item.id) {
    var mention = '[' + item.model_type + ':' + item.id + ']';

    if (summernoteConfig.data('advanced-mention')) {
      return mention;
    }

    if (advancedRequest) {
      return mention;
    }

    return $('<a />', {
      text: item.fullname,
      href: '#',
      "class": 'mention',
      'data-name': item.fullname,
      'data-mention': mention
    })[0];
  } else if (item.url) {
    if (item.tooltip) {
      return $('<a />', {
        text: item.fullname,
        href: item.url,
        title: item.tooltip.replace(/["]/g, '\''),
        'data-toggle': 'tooltip',
        'data-html': 'true'
      })[0];
    }

    return $('<a />', {
      text: item.fullname,
      href: item.url
    })[0];
  } else if (item.inject) {
    return item.inject;
  }

  return item.fullname;
}
/**
 *
 * @param item
 * @returns {jQuery|HTMLElement}
 */


function attributeContent(item) {
  if (summernoteConfig.data('advanced-mention')) {
    return '{attribute:' + item.id + '}';
  }

  return $('<a />', {
    href: '#',
    "class": 'attribute',
    text: '{' + item.name + '}',
    'data-attribute': '{attribute:' + item.id + '}'
  })[0];
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
  } else if (locale == 'ca') {
    return 'ca-ES';
  } else if (locale == 'el') {
    return 'el-GR';
  } else if (locale == 'en') {
    return 'en-US';
  } else {
    return locale + '-' + locale.toUpperCase();
  }
}
/**
 * Upload a file through summernote
 * @param file
 */


function uploadImage($summernote, file) {
  // Check if the campaign is superboosted
  if (!summernoteConfig.data('gallery-upload')) {
    $('#campaign-imageupload-error').modal();
    console.warn('Campaign isn\'t superboosted');
    return;
  }

  formData = new FormData();
  formData.append("file", file);
  formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
  $.ajax({
    url: summernoteConfig.data('gallery-upload'),
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function success(result) {
      //console.log('result', result);
      $summernote.summernote('insertImage', result, function ($image) {
        $image.attr('src', result);
      });
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      console.log(textStatus + " " + errorThrown);
      $('#superboosted-error').text(buildErrors(jqXHR.responseJSON.errors));
      $('#campaign-imageupload-error').modal();
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
    errors += data[key] + "\n";
  }

  return errors;
}

/***/ }),

/***/ 23:
/*!******************************************************!*\
  !*** multi ./resources/assets/js/editors/summernote ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/jay/Documents/GitHub/miscellany/resources/assets/js/editors/summernote */"./resources/assets/js/editors/summernote.js");


/***/ })

/******/ });