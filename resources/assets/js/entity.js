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
                registerDelete();
            });
        });
    }
});

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

function registerDelete() {
    $('.entity-file-remove').each(function() {
        $(this).unbind('click');
        $(this).on('click', function (e) {
            $(this).removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');
            $.ajax({
                type: 'GET',
                url: $(this).data('url'),
                context: this
            }).done(function (result, textStatus, xhr) {
                // Hide this
                console.log('removed', $(this), $(this).parent());
                $(this).parent().fadeOut();
                toggleUpload(result.enabled);
            });
        });
    })
}

function replaceFileList(data) {
    $('.entity-files').html(data.html);

    registerDelete();
}

function toggleUpload(enabled) {
    if (enabled) {
        entityFileDrop.fadeIn();
        entityFileMax.hide();
    } else {
        entityFileDrop.hide();
        entityFileMax.fadeIn();
    }
}