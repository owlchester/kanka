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

    var embedPlugin = function(context) {
        var self = this;

        var options = context.options;
        var isIncludedInToolbar = false;

        for (var idx in options.toolbar) {
            // toolbar => [groupName, [list of button]]
            var buttons = options.toolbar[idx][1];
            if ($.inArray('embed', buttons) > -1) {
                isIncludedInToolbar = true;
                break;
            }
        }

        if (!isIncludedInToolbar) {
            return;
        }

        var ui = $.summernote.ui;
        var $editor = context.layoutInfo.editor;
        var lang = options.langInfo;

        // Create an embed button to be used in the toolbar
        context.memo('button.embed', function() {
            var button = ui.button({
                contents: "<i class='fas fa-photo-video'/>",
                tooltip: lang.embedButton.tooltip,
                click: function(e) {
                    self.show();
                }
            });

            return button.render();
        });

        this.createEmbedDialog = function($container) {
            var dialogOption = {
                title: lang.embedDialog.title,
                body: '<div class="form-group">' +
                    '<label>' + lang.embedDialog.label + '</label>' +
                    '<input id="input-autocomplete" class="form-control" type="text" placeholder="' + lang.embedDialog.placeholder + '" />' +
                    '<p class="help-block">' + lang.embedDialog.help + '</p>' +
                    '</div>',
                footer: '<button href="#" id="btn-add" class="btn btn-primary">' + lang.embedDialog.button + '</button>',
                closeOnEscape: true
            };

            self.$dialog = ui.dialog(dialogOption).render().appendTo($container);
            self.$dialog.css({
                "height": "100%"
            });
            self.$addBtn = self.$dialog.find('#btn-add');
            self.$embedInput = self.$dialog.find('#input-autocomplete')[0];
        };

        this.enableAddButton = function() {
            if (self.$embedInput.value && self.$embedInput.value.length > 0) {
                self.$addBtn.attr("disabled", false);
            } else {
                self.disableAddButton();
            }
        };

        this.disableAddButton = function() {
            self.$addBtn.attr("disabled", true);
        };

        this.initEmbed = function() {
            self.enableAddButton();
        };

        this.showEmbedDialog = function() {
            self.disableAddButton();
            self.$embedInput.value = "";

            return $.Deferred(function(deferred) {
                const $embedInput = self.$dialog.find('#input-autocomplete');
                const $embedAdd = self.$dialog.find('#btn-add');

                ui.onDialogShown(self.$dialog, function() {
                    context.triggerEvent('dialog.shown');
                    self.$embedInput.focus();

                    $embedInput.on('input paste propertychange', () => {
                        self.enableAddButton();
                    });

                    self.$addBtn.click(function(event) {
                        event.preventDefault();
                        deferred.resolve({
                            place: self.$embedInput.value
                        });
                    });
                });

                ui.onDialogHidden(self.$dialog, function() {
                    self.$addBtn.off('click');
                    if (deferred.state() === 'pending') {
                        deferred.reject();
                    }
                });

                ui.showDialog(self.$dialog);


                self.bindEnterKey($embedInput, $embedAdd);
            });
        };

        this.show = function() {
            context.invoke('editor.saveRange');

            self.showEmbedDialog()
                .then(function(data) {
                    context.invoke('editor.restoreRange');
                    self.insertEmbedToEditor(data.place);
                    ui.hideDialog(self.$dialog);
                }).fail(function() {
                context.invoke('editor.restoreRange');
            });
        };

        this.insertEmbedToEditor = function(placeName) {
            // Only insert if it's an embed
            if (!/^<iframe/i.test(placeName)) {
                return;
            }

            var $div = $('<div>');

            $div.css({
            });

            $div.html(placeName)
            context.invoke('editor.insertNode', $div[0]);
        };

        this.initialize = function() {
            var $container = options.dialogsInBody ? $(document.body) : $editor;
            self.createEmbedDialog($container);
        };

        this.destroy = function() {
            ui.hideDialog(self.$dialog);
            self.$dialog.remove();
        };


        this.bindEnterKey = function ($input, $btn) {
            $input.on('keypress', function (event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    $btn.trigger('click');
                }
            });
        };

        // This events will be attached when editor is initialized.
        this.events = {
            // This will be called after modules are initialized.
            'summernote.init': function(we, e) {
                self.initEmbed();
            }
        };
    };

    $.extend(true, $.summernote, {
        lang: {
            'en-US': {
                embedButton: {
                    tooltip: "Embed"
                },
                embedDialog: {
                    title: "Insert Embed",
                    label: "Embed script",
                    placeholder: "<iframe src=''></iframe>",
                    button: "Insert Embed",
                    help: "Copy-Past a Spotify, Youtube or Google Docs embed code in the above field.",
                }
            },
        },
        plugins: {
            'embed': embedPlugin
        }
    });

}));

