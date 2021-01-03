/* Kanka Spoiler/Summary plugin */
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
            spoiler: {
                tooltip: 'Detail & Summary'
            }
        }
    });
    $.extend($.summernote.options, {
        spoiler: {
            icon: '<i class="fas fa-chevron-circle-right"></i>',
            css: '@media all{}'
        }
    });
    $.extend($.summernote.plugins, {
        'spoiler': function(context) {
            var ui      = $.summernote.ui;
            var options = context.options;
            var lang    = options.langInfo;
            $("head").append('<style>' + options.spoiler.css + '</style>');
            context.memo('button.spoiler',function() {
                var button = ui.button({
                    contents: options.spoiler.icon,
                    tooltip:  lang.spoiler.tooltip,
                    container: 'body',
                    click: function (e) {
                        e.preventDefault();
                        if (getSelection().rangeCount > 0) {
                            var el = getSelection().getRangeAt(0).commonAncestorContainer.parentNode;
                            if ($(el).hasClass('note-editable')) {
                                el = getSelection().getRangeAt(0).commonAncestorContainer;
                            }
                            if (!$(el).hasClass('spoiler')) {
                                if ($(el).next('details.spoiler').length < 1)
                                    $('<details class="spoiler"><summary>Summary</summary>Details</details>').insertAfter(el);
                            }
                        } else {
                            if ($('.note-editable details').last().attr('class') !== 'spoiler')
                                $('.note-editable').append('<details class="spoiler"><summary>Summary</summary>Details</details>');
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
