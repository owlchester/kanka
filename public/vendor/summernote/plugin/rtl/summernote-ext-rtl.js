(function(factory) {
    /* global define */
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(window.jQuery);
    }
}(function($) {
    // Extends plugins for adding hello.
    //  - plugin is external module for customizing.
    $.extend($.summernote.plugins, {
        /**
         * @param {Object} context - context object has status of editor.
         */
        'rtl': function(context) {
            var self = this;
            var selection;
            // ui has renders to build ui elements.
            //  - you can create a button with `ui.button`
            var ui = $.summernote.ui;
            // add hello button
            context.memo('button.rtl', function() {
                // create button
                var button = ui.button({
                    contents: '<i class="fa fa-paragraph"/><i class="fa fa-caret-left"/>',
                    tooltip: 'Change text direction to the right',
                    click: function() {
                        function clearSelection() {
                            if (document.selection) {
                                document.selection.empty();
                            } else if (window.getSelection) {
                                window.getSelection().removeAllRanges();
                            }
                        }

                        function getHTMLOfSelection() {
                            var range;
                            if (document.selection && document.selection.createRange) {
                                range = document.selection.createRange();
                                return range.htmlText;
                            } else if (window.getSelection) {
                                selection = window.getSelection();
                                if (selection.rangeCount > 0) {
                                    range = selection.getRangeAt(0);
                                    var clonedSelection = range.cloneContents();
                                    var div = document.createElement('div');
                                    div.appendChild(clonedSelection);
                                    return div.innerHTML;
                                } else {
                                    return '';
                                }
                            } else {
                                return '';
                            }
                        }
                        var highlight = window.getSelection();
                        var range = highlight.getRangeAt(0);
                        var elementsClass = range.endContainer.parentElement;


                        window.highlight = highlight;
                        window.range = range;
                        window.elementsClass = elementsClass;
                        if (elementsClass.style.direction != "rtl" && elementsClass.style.direction != "ltr") {
                            var spn = document.createElement('div');
                            spn.innerHTML = getHTMLOfSelection();
                            spn.style.direction = 'rtl';
                            range.deleteContents();
                            range.insertNode(spn);
                        } else {
                            elementsClass.style.direction = 'rtl';
                            if($(elementsClass).is("li")){
                                direction = $(elementsClass).css('direction');
                                $(elementsClass).parent().css('direction',direction);
                            }
                        }
                        clearSelection();
                    }
                });
                // create jQuery object from button instance.
                var $rtl = button.render();
                return $rtl;
            });
        },
        'ltr': function(context) {
            var self = this;
            // ui has renders to build ui elements.
            var ui = $.summernote.ui;
            context.memo('button.ltr', function() {
                // create button
                var button = ui.button({
                    contents: '<i class="fa fa-caret-right"/><i class="fa fa-paragraph"/>',
                    tooltip: 'Change text direction to the left',
                    click: function() {
                        function clearSelection() {
                            if (document.selection) {
                                document.selection.empty();
                            } else if (window.getSelection) {
                                window.getSelection().removeAllRanges();
                            }
                        }

                        function getHTMLOfSelection() {
                            var range;
                            if (document.selection && document.selection.createRange) {
                                range = document.selection.createRange();
                                return range.htmlText;
                            } else if (window.getSelection) {
                                selection = window.getSelection();
                                if (selection.rangeCount > 0) {
                                    range = selection.getRangeAt(0);
                                    var clonedSelection = range.cloneContents();
                                    var div = document.createElement('div');
                                    div.appendChild(clonedSelection);
                                    return div.innerHTML;
                                } else {
                                    return '';
                                }
                            } else {
                                return '';
                            }
                        }
                        var highlight = window.getSelection();
                        var range = highlight.getRangeAt(0);
                        var elementsClass = range.endContainer.parentElement;
                        if (elementsClass.style.direction != "rtl" && elementsClass.style.direction != "ltr") {
                            var spn = document.createElement('div');
                            spn.innerHTML = getHTMLOfSelection();
                            spn.style.direction = 'ltr';
                            range.deleteContents();
                            range.insertNode(spn);
                        } else {
                            elementsClass.style.direction = 'ltr';
                            if($(elementsClass).is("li")){
                                direction = $(elementsClass).css('direction');
                                $(elementsClass).parent().css('direction',direction);
                            }
                        }
                        clearSelection();
                    }
                });
                // create jQuery object from button instance.
                var $ltr = button.render();
                return $ltr;
            });
        }
    });
}));
