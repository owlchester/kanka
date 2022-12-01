import Sortable from "sortablejs";

/**
 * When adding a new attribute, we give it a negative id to avoid issues with checkboxes losing information
 * @type {number}
 */
var attribute_id_count = -1000;
var maxFields = false;
var maxFieldAlert;

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
function initAttributeUI()
{
    var target = $('#add_attribute_target');

    initAttributeHandlers();

    $('.add_attribute').click(function (e) {
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

        let body = $($(this).data('template')).clone().removeClass('hidden').removeAttr('id');
        let html = body.html().replace(/\$TMP_ID\$/g, attribute_id_count);
        body.html(html).insertBefore(target);
        initAttributeHandlers();
        dynamicMentions();

        return false;
    });

    // Delete all visible attributes
    $('#attributes-delete-all-confirm-submit').click(function(e) {
        e.preventDefault();

        $(this).siblings('input[name="delete-all-attributes"]').val(1);
        $('#entity-attributes-all .attribute_delete').click();
        $('#attributes-delete-all-confirm').modal('hide');
        if (maxFieldAlert) {
            maxFieldAlert.hide();
        }
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

    let el = document.querySelector('.entity-attributes');
    Sortable.create(el, {handle: '.input-group-addon'});

    $.each($('.attribute_delete'), function() {
        $(this).unbind('click');
        $(this).on('click', function() {
            $(this).parent().parent().parent().remove();

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
        } else {
            // Lock
            $(this).removeClass('fa-unlock-alt').addClass('fa-lock').prop('title', $(this).data('private'));
            $(this).prev('input:hidden').val("1");
        }
    });

    $('[data-toggle="star"]').unbind('click').click(function () {
        if ($(this).hasClass('fa-regular')) {
            // Unlock
            $(this).removeClass('fa-regular').addClass('fa-solid').prop('title', $(this).data('entry'));
            $(this).prev('input:hidden').val("1");
        } else {
            // Lock
            $(this).removeClass('fa-solid').addClass('fa-regular').prop('title', $(this).data('tab'));
            $(this).prev('input:hidden').val("0");
        }
    });

    //window.initSelect2();
}


var liveEditURL, liveEditModal, liveEditCurrentUID;
function initLiveAttributes() {
    let config = $('[name="live-attribute-config"]');
    if (config.length === 0) {
        return;
    }

    liveEditURL = config.data('live');
    liveEditModal = $('#live-attribute-modal');

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
        $.ajax({
            url: url
        }).done(function (result) {
            let params = {};
            liveEditModal.find('.modal-content').html(result);
            liveEditModal.modal(params);

            //console.log('child', liveEditModal.find('form'));
            liveEditModal.find('form').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    method: 'POST',
                    context: this,
                    url: $(this).attr('action'),
                    data: $(this).serialize()
                }).done(function (result) {

                    liveEditModal.find('.modal-content').html('');
                    liveEditModal.modal('hide');

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
                    console.error('live-edit-error', result);

                    liveEditModal.find('.modal-content').html('');
                    liveEditModal.modal('hide');
                });

                return false;
            });
        });
    });
}
