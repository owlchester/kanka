var addPermBtn;
$(document).ready(function () {
    addPermBtn = $('.post-perm-add');
    if (addPermBtn.length === 0) {
        return;
    }
    registerAdvancedPermissions();
    registerPermissionDeleteEvents();
});

/**
 * Add advanced permissions on a post
 */
function registerAdvancedPermissions() {
    addPermBtn.on('click', function (ev) {
        ev.preventDefault();
        let type = $(this).data('type');
        let selected = $('select[name="' + type + '"]');

        if (!selected || !selected.val()) {
            return false;
        }

        let selectedName = selected.find(':selected')[0];
        //console.log('selected name for ', type, selectedName.text);

        // Add a block
        let body = $('#post-perm-' + type + '-template').clone().removeClass('hidden').removeAttr('id');
        let html = body.html()
            .replace(/\$SELECTEDID\$/g, selected.val())
            .replace(/\$SELECTEDNAME\$/g, selectedName.text);
        body.html(html).insertBefore($('#post-perm-target'));

        $('#post-new-' + type).modal('toggle');

        registerPermissionDeleteEvents();

        // Reset the value
        selected.val('').trigger('change');
        return false;
    });
}

/**
 * Remove an advanced permission from a post
 */
function registerPermissionDeleteEvents() {
    $.each($('.post-delete-perm'), function () {
        $(this).unbind('click');
        $(this).on('click', function () {
            $(this).parent().parent().parent().parent().remove();
        });
    });
}
