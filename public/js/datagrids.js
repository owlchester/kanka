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
/******/ 	return __webpack_require__(__webpack_require__.s = 13);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/datagrids.js":
/*!******************************************!*\
  !*** ./resources/assets/js/datagrids.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// id="datagrids-bulk-actions-permissions"
// id="datagrids-bulk-actions-edit
$(document).ready(function () {
  // Multi-delete
  var crudDelete = $('#datagrid-select-all');

  if (crudDelete.length > 0) {
    crudDelete.click(function (e) {
      if ($(this).prop('checked')) {
        $.each($("input[name='model[]']"), function () {
          $(this).prop('checked', true);
        });
      } else {
        $.each($("input[name='model[]']"), function () {
          $(this).prop('checked', false);
        });
      }

      toggleCrudMultiDelete();
    });
  }

  $.each($("input[name='model[]']"), function () {
    $(this).change(function (e) {
      toggleCrudMultiDelete();
      e.preventDefault();
    });
  });
  registerBulkActions();
  toggleCrudMultiDelete();
});
/**
 * Register button handeling for bulk actions
 */

function registerBulkActions() {
  $('#datagrids-bulk-actions-permissions').on('click', function () {
    setDatagridAction('permissions', '#datagrid-bulk-permission-models');
  });
  $('#datagrids-bulk-actions-batch').on('click', function () {
    setDatagridAction('batch', '#datagrid-bulk-batch-models');
  });
}
/**
 * Set the datagrid action
 * @param action
 */


function setDatagridAction(action, modelField) {
  var values = [];
  $.each($("input[name='model[]']"), function () {
    if ($(this).prop('checked')) {
      values.push($(this).val());
    }
  });
  $(modelField).val(values.toString());
}
/**
 *
 */


function toggleCrudMultiDelete() {
  var hide = true;
  $.each($("input[name='model[]']"), function () {
    if ($(this).prop('checked')) {
      hide = false;
    }
  });

  if (hide) {
    $('.datagrid-bulk-actions').hide();
  } else {
    $('.datagrid-bulk-actions').show();
  }
}

/***/ }),

/***/ 13:
/*!*********************************************!*\
  !*** multi ./resources/assets/js/datagrids ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\Payne\Php\kanka\resources\assets\js\datagrids */"./resources/assets/js/datagrids.js");


/***/ })

/******/ });