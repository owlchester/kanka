/**
 * When adding a new attribute, we give it a negative id to avoid issues with checkboxes losing information
 * @type {number}
 */
var attribute_id_count = -1000;

$(document).ready(function() {
    if($('#add_attribute_target').length > 0) {
        initAttributeUI();
    }
});

/**
 * Initiate on click handles for attribute interface
 */
function initAttributeUI()
{
    var target = $('#add_attribute_target');
    var targetNew = $('#add_unsortable_attribute_target');

    initAttributeHandlers();

    $('#attribute_add').on('click', function(e) {
        e.preventDefault();
        attribute_id_count -= 1;

        let body = $('#attribute_template').clone().removeClass('hidden').removeAttr('id');
        let html = body.html().replace(/\$TMP_ID\$/g, attribute_id_count);
        body.html(html).insertBefore(target);
        initAttributeHandlers();

        return false;
    });

    $('#block_add').click(function(e) {
        e.preventDefault();
        attribute_id_count -= 1;

        let body = $('#block_template').clone().removeClass('hidden').removeAttr('id');
        let html = body.html().replace(/\$TMP_ID\$/g, attribute_id_count);
        body.html(html).insertBefore(target);
        initAttributeHandlers();
        return false;
    });

    $('#text_add').click(function(e) {
        e.preventDefault();
        attribute_id_count -= 1;

        let body = $('#text_template').clone().removeClass('hidden').removeAttr('id');
        let html = body.html().replace(/\$TMP_ID\$/g, attribute_id_count);
        body.html(html).insertBefore(target);
        initAttributeHandlers();
        return false;
    });

    $('#checkbox_add').click(function(e) {
        e.preventDefault();
        attribute_id_count -= 1;

        let body = $('#checkbox_template').clone().removeClass('hidden').removeAttr('id');
        let html = body.html().replace(/\$TMP_ID\$/g, attribute_id_count);
        body.html(html).insertBefore(target);
        initAttributeHandlers();
        return false;
    });

    $('#section_add').click(function(e) {
        e.preventDefault();
        attribute_id_count -= 1;

        let body = $('#section_template').clone().removeClass('hidden').removeAttr('id');
        let html = body.html().replace(/\$TMP_ID\$/g, attribute_id_count);
        body.html(html).insertBefore(target);
        initAttributeHandlers();
        return false;
    });

    $('#entity_add').click(function(e) {
        e.preventDefault();
        attribute_id_count -= 1;

        let body = $('#entity_template').clone().removeClass('hidden').removeAttr('id');
        let html = body.html().replace(/\$TMP_ID\$/g, attribute_id_count);
        body.html(html).insertBefore(target);
        initAttributeHandlers();
        return false;
    });

    // Delete all visible attributes
    $('#attributes-delete-all-confirm-submit').click(function(e) {
        e.preventDefault();

        $('#entity-attributes-all .attribute_delete').click();
        $('#attributes-delete-all-confirm').modal('hide');
        return false;
    });

    $.each($('[data-toggle="private"]'), function () {
        // Add the title first
        if ($(this).hasClass('fa-lock')) {
            $(this).prop('title', $(this).data('private'));
        } else {
            $(this).prop('title', $(this).data('public'));
        }
    });
}

/**
 * This function rebinds the delete on all buttons
 */
function initAttributeHandlers() {

    $('.entity-attributes').sortable({});

    $.each($('.attribute_delete'), function() {
        $(this).unbind('click');
        $(this).on('click', function() {
            $(this).parent().parent().parent().remove();
        });
    });

    $('[data-toggle="private"]').unbind('click').click(function() {
        if ($(this).hasClass('fa-lock')) {
            // Unlock
            $(this).removeClass('fa-lock').addClass('fa-unlock-alt').prop('title', $(this).data('public'));
            $(this).prev('input:hidden').val("0");
        } else {
            // Lock
            $(this).removeClass('fa-unlock-alt').addClass('fa-lock').prop('title', $(this).data('private'));
            $(this).prev('input:hidden').val("1");
        }
    });

    $('[data-toggle="star"]').unbind('click').click(function () {
        if ($(this).hasClass('far')) {
            // Unlock
            $(this).removeClass('far').addClass('fas').prop('title', $(this).data('entry'));
            $(this).prev('input:hidden').val("1");
        } else {
            // Lock
            $(this).removeClass('fas').addClass('far').prop('title', $(this).data('tab'));
            $(this).prev('input:hidden').val("0");
        }
    });

    //window.initSelect2();
}
