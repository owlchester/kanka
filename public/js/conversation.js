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
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/conversation.js":
/***/ (function(module, exports) {

var conversationBody, conversationSend, conversationMessage, conversationContext;
var conversationLoadPrevious;
var conversationToggles, conversationBox;
var conversationCurrentConversation;

$(document).ready(function () {
    conversationBody = $('#conversation_body');
    conversationToggles = $('[data-toggle="conversation"]');

    if (conversationToggles.length > 0) {
        initConversations();
    }

    if (conversationBody.length === 1) {
        initConversation();
    }
});

/**
 *
 */
function initConversations() {
    conversationBox = $('#conversation_box');

    conversationToggles.each(function (i) {
        $(this).on('click', function (e) {
            e.preventDefault();

            // Don't re-load if already viewing
            if (conversationCurrentConversation == $(this).attr('href')) {
                return false;
            }
            conversationCurrentConversation = $(this).attr('href');

            conversationBox.html('<i class="fa fa-spinner fa-spin"></i>');
            $(this).parent().addClass('active');

            $.ajax($(this).attr('href')).done(function (data) {
                conversationBox.html(data);
                initConversation();
                window.crudInitAjaxModal();
            });

            return false;
        });
    });
}

/**
 *
 */
function initConversation() {
    // Save references
    conversationBody = $('#conversation_body');
    conversationSend = $('#conversation_send');
    conversationContext = $("input[name='context']");
    conversationMessage = $("input[name='message']");

    // Load the first messages
    // $.ajax(
    //     conversationBody.data('url')
    // ).done(function(data) {
    //     conversationBody.html(data);
    //     scrollToBottom(conversationBody);
    //     initLoadPrevious();
    // });
    scrollToBottom(conversationBody);
    initLoadPrevious();

    conversationSend.on('submit', function (e) {
        e.preventDefault();
        var text = conversationContext.val();
        if (!text || text.length === 0 || !text.trim()) {
            return false;
        }

        newest = $('.box-comment').last().data('id');
        conversationMessage.val(text);
        conversationContext.prop('disabled', true);
        $.ajax({
            type: "POST",
            url: $(this).attr('action') + '?newest=' + newest,
            data: $(this).serialize()
        }).done(function (data) {
            // Add new messages
            conversationBody.append(data);
            conversationContext.val('');
            conversationMessage.val('');
            conversationContext.prop('disabled', false);
            conversationContext.focus();

            // Scroll to bottom
            scrollToBottom(conversationBody);
        }).fail(function (data) {
            console.error("Failed Post", data);
        });
        return false;
    });
}

function initLoadPrevious() {
    conversationLoadPrevious = $('#conversation_load_previous');
    if (conversationLoadPrevious.length === 1) {
        conversationLoadPrevious.on('click', function (e) {
            //console.log('load previous url', $(this).data('url'));
            conversationLoadPrevious.html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax($(this).data('url')).done(function (data) {
                conversationLoadPrevious.remove();
                conversationBody.prepend(data);
                initLoadPrevious();
            });
        });
    }
}
/**
 * Scroll to the bottom of an element.
 * @param element
 */
function scrollToBottom(element) {
    element.scrollTop(element.prop('scrollHeight'));
}

/***/ }),

/***/ 8:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/conversation.js");


/***/ })

/******/ });