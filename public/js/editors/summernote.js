/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************************!*\
  !*** ./resources/assets/js/editors/summernote.js ***!
  \***************************************************/
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
    maximumImageFileSize: parseInt(summernoteConfig.data('filesize')) * 1024,
    lang: editorLang(summernoteConfig.data('locale')),
    hintSelect: 'next',
    placeholder: summernoteConfig.data('placeholder'),
    dialogsInBody: summernoteConfig.data('dialogs') === 1,
    toolbar: [['style', ['style']], ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']], ['color', ['color']], ['kanka', ['aroba', summernoteConfig.data('bragi') !== undefined ? 'bragi' : null]], ['para', ['ul', 'ol', 'kanka-indent', 'kanka-outdent', 'paragraph']], ['table', ['table', 'spoiler', 'tableofcontent']], ['insert', ['link', 'picture', 'video', 'embed', 'hr']],
    //['dir', ['ltr', 'rtl']],
    ['view', ['fullscreen', 'codeview', 'prettify', 'help']], summernoteConfig.data('gallery') !== '' ? ['extensions', ['summernoteGallery']] : null],
    popover: {
      table: [['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']], ['delete', ['deleteRow', 'deleteCol', 'deleteTable']], ['custom', ['tableHeaders']], ['custom', ['tableStyles']]],
      image: [['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']], ['float', ['floatLeft', 'floatRight', 'floatNone']], ['remove', ['removeMedia']], ['custom', ['imageAttributes']]]
    },
    callbacks: {
      onImageUpload: function onImageUpload(files) {
        uploadImage($summernote, files[0]);
      },
      onChange: function onChange() {
        window.entityFormHasUnsavedChanges = true;
      },
      onChangeCodeview: function onChangeCodeview(contents, $editable) {
        $(this).summernote('code', contents);
      }
      /*onBlur: function() {
          console.log('blury');
      },*/
    },

    summernoteGallery: {
      source: {
        // data: [],
        url: summernoteConfig.data('gallery'),
        responseDataKey: 'data',
        nextPageKey: 'links.next'
      },
      modal: {
        loadOnScroll: true,
        maxHeight: 350,
        title: summernoteConfig.data('gallery-title'),
        close_text: summernoteConfig.data('gallery-close'),
        ok_text: summernoteConfig.data('gallery-add'),
        selectAll_text: summernoteConfig.data('gallery-select-all'),
        deselectAll_text: summernoteConfig.data('gallery-deselect-all'),
        noImageSelected_msg: summernoteConfig.data('gallery-error')
      }
    },
    bragi: {
      source: {
        url: summernoteConfig.data('bragi')
      },
      buttonLabel: '<i class="fa-brands fa-pied-piper-hat"></i>'
    },
    hint: [{
      match: /\B@(\S*)$/,
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
      match: /\B\[(\S[^:]*)$/,
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
        advancedRequest = true;
        return hintContent(item);
      }
    }, {
      match: /\B\#(\S*)$/,
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
      match: /\B{(\S[^:]*)$/,
      search: function search(keyword, callback) {
        return attributeSearch(keyword, callback);
      },
      template: function template(item) {
        return attributeTemplate(item);
      },
      content: function content(item) {
        return attributeContent(item);
      }
    }],
    keyMap: {
      pc: {
        'ESC': 'escape',
        'ENTER': 'insertParagraph',
        'CTRL+Z': 'undo',
        'CTRL+Y': 'redo',
        'TAB': 'tab',
        'SHIFT+TAB': 'untab',
        'CTRL+B': 'bold',
        'CTRL+I': 'italic',
        'CTRL+U': 'underline',
        'CTRL+SHIFT+I': 'strikethrough',
        'CTRL+BACKSLASH': 'removeFormat',
        'CTRL+SHIFT+L': 'justifyLeft',
        'CTRL+SHIFT+E': 'justifyCenter',
        'CTRL+SHIFT+R': 'justifyRight',
        'CTRL+SHIFT+J': 'justifyFull',
        'CTRL+SHIFT+NUM7': 'insertUnorderedList',
        'CTRL+SHIFT+NUM8': 'insertOrderedList',
        'CTRL+LEFTBRACKET': 'outdent',
        'CTRL+RIGHTBRACKET': 'indent',
        'CTRL+NUM0': 'formatPara',
        'CTRL+NUM1': 'formatH1',
        'CTRL+NUM2': 'formatH2',
        'CTRL+NUM3': 'formatH3',
        'CTRL+NUM4': 'formatH4',
        'CTRL+NUM5': 'formatH5',
        'CTRL+NUM6': 'formatH6',
        'CTRL+ENTER': 'insertHorizontalRule',
        'CTRL+K': 'linkDialog.show'
      },
      mac: {
        'ESC': 'escape',
        'ENTER': 'insertParagraph',
        'CMD+Z': 'undo',
        'CMD+SHIFT+Z': 'redo',
        'TAB': 'tab',
        'SHIFT+TAB': 'untab',
        'CMD+B': 'bold',
        'CMD+I': 'italic',
        'CMD+U': 'underline',
        'CMD+SHIFT+I': 'strikethrough',
        'CMD+BACKSLASH': 'removeFormat',
        'CMD+SHIFT+L': 'justifyLeft',
        'CMD+SHIFT+E': 'justifyCenter',
        'CMD+SHIFT+R': 'justifyRight',
        'CMD+SHIFT+J': 'justifyFull',
        'CMD+SHIFT+NUM7': 'insertUnorderedList',
        'CMD+SHIFT+NUM8': 'insertOrderedList',
        'CMD+LEFTBRACKET': 'outdent',
        'CMD+RIGHTBRACKET': 'indent',
        'CMD+NUM0': 'formatPara',
        'CMD+NUM1': 'formatH1',
        'CMD+NUM2': 'formatH2',
        'CMD+NUM3': 'formatH3',
        'CMD+NUM4': 'formatH4',
        'CMD+NUM5': 'formatH5',
        'CMD+NUM6': 'formatH6',
        'CMD+ENTER': 'insertHorizontalRule',
        'CMD+K': 'linkDialog.show'
      }
    }
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
    //console.log('entity not yet created');
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
  var type = item.type ? ' (' + item.type + ')' : '';
  if (item.image) {
    return '<div class="entity-hint">' + item.image + '<div class="entity-hint-name">' + item.fullname + type + '</div>' + '</div>';
  }
  return item.fullname + type;
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
    var mention = '[' + item.model_type + ':' + item.id + item.fullname + ']';
    var advancedMention = '[' + item.model_type + ':' + item.id + item.advanced_mention + ']';
    if (item.alias_id) {
      mention = '[' + item.model_type + ':' + item.id + item.advanced_mention + '|alias:' + item.alias_id + item.advanced_mention_alias + ']';
      return $('<span>' + mention + '</span>')[0];
    }
    if (summernoteConfig.data('advanced-mention')) {
      return $('<span>' + advancedMention + '</span>')[0];
    }
    if (advancedRequest) {
      return $('<span>' + advancedMention + '</span>')[0];
    }
    //console.log('standard');
    return $('<a />', {
      text: item.fullname,
      href: '#',
      "class": 'mention',
      'data-name': item.fullname,
      'data-mention': '[' + item.model_type + ':' + item.id + ']'
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
    "class": 'attribute attribute-mention',
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
  var modal = $('#campaign-imageupload-modal');
  // Check if the campaign is superboosted
  if (!summernoteConfig.data('gallery-upload')) {
    modal.modal();
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
      // Depending on the error, we need to handle the user differently
      //console.log(textStatus + " " + errorThrown);
      //console.log(jqXHR);
      var error = $('#campaign-imageupload-error');
      var boosted = $('#campaign-imageupload-boosted');
      var permission = $('#campaign-imageupload-permission');
      error.hide();
      boosted.hide();
      permission.hide();
      if (jqXHR.status === 422) {
        error.text(buildErrors(jqXHR.responseJSON.errors)).show();
      } else if (jqXHR.status === 403) {
        permission.show();
      } else {
        boosted.show();
      }
      //$('#superboosted-error').text(buildErrors(jqXHR.responseJSON.errors));
      modal.modal();
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
/******/ })()
;
//# sourceMappingURL=summernote.js.map