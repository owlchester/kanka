$(document).ready(function() {
    $(document).on('shown.bs.modal shown.bs.popover', function() {
        initFormMembersSelect();
    });
    if ($('.form-members').count === 0) {
        return;
    }
    initFormMembersSelect();
});

function initFormMembersSelect() {
    $.each($('.form-members'), function () {
        let me = $(this);
        if (me.data('loaded') === 1) {
            return;
        }
        me.data('loaded', 1);
        let allowClear = me.data('allow-clear');

        me.select2({
            tags: true,
            allowClear: allowClear || true,
            minimumInputLength: 0,
            ajax: {
                quietMillis: 500,
                delay: 500,
                url: me.data('url'),
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
