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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/entity.js":
/***/ (function(module, exports) {

var entityFileUi, entityFileModal;
var entityFileDrop, entityFileProgress, entityFileMax;
var openingEntityFileModal = false;

$(document).ready(function () {
    entityFileUi = $('.entity-file-ui');
    entityFileModal = $('#entity-modal');

    if (entityFileUi.length === 1) {
        entityFileUi.on('click', function (e) {
            openingEntityFileModal = true;
            entityFileModal.on('shown.bs.modal', function (e) {
                initEntityFileModal();
                registerDelete();
            });
        });
    }
});

function initEntityFileModal() {
    if (!openingEntityFileModal) {
        return;
    }
    console.log('file modal loaded');
    openingEntityFileModal = false;

    entityFileDrop = $('.entity-files-drop');
    entityFileProgress = $('#entity-file-progress');
    entityFileMax = $('.entity-file-upload-max');

    entityFileDrop.bind('drop', function (e) {
        e.preventDefault();
        entityFileProgress.show();
    }).on('click', function (e) {
        console.log('clicked');
        $('#entity-file-upload').trigger('click');
    });

    $('#entity-file-upload').fileupload({
        dropZone: entityFileDrop,
        dataType: 'json',
        add: function add(e, data) {
            entityFileDrop.hide();
            console.log('data', data);
            data.submit();
        },
        progressall: function progressall(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress').show();
            $('.progress .progress-bar').css('width', progress + '%');
        },
        done: function done(e, data) {
            $('.progress').hide();
            //entityFileDrop.show();

            console.log('done', data.result);

            if (data.result.success) {
                replaceFileList(data.result);
                toggleUpload(data.result.enabled);
                $('.entity-file-upload-error').hide();
            } else {
                $('.entity-file-upload-error').text(data.result.error).fadeToggle();
                console.log('no success');
            }
        }
    });

    // When dropped, start uploading pronto
    entityFileDrop.bind('drop', function (e) {
        console.log('file dropped');
        entityFileProgress.show();
    });
}

function registerDelete() {
    $('.entity-file-remove').each(function () {
        $(this).unbind('click');
        $(this).on('click', function (e) {
            $(this).removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');
            $.ajax({
                type: 'GET',
                url: $(this).data('url'),
                context: this
            }).done(function (result, textStatus, xhr) {
                // Hide this
                console.log('removed', $(this), $(this).parent());
                $(this).parent().fadeOut();
                toggleUpload(result.enabled);
            });
        });
    });
}

function replaceFileList(data) {
    $('.entity-files').html(data.html);

    registerDelete();
}

function toggleUpload(enabled) {
    if (enabled) {
        entityFileDrop.fadeIn();
        entityFileMax.hide();
    } else {
        entityFileDrop.hide();
        entityFileMax.fadeIn();
    }
}

/***/ }),

/***/ 5:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/entity.js");


/***/ })

/******/ });