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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/ajax-subforms.js":
/*!**********************************************!*\
  !*** ./resources/assets/js/ajax-subforms.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Contains standard ajax process for forms.
 *
 * Wartning /!\ : This will replace submit events on the form itself!
 * Usage: <form> tag must have class : 'ajax-subforms'
 *        Submit button or button group must be enclosed in a <div> that has the class : 'submit-group'
 */
$(document).ready(function () {
  initSubforms();
  $(document).on('shown.bs.modal shown.bs.popover', function () {
    initSubforms();
  });
});

function initSubforms() {
  //console.info('Init Ajax Subforms');
  var subForms = $('.ajax-subform');

  if (subForms.length === 0) {
    //console.info('not ajax subforms');
    return;
  } //remove current submit event just in case it isn't clear


  subForms.off('submit');
  subForms.on('submit', function (e) {
    //console.log('Ajax subform submitted', $(this));
    //Get the validity status of the form
    var formIsValid = $(this).attr('is-valid'); //console.log("Form validity", formIsValid);

    if (formIsValid) {
      //console.log("Ajax subform already validated, sending", $(this));
      //do nothing and send form
      return true;
    } //else form is not confirmed valid
    //disable global alert when redirection occurs


    window.entityFormHasUnsavedChanges = false;
    e.preventDefault(); //show button animation

    var currentAjaxForm = $(this);
    currentAjaxForm.find('.submit-group').hide();
    currentAjaxForm.find('.submit-animation').show(); // Allow ajax requests to use the X_CSRF_TOKEN for deletes

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }); //send request to server

    var formData = new FormData(this);
    $.ajax({
      url: $(this).attr('action'),
      method: $(this).attr('method'),
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function (res) {
      // If the validation succeeded, confirm its validity
      currentAjaxForm.attr('is-valid', true); // resubmit the form

      currentAjaxForm.submit();
    }).fail(function (err) {
      //console.log('error', err);
      // Reset any error fields
      currentAjaxForm.find('.input-error').removeClass('input-error');
      currentAjaxForm.find('.text-danger').remove(); // /?\ how do the 503/403 error ids work ?
      // If we have a 503 error status, let's assume it's from cloudflare and help the user
      // properly save their data.

      if (err.status === 503) {
        $('#entity-form-503-error').show();
        resetSubformSubmitAnimation(currentAjaxForm);
      } // If it's 403, the session is gone


      if (err.status === 403) {
        $('#entity-form-403-error').show();
        resetSubformSubmitAnimation(currentAjaxForm);
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
      var firstItemDom = currentAjaxForm.find('[name="' + firstItem + '"]'); // If we can actually find the first element, switch to it and the correct tab.

      if (firstItemDom.length > 0) {
        firstItemDom.focus();
      } // Reset submit buttons


      resetSubformSubmitAnimation(currentAjaxForm);
    });
  });
}

function resetSubformSubmitAnimation(form) {
  //console.log("Resetting ajax subform animation");
  //reset animation
  form.find('.submit-group').show();
  form.find('.submit-animation').hide();
}

/***/ }),

/***/ 2:
/*!****************************************************!*\
  !*** multi ./resources/assets/js/ajax-subforms.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/jay/Documents/GitHub/miscellany/resources/assets/js/ajax-subforms.js */"./resources/assets/js/ajax-subforms.js");


/***/ })

/******/ });