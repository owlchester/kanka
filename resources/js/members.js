import TomSelect from 'tom-select';

window.onEvent(function () {
    initFormMembersSelect();
});

const initFormMembersSelect = () => {
    document.querySelectorAll('.form-members').forEach((form) => {
        if (form.tomselect) {
            return;
        }

        const plugins = ['remove_button'];
        if (form.dataset.allowClear === 'true') {
            plugins.push('clear_button');
        }

        new TomSelect(form, {
            plugins,
            placeholder: form.dataset.placeholder || '',
            allowEmptyOption: true,
            loadThrottle: 500,
            shouldLoad: function (query) {
                return query.length >= 2;
            },
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            create: false,
            load: function (query, callback) {
                if (query.length < 2) { callback(); return; }
                fetch(form.dataset.url + '?q=' + encodeURIComponent(query.trim()), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(r => r.json())
                    .then(data => callback(data))
                    .catch(() => callback());
            },
            render: {
                item: function (data, escape) {
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        });
    });
};

initFormMembersSelect();
