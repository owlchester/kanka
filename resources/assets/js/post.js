var addPermBtn;
$(document).ready(function () {
    addPermBtn = $('.entity-note-perm-add');
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
        let body = $('#entity-note-perm-' + type + '-template').clone().removeClass('hidden').removeAttr('id');
        let html = body.html()
            .replace(/\$SELECTEDID\$/g, selected.val())
            .replace(/\$SELECTEDNAME\$/g, selectedName.text);
        body.html(html).insertBefore($('#entity-note-perm-target'));

        $('#entity-note-new-' + type).modal('toggle');

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
    $.each($('.entity-note-delete-perm'), function () {
        $(this).unbind('click');
        $(this).on('click', function () {
            $(this).parent().parent().parent().parent().remove();
        });
    });
}
