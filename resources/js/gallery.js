import axios from "axios";

var loader, gallery, search;
var fileDrop, fileProgress, fileUploadField, fileError;
var galleryForm;
var maxFiles;
var maxError;

let bulkDelete, bulkForm;

$(document).ready(function() {
    initGallery();
    initUploader();
    registerEvents();
});

function initGallery() {
    loader = $('#gallery-loader');
    gallery = $('#gallery-images');
    search = $('#gallery-search');
    bulkDelete = $('#bulk-delete');
    bulkForm = $('form#gallery-bulk');

    galleryForm = document.getElementById('gallery-form');

    fileDrop = $('.uploader');
    fileProgress = $('.progress');
    fileUploadField = $('#file-upload');
    fileError = $('.gallery-error');

    let config = $('#gallery-config');
    maxFiles = config.data('max');
    maxError = config.data('error');

    search.on('blur', function(e) {
        e.preventDefault();
        initSearch();
    }).bind('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            initSearch();
        }
    });

    galleryForm.ondrop = (ev) => {
        ev.preventDefault();
        ev.stopPropagation();


        if (ev.dataTransfer.items) {
            let data = new FormData();
            let fileCount = 0;
            // Use DataTransferItemList interface to access the file(s)
            [...ev.dataTransfer.items].forEach((item, i) => {
                // If dropped items aren't files, reject them
                if (item.kind === 'file') {
                    data.append('file[]', item.getAsFile());
                    fileCount++;
                }
            });

            if (fileCount > maxFiles) {
                alertTooManyFiles();
                return;
            }

            let folder = $('input[name="folder_id"]');
            if (folder) {
                data.append('folder_id', folder.val());
            }
            uploadFiles(data);
            galleryForm.classList.remove('drop-shadow', 'dropping');
        } else {
            // Use DataTransfer interface to access the file(s)
            [...ev.dataTransfer.files].forEach((file, i) => {
                //console.log(`… file[${i}].name = ${file.name}`);
            });
        }
    };
    galleryForm.ondragover = (e) => {
        e.preventDefault();
        galleryForm.classList.add('drop-shadow', 'dropping');
    };
    galleryForm.ondragleave = (e) => {
        galleryForm.classList.remove('drop-shadow', 'dropping');
    };

    bulkForm.submit(function (e) {
        e.preventDefault();

        var data = new FormData();
        $.each($('li[data-selected="1"]'), function (i) {
            data.append('file[]', $(this).data('id'));
        });

        let folder = $('input[name="folder_id"]');
        if (folder) {
            data.append('folder_id', folder.val());
        }

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            context: this,
            data: data,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(res) {
            $('li[data-selected="1"]').remove();
            let target = document.getElementById('bulk-destroy-dialog');
            target.close();

            window.showToast(res.toast);
            return false;
        });

        return false;
    });

}

/**
 *
 */
function initSearch() {
    gallery.hide();
    loader.show();

    $.ajax({
        url: search.data('url') + '?q=' + search.val()
    }).done(function(data) {
        loader.hide();
        gallery.html(data).show();
        registerEvents();
    });
}

/**
 *
 */
function initUploader() {

    galleryForm.onchange = (event) => {
        event.preventDefault();

        let galleryFiles = document.getElementById('file-upload');

        if (galleryFiles.files.length > maxFiles) {
            alertTooManyFiles();
            return;
        }

        var data = new FormData();
        /*for (const i in galleryFiles.files) {
            let key = 'file[]';
            data.append(key, galleryFiles.files[i]);
        }*/
        Array.from(galleryFiles.files).forEach(file => {
            data.append('file[]', file);
        });

        let folder = $('input[name="folder_id"]');
        if (folder) {
            data.append('folder_id', folder.val());
        }

        uploadFiles(data);
    };
}

const alertTooManyFiles = () => {
    window.showToast(maxError, 'toast-error');
};

const uploadFiles = (data) => {
    var config = {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: function (progressEvent) {
            let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
            $('[role="progressbar"]').css(
                'width',
                percentCompleted + '%'
            );
        }
    };

    fileProgress.show();

    axios
        .post(galleryForm.action, data, config)
        .then(function (res) {

            fileProgress.hide();

            if (res.data.success) {
                res.data.images.forEach(image => {

                    // Do we have a folder to add to?
                    let last = $('li[data-folder]').last();

                    if (last.length === 1) {
                        $(image).insertAfter($('li[data-folder]').last());
                    } else {
                        gallery.prepend(image);
                    }
                });

                registerEvents();
            }
        })
        .catch(function (err) {
            fileProgress.hide();

            if (err.response && err.response.data.message) {
                fileError.text(err.response.data.message).fadeToggle();
            }

            registerEvents();
        });
};


function registerEvents() {
    $('#gallery-images li')
        .unbind('click')
        .on('click', function (e) {
            if (e.shiftKey) {
                if (!$(this).data('id')) {
                    return;
                }
                $(this).toggleClass('border-2 border-blue-500');
                if ($(this).attr('data-selected') === '1') {
                    $(this).attr('data-selected', '');
                } else {
                    $(this).attr('data-selected', 1);
                }
                registerShift();
                return;
            }
            let folder = $(this).data('folder');
            if (folder) {
                window.location = folder;
                return;
            }

            $.ajax({
                url: $(this).data('url')
            }).done(function(data) {
                $('#large-modal-content').html(data);
                $('#large-modal').modal('show');
            });
    });
}
const registerShift = () => {
    let selected = $('li[data-selected="1"]');
    if (selected.length === 0) {
        bulkDelete.hide();
    } else {
        bulkDelete.show();
    }
};
