const summernoteConfig = document.querySelector('#summernote-config');
let advancedRequest = false;


/**
 * Initialize summernote when available
 */
window.initSummernote = function() {
    document.querySelectorAll('.html-editor')?.forEach(function (field) {
        initField(field);
    });
};

const initField = (field) => {
    $(field).summernote({
        height: '300px',
        maximumImageFileSize: parseInt(summernoteConfig.dataset.filesize) * 1024,
        lang: editorLang(summernoteConfig.dataset.locale),
        hintSelect: 'next',
        placeholder: summernoteConfig.dataset.placeholder,
        dialogsInBody: summernoteConfig.dataset.dialogs === 1,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['color', ['color']],
            ['kanka', ['aroba', (summernoteConfig.dataset.bragi !== undefined ? 'bragi' : null)]],
            ['para', ['ul', 'ol', 'kanka-indent', 'kanka-outdent', 'paragraph']],
            ['table', ['table', 'tableofcontent']],
            ['insert', ['link', 'picture', 'video', 'embed', 'hr']],
            //['dir', ['ltr', 'rtl']],
            ['view', ['fullscreen', 'codeview', 'prettify']],
            (summernoteConfig.dataset.gallery ? ['extensions', ['summernoteGallery', 'help']] : null),
        ],

        popover: {
            table: [
                ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                ['custom', ['tableHeaders']],
                ['custom', ['tableStyles']]
            ],
            image: [
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']],
                ['custom', ['imageAttributes']],
            ],
        },
        callbacks: {
            onImageUpload: function (files) {
                uploadImage($(field), files[0]);
            },
            onChange: function() {
                window.entityFormHasUnsavedChanges = true;
            },
            onChangeCodeview: function(contents, $editable) {
                $(field).summernote('code', contents);
            },
            /*onBlur: function() {
                console.log('blury');
            },*/
        },
        summernoteGallery: {
            source: {
                // data: [],
                url: summernoteConfig.dataset.gallery,
                responseDataKey: 'data',
                nextPageKey: 'links.next',
            },
            modal: {
                loadOnScroll: true,
                maxHeight: 350,
                title: summernoteConfig.dataset.galleryTitle,
                close_text: summernoteConfig.dataset.galleryClose,
                ok_text: summernoteConfig.dataset.galleryAdd,
                selectAll_text: summernoteConfig.dataset.gallerySelectAll,
                deselectAll_text: summernoteConfig.dataset.galleryDeselectAll,
                noImageSelected_msg: summernoteConfig.dataset.galleryError,
            }
        },
        bragi: {
            source: {
                url: summernoteConfig.dataset.bragi,
            },
            buttonLabel: '<i class="fa-brands fa-pied-piper-hat"></i>',
        },
        hint: [
            {
                match: /\B::(\S*)$/,
                search: function (keyword, callback) {
                    if (keyword.length < 3) {
                        return [];
                    }
                    return hintPosts(keyword, callback);
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
                match: /\B@(\S*)$/,
                search: function (keyword, callback) {
                    if (keyword.length < 3) {
                        return [];
                    }
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
                match: /\B\[(\S[^:]*)$/,
                search: function (keyword, callback) {
                    if (keyword.length < 3) {
                        return [];
                    }
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
                match: /\B\#(\S*)$/,
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
            {
                match: /\B{(\S[^:]*)$/,
                search: function (keyword, callback) {
                    return attributeSearch(keyword, callback);
                },
                template: function (item) {
                    return attributeTemplate(item);
                },
                content: function (item) {
                    return attributeContent(item);
                }
            },
        ],
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
                'CTRL+K': 'linkDialog.show',
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
                'CMD+K': 'linkDialog.show',
            },
        },
    });
};

/**
 * Search for entities
 * @param keyword
 * @param callback
 */
function hintEntities(keyword, callback) {
    axios.get(summernoteConfig.dataset.mention + '?q=' + keyword + '&new=1')
        .then(res => callback(res.data))
        .catch(err => {
            if (err.resonse.status === 503) {
                window.showToast(err.response.data.message, 'error');
            }
        })
    ;
}

/**
 * Search for posts
 * @param keyword
 * @param callback
 */
function hintPosts(keyword, callback) {
    axios.get(summernoteConfig.dataset.mention + '?q=' + keyword + '&posts=1')
        .then(res => callback(res.data))
        .catch(err => {
            if (err.resonse.status === 503) {
                window.showToast(err.response.data.message, 'error');
            }
        })
    ;
}

/**
 * Search for months
 * @param keyword
 * @param callback
 */
function hintMonths(keyword, callback) {
    axios.get(summernoteConfig.dataset.months + '?q=' + keyword)
        .then(res => callback(res.data));
}

/**
 * Search for attributes
 * @param keyword
 * @param callback
 */
function attributeSearch(keyword, callback) {
    if (!summernoteConfig.dataset.attributes) {
        //console.log('entity not yet created');
        return false;
    }
    axios.get(summernoteConfig.dataset.attributes + '?q=' + keyword)
        .then(res => callback(res.data));
}

/**
 * Hint template (results displayed in dropdown)
 * @param item
 * @returns {string}
 */
function hintTemplate(item) {
    let type = (item.type ? ' (' + item.type + ')' : '');
    if (item.image) {
        const div = document.createElement('div');
        div.classList.add('entity-hint');
        div.innerHTML = item.image +
            '<div class="entity-hint-name">' +
            item.fullname +
            type +
            '</div>';
        return div;
    }
    return item.fullname + type;
}

/**
 * Attribute template
 * @param item
 * @returns {string}
 */
function attributeTemplate(item) {
    return item.name +  (item.value ? ' (' + item.value + ')' : '');
}

/**
 * Hint content that is injected in the editor
 * @param item
 * @returns {string|*}
 */
const hintContent = (item) => {
    if (item.id) {
        const span = document.createElement('span');
        let mention = '[' + item.model_type + ':' + item.id + item.fullname + ']';
        let advancedMention = '[' + item.model_type + ':' + item.id + item.advanced_mention + ']';
        if (item.alias_id) {
            mention = '[' + item.model_type + ':' + item.id + item.advanced_mention + '|alias:' + item.alias_id + item.advanced_mention_alias + ']';
            span.innerHTML = mention;
            return span;
        }
        if (summernoteConfig.dataset.advancedMention) {
            span.innerHTML = advancedMention;
            return span;
        }
        if (advancedRequest) {
            span.innerHTML = advancedMention;
            return span;
        }
        //console.log('standard');
        const link = document.createElement('a');
        link.text = item.fullname;
        link.href = '#';
        link.classList.add('mention');
        link.dataset.name = item.fullname;
        link.dataset.mention = '[' + item.model_type + ':' + item.id + ']';
        return link;
    } else if (item.url) {
        const mention = document.createElement('a');
        mention.text = item.fullname;
        mention.href = item.url;
        if (item.tooltip) {
            mention.title = item.tooltip.replace(/["]/g, '\'');
            mention.dataset.toggle = 'tooltip';
            mention.dataset.html = true;
            return mention;
        }
        return mention;
    } else if (item.inject) {
        return item.inject;
    }
    return item.fullname;
};

/**
 *
 * @param item
 * @returns {jQuery|HTMLElement}
 */
function attributeContent(item)
{
    if (summernoteConfig.dataset.advancedMention) {
        return '{attribute:' + item.id + '}';
    }
    const link = document.createElement('a');
    link.href = '#';
    link.classList.add('attribute', 'attribute-mention');
    link.text = '{' + item.name + '}';
    link.dataset.attribute =  '{attribute:' + item.id + '}';
    return link;
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
    } else if(locale == 'en') {
        return 'en-US';
    } else {
        return locale + '-' + locale.toUpperCase();
    }
}

/**
 * Upload a file through summernote
 * @param file
 */
const uploadImage = ($summernote, file) => {
    const modal = document.querySelector('#campaign-imageupload-modal');
    // Check if the campaign is superboosted
    if (!summernoteConfig.dataset.galleryUpload) {
        $(modal).modal();
        console.warn('Campaign isn\'t superboosted');
        return;
    }

    let formData = new FormData();
    formData.append("file[]", file);
    axios.post(summernoteConfig.dataset.galleryUpload, formData)
        .then(res => {
            //console.log('result', res.data);
            $summernote.summernote('insertImage', res.data.url, function ($image) {
                $image.attr('src', res.data.url);
                $image.attr('data-gallery-id', res.data.id);
            });
        })
        .catch(err => {
            // Depending on the error, we need to handle the user differently
            //console.log(textStatus + " " + errorThrown);
            //console.log(jqXHR);
            let error = document.querySelector('#campaign-imageupload-error');
            let permission = document.querySelector('#campaign-imageupload-permission');

            error.classList.add('hidden');
            permission.classList.add('hidden');

            if (err.response.status === 422) {
                error.innerHTML = buildErrors(err.response.data.errors);
                error.classList.remove('hidden');
            } else if (err.response.status === 403) {
                permission.classList.remove('hidden');
            }
            $(modal).modal();
        });
};

/**
 *
 * @param data
 * @returns {string}
 */
const buildErrors = (data) => {
    let errors = '';
    for (let key in data) {
        // skip loop if the property is from prototype
        if (!data.hasOwnProperty(key)) continue;

        errors += data[key] + "\n";
    }
    return errors;
};

// We have to wait for ready to load all of summernote, otherwise our plugins won't register
$(document).ready(function () {
    if (summernoteConfig) {
        window.initSummernote();
    }
});
