/* https://github.com/DiemenDesign/summernote-pagebreak */
(function(factory) {
    if(typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory(require('jquery'));
    } else {
        factory(window.jQuery);
    }
}
(function($) {
    $.extend(true,$.summernote.lang, {
        'en-US': {
            tableofcontent: {
                tooltip: 'Table of content'
            }
        }
    });
    $.extend($.summernote.options, {
        tableofcontent: {
            icon: '<i class="far fa-list-alt"></i>',
            css: ''
        }
    });
    $.extend($.summernote.plugins, {
        'tableofcontent': function(context) {
            var ui      = $.summernote.ui;
            var options = context.options;
            var lang    = options.langInfo;
            $("head").append('<style>' + options.tableofcontent.css + '</style>');
            context.memo('button.tableofcontent',function() {
                var button = ui.button({
                    contents: options.tableofcontent.icon,
                    tooltip:  lang.tableofcontent.tooltip,
                    container: 'body',
                    click: function (e) {
                        e.preventDefault();
                        if (getSelection().rangeCount > 0) {
                            var el = getSelection().getRangeAt(0).commonAncestorContainer.parentNode;
                            if ($(el).hasClass('note-editable')) {
                                el = getSelection().getRangeAt(0).commonAncestorContainer;
                            }
                            $('<p>{table-of-contents}</p>').insertBefore(el);

                        } else {
                            $('.note-editable').append('<p>{table-of-contents}</p>');
                        }

                        // Launching this method to force Summernote sync it's content with the bound textarea element
                        context.invoke('editor.insertText','');
                    }
                });
                return button.render();
            });
        }
    });
}));
