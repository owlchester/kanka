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
window.initSummernote = function() {
    $('.html-editor').summernote({
        height: '300px',
        lang: editorLang(summernoteConfig.data('locale')),
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'embed', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        popover: {
            table: [
                ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                ['custom', ['tableHeaders']]
            ],
        },
        hint: [
            {
                match: /\B@(\w*)$/,
                search: function (keyword, callback) {
                    return hintEntities(keyword, callback);
                },
                template: function (item) {
                    return hintTemplate(item);
                },
                content: function (item) {
                    advancedRequest = false;
                    return hintContent(item);
                }
            },
            {
                match: /\B\[(\w*)$/,
                search: function (keyword, callback) {
                    return hintEntities(keyword, callback);
                },
                template: function (item) {
                    return hintTemplate(item);
                },
                content: function (item) {
                    advancedRequest = true;
                    return hintContent(item);
                }
            },
            {
                match: /\B\#(\w*)$/,
                search: function (keyword, callback) {
                    return hintMonths(keyword, callback);
                },
                template: function (item) {
                    return hintTemplate(item);
                },
                content: function (item) {
                    advancedRequest = false;
                    return hintContent(item);
                }
            },
        ],
    });
}

/**
 * Search for entities
 * @param keyword
 * @param callback
 */
function hintEntities(keyword, callback) {
    $.ajax({
        url: summernoteConfig.data('mention') + '?q=' + keyword,
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
 * Hint template (results displayed in dropdown)
 * @param item
 * @returns {string}
 */
function hintTemplate(item) {
    return (item.image ? item.image : '') + item.fullname + (item.type ? ' (' + item.type + ')' : '');
}

/**
 * Hint content that is injected in the editor
 * @param item
 * @returns {string|*}
 */
function hintContent(item) {
    console.log('item', item);
    if (item.id) {
        let mention = '[' + item.model_type + ':' + item.id + ']';
        if (summernoteConfig.data('advanced-mention')) {
            return mention;
        } else {
            if (advancedRequest) {
                return mention;
            }
            return $('<a>', {
                text: item.fullname,
                href: '#',
                class: 'mention',
                'data-mention': mention,
            })[0];
        }
    }
    else if (item.url) {
        if (item.tooltip) {
            return $('<a>', {
                text: item.fullname,
                href: item.url,
                title: item.tooltip.replace(/["]/g, '\''),
                'data-toggle': 'tooltip',
                'data-html': 'true',
            })[0];
        }
        return $('<a>', {
            text: item.fullname,
            href: item.url,
        })[0];
    }
    return item.fullname;
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
    } else if(locale == 'en') {
        return 'en-US';
    } else {
        return locale + '-' + locale.toUpperCase();
    }
}
