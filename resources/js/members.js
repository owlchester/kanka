
$(document).ready(function() {
    $(document).on('shown.bs.modal', function() {
        initFormMembersSelect();
    });
    initFormMembersSelect();
});

function initFormMembersSelect() {
    const formMembers = document.querySelectorAll('.form-members');
    formMembers.forEach((form) => {
        if (form.dataset.loaded === 1) {
            return;
        }
        form.dataset.loaded = 1;
        let allowClear = form.dataset.allowClear;

        $(form).select2({
            tags: true,
            allowClear: allowClear || true,
            minimumInputLength: 2,
            ajax: {
                quietMillis: 500,
                delay: 500,
                url: form.dataset.url,
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
                cache: true
            },
            createTag: function() {
                return undefined;
            }
        });
    });
}
