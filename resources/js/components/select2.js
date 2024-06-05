$(document).ready(function() {
    window.initForeignSelect = function () {
        if ($('select.select2').length === 0) {
            return;
        }
        $.each($('select.select2'), function (index) {

            if ($(this).hasClass('select2-hidden-accessible')) {
                return;
            }
            if ($(this).hasClass('campaign-genres')) {

                $(this).select2({
                    tags: false,
                    allowClear: true,
                    dropdownParent: '',
                    width: '100%',
                    maximumSelectionLength: 3,
                });
                return;
            }

            let url = $(this).data('url');
            let allowClear = $(this).data('allow-clear');
            let dropdownParent = $(this).data('dropdown-parent');

            if (!url) {
                $(this).select2({
                    tags: false,
                    placeholder: $(this).data('placeholder'),
                    allowClear: allowClear ?? false,
                    //tags: $(this).data('tags') || false,
                    language: $(this).data('language'),
                    minimumInputLength: 0,
                    dropdownParent: dropdownParent || '',
                    width: '100%',
                });
                return;
            }

            // Check it isn't the select2-icon
            $(this).select2({
                tags: false,
                placeholder: $(this).data('placeholder'),
                allowClear: allowClear || true,
                //tags: $(this).data('tags') || false,
                language: $(this).data('language'),
                minimumInputLength: 0,
                dropdownParent: dropdownParent || '',
                width: '100%',

                ajax: {
                    delay: 500,
                    quietMillis: 500,
                    url: url,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    error: function(response) {
                        console.log('error', response);
                        if (response.status === 503) {
                            window.showToast(response.responseJSON.message, 'error');
                        }
                        return { results: [] }; // Return dataset to load after error
                    },
                    cache: true
                },
                templateResult: function (item) {
                    let $span = '';
                    if (item.image) {
                        $span = $("<span class='flex gap-2 items-center text-left'>" +
                            "<img src='" + item.image + "' class='rounded-full flex-none w-6 h-6'/>" +
                            "<span class='grow'>" + item.text + "</span>" +
                            "</span>");
                    } else {
                        $span = $("<span>" + item.text + "</span>");
                    }
                    return $span;
                },
                createTag: function (data) {
                    return null;
                }
            });
        });

        // Select2 with local search
        $('select.select2-local').select2({
            placeholder: $(this).data('placeholder'),
            language: $(this).data('language'),
            allowClear: true
        });

        // Select2 with colour box
        $('select.select2-colour').select2({
            allowClear: false,
            templateResult: select2ColourState,
            templateSelection: select2ColourState,
        });
    }
});

function select2ColourState (state) {
    if (state.id === 'none') {
        return state.text;
    }

    let $state = $(
        '<span><div class="badge label bg-' + state.id + '"> </div>' + state.text + '</span>'
    );
    return $state;
}

// Load the translations into memory
import "select2/dist/js/i18n/ca.js";
import "select2/dist/js/i18n/de.js";
import "select2/dist/js/i18n/en.js";
import "select2/dist/js/i18n/es.js";
import "select2/dist/js/i18n/fr.js";
import "select2/dist/js/i18n/hu.js";
import "select2/dist/js/i18n/it.js";
import "select2/dist/js/i18n/nl.js";
import "select2/dist/js/i18n/pl.js";
import "select2/dist/js/i18n/pt-BR.js";
import "select2/dist/js/i18n/ru.js";
import "select2/dist/js/i18n/sk.js";
