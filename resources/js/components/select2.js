window.initForeignSelect = function () {
    const fields = document.querySelectorAll('select.select2');
    if (fields.length === 0) {
        return;
    }
    fields.forEach(field => {
        if (field.classList.contains('select2-hidden-accessible')) {
            return;
        }
        if (field.classList.contains('campaign-genres')) {
            $(field).select2({
                tags: false,
                allowClear: true,
                dropdownParent: '',
                width: '100%',
                maximumSelectionLength: 3,
            });
            return;
        }

        const url = field.dataset.url;
        const allowClear = field.dataset.allowClear;
        const dropdownParent = field.dataset.dropdownParent || '';
        const placeholder = field.dataset.placeholder;

        if (!url) {
            $(field).select2({
                tags: false,
                placeholder: placeholder,
                allowClear: allowClear ?? false,
                language: field.dataset.language,
                minimumInputLength: 0,
                dropdownParent: dropdownParent,
                width: '100%',
            });
            return;
        }

        // Check it isn't the select2-icon
        console.log('select2', field, field.dataset.allowNew === 'true');
        $(field).select2({
            tags: field.dataset.allowNew === 'true',
            placeholder: placeholder,
            allowClear: allowClear || true,
            language: field.dataset.language,
            minimumInputLength: 0,
            dropdownParent: dropdownParent,
            width: '100%',

            ajax: {
                delay: 500,
                quietMillis: 500,
                url: url,
                dataType: 'json',
                data: function (params) {
                    return {
                        q: params.term?.trim()
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                error: function(response) {
                    //console.log('error', response);
                    if (response.status === 503) {
                        window.showToast(response.responseJSON.message, 'error');
                    }
                    return { results: [] }; // Return dataset to load after error
                },
                cache: true
            },
            templateResult: formatResultList,
            templateSelection: formatResult,
            createTag: function (data) {
                let term = data.term?.trim();

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term + ' (' + field.dataset.newTag + ')',
                    newTag: true // add additional parameters
                };
            }
        });
    });

    initLocalSelects();
    initColourSelects();
};

const formatResultList = (item) => {
    const element = document.createElement('span');
    if (item.image) {
        element.classList.add('flex', 'gap-2', 'items-center', 'text-left');
        element.innerHTML =  "<img src='" + item.image + "' class='rounded-full flex-none w-6 h-6'/>" +
            "<span class='grow'>" + item.text + "</span>";
    } else {
        element.innerHTML = item.text;
    }
    return element;
};

const formatResult = (item) => {
    if (!item.id) {
        return item.text;
    }
    const ele = document.createElement('span');
    ele.innerHTML = item.text;
    return ele;
};

const initLocalSelects = () => {
    // Select2 with local search
    const fields = document.querySelectorAll('select.select2-local');
    if (fields.length === 0) {
        return;
    }
    fields.forEach(field => {
        $(field).select2({
            placeholder: field.dataset.placeholder,
            language: field.dataset.language,
            allowClear: true
        });
    });
};

const initColourSelects = () => {
    // Select2 with local search
    const fields = document.querySelectorAll('select.select2-colour');
    if (fields.length === 0) {
        return;
    }
    fields.forEach(field => {
        $(field).select2({
            placeholder: field.dataset.placeholder,
            language: field.dataset.language,
            allowClear: false,
            templateResult: select2ColourState,
            templateSelection: select2ColourState,
        });
    });
};

const select2ColourState = (state) => {
    if (state.id === 'none') {
        return state.text;
    }

    const span = document.createElement('span');
    span.innerHTML = '<div class="badge label bg-' + state.id + '"> </div>' + state.text;
    return span;
};

// Load the translations into memory
import "select2/dist/js/i18n/de.js";
import "select2/dist/js/i18n/en.js";
import "select2/dist/js/i18n/es.js";
import "select2/dist/js/i18n/fr.js";
import "select2/dist/js/i18n/it.js";
import "select2/dist/js/i18n/nl.js";
import "select2/dist/js/i18n/pl.js";
import "select2/dist/js/i18n/pt-BR.js";
import "select2/dist/js/i18n/ru.js";
import "select2/dist/js/i18n/sk.js";
