import TomSelect from 'tom-select';

const tsCache = {};
const tsPending = {};

const fetchWithCache = (url, query) => {
    const key = url + '?q=' + query;
    if (tsCache[key] !== undefined) {
        return Promise.resolve(tsCache[key]);
    }
    if (tsPending[key]) {
        return tsPending[key];
    }
    const promise = fetch(key, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(r => {
        if (!r.ok) {
            if (r.status === 503) {
                r.json().then(data => window.showToast(data.message, 'error'));
            }
            return [];
        }
        return r.json();
    }).then(data => {
        tsCache[key] = data;
        delete tsPending[key];
        return data;
    }).catch(() => {
        delete tsPending[key];
        return [];
    });
    tsPending[key] = promise;
    return promise;
};

window.initForeignSelect = function () {
    document.querySelectorAll('select.select2').forEach(field => {
        if (field.tomselect) {
            return;
        }

        if (field.classList.contains('campaign-genres')) {
            new TomSelect(field, {
                maxItems: 3,
                plugins: ['remove_button'],
            });
            return;
        }

        const url = field.dataset.url;
        const allowClear = field.dataset.allowClear === 'true';
        const placeholder = field.dataset.placeholder || '';
        const allowNew = field.dataset.allowNew === 'true';
        const dropdownParent = field.dataset.dropdownParent || null;
        const plugins = ['dropdown_input'];

        if (field.multiple) {
            plugins.push('remove_button');
        }
        if (allowClear) {
            plugins.push('clear_button');
        }

        const baseOptions = {
            plugins,
            placeholder,
            dropdownParent,
            allowEmptyOption: true,
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
        };

        if (!url) {
            new TomSelect(field, { ...baseOptions });
            return;
        }

        new TomSelect(field, {
            ...baseOptions,
            preload: 'focus',
            loadThrottle: 500,
            create: allowNew ? function (input, callback) {
                const term = input.trim();
                if (!term) { return; }
                callback({ id: 'new:' + term, text: term + ' (' + (field.dataset.newTag || '') + ')' });
            } : false,
            load: function (query, callback) {
                fetchWithCache(url, query.trim())
                    .then(data => callback(data))
                    .catch(() => callback());
            },
            render: {
                option: function (data, escape) {
                    if (data.image) {
                        return '<div class="flex gap-2 items-center text-left">'
                            + '<img src="' + escape(data.image) + '" class="rounded-full flex-none w-6 h-6"/>'
                            + '<span class="grow">' + escape(data.text) + '</span>'
                            + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                item: function (data, escape) {
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        });
    });

    initLocalSelects();
    initColourSelects();
};

const initLocalSelects = () => {
    document.querySelectorAll('select.select2-local').forEach(field => {
        if (field.tomselect) {
            return;
        }
        new TomSelect(field, {
            placeholder: field.dataset.placeholder || '',
            allowEmptyOption: true,
            plugins: ['clear_button'],
        });
    });
};

const initColourSelects = () => {
    document.querySelectorAll('select.select2-colour').forEach(field => {
        if (field.tomselect) {
            return;
        }
        new TomSelect(field, {
            placeholder: field.dataset.placeholder || '',
            allowEmptyOption: true,
            render: {
                option: function (data, escape) {
                    if (data.value === 'none' || !data.value) {
                        return '<div>' + escape(data.text) + '</div>';
                    }
                    return '<div class="flex items-center gap-2"><span class="badge label bg-' + escape(data.value) + ' inline-block w-4 h-4 rounded-sm mr-1"> </span>' + escape(data.text) + '</div>';
                },
                item: function (data, escape) {
                    if (data.value === 'none' || !data.value) {
                        return '<div>' + escape(data.text) + '</div>';
                    }
                    return '<div class="flex items-center gap-2"><span class="badge label bg-' + escape(data.value) + ' inline-block w-4 h-4 rounded-sm mr-1"> </span>' + escape(data.text) + '</div>';
                },
            },
        });
    });
};
