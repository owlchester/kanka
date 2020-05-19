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
/******/ 	return __webpack_require__(__webpack_require__.s = 12);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/subscription.js":
/*!*********************************************!*\
  !*** ./resources/assets/js/subscription.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// Strip variables for the page
var stripe, elements, card; // Form status

var formSubmit = false;
$(document).ready(function () {
  initStripe();
  $('#subscribe-confirm').on('shown.bs.modal', function () {
    initConfirmListener();
  });
}); // Initialize the stripe API

function initStripe() {
  var token = $('#stripe-token');
  stripe = Stripe(token.val()); // Create an instance of Elements.

  elements = stripe.elements();
} // When the modal is opened and loaded, inject stripe if needed and the form validator


function initConfirmListener() {
  var cardSelector = $('#card-element');

  if (cardSelector.length === 1) {
    // First time opening the modal, initiate a new card
    if (!card) {
      // Custom styling can be passed to options when creating an Element.
      // (Note that this demo uses a wider set of styles than the guide below.)
      var style = {
        base: {
          color: '#555555',
          fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
          fontSmoothing: 'antialiased',
          fontSize: '14px',
          '::placeholder': {
            color: '#777777'
          }
        },
        invalid: {
          color: '#fa755a',
          iconColor: '#fa755a'
        }
      }; // Create an instance of the card Element.

      card = elements.create('card', {
        hidePostalCode: true,
        style: style
      });
    } // Add an instance of the card Element into the `card-element` <div>.


    card.mount('#card-element');
  }

  $('#subscription-confirm').submit(function (e) {
    // If we've passed the strip validation, we can go further
    if (formSubmit) {
      return true;
    }

    e.preventDefault();
    var button = $('.subscription-confirm-button');
    button.addClass('disabled').html('<i class="fa fa-spin fa-spinner"></i>');
    var intentToken = $('input[name="subscription-intent-token"]');
    var errorMessage = $('.alert-danger');
    errorMessage.hide(); // If the form already has a payment id, we don't need stripe to add the new one

    var cardID = $('input[name="payment_id"]');

    if (cardID.val()) {
      formSubmit = true;
      $('#subscription-confirm').submit();
      return false;
    }

    stripe.confirmCardSetup(intentToken.val(), {
      payment_method: {
        card: card,
        billing_details: {
          name: $('input[name="card-holder-name"]').val()
        }
      }
    }).then(function (result) {
      if (result.error) {
        button.removeClass('disabled').text(button.data('text'));
        errorMessage.text(result.error.message).show();
        return false;
      } else {
        cardID.val(result.setupIntent.payment_method);
        formSubmit = true;
        $('#subscription-confirm').submit();
      }
    }.bind(this));
  });
  $('.subscription-form').submit(function (e) {
    var button = $('.subscription-confirm-button');
    button.addClass('disabled').html('<i class="fa fa-spin fa-spinner"></i>');
    return true;
  });
}

/***/ }),

/***/ 12:
/*!************************************************!*\
  !*** multi ./resources/assets/js/subscription ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\jerem\Projects\Php\kanka\resources\assets\js\subscription */"./resources/assets/js/subscription.js");


/***/ })

/******/ });