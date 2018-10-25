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
                registerDeleteBtn();
                registerRenameBtn();
                registerRenameField();
            });
        });
    }
});

/**
 *
 */
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

    // Allow ajax requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#entity-file-upload').fileupload({
        dropZone: entityFileDrop,
        dataType: 'json',
        add: function add(e, data) {
            entityFileDrop.hide();
            $('.entity-file-upload-error').hide();
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

                refreshEntityFileList();
            } else {
                $('.entity-file-upload-error').text(data.result.error).fadeIn();
                console.log('no success');
            }
        },
        fail: function fail(e, data) {
            toggleUpload(true);
            $('.progress').hide();
            $('.entity-file-upload-error').text(buildErrors(data.jqXHR.responseJSON.errors)).fadeToggle();
        }
    });

    // When dropped, start uploading pronto
    entityFileDrop.bind('drop', function (e) {
        entityFileProgress.show();
    });
}

/**
 * When clicking on the trash, delete an object
 */
function registerDeleteBtn() {
    $('.entity-file-remove').each(function () {
        $(this).unbind('click');
        $(this).on('click', function (e) {
            $(this).removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');
            $.post({
                url: $(this).data('url'),
                data: {
                    '_method': 'DELETE'
                },
                context: this
            }).done(function (result, textStatus, xhr) {
                // Hide this
                $(this).parent().fadeOut();
                toggleUpload(result.enabled);
                refreshEntityFileList();
            });
        });
    });
}

/**
 * When clicking on rename, show a special form
 */
function registerRenameBtn() {
    $('.entity-file-rename').each(function (i) {
        $(this).unbind('click').on('click', function (e) {
            console.log('rename click');
            $(this).parent().children('a').hide();
            $(this).parent().children('input').val($(this).data('default')).show().focus();
            $(this).hide();
        });
    });
}

/**
 * Renaming an entity can be submitted hitting enter, or canceled by losing focus
 */
function registerRenameField() {
    $('.entity-file-name').each(function () {
        $(this).unbind('keypress').unbind('focusout').keypress(function (e) {
            var keyCode = e.keyCode || e.which;
            var link;

            // Submit
            if (keyCode === 13) {
                e.preventDefault();
                link = $(this).parent().children('a');

                // Ajax rename.
                $.post({
                    url: $(this).data('url'),
                    data: {
                        '_method': 'PATCH',
                        'name': $(this).val(),
                        'csrf-token': $('.csrf-token').val()
                    },
                    datatype: 'JSON',
                    context: this
                }).done(function (data) {
                    var newVal = $(this).val();
                    $(this).val(newVal).hide();

                    // Change link text, data-default and show it
                    link.data('default', newVal).html(newVal).show();

                    // Enable editing again
                    $(this).parent().children('.entity-file-rename').data('default', newVal).show();
                    $('.entity-file-error').hide();

                    refreshEntityFileList();
                }).fail(function (data) {
                    $(this).parent().children('.entity-file-error').text(buildErrors(data.responseJSON.errors)).show();
                });
            }
        }).focusout(function (e) {
            // Show the normal field, hide the rest. Reset the value.
            link = $(this).parent().children('a');
            $(this).val($(this).data('default'));
            link.show();
            $(this).hide();
            $(this).parent().children('.entity-file-rename').show();
            $('.entity-file-error').hide();
        });
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

/**
 *
 * @param data
 */
function replaceFileList(data) {
    $('.entity-files').html(data.html);

    registerDeleteBtn();
    registerRenameBtn();
    registerRenameField();
}

/**
 *
 * @param enabled
 */
function toggleUpload(enabled) {
    if (enabled) {
        entityFileDrop.fadeIn();
        entityFileMax.hide();
    } else {
        entityFileDrop.hide();
        entityFileMax.fadeIn();
    }
}

/**
 * Refresh the file list behind the modal
 */
function refreshEntityFileList() {
    $('.entity-file-list').each(function () {
        // Get the new list with ajax, as someone else might also be changing the file list.
        $.ajax({
            url: $(this).data('url'),
            context: this
        }).done(function (data) {
            if (data) {
                $(this).html(data);
            }
        });
    });
}

/***/ }),

/***/ 5:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/entity.js");


/***/ })

/******/ });