window.initTags = function() {
    document.querySelectorAll('.form-tags')?.forEach(function (ele)  {
        if (ele.classList.contains("select2-hidden-accessible")) {
            return;
        }
        if (ele.dataset.loaded === 1) {
            return;
        }
        ele.dataset.loaded = 1;

        $(ele).select2({
            tags: ele.dataset.allowNew === 'true',
            allowClear: ele.dataset.allowClear === 'true',
            dropdownParent: ele.dataset.dropdownParent || '',
            minimumInputLength: 0,
            ajax: {
                quietMillis: 500,
                delay: 500,
                url: ele.dataset.url,
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
                cache: true
            },
            createTag: function (params) {
                const term = params.term?.trim();

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true // add additional parameters
                };
            },
            templateResult: function (item) {
                const temp = document.createElement('span');
                temp.classList.add('block', 'grow', 'text-left');
                temp.innerHTML = item.text;
                if (item.colour) {
                    temp.classList.add('flex', 'gap-2', 'items-center', 'text-left');
                    temp.innerHTML =
                        "<span class='rounded-full flex-none w-6 h-6 " + item.colour + "' /></span>" +
                        "<span class='grow'>" + item.text + "</span>"
                    ;
                }
                return temp;
            },
            templateSelection : function (state, container) {
                if (state.newTag) {
                    const span = document.createElement('span');
                    span.classList.add('new-tag');
                    span.title = ele.dataset.newTag;
                    span.innerHTML = state.text + ' <i class="fa-solid fa-plus-circle" aria-hidden="true"></i>';
                }

                let el = state.element;
                let colours = [];
                if (state.colour) {
                    colours = state.colour.trim().split(' ');
                } else if(el.dataset.colour) {
                    colours = el.dataset.colour.trim().split(' ');
                }
                if (colours.length > 0) {
                    colours.forEach(colour => {
                        if (colour.trim().length === 0) {
                            return;
                        }
                        container[0].classList.add(colour);
                    });
                }
                container[0].classList.add('text-left');
                return state.text;
            },
        });
    });

    document.querySelectorAll('.position-dropdown')?.forEach(function (ele) {
        if (ele.classList.contains("select2-hidden-accessible")) {
            return;
        }
        if (ele.dataset.loaded === 1) {
            return;
        }
        ele.dataset.loaded = 1;
        $(ele).select2({
            tags: true,
            allowClear: true,
            dropdownParent: ele.dataset.dropdownParent || '',
            placeholder: ele.dataset.placeholder,
            minimumInputLength: 0,
            createTag: function (params) {
                const term = params.term?.trim();

                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true // add additional parameters
                };
            },
        });
    });
};

window.initTags();
