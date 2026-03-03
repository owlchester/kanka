import TomSelect from 'tom-select';

window.initTags = function () {
    document.querySelectorAll('.form-tags')?.forEach(function (ele) {
        if (ele.tomselect) {
            return;
        }

        const allowNew = ele.dataset.allowNew === 'true';
        const plugins = ['dropdown_input', 'remove_button'];
        if (ele.dataset.allowClear === 'true') {
            plugins.push('clear_button');
        }

        const ts = new TomSelect(ele, {
            plugins,
            allowEmptyOption: true,
            preload: 'focus',
            loadThrottle: 500,
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            create: allowNew ? function (input, callback) {
                const term = input.trim();
                if (!term) { return; }
                callback({ id: term, text: term, newTag: true });
            } : false,
            dropdownParent: ele.dataset.dropdownParent || null,
            load: function (query, callback) {
                fetch(ele.dataset.url + '?q=' + encodeURIComponent(query.trim()), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(r => r.json())
                    .then(data => callback(data))
                    .catch(() => callback());
            },
            render: {
                option: function (data, escape) {
                    if (data.colour) {
                        return '<div class="flex gap-2 items-center text-left">'
                            + '<span class="rounded-full flex-none w-6 h-6 ' + escape(data.colour) + '"></span>'
                            + '<span class="grow">' + escape(data.text) + '</span>'
                            + '</div>';
                    }
                    return '<div class="block grow text-left">' + escape(data.text) + '</div>';
                },
                item: function (data, escape) {
                    const div = document.createElement('div');
                    if (data.newTag) {
                        div.title = ele.dataset.newTag || '';
                        div.innerHTML = escape(data.text) + ' <i class="fa-solid fa-flag" aria-hidden="true"></i>';
                    } else {
                        div.innerHTML = escape(data.text);
                    }
                    const colours = (data.colour || '').trim().split(' ').filter(c => c);
                    colours.forEach(c => div.classList.add(c));
                    div.classList.add('text-left');
                    return div;
                },
            },
        });
    });

    document.querySelectorAll('.position-dropdown')?.forEach(function (ele) {
        if (ele.tomselect) {
            return;
        }
        new TomSelect(ele, {
            plugins: ['remove_button', 'clear_button'],
            placeholder: ele.dataset.placeholder || '',
            allowEmptyOption: true,
            dropdownParent: ele.dataset.dropdownParent || null,
            create: function (input, callback) {
                const term = input.trim();
                if (!term) { return; }
                callback({ value: term, text: term });
            },
        });
    });
};

window.initTags();
