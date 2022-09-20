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
            aroba: {
                tooltip: 'Mentions'
            }
        }
    });
    $.extend($.summernote.options, {
        aroba: {
            icon: '<i class="far fa-at"></i>',
            css: ''
        }
    });
    $.extend($.summernote.plugins, {
        'aroba': function(context) {
            var self = this;

            var ui = $.summernote.ui;

            var options = context.options;
            var lang = options.langInfo;

            var $container = options.dialogsInBody ? $(document.body) : context.layoutInfo.editor;

            // add hello button
            context.memo('button.aroba', function() {
                // create button
                let button = ui.button({
                    contents: '<i class="fa-solid fa-at"/>',
                    tooltip: 'Mentions',
                    click: function () {
                        self.openPopup();
                    },
                });

                // create jQuery object from button instance.
                let $hello = button.render();
                return $hello;
            });

            var body = [
                '<p class="text-center">',
                'Create mentions to other entities of the campaign by typing <code>@</code> followed by at least three letters.',
                '<br /><br />',
                'Search for entities with spaces by replacing <code>&nbsp;</code> with <code>_</code>. For example, <code>@Kanka_is_awesome</code>.',
                '</p>',
            ].join('');

            var footer = [
                '<p class="text-center">',
                '<a href="https://docs.kanka.io/en/latest/features/mentions.html" target="_blank">Learn more about mentions on our docs</a> · ',
                '</p>',
            ].join('');

            self.$dialog = ui.dialog({
                title: lang.aroba.title,
                fade: options.dialogsFade,
                body: body,
                footer: footer,
            }).render().appendTo($container);

            /**
             * show help dialog
             *
             * @return {Promise}
             */
            this.showHelpDialog = function() {
                return $.Deferred((deferred) => {
                    ui.onDialogShown(this.$dialog, () => {
                        context.triggerEvent('dialog.shown');
                        deferred.resolve();
                    });
                    ui.showDialog(this.$dialog);
                }).promise();
            }

            this.openPopup = function() {
                context.invoke('editor.saveRange');
                this.showHelpDialog().then(() => {
                    context.invoke('editor.restoreRange');
                });
            }
        }
    });

}));
