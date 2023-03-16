/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/js/components/ajax-modal.js":
/*!******************************************************!*\
  !*** ./resources/assets/js/components/ajax-modal.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ajaxModal)
/* harmony export */ });
function ajaxModal() {
  $('[data-toggle="ajax-modal"]').unbind('click').click(function (e) {
    e.preventDefault();
    ajaxModal = $(this);
    $.ajax({
      url: $(this).data('url')
    }).done(function (result, textStatus, xhr) {
      if (result) {
        var params = {};
        var target = $(ajaxModal).data('target');
        var backdrop = $(ajaxModal).data('backdrop');
        if (backdrop) {
          params.backdrop = backdrop;
        }
        $(target).find('.modal-content').html(result);
        $(target).modal(params);
      }
    }).fail(function (result, textStatus, xhr) {
      //console.log('modal ajax error', result);
    });
    return false;
  });
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!************************************************!*\
  !*** ./resources/assets/js/forms/character.js ***!
  \************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_ajax_modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/ajax-modal */ "./resources/assets/js/components/ajax-modal.js");

var characterAddOrganisation, characterTemplateOrganisation, characterOrganisations;
$(document).ready(function () {
  characterOrganisations = $('.character-organisations');
  characterAddOrganisation = $('#add_organisation');
  if (characterAddOrganisation.length === 1) {
    initCharacterOrganisation();
  }
});

/**
 *
 */
function initCharacterOrganisation() {
  characterTemplateOrganisation = $('#template_organisation');
  characterAddOrganisation.on('click', function (e) {
    e.preventDefault();
    $(characterOrganisations).append('<div class="form-group">' + characterTemplateOrganisation.html() + '</div>');

    // Replace the temp class with the real class. We need this to avoid having two select2 fields
    characterOrganisations.find('.tmp-org').removeClass('tmp-org').addClass('select2');

    // Handle deleting already loaded blocks
    characterDeleteRowHandler();
    return false;
  });
  characterDeleteRowHandler();
}

/**
 *
 */
function characterDeleteRowHandler() {
  $.each($('.member-delete'), function () {
    $(this).unbind('click').unbind('keydown');
    $(this).on('click', function (e) {
      e.preventDefault();
      $(this).closest('.form-group').remove();
    }).on('keydown', function (e) {
      // Support for pressing enter on a span
      if (e.key !== 'Enter') {
        return;
      }
      $(this).click();
    });
    ;
  });

  // Always re-calc the sortable traits
  window.initSortable();
  window.initForeignSelect();
}
})();

/******/ })()
;
//# sourceMappingURL=character.js.map