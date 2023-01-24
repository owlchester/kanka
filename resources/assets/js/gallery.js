import axios from "axios";

var loader, gallery, search;
var fileDrop, fileProgress, fileUploadField, fileError;
var galleryForm;

$(document).ready(function() {
    initGallery();
    initUploader();
    registerEvents();
});

function initGallery() {
    loader = $('#gallery-loader');
    gallery = $('#gallery-images');
    search = $('#gallery-search');

    galleryForm = document.getElementById('gallery-form');

    fileDrop = $('.uploader');
    fileProgress = $('.progress');
    fileUploadField = $('#file-upload');
    fileError = $('.gallery-error');

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
            var data = new FormData(galleryForm);
            // Use DataTransferItemList interface to access the file(s)
            [...ev.dataTransfer.items].forEach((item, i) => {
                // If dropped items aren't files, reject them
                if (item.kind === 'file') {
                    data.append('file[]', item.getAsFile());
                }
            });
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
        console.log('drag start');
    };
    galleryForm.ondragleave = (e) => {
        galleryForm.classList.remove('drop-shadow', 'dropping');
        console.log('drag end');
    };

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

        var data = new FormData(galleryForm);
        Array.from(galleryFiles.files).forEach(file => {
            data.append('file[]', file);
        });

        uploadFiles(data);
    };
}

const uploadFiles = (data) => {
    var config = {
        onUploadProgress: function (progressEvent) {
            let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
            $('.progress .progress-bar').css(
                'width',
                percentCompleted + '%'
            );
        }
    };

    fileProgress.show();

    axios
        .post(galleryForm.action, data, config)
        .then(function (res) {
            /*output.className = 'container';
            output.innerHTML = res.data;*/
            console.info('then', res);
            console.log('data', res.data);

            fileProgress.hide();

            if (res.data.success) {
                res.data.images.forEach(image => {
                    //console.log('image', image);

                    // Do we have a folder to add to?
                    let last = $('li[data-folder]').last();

                    if (last.length === 1) {
                        console.log('last', last[0]);
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
        .on('click', function () {
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
