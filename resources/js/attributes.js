import Sortable from "sortablejs";

/**
 * When adding a new attribute, we give it a negative id to avoid issues with checkboxes losing information
 * @type {number}
 */
let attribute_id_count = -1000;
let maxFields = false;
let maxFieldAlert;

const target = $('#add_attribute_target');

import dynamicMentions from "./mention";

$(document).ready(function() {
    initLiveAttributes();
    if ($('#add_attribute_target').length === 0) {
        return;
    }
    initAttributeUI();

    let maxConfig = $('[data-max-fields]');
    if (maxConfig.length === 1) {
        maxFields = maxConfig.data('max-fields');
        maxFieldAlert = $('.alert-too-many-fields');
    }
});

/**
 * Initiate on click handles for attribute interface
 */
const initAttributeUI = () => {
    initAttributeHandlers();
    initAddAttribute();

    // Delete all visible attributes
    $('#attributes-delete-all-confirm-submit').click(function(e) {
        e.preventDefault();

        $(this).siblings('input[name="delete-all-attributes"]').val(1);
        $('#entity-attributes-all .attribute_delete').click();
        $('#attributes-delete-all-confirm').modal('hide');
        if (maxFieldAlert) {
            maxFieldAlert.hide();
        }

        $(this).closest('dialog')[0].close();
        window.scrollTo({ top: 0, behavior: 'smooth' });

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

    $(document).on('shown.bs.modal', function () {
        initAddAttribute();
    });
};

const initAddAttribute = () => {
    $('[data-attribute-template]').unbind('click').click(function (e) {
        e.preventDefault();

        if (maxFields !== false) {
            let fieldCount = $('form :input').length + 4;
            //console.log('checking', fieldCount, 'vs', maxFields);
            if (fieldCount > maxFields) {
                maxFieldAlert.show();
                return;
            } else {
                maxFieldAlert.hide();
            }
        }
        attribute_id_count -= 1;

        let template = $(this).data('attribute-template');
        let html = $(template).html().replace(/\$TMP_ID\$/g, attribute_id_count);
        target.append(html);
        initAttributeHandlers();
        dynamicMentions();

        return false;
    });
};

/**
 * This function rebinds the delete on all buttons
 */
const initAttributeHandlers = () => {
    $.each($('.attribute_delete'), function() {
        $(this).unbind('click');
        $(this).on('click', function() {
            $(this).parent().parent().remove();

            if (maxFieldAlert) {
                maxFieldAlert.hide();
            }
        });
    });

    $('[data-toggle="private"]').unbind('click').click(function() {
        if ($(this).hasClass('fa-lock')) {
            // Unlock
            $(this).removeClass('fa-lock').addClass('fa-unlock-alt').prop('title', $(this).data('public'));
            $(this).prev('input:hidden').val("0");
            window.showToast($(this).data('unlock'));
        } else {
            // Lock
            $(this).removeClass('fa-unlock-alt').addClass('fa-lock').prop('title', $(this).data('private'));
            $(this).prev('input:hidden').val("1");
            window.showToast($(this).data('lock'));
        }
    });

    $('[data-toggle="star"]').unbind('click').click(function () {
        if ($(this).hasClass('fa-regular')) {
            // Unlock
            $(this).removeClass('fa-regular').addClass('fa-solid').prop('title', $(this).data('entry'));
            $(this).prev('input:hidden').val("1");
            window.showToast($(this).data('pin'));
        } else {
            // Lock
            $(this).removeClass('fa-solid').addClass('fa-regular').prop('title', $(this).data('tab'));
            $(this).prev('input:hidden').val("0");
            window.showToast($(this).data('unpin'));
        }
    });
};

let liveEditURL, liveEditModal, liveEditCurrentUID;
const initLiveAttributes = () => {
    let config = $('[name="live-attribute-config"]');
    if (config.length === 0) {
        return;
    }

    liveEditURL = config.data('live');
    liveEditModal = $('#live-attribute-dialog');

    // Add the live-edit-parsed attribute to variables to confirm that they are valid
    let uid = 1;
    $.each($('.live-edit'), function () {
        $(this).addClass('live-edit-parsed');
        $(this).attr('data-uid', uid);
        uid++;
    });

    $('.live-edit-parsed').unbind('click').click(function () {
        //console.log('clicked on live edit parsed');

        let id = $(this).data('id');
        liveEditCurrentUID = $(this).data('uid');

        let url = liveEditURL + '?id=' + id + '&uid=' + $(this).data('uid');

        $(document).on('shown.bs.modal', function () {
            listenToLiveForm();
        });
        window.openDialog('live-attribute-dialog', url);

    });
};

const listenToLiveForm = () => {
    liveEditModal.find('form').submit(function (e) {
        e.preventDefault();

        $.ajax({
            method: 'POST',
            context: this,
            url: $(this).attr('action'),
            data: $(this).serialize()
        }).done(function (result) {

            liveEditModal.find('article').html('');
            let dialog = document.getElementById('live-attribute-dialog');
            dialog.close();

            let target = $('[data-uid="' + result.uid + '"]');
            //console.log('looking for', '[data-uid="' + result.uid + '"]', target);
            target.html(result.value);
            if (result.value) {
                target.removeClass('empty-value');
            } else {
                target.addClass('empty-value');
            }

            window.showToast(result.success);

        }).fail(function (result) {
            //alert('error! check console logs');
            //console.error('live-edit-error', result);
            let dialog = document.getElementById('live-attribute-dialog');
            dialog.close();
        });

        return false;
    });
};
