var entityFileUi, entityFileModal;
var entityFileDrop, entityFileProgress, entityFileMax;
var openingEntityFileModal = false;

$(document).ready(function () {
    entityFileUi = $('.entity-file-ui');
    entityFileModal = $('#entity-modal');

    if (entityFileUi.length === 1) {
        entityFileUi.on('click', function(e) {
            openingEntityFileModal = true;
            entityFileModal.on('shown.bs.modal', function(e) {
                initEntityFileModal();
                registerDeleteBtn();
                registerRenameBtn();
                registerRenameField()
            });
        });
    }
});

/**
 *
 */
function initEntityFileModal() {
    if (!openingEntityFileModal) {
        return;
    }
    console.log('file modal loaded');
    openingEntityFileModal = false;

    entityFileDrop = $('.entity-files-drop');
    entityFileProgress = $('#entity-file-progress');
    entityFileMax = $('.entity-file-upload-max');

    entityFileDrop.bind('drop', function(e) {
        e.preventDefault();
        entityFileProgress.show();
    }).on('click', function(e) {
        console.log('clicked')
        $('#entity-file-upload').trigger('click');
    });


    // Allow ajax requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#entity-file-upload').fileupload({
        dropZone: entityFileDrop,
        dataType: 'json',
        add: function (e, data) {
            entityFileDrop.hide();
            console.log('data', data);
            data.submit();
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress').show();
            $('.progress .progress-bar').css(
                'width',
                progress + '%'
            );
        },
        done: function (e, data) {
            $('.progress').hide();
            //entityFileDrop.show();

            console.log('done', data.result);

            if (data.result.success) {
                replaceFileList(data.result);
                toggleUpload(data.result.enabled);
                $('.entity-file-upload-error').hide();
            } else {
                $('.entity-file-upload-error').text(data.result.error).fadeToggle();
                console.log('no success');
            }
        }
    });

    // When dropped, start uploading pronto
    entityFileDrop.bind('drop', function(e) {
        console.log('file dropped');
        entityFileProgress.show();
    });

}

/**
 * When clicking on the trash, delete an object
 */
function registerDeleteBtn() {
    $('.entity-file-remove').each(function() {
        $(this).unbind('click');
        $(this).on('click', function (e) {
            $(this).removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');
            $.post({
                url: $(this).data('url'),
                data: {
                    '_method': 'DELETE'
                },
                context: this
            }).done(function (result, textStatus, xhr) {
                // Hide this
                $(this).parent().fadeOut();
                toggleUpload(result.enabled);
            });
        });
    })
}

/**
 * When clicking on rename, show a special form
 */
function registerRenameBtn() {
    $('.entity-file-rename').each(function(i) {
        $(this).unbind('click').on('click', function(e) {
            console.log('rename click');
            $(this).parent().children('a').hide();
            $(this).parent().children('input').val($(this).data('default')).show().focus();
            $(this).hide();
        });
    });
}

/**
 * Renaming an entity can be submitted hitting enter, or canceled by losing focus
 */
function registerRenameField() {
    $('.entity-file-name').each(function() {
        $(this).unbind('keypress').unbind('focusout')
            .keypress(function(e) {
                var keyCode = e.keyCode || e.which;
                var link;

                // Submit
                if (keyCode === 13) {
                    e.preventDefault();
                    link = $(this).parent().children('a');

                    // Ajax rename.
                    $.post({
                        url: $(this).data('url'),
                        data: {
                            '_method': 'PATCH',
                            'name': $(this).val(),
                            'csrf-token': $('.csrf-token').val()
                        },
                        datatype: 'JSON',
                        context: this
                    }).done(function (data) {
                        var newVal = $(this).val();
                        $(this).val(newVal).hide();

                        // Change link text, data-default and show it
                        link.data('default', newVal).html(newVal).show();

                        // Enable editing again
                        $(this).parent().children('.entity-file-rename').data('default', newVal).show();
                        $('.entity-file-error').hide();

                    }).fail(function(data) {
                        var errors = '';
                        for (var key in data.responseJSON.errors) {
                            // skip loop if the property is from prototype
                            if (!data.responseJSON.errors.hasOwnProperty(key)) continue;

                            errors += data.responseJSON.errors[key] + "\n";
                        }
                        $(this).parent().children('.entity-file-error').text(errors).show();
                    });
                }
            })
            .focusout(function(e) {
                // Show the normal field, hide the rest. Reset the value.
                link = $(this).parent().children('a');
                $(this).val($(this).data('default'));
                link.show();
                $(this).hide();
                $(this).parent().children('.entity-file-rename').show();
                $('.entity-file-error').hide();
            })
    });
}

/**
 *
 * @param data
 */
function replaceFileList(data) {
    $('.entity-files').html(data.html);

    registerDeleteBtn();
    registerRenameBtn();
    registerRenameField();
}

/**
 *
 * @param enabled
 */
function toggleUpload(enabled) {
    if (enabled) {
        entityFileDrop.fadeIn();
        entityFileMax.hide();
    } else {
        entityFileDrop.hide();
        entityFileMax.fadeIn();
    }
}