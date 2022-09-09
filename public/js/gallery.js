/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/assets/js/gallery.js ***!
  \****************************************/
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
  }).bind('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      initSearch();
    }
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
  fileDrop.unbind('drop dragover').bind('drop dragover', function (e) {
    e.preventDefault();
    fileProgress.show();
  });
  $('.file-upload-form').fileupload({
    dropZone: fileDrop,
    dataType: 'json',
    add: function add(e, data) {
      fileError.hide();
      data.submit();
    },
    progressall: function progressall(e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      fileProgress.show();
      $('.progress .progress-bar').css('width', progress + '%');
    },
    done: function done(e, data) {
      fileProgress.hide();

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
    var folder = $(this).data('folder');

    if (folder) {
      window.location = folder;
      return;
    }

    $.ajax({
      url: $(this).data('url')
    }).done(function (data) {
      $('#large-modal-content').html(data);
      $('#large-modal').modal('show');
    });
  });
}
/******/ })()
;